<?php

namespace App\Http\Controllers;

use App\Models\bukti;
use Illuminate\Http\Request;
use App\PDF\CustomPDF;
use TCPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BuktiController extends Controller
{
    public function index()
    {
        $data = bukti::all();
        return view('menu.bukti.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users' => 'required|string|max:255',
            'file' => 'required',
        ]);

        $path = $request->file('file')->store('uploads/bukti', 'public');

        // Simpan data
        Bukti::create([
            'users' => $validated['users'],
            'file' => $path, // ini path relatif ke storage
        ]);

        return redirect()->back()->with('success', 'Bukti berhasil diunggah!');
    }

    public function edit($id)
    {
        $bukti = Bukti::find($id);
        return view('menu.bukti.edit', compact('bukti'));
    }

    public function update(Request $request, $id)
    {
        $bukti = Bukti::findOrFail($id);

        $validated = $request->validate([
            'users' => 'required|string|max:255',
            'file' => 'nullable',
        ]);

        // Jika ada file baru diupload
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($bukti->file && Storage::disk('public')->exists($bukti->file)) {
                Storage::disk('public')->delete($bukti->file);
            }

            // Simpan file baru
            $path = $request->file('file')->store('uploads/bukti', 'public');
            $validated['file'] = $path;
        }

        // Update data
        $bukti->update($validated);

        return redirect()->route('Bukti.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bukti = Bukti::findOrFail($id);

        // Hapus file fisik jika ada
        if ($bukti->file && Storage::disk('public')->exists($bukti->file)) {
            Storage::disk('public')->delete($bukti->file);
        }

        // Hapus data dari database
        $bukti->delete();

        return redirect()->route('Bukti.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetak(Request $request)
    {
        $periode = $request->get('periode', 'bulan');

        $now = Carbon::now();
        $start = $now->copy()->startOfMonth();
        $end = $now->copy()->endOfMonth();

        // Tentukan range periode berdasarkan pilihan
        switch ($periode) {
            case 'triwulan':
                $quarter = ceil($now->month / 3);
                $start = Carbon::create($now->year, ($quarter - 1) * 3 + 1, 1)->startOfMonth();
                $end = $start->copy()->addMonths(2)->endOfMonth();
                break;
            case 'tahun':
                $start = Carbon::create($now->year, 1, 1);
                $end = Carbon::create($now->year, 12, 31);
                break;
            default:
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
        }

        // Ambil data karyawan berdasarkan created_at
        $data = bukti::whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->get();

        // Format tanggal
        $formattedStart = $start->translatedFormat('d M Y');
        $formattedEnd = $end->translatedFormat('d M Y');

        // Inisialisasi PDF
        $pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(15, 35, 15); // Header akan muncul dari y=35
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 7, 'LAPORAN DATA BUKTI PEMBAYARAN PAJAK', 0, 1, 'C');

        // Periode laporan
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'Periode: ' . $formattedStart . ' - ' . $formattedEnd, 0, 1, 'C');

        $pdf->Ln(5); // Spasi sebelum tabel

        // Tabel HTML
        $tbl = '
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="30%">Pengupload</th>
                <th width="30%">Tanggal Input</th>
                <th width="30%">Tanggal Edit</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($data as $index => $row) {
            $tbl .= '
            <tr>
                <td width="10%">' . ($index + 1) . '</td>
                <td width="30%">' . $row->users . '</td>
                <td width="30%">' . Carbon::parse($row->created_at)->translatedFormat('d M Y') . '</td>
                <td width="30%">' . Carbon::parse($row->updated_at)->translatedFormat('d M Y') . '</td>
            </tr>';
        }

        $tbl .= '
        </tbody>
    </table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // Output PDF
        $pdf->Output('laporan_karyawan.pdf', 'I');
    }
}

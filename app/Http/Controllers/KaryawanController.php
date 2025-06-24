<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\PDF\CustomPDF;
use TCPDF;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::all();
        return view('menu.karyawan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'hp' => 'required|string|min:10|unique:karyawans,hp',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'identitas' => 'required|unique:karyawans,identitas',
        ]);

        // Hanya data tervalidasi yang digunakan
        Karyawan::create($validated);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = Karyawan::find($id);
        return view('menu.karyawan.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'hp' => 'required|string|min:10|unique:karyawans,hp',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'identitas' => 'required|unique:karyawans,identitas',
        ]);

        $user = Karyawan::findOrFail($id);

        $user->update($validatedData);

        return redirect()->route('Karyawan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $user = Karyawan::findOrFail($id);
        $user->delete();
        return redirect()->route('Karyawan.index')->with('success', 'Data berhasil dihapus!');
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
        $data = Karyawan::whereBetween('created_at', [$start, $end])
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
        $pdf->Cell(0, 7, 'LAPORAN DATA KARYAWAN', 0, 1, 'C');

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
                <th width="5%">No</th>
                <th width="10%">Nama</th>
                <th width="15%">Identitas</th>
                <th width="30%">Alamat</th>
                <th width="15%">HP</th>
                <th width="10%">JK</th>
                <th width="15%">Tanggal Input</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($data as $index => $row) {
            $tbl .= '
            <tr>
                <td width="5%">' . ($index + 1) . '</td>
                <td width="10%">' . $row->name . '</td>
                <td width="15%">' . $row->identitas . '</td>
                <td width="30%">' . $row->alamat . '</td>
                <td width="15%">' . $row->hp . '</td>
                <td width="10%">' . ucfirst($row->jk) . '</td>
                <td width="15%">' . Carbon::parse($row->created_at)->translatedFormat('d M Y') . '</td>
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

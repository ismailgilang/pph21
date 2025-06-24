<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\penggajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\PDF\CustomPDF;
use TCPDF;

class PenggajianController extends Controller
{
    public function index()
    {
        $data = penggajian::all();
        $karyawan = Karyawan::all();
        return view('menu.penggajian.index', compact('data', 'karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required',
            'kegiatan' => 'required',
            'tanggal' => 'required',
            'diajukan' => 'required',
        ]);

        $dpp = $request->diajukan / 2;
        $pph21 = $dpp * 0.05;
        $dibayarkan = $request->diajukan - $pph21;

        $validated['dpp'] = $dpp;
        $validated['pph21'] = $pph21;
        $validated['dibayarkan'] = $dibayarkan;

        // Hanya data tervalidasi yang digunakan
        Penggajian::create($validated);

        return redirect()->back()->with('success', 'Penggajian created successfully!');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::all();
        $penggajian = penggajian::find($id);
        return view('menu.penggajian.edit', compact('penggajian', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required',
            'kegiatan'    => 'required',
            'tanggal'     => 'required|date',
            'diajukan'    => 'required|numeric',
        ]);

        // Hitung data turunan
        $dpp  = $request->diajukan / 2;
        $pph21 = $dpp * 0.05;
        $dibayarkan = $request->diajukan - $pph21;

        $penggajian = Penggajian::findOrFail($id);

        // Update data
        $penggajian->update([
            'karyawan_id'    => $validated['karyawan_id'],
            'kegiatan'       => $validated['kegiatan'],
            'tanggal'        => $validated['tanggal'],
            'diajukan'       => $validated['diajukan'],
            'dpp'            => $dpp,
            'pph21'          => $pph21,
            'dibayarkan'     => $dibayarkan,
        ]);

        return redirect()->route('Penggajian.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $user = penggajian::findOrFail($id);
        $user->delete();
        return redirect()->route('Penggajian.index')->with('success', 'Data berhasil dihapus!');
    }

    public function penggajian($id)
    {
        $karyawan = Karyawan::find($id);
        return view('menu.penggajian.karyawan', compact('karyawan'));
    }

    public function store2(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required',
            'kegiatan' => 'required',
            'tanggal' => 'required',
            'diajukan' => 'required',
        ]);

        $dpp = $request->diajukan / 2;
        $pph21 = $dpp * 0.05;
        $dibayarkan = $request->diajukan - $pph21;

        $validated['dpp'] = $dpp;
        $validated['pph21'] = $pph21;
        $validated['dibayarkan'] = $dibayarkan;

        // Hanya data tervalidasi yang digunakan
        Penggajian::create($validated);

        return redirect()->route('Penggajian.index')->with('success', 'Data berhasil disimpan');
    }

    public function getTotal(Request $request)
    {
        $periode = $request->query('periode', 'bulan');
        $now = Carbon::now();
        $start = $now->copy();
        $end = $now->copy();

        switch ($periode) {
            case 'triwulan':
                $quarter = ceil($now->month / 3);
                $start = Carbon::create($now->year, ($quarter - 1) * 3 + 1, 1);
                $end = $start->copy()->addMonths(3)->endOfMonth();
                break;
            case 'tahun':
                $start = Carbon::create($now->year, 1, 1);
                $end = Carbon::create($now->year, 12, 31);
                break;
            default: // bulan
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
        }

        $total = DB::table('penggajians')
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->sum('pph21');

        return response()->json([
            'periode' => $start->format('d M Y') . ' - ' . $end->format('d M Y'),
            'total' => $total
        ]);
    }

    public function cetak(Request $request)
    {
        $periode = $request->get('periode', 'bulan');

        $now = Carbon::now();
        $start = $now->copy()->startOfMonth();
        $end = $now->copy()->endOfMonth();



        // Tentukan range periode
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

        // Ambil data penggajian dan relasi karyawan
        $data = Penggajian::with('karyawan')
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        $totalPph21 = $data->sum('pph21');
        $formattedStart = $start->translatedFormat('d M Y'); // contoh: 01 Jun 2025
        $formattedEnd = $end->translatedFormat('d M Y');     // contoh: 30 Jun 2025


        // Buat TCPDF
        $pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(15, 35, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 7, 'LAPORAN PENGGAJIAN - PPH21', 0, 1, 'C');

        // Periode
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'Periode: ' . $formattedStart . ' - ' . $formattedEnd, 0, 1, 'C');



        $pdf->SetFont('helvetica', '', 11);
        $pdf->Ln(5);

        // === TABEL ===
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
            padding: 8px;
            text-align: left;
            font-size: 9pt;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="23%">Nama Karyawan</th>
                <th width="10%">Kegiatan</th>
                <th width="13%">Tanggal</th>
                <th width="13%">Diajukan</th>
                <th width="13%">DPP</th>
                <th width="13%">Dibayarkan</th>
                <th width="12%">PPh21</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($data as $index => $row) {
            $namaLengkap = $row->karyawan->identitas . ' - ' . $row->karyawan->name;

            $tbl .= '
            <tr>
                <td width="4%">' . ($index + 1) . '</td>
                <td width="23%">' . $namaLengkap . '</td>
                <td width="10%">' . $row->kegiatan . '</td>
                <td width="13%">' . Carbon::parse($row->tanggal)->format('d M Y') . '</td>
                <td width="13%">Rp ' . number_format($row->diajukan, 0, ',', '.') . '</td>
                <td width="13%">Rp ' . number_format($row->dpp, 0, ',', '.') . '</td>
                <td width="13%">Rp ' . number_format($row->dibayarkan, 0, ',', '.') . '</td>
                <td width="12%">Rp ' . number_format($row->pph21, 0, ',', '.') . '</td>
            </tr>';
        }

        $tbl .= '
        <tr>
            <td colspan="7" align="right"><strong>Total pph1 yang harus dibayarkan</strong></td>
            <td><strong>Rp ' . number_format($totalPph21, 0, ',', '.') . '</strong></td>
        </tr>
        </tbody>
    </table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // Output file
        $pdf->Output('laporan_pph21.pdf', 'I'); // 'I' = inline, 'D' = download
    }
}

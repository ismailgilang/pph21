<?php

namespace App\PDF;

use TCPDF;

class CustomPDF extends TCPDF
{
    public function Header()
    {
        // Logo kiri
        $imageFile = public_path('images/logo.jpg');
        if (file_exists($imageFile)) {
            $this->Image($imageFile, 10, 1, 35); // X, Y, Width
        }

        // Posisi teks ke tengah halaman
        $this->SetXY(40, 13); // Geser ke kanan dari logo
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 6, 'JASA PRIMA LOGISTIK CABANG JAWA BARAT', 0, 1, 'C');

        $this->SetX(40); // Pastikan horizontal posisi tetap
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 6, 'Jl.Saturnus Raya No.54a, Manjahlega, Kec, Rancasari, Kota Bandung, Jawa Barat 40286', 0, 1, 'C');

        // Garis pembatas
        $this->Ln(3);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(5); // Jarak ke konten bawah
    }
}

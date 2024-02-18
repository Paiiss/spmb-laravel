<?php

namespace App\Helper;

use FPDF;

class MyPdf extends FPDF
{
    public function header()
    {
        $this->Line(10, 35, $this->GetPageWidth() - 10, 35);
        $title = 'UNIVERSITAS HANG TUAH PEKANBARU';
        // $this->Image('htp.png', 18, 13, 20);
        $this->SetFont('Times', 'B', 19);
        $w = $this->GetStringWidth($title) + 6;
        $this->SetX((210 - $w) / 2);
        $this->Cell($w, 15, $title, 0, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 0, 'Jl. Mustafa Sari No 5 Tangkerang Selatan Pekanbaru, Telp (0761) 33815 Fax (0761) 33815', 0, 1, 'C');
        $this->Cell(0, 8, 'Email : universitas@htp.ac.id Izin Mendiknas: 226/D/O/2002 Izin Mendikbud-Ristek : 73/E/O/2022', 0, 1, 'C');
        $this->Ln(10);
    }

    public function footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
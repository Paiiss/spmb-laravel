<?php

namespace App\Helper;

use App\Helper\WriteTagHelper;
use App\Models\WebSettings;

class MyPdf extends WriteTagHelper
{
    private $widths;
    private $aligns;
    private $type_fonts;

    public $institution;
    public $isUseSignature = false;

    public function __construct($orientation, $unit, $size)
    {
        parent::__construct($orientation, $unit, $size);
    }

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function SetFonts($f)
    {
        $this->type_fonts = $f;
    }

    function Row($data, $head = 5, $checkPageBreak = false)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));

        $h = $head * $nb;
        $this->CheckPageBreak($h, $checkPageBreak);
        for ($i = 0; $i < count($data); $i++) {

            if (isset($this->type_fonts[$i])) {
                $this->SetFont($this->type_fonts[$i][0], $this->type_fonts[$i][1], $this->type_fonts[$i][2]);
            }

            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, $head, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function RowHead($data, $head = 7, $mid = true)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));

        $h = $head * $nb;
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {

            if (isset($this->type_fonts[$i])) {
                $this->SetFont($this->type_fonts[$i][0], $this->type_fonts[$i][1], $this->type_fonts[$i][2]);
            }

            $nbLines = $this->NbLines($this->widths[$i], $data[$i]);
            $heightColumn = $h / $nbLines;

            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h, 'DF');
            if ($mid == true)
                $this->MultiCell($w, $heightColumn, $data[$i], 0, $a);
            else
                $this->MultiCell($w, $head, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h, $checkPageBreak = false, $hBreak = 65)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);

        if ($checkPageBreak and $this->isUseSignature) {
            if ($this->GetY() + $h >= ($this->GetPageHeight() - $hBreak)) {
                $this->AddPage($this->CurOrientation);
            }
        }
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


    public $site_name = null;
    public $short_name = null;
    public $logo_icon = null;
    public $logo_icon_path = null;
    public $address = null;
    public $email = null;
    public $phone_number = null;
    public $facsimile = null;

    public $institution_name = "{ Silahkan Atur Nama Institusi Pada Pengaturan }";
    public $institution_address = "{ Silahkan Atur Alamat Institusi\nPada Pengaturan }";

    public $header1 = 'PANITIA PENERIMAAN MAHASISWA BARU';
    public $header2 = 'Kota Pekanbaru - Riau';

    function data_core()
    {
        $site_name = config('app.name', 'Laravel');
        $short_name = ucwords(request()->getHttpHost());
        $logo_icon_path = 'assets/img/logo-default.png';
        $logo_icon = asset($logo_icon_path);
        $address = null;
        $email = null;
        $phone_number = null;
        $facsimile = null;

        $core = WebSettings::first();
        if ($core) {
            // if ($core->logo_icon) {
            //     $logo_icon = asset('storage/' . $core->logo_icon);
            //     $logo_icon_path = 'storage/' . $core->logo_icon;
            // }
            $site_name = $core->site_name ?? $site_name;
            $short_name = $core->short_name ?? $short_name;
            $address = $core->contact_address ?? $address;
            $email = $core->contact_email ?? $email;
            $phone_number = $core->contact_telp ?? $phone_number;
            $facsimile = $core->contact_fax ?? $facsimile;
        }
        $this->logo_icon = $logo_icon;
        $this->logo_icon_path = $logo_icon_path;
        $this->site_name = $site_name;
        $this->short_name = $short_name;
        $this->address = $address;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->facsimile = $facsimile;

        if ($core->institution_name)
            $this->institution_name = $core->institution_name;
        if ($core->contact_address)
            $this->institution_address = $core->contact_address;
    }

    function image_kop()
    {
        $this->Image(public_path('assets/img/logo-default.png'), 10, 10, 19, 20);
    }
    function image_kop_ls()
    {
        $this->Image(public_path('assets/img/logo-default.png'), 15, 10, 18, 20);
    }

    function title_kop()
    {
        $this->SetFont('Times', 'B', '16');
        $x = 10;
        $wIcon = 20;
        $wText = 170;
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell($wText, 6, $this->header1, 0, 1, 'C');

        $fontSize = 14;
        $lengthOpdName = strlen($this->institution_name);
        if ($lengthOpdName >= 59)
            $fontSize = 11;
        elseif ($lengthOpdName >= 54 and $lengthOpdName <= 58)
            $fontSize = 13;
        elseif ($lengthOpdName >= 50 and $lengthOpdName <= 53)
            $fontSize = 14;
        elseif ($lengthOpdName >= 45 and $lengthOpdName <= 49)
            $fontSize = 15;
        elseif ($lengthOpdName >= 40 and $lengthOpdName <= 44)
            $fontSize = 15.5;
        else
            $fontSize = 16;

        $this->SetFont('Times', 'B', $fontSize);
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell($wText, 6, $this->institution_name, 0, 1, 'C');

        $this->SetFont('Times', '', '11');
        $this->setX($x);
        $this->Cell($wIcon);
        $this->MultiCell($wText, 5, $this->institution_address, 0, 'C'); // . ' ' . $this->header2

        $this->SetFont('Times', 'B', '11');
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell($wText, 5, 'P E K A N B A R U ', 0, 1, 'C');
    }
    function title_kop_ls()
    {
        $this->SetFont('Times', 'B', '20');
        $x = 10;
        $wIcon = 30;
        // $wText = 170;
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell(0, 5, $this->header1, 0, 1, 'C');
        $this->ln(2);
        // $this->SetFontSpacing(0);
        $this->SetFont('Times', 'B', '18');
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell(0, 5, $this->institution_name, 0, 1, 'C');
        $this->ln(1);
        $this->SetFont('Times', '', '12');
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell(0, 5, trim(preg_replace('/\s+/', ' ', $this->institution_address)), 0, 1, 'C');
        $this->SetFont('Times', 'B', '12');
        $this->setX($x);
        $this->Cell($wIcon);
        $this->Cell(0, 5, 'P E K A N B A R U - ', 0, 1, 'C');
    }

    function line_kop()
    {
        $h = $this->getY();
        $y = $h + 1;
        $this->SetLineWidth(0);
        $this->Line(10, $y, $this->GetPageWidth() - 10, $y);
        $this->SetLineWidth(1);
        $this->Line(10, $y + 1, $this->GetPageWidth() - 10, $y + 1);
    }
    function line_kop_ls()
    {
        $h = $this->getY();
        $y = $h + 2;
        $this->SetLineWidth(0);
        $this->Line(10, $y, $this->GetPageWidth() - 10, $y);
        $this->SetLineWidth(1);
        $this->Line(10, $y + 1, $this->GetPageWidth() - 10, $y + 1);
    }

    public $skipHeader = false;
    public $skipFooter = false;

    function Header()
    {
        $this->data_core();
        if (!$this->skipHeader) {
            if ($this->DefOrientation == 'P') {
                $this->image_kop();
                $this->title_kop();
                $this->line_kop();
            } else {
                $this->image_kop_ls();
                $this->title_kop_ls();
                $this->line_kop_ls();
            }
            $this->Ln(8);
        }
    }
    function Footer()
    {
        if (!$this->skipFooter) {
            if ($this->DefOrientation == 'P') {
                $this->SetY(-10);
                $this->SetX(5);
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('Times', '', 8);

                $widthLR = 2 / 5 * $this->GetPageWidth() - 5;
                $widthC = 1 / 5 * $this->GetPageWidth();
                // $this->Cell($widthLR, 10, 'Data di-export melalui ' . ucwords(request()->getHttpHost()), 0, 0, 'L'); // $this->short_name
                // $this->Cell($widthC, 10, 'Hal ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
                $this->Cell($widthLR, 10, 'Pada : ' . date('d-m-Y H:i:s'), 0, 0, 'L');
            } else {
                $this->SetY(-10);
                $this->SetX(5);
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('Times', '', 8);

                $widthLR = 2 / 5 * $this->GetPageWidth() - 5;
                $widthC = 1 / 5 * $this->GetPageWidth();
                $this->Cell($widthLR, 10, 'Data di-export melalui ' . ucwords(request()->getHttpHost()), 0, 0, 'L');
                $this->Cell($widthC, 10, 'Hal ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
                $this->Cell($widthLR, 10, 'Pada : ' . date('d-m-Y H:i:s'), 0, 0, 'R');
            }
        }
    }


    protected $cs;

    function SetFontSpacing($cs = 0)
    {
        $this->cs = $cs;
        $this->_out(sprintf('BT %.3F Tc ET', $cs * $this->k));
    }
    // protected $FontSpacingPt;      // current font spacing in points
    // protected $FontSpacing;        // current font spacing in user units
    // function SetFontSpacing($size) {
    //     if ($this->FontSpacingPt==$size)
    //         return;
    //     $this->FontSpacingPt = $size;
    //     $this->FontSpacing = $size/$this->k;
    //     if ($this->page>0)
    //         $this->_out(sprintf('BT %.3f Tc ET', $size));
    // }

    // function GetStringWidth($s) {
    //     // Get width of a string in the current font
    //     $s = (string)$s;
    //     $cw = &$this->CurrentFont['cw'];
    //     $w = 0;
    //     $l = strlen($s);
    //     for($i=0;$i<$l;$i++) {
    //         $charw = $cw[$s[$i]];
    //         $wtf = $this->cs/4+1;
    //         $w += $charw*$wtf;
    //     }
    //     return $w*$this->FontSize/1000;
    // }


    protected $col = 0;
    protected $y0;

    function SetCol($col)
    {
        $this->col = $col;
        $x = 10 + $col * 100; // 65 for 3 column
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        if ($this->col < 1) // 1 for 2 column
        {
            $this->SetCol($this->col + 1);
            $this->SetY($this->y0);
            return false;
        } else {
            $this->SetCol(0);
            return true;
        }
    }

    function ChapterTitle($num, $label)
    {
        // Title
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, "Chapter $num : $label", 0, 1, 'L', true);
        $this->Ln(4);
        // Save ordinate
        $this->y0 = $this->GetY();
    }

    function ChapterBody($file)
    {
        // Read text file
        $txt = file_get_contents($file);
        // Font
        $this->SetFont('Times', '', 12);
        // Output text in a 6 cm width column
        $this->MultiCell(60, 5, $txt); // 60 for 3 column
        $this->Ln();
        // Mention
        $this->SetFont('', 'I');
        $this->Cell(0, 5, '(end of excerpt)');
        // Go back to first column
        $this->SetCol(0);
    }

    function PrintChapter($num, $title, $file)
    {
        // // [Original] Add chapter
        // $this->AddPage();
        // $this->ChapterTitle($num,$title);
        // $this->ChapterBody($file);

        // Add chapter
        $this->AddPage();
        $this->ChapterTitle($num, $title);
        $this->ChapterBody($file);
    }

    function PrintText($txt)
    {
        // Save ordinate
        $this->y0 = $this->GetY();
        // $txt = file_get_contents($txt);
        // Output text in a 6 cm width column
        $this->MultiCell(160 / 2, 5, $txt); // 60 for 3 column
        $this->Ln();
        // Go back to first column
        $this->SetCol(0);
    }
}
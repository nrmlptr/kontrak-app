<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;
use Spatie\PdfToImage\Pdf;
use Org_Heigl\Ghostscript\Ghostscript;

class PDFConvertController extends Controller
{
    //
    public function index()
    {
        $pdf_file = public_path() . "/tespdf/standartes1.pdf";
        // dd($pdf_file);
        $output_path = public_path() . "/tesimage/";
        // Ghostscript::setGsPath("C:\Program Files\gs\gs10.03.1\bin\gswin64c.exe");
        $pdf1 = new Pdf($pdf_file);
        // dd($pdf1);
        // $pdf1->setOutputFormat('png')->saveImage($output_path);
        $pdf1->quality(90)->save($output_path);
    }
}

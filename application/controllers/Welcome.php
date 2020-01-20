<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'tcpdf.php';
class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
	function veri(){
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle('CERTIFICADO');
// remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//// set margins
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set font
        $pdf->SetFont('times', 'BI', 12);
// add a page
        $pdf->AddPage();

// set some text to print
        $txt = <<<EOD
TCPDF Example 002

Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
EOD;

// print a block of text using Write()
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
        $pdf->Output('example_002.pdf', 'I');
    }
}

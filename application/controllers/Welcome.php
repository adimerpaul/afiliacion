<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'tcpdf.php';
include "qrlib.php";
class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
	function veri(){


//        exit;
	    $ci=$_POST['ci'];
        $dia=$_POST['dia'];
        $mes=$_POST['mes'];
        $anio=$_POST['anio'];
        $nombres= strtoupper( $_POST['nombres']);
        $paterno=strtoupper($_POST['paterno']);
        $materno=strtoupper($_POST['materno']);
        $codafiliacion=0;
        $query=$this->db->query("SELECT max(ID) as MAXIMO FROM CONSULTAAFILIACION");
        $id=$query->row()->MAXIMO+1;

	    $query=$this->db->query("SELECT *
FROM PACIENTE P
INNER JOIN AFILIACION A ON P.COD_PACIENTE=A.COD_PACIENTE
WHERE P.CI='$ci' AND P.DIA='$dia' AND P.MES='$mes' AND P.GESTION='$anio'");

	    if($query->num_rows()==1){
	        $nombres=$query->row()->NOMBRE;
            $paterno=$query->row()->A_PATERNO;
            $materno=$query->row()->A_MATERNO;
            $codafiliacion=$query->row()->COD_AFILIACION;
            $text="";
            $co="A";
            $afiliado="SI";
        }else{
	        $text="NO";
            $co="NA";
            $afiliado="NO";
        }
        $codigo="OR-SSU-$co".str_pad($id, 5, "0", STR_PAD_LEFT);;
        $mesCon=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Actubre","Noviembre","Diciembre"];

        $this->db->query("INSERT INTO CONSULTAAFILIACION VALUES('$id','$nombres','$paterno','$materno','$ci','$dia','$mes','$anio','".date('m/d/Y')."','$codigo','$afiliado','$codafiliacion')");
//        exit;
// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Adimer Paul Chambi Ajata');
        $pdf->SetTitle('Certificado de Afiliacion');
//        $pdf->SetSubject('TCPDF Tutorial');
//        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $realizado="https://ssuoruro.gob.bo/";
        $pdf->SetHeaderData('ssu2.jpg', 20, 'CERTIFICADO DE '.$text.' AFILIACIÓN', $realizado, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

// set text shadow effect

        QRcode::png("Nombre=$paterno $materno $nombres|Nacimiento=$dia de $mes Del $anio|CI=$ci|Codigo=$codigo", 'img/a.png', QR_ECLEVEL_L, 4);
// Set some content to print
        $html = '
<br>
<h2 align="center">SEGURO SOCIAL UNIVERSITARIO DE ORURO  </h2>
<p>Oruro, '.date('d').' de '.$mesCon[(int)(date('m')-1)].' del '.date('Y').'</p>
<h4 align="center">Formulario de '. ucfirst(strtolower($text)).' Afiliación al  <br>Seguro Social Universitario de Oruro </h4>
<p>SEGURO SOCIAL UNIVERSITARIO DE ORURO, A SOLICITUD DEL INTERESADO: </p>
<p align="justify">Da a conocer que: De acuerdo a la base de datos del Seguro Social Universitario de Oruro, '.$paterno.' '.$materno.' '.$nombres.', con documento de identidad '.$ci.' y fecha de nacimiento '.$dia.' de  '.strtolower($mes).' del '.$anio.', '.strtolower($text).' se encuentra afiliado (a) en nuestro seguro de salud.</p>
<p align="center">
<img src="img/a.png" alt="">
</p>
<p><b>AVISO:</b> La veracidad de la presente certificación puede ser verificada introduciendo el
código de certificado en https://ssuoruro.gob.bo/ o a través del
Código QR con un dispositivo móvil.</p>
<p><b>CODIGO DE CONTROL:</b> '.$codigo.'</p>
<p>La validez del presente documento es de 60 días a partir de la fecha de emisión.</p>
<br>
<br>
<p>La reproducción total o parcial y/o el uso no autorizado de este documento, constituye un delito de ser sancionado conforme a la ley</p>

';
//        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    }
}

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
        $ci=trim(strtoupper($_POST['ci']));
        $dia=$_POST['dia'];
        $mes=$_POST['mes'];
        $anio=$_POST['anio'];
        $nombres=trim(strtoupper( $_POST['nombres']));
        $paterno=trim(strtoupper($_POST['paterno']));
        $materno=trim(strtoupper($_POST['materno']));
        $codafiliacion=0;
                $query=$this->db->query("SELECT *
                FROM PACIENTE P
                INNER JOIN AFILIACION A ON P.COD_PACIENTE=A.COD_PACIENTE
                WHERE P.CI like '$ci%' AND P.DIA='$dia' AND P.MES='$mes' AND P.GESTION='$anio' AND A.ESTADO='V'");
if($query->num_rows()>0){
        //if(intval ($query->row()->CI)==$ci){
                $nombres=$query->row()->NOMBRE;
                $paterno=$query->row()->A_PATERNO;
                $materno=$query->row()->A_MATERNO;
                $codafiliacion=$query->row()->COD_AFILIACION;
                $matricula=$query->row()->MATRICULA;
                $text="";
                $co="A";
                $afiliado="SI";
        /*}else{
                $text="NO";
                $co="NA";
                $afiliado="NO";
        }*/
        
}else{
        $text="NO";
    $co="NA";
    $afiliado="NO";
    $codafiliacion=0;
    $matricula="NNN";
}

//echo $afiliado;
//exit;
$host = 'localhost:/Lazzarus/CERTIFICADOS.fdb';
$gestor_db = ibase_connect($host, 'SYSDBA', 'cde3vfr4');
$sentencia = 'SELECT max(ID_CERTIFICADOS) as MAXIMO FROM CERTIFICACION';
$gestor_sent = ibase_query($gestor_db, $sentencia);
while ($fila = ibase_fetch_object($gestor_sent)) {
    $id=$fila->MAXIMO+1;
}
//ibase_free_result($gestor_sent);
//ibase_close($gestor_db);

        //exit;
	
        //$query=$this->db->query("SELECT max(ID) as MAXIMO FROM CONSULTAAFILIACION");
        //$id=$query->row()->MAXIMO+1;

/*	    $query=$this->db->query("SELECT *
FROM PACIENTE P
INNER JOIN AFILIACION A ON P.COD_PACIENTE=A.COD_PACIENTE
WHERE P.CI='$ci' AND P.DIA='$dia' AND P.MES='$mes' AND P.GESTION='$anio'");*/
/*
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
        }*/
        $codigo="OR-SSU-$co".str_pad($id, 5, "0", STR_PAD_LEFT);;
        $mesCon=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Actubre","Noviembre","Diciembre"];
        $sentencia = "INSERT INTO CERTIFICACION VALUES('$id','$nombres','$paterno','$materno','$ci','$dia','$mes','$anio','".date('m/d/Y')."','$codigo','$afiliado','$codafiliacion','AFILIACION')";
$gestor_sent = ibase_query($gestor_db, $sentencia);
//exit;
        //$this->db->query("INSERT INTO CONSULTAAFILIACION VALUES('$id','$nombres','$paterno','$materno','$ci','$dia','$mes','$anio','".date('m/d/Y')."','$codigo','$afiliado','$codafiliacion')");
//        exit;
// create new PDF document
        if($afiliado=="SI"){
                echo "<h3 style='background:#dd2c00;color:white;font-size:15px;padding:10px'>Usted se encuentra afiliado al Seguro Social Universitario Oruro</h3>
                <a href='https://www.ssuoruro.gob.bo/afiliacion/'>Volver a consular</a>";
                exit;
        }


        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Seguro Social Universitario');
        $pdf->SetTitle('Certificado de Afiliacion');
//        $pdf->SetSubject('TCPDF Tutorial');
//        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $realizado="https://wwww.ssuoruro.gob.bo/";
        $pdf->SetHeaderData('ssu2.jpg', 20, 'SEGURO SOCIAL UNIVERSITARIO', "Ente Gestor de la Seguridad Social de Corto Plazo\nhttps://ssuoruro.gob.bo
        ", array(0,0,0), array(0,0,0));
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

        QRcode::png("Nombre=$paterno $materno $nombres|Nacimiento=$dia de $mes Del $anio|CI=$ci|Codigo=$codigo|$codafiliacion-$matricula", 'img/a.png', QR_ECLEVEL_L, 4);
// Set some content to print
        $html = '
<p>Oruro, '.date('d').' de '.$mesCon[(int)(date('m')-1)].' del '.date('Y').'</p>
<p><b>Código de Control: </b> '.$codigo.'</p>

<br>
<div></div>
<br>
<div></div>
<br>
<h2 align="center">FORMULARIO DE '.$text.' AFILIACIÓN </h2>

<br>
<div></div>
<br>
<div></div>
<br>
<p align="justify">El Departamento de Seguros del Seguro Social Universitario Oruro, en atención a la solicitud vía página Web por el(la) interesado(a), hace saber que:</p>
<p>De acuerdo a la Base de Datos del Seguro Social Universitario Oruro, se tiene que el (la) señor(a): '.$paterno.' '.$materno.' '.$nombres.' con Cédula de Identidad  '.$ci.'  y fecha de nacimiento '.$dia.' de  '.strtolower($mes).' del '.$anio.', '.strtolower($text).' se encuentra afiliado(a) en nuestro seguro de salud.</p>
<p><b><u>MEDIDA DE SEGURIDAD</u></b></p>
<p align="rigth">
<img src="img/a.png" alt="">
</p>
<p>NOTAS: </p>
<p align="justify">La validez del presente documento es de 60 días a partir de la fecha de emisión.</p>
<p align="justify">La modificación total o parcial y/o el uso no indebido de este documento será de estricta responsabilidad del solicitante, constituyendo un delito de ser sancionado conforme a Ley.</p>
<br>
<p align="justify">La veracidad del presente Formulario puede ser verificada introduciendo el Código de Control en <u>https://www.ssuoruro.gob.bo/</u> o a través del Código QR con un dispositivo móvil.</p>

';
//<p align="justify">Da a conocer que: De acuerdo a la base de datos del Seguro Social Universitario de Oruro, '.$paterno.' '.$materno.' '.$nombres.', con documento de identidad '.$ci.' y fecha de nacimiento '.$dia.' de  '.strtolower($mes).' del '.$anio.', '.strtolower($text).' se encuentra afiliado (a) en nuestro seguro de salud.</p>
//        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('Seguro Social Universitario.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    }
}

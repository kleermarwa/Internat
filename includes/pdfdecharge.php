<?php
session_start();
// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-main/tcpdf.php');
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT decharge.*, students.*
        FROM decharge
        JOIN students ON decharge.student_id = students.id
        WHERE decharge.student_id = '$user_id'
        AND decharge.status = 'Validé'";


$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$departement = $data[0]['filliere'];

$currentYear = date('Y');
$previousYear = $currentYear - 1;
$yearRange = $previousYear . '/' . $currentYear;

$room = $data[0]['room_number'];
$chambre = ($room == NULL) ? 'externe' : "résidant dans chambre N° : $room";

$nameArray = explode(' ', $data[0]['name']);
$firstName = $nameArray[0];
$datetime = $data[0]['updated_at'];
$genre = $data[0]['genre'];
$name = $data[0]['name'];
$email = $data[0]['email'];
$id = $data[0]['id_demande'];
$designation = ($genre == 'boy') ? 'l\'étudiant ' : 'l\'étudiante ';
$annee_scolaire = $data[0]['annee_scolaire'];
$année = ($annee_scolaire == '2') ? '2<sup>ème</sup> ' : '1<sup>ère</sup> ';
$cher = ($genre == 'boy') ? 'Cher ' : 'Chère ';
$date = date('d-m-Y', strtotime($datetime));

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Service des Affaires d\'internat ESTC');
$pdf->SetTitle('Décharge ' . $name);
$pdf->SetSubject('Internat');
$pdf->SetKeywords('TCPDF, PDF, estc, Décharge, internat ,chambre');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// ---------------------------------------------------------
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = <<<EOD
<table style="width: 100%;">
<tr>
  <td style="color:#004b82">
    <p>L'Université Hassan II <br>Ecole Supérieure de Technologie<br>Casablanca</p>
  </td>
  <td style="text-align: right;">
    <img src="../images/logo.png" alt="estc" style="width: 100px; height: auto;">
  </td>
</tr>
</table> <hr> 
<h2 style="text-align: center;font-style: italic;"> ATTESTATION</h2>
<h2 style="text-align: center;"> ********</h2>
<div>
<p style="text-align: center;"> Les signataires suivants attestent avoir reçu et vérifié le matériel remis par $designation : $name , inscrit en $année année.
Département : $departement , année universitaire : $yearRange, $chambre. <br><br> En conséquance $designation est libre de tout engagement auprès des services concernés.  </p>
<div style="text-align: center;">
<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;width: 100%;">
    <tbody><tr style="background-color: #ecf0f1; font-weight: bold;">
      <td>ADMINISTRATION</td>
      <td>OBSERVATION</td>
    </tr>
    <tr>
      <td> <br> <br> <br> <br></td>
      <td></td>
    </tr>
  </tbody></table> 
  <p> <br> </p>
  <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;width: 100%;">
    <tbody><tr style="background-color: #ecf0f1; font-weight: bold;">
      <td>SERVICE DES AFFAIRES DE L'INTERNAT</td>
      <td>OBSERVATION</td>
    </tr>
    <tr>
      <td>EN REGLE</td>
      <td>EXTERNE</td>
    </tr>
    <tr>
      <td> <br> <br> <br> <br></td>
      <td></td>
    </tr>
  </tbody></table> 
  <p> <br> </p>
  <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;width: 100%;">
    <tbody><tr style="background-color: #ecf0f1; font-weight: bold;">
      <td>SERVICE ECONOMIQUE</td>
      <td>OBSERVATION</td>
    </tr>
    <tr>
      <td>EN REGLE</td>
      <td>EXTERNE</td>
    </tr>
    <tr>
      <td> <br> <br> <br> <br></td>
      <td></td>
    </tr>
  </tbody></table> 
  <p> <br> </p>
  <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;width: 100%;">
    <tbody><tr style="background-color: #ecf0f1; font-weight: bold;">
      <td>DEPARTEMENT</td>
      <td>OBSERVATION</td>
    </tr>
    <tr>
      <td>EN REGLE</td>
      <td>EXTERNE</td>
    </tr>
    <tr>
      <td> <br> <br> <br> <br></td>
      <td></td>
    </tr>
  </tbody></table>
  <p>N.B : Cette attestation doit être rendue au service des affaires estudiantines.</p> 
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Décharge ' . $name . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
<?php
session_start();
// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-main/tcpdf.php');
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT internat.*, students.*, internat.room_number AS room_alias
        FROM internat
        JOIN students ON internat.student_id = students.id
        WHERE internat.student_id = '$user_id'
        AND internat.status = 'Accepté'";


$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
$nameArray = explode(' ', $data[0]['name']);
$firstName = $nameArray[0];
$datetime = $data[0]['updated_at'];
$genre = $data[0]['genre'];
$name = $data[0]['name'];
$email = $data[0]['email'];
$room = $data[0]['room_alias'];
$id = $data[0]['id_demande'];
$designation = ($genre == 'boy') ? 'Etudiant :' : 'Etudiante :';
$cher = ($genre == 'boy') ? 'Cher ' : 'Chère ';
$date = date('d-m-Y', strtotime($datetime));




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Service des Affaires d\'internat ESTC');
$pdf->SetTitle('Approbation ' . $name);
$pdf->SetSubject('Internat');
$pdf->SetKeywords('TCPDF, PDF, estc, approbation, internat ,chambre');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

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
    <p>L'Université Hassan II</p>
    <p>Ecole Supérieure de Technologie</p>
    <p>Casablanca</p>
  </td>
  <td style="text-align: right;">
    <img src="../images/logo.png" alt="estc" style="width: 100px; height: auto;">
  </td>
</tr>
</table> <br> <hr> <br>
<h2 style="text-align: center;font-style: italic;"> ATTESTATION D'APPROBATION </h2>
<div>
<p style="margin-left: 10rem;">$designation $name<p>
<p>Email : <span style="color:blue"> $email </span> </p>
<p>N° Demande :  $id </p> <br><br>
<p>               $cher $firstName,</p>
<p>RE : APPROBATION DE LA DEMANDE DE CHAMBRE</p>
<p>Les détails de votre affectation de chambre sont les suivants :</p>
<ul>
  <li>Numéro de chambre : $room</li>
  <li>Date d'arrivée : [Date d'arrivée]</li>
</ul>
<p>Veuillez vous assurer de respecter la date d'arrivée fournie. Tout manquement pourrait entraîner des ajustements de votre affectation de chambre.</p>
<p>Pour finaliser la procédure d'affectation de chambre, veuillez vous présenter à l'école avec cet attestation pour valider votre hébergement et récupérer les clés. Sans cette validation, votre demande pourrait être annulée.</p>

<h3 style="text-align: center;">Internat</h3>
<p style="text-align: center;">Les frais d'internat sont répartis comme suit : <br>
Logement: (Mi-Septembre + Octobre + Novembre + Décembre) 350 DH <br>
Frais de restaurant : (Mi-Septembre + Octobre + Novembre + Décembre) 525 DH <br>
Caution de l'internat : 200 DH <br>
Frais de tirage (Premier Trimestre) 100 DH <br>
<h4 style="text-align: center;">Total : 1175 DH</h4> <br>
Aucun frais ne sera remboursé après inscription.</p>
</div>
<hr>
<p>Cordialement,</p> 
<p>Ecole Supérieure de Technologie de Casablanca<br>
Service des Affaires d'internat<br>
ESTC : Km 7, Route d'El Jadida, B.P. : 8012 OASIS, Casablanca.</p>
<table style="width: 100%;">
<tr>
  <td style="text-align: right;">
    <p> Fait à Casablanca, Le $date </p>
  </td>
</tr>
</table>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Approbation ' . $name . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
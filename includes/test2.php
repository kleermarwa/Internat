<?php
// Include database connection
include 'db_connect.php';

$user_id = 1;

$sql = "SELECT internat.*, students.*
        FROM internat
        JOIN students ON internat.student_id = students.id
        WHERE internat.student_id = '$user_id'
";
$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
$nameArray = explode(' ', $data[0]['name']);
$firstName = $nameArray[0];

?>
<table style="width: 100%;">
  <tr>
    <td>
      <p>L'Université Hassan II</p>
      <p>Ecole Supérieure de Technologie</p>
      <p>Casablanca</p>
    </td>
    <td style="text-align: right;">
      <img src="../images/logo.png" alt="estc" style="width: 100px; height: auto;">
    </td>
  </tr>
</table>
<!-- Section du corps -->
<div style="padding: 20px;">
  <p>Date : <?= $data[0]['updated_at'] ?></p>
  <p><?php echo $data[0]['genre'] == 'boy' ? 'Etudiant : ' : 'Etudiante : '; ?><?= $data[0]['name'] ?><br>
  <p>Email : <?= $data[0]['email'] ?></p>
  <p>N° Demande :  <?= $data[0]['id_demande'] ?></p>
  <p style="margin-left: 30px;"><?php echo $data[0]['genre'] == 'boy' ? 'Cher ' : 'Chère ';
      echo $firstName; ?>,</p>
  <p>RE : APPROBATION DE LA DEMANDE DE CHAMBRE</p>
  <p>Les détails de votre affectation de chambre sont les suivants :</p>
  <ul>
    <li>Numéro de chambre : <?= $data[0]['room_number'] ?></li>
    <li>Date d'arrivée : [Date d'arrivée]</li>
  </ul>
  <p>Veuillez vous assurer de respecter la date d'arrivée fournie. Tout manquement pourrait entraîner des ajustements de votre affectation de chambre.</p>
  <p>Pour finaliser la procédure d'affectation de chambre, veuillez vous présenter à l'école avec cet attestation pour valider votre hébergement et récupérer les clés. Sans cette validation, votre demande pourrait être annulée.</p>

  <div style="text-align: center;">
    <h3>Internat</h3>
    <p>Les frais d'internat sont répartis comme suit : <br>
      Logement: (Mi-Septembre + Octobre + Novembre + Décembre) 350 DH <br>
      Frais de restaurant : (Mi-Septembre + Octobre + Novembre + Décembre) 525 DH <br>
      Caution de l'internat : 200 DH <br>
      Frais de tirage (Premier Trimestre) 100 DH <br><br>
    <h4>Total : 1175 DH</h4> <br>
    Aucun frais ne sera remboursé après inscription.</p>
  </div>
  <p>Cordialement,</p>
  <p>Ecole Supérieure de Technologie de Casablanca<br>
    Service des Affaires d'internat<br>
    ESTC : Km 7, Route d'El Jadida, B.P. : 8012 OASIS, Casablanca.</p>
</div>
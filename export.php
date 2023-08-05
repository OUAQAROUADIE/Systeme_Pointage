<?php
require 'connexion.php';

// Check the export type (PDF or Excel)
$type = isset($_GET['type']) ? $_GET['type'] : 'pdf';

// Fetch all contacts
$stmt = $pdo->prepare('SELECT stagiaire.*, fonction.titre AS fonction_titre
FROM stagiaire
JOIN fonction ON stagiaire.id_fonction = fonction.id_fonction;');
$stmt->execute();
$stagiaireData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Export as PDF
require_once('TCPDF/tcpdf.php');

function generateTablePDF($tableData, $filename, $tableName) {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle($filename);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();

    // Generate PDF based on table name
    switch ($tableName) {
        case 'stagiaire':
            generateStagiaireTablePDF($pdf, $tableData);
            break;
        case 'pointage':
            generatePointageTablePDF($pdf, $tableData);
            break;
        default:
            // Handle unknown table name
            break;
    }

    $pdf->Output($filename . '.pdf', 'D');
    exit();
}

function generateStagiaireTablePDF($pdf, $tableData) {
    $html = '<h2>Liste des Stagiaires</h2><table><thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Telephone</th><th>Fonction</th></tr></thead>';

    foreach ($tableData as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['Nom'].'</td>';
        $html .= '<td>'.$row['Prenom'].'</td>';
        $html .= '<td>'.$row['Email'].'</td>';
        $html .= '<td>'.$row['Tele'].'</td>';
        $html .= '<td>'.$row['fonction_titre'].'</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}

function generatePointageTablePDF($pdf, $tableData) {
    $html = '<h2>Pointage</h2><table><thead><tr><th>Nom</th><th>Prénom</th><th>Date-D</th><th>Date-F</th></tr></thead>';

    foreach ($tableData as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['Nom'].'</td>';
        $html .= '<td>'.$row['Prenom'].'</td>';
        $html .= '<td>'.$row['Date-D'].'</td>';
        $html .= '<td>'.$row['Date-F'].'</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}

$tableName = isset($_GET['table']) ? $_GET['table'] : '';

if ($tableName === 'stagiaire') {
    generateTablePDF($stagiaireData, 'Liste des Stagiaires', 'stagiaire');
} elseif ($tableName === 'pointage') {
    // Fetch data for pointage table
    $stmt = $pdo->prepare('SELECT stagiaire.Nom, stagiaire.Prenom, pointage.`Date-D`, pointage.`Date-F`
                           FROM stagiaire
                           JOIN pointage ON stagiaire.id = pointage.`stagiaire_id`
                           ORDER BY pointage.`Date-F` DESC');
    $stmt->execute();
    $pointageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    generateTablePDF($pointageData, 'Pointage', 'pointage');
} else {
    // Handle unknown table name
}
?>

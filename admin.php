<?php
include 'design.php';
require 'connexion.php';

$requete = "SELECT stagiaire.*, fonction.titre AS fonction_titre
FROM stagiaire
JOIN fonction ON stagiaire.id_fonction = fonction.id_fonction;";

$stmt = $pdo->query($requete);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    function exportToExcel() {
        // Créer le fichier Excel
        var workbook = XLSX.utils.book_new();

        // Convertir les données en un tableau compatible avec SheetJS
        var dataArray = <?php echo json_encode($contacts); ?>;
        var sheetData = dataArray.map(function(item) {
            return [item.Nom, item.Prenom, item.Email, item["Date-D"], item.Date_F, item.Adresse, item.Tele, item.fonction_titre];
        });

        // Créer une feuille de calcul
        var worksheet = XLSX.utils.aoa_to_sheet([
            ["Nom", "Prénom", "Email", "Date D", "Date F", "Adresse", "Téléphone", "Fonction"],
            ...sheetData
        ]);

        // Ajouter la feuille de calcul au classeur
        XLSX.utils.book_append_sheet(workbook, worksheet, "Liste des Stagiaires");

        // Convertir le classeur en un fichier Excel binaire
        var excelData = XLSX.write(workbook, { bookType: "xlsx", type: "array" });

        // Créer un objet Blob à partir des données Excel
        var blob = new Blob([excelData], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });

        // Créer un URL object à partir du blob
        var url = URL.createObjectURL(blob);

        // Créer un lien de téléchargement et cliquer dessus pour télécharger le fichier Excel
        var link = document.createElement("a");
        link.href = url;
        link.download = "Liste des stagiaires.xlsx";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>

<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<?php
ob_start(); // Start output buffering
?>

<h2>Liste des Stagiaires</h2>
<div class="row align-items-center mb-3">
    <div class="col">
        <div class="export-button mb-2">
            <button style="border:none; background-color:#f8f8fd;"><a href="export.php?type=pdf&table=stagiaire" class="export-link">PDF<i class="fa-solid fa-download"></i></a></button>
            <button onclick="exportToExcel()" style="border:none; background-color:#f8f8fd;"><a class="export-link">Excel <i class="fa-solid fa-download"></i></a></button>
        </div>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="add-stagiaire mb-2">
            <button type="button" class="btn btn-warning">
                <a href="create.php" class="text-white">Ajouter <i class="fa-solid fa-square-plus"></i></a>
            </button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Date D</th>
                <th scope="col">Date F</th>
                <th scope="col">Adresse</th>
                <th scope="col">Image</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Fonction</th>
                <th scope="col">CV</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr scope="row">
                <td class="align-middle"><?php echo $contact['Nom']; ?></td>
                <td class="align-middle"><?php echo $contact['Prenom']; ?></td>
                <td class="align-middle"><?php echo $contact['Email']; ?></td>
                <td class="align-middle"><?php echo $contact['Date-D']; ?></td>
                <td class="align-middle"><?php echo $contact['Date_F']; ?></td>
                <td class="align-middle"><?php echo $contact['Adresse']; ?></td>
                <td class="align-middle">
                    <?php if (!empty($contact['Image'])): ?>
                    <img src="images/<?php echo $contact['Image']; ?>" alt="<?php echo $contact['Nom']; ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;" class="contact-image">
                    <?php else: ?>
                    No Image
                    <?php endif; ?>
                </td>
                <td class="align-middle"><?php echo $contact['Tele']; ?></td>
                <td class="align-middle"><?php echo $contact['fonction_titre']; ?></td>
                <td class="align-middle">
                    <?php if (!empty($contact['CV'])): ?>
                    <a href="cvs/<?php echo $contact['CV']; ?>" target="_blank"><i class="fas fa-file"></i></a>
                    <?php else: ?>
                    No CV
                    <?php endif; ?>
                </td>
                <td class="align-middle">
                    <div class="d-flex">
                        <button type="button" class="btn btn-warning mr-2 align-middle"><a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs" style="color: #ffffff;"></i></a></button>
                        <button type="button" class="btn btn-danger mr-2 align-middle"><a href="delete.php?id=<?php echo $contact['id']; ?>" class="trash"><i class="fas fa-trash fa-xs" style="color: #ffffff;"></i></a></button>
                        <button type="button" class="btn btn-primary align-middle"><a href="pointage-stagiaire.php?id=<?php echo $contact['id']; ?>" class=""><i class=" fa-solid fa-user" style="color: #ffffff;"></i></a></button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

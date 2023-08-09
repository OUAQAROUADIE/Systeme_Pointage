<?php
include 'design.php';
require 'connexion.php';

$requete = "SELECT * FROM fonction";
$stmt = $pdo->query($requete);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php
ob_start(); // Start output buffering
?>

<h2>Liste des fonctions</h2>
<div class="row align-items-center mb-3">
    <div class="col d-flex justify-content-end">
        <div class="add-stagiaire mb-2">
            <button type="button" class="btn btn-warning">
                <a href="fonction_add.php" class="text-white">Ajouter <i class="fa-solid fa-square-plus"></i></a>
            </button>
        </div>
    </div>
</div>
<div class="col d-flex justify-content-end  col d-flex">
<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Titre</th>
                <th scope=" col d-flex justify-content-end ">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr scope="row">
                <td class="align-middle"><?php echo $contact['titre']; ?></td>
                <td class="align-middle">
                    <div class="d-flex flex-row-reverse">
                        <button type="button" class="btn btn-warning mr-2 align-middle"><a href="fonction_update.php?id_fonction=<?=$contact['id_fonction']?>" class="edit"><i class="fas fa-pen fa-xs" style="color: #ffffff;"></i></a></button>
                        <button type="button" class="btn btn-danger mr-2 align-middle"><a href="fonction_delete.php?id_fonction=<?php echo $contact['id_fonction']; ?>" class="trash"><i class="fas fa-trash fa-xs" style="color: #ffffff;"></i></a></button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

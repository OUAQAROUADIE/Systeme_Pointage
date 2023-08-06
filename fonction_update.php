<?php
include 'design.php';
require 'connexion.php';
$msg = '';

if (isset($_GET['id_fonction'])) {
    $id_fonction = $_GET['id_fonction'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_fonction = $_POST['id_fonction'];
        $titre = $_POST['titre'];

        $stmt = $pdo->prepare('UPDATE fonction SET titre = ? WHERE id_fonction = ?');
        $stmt->execute([$titre, $id_fonction]);
        $msg = 'Mis à jour avec succès !';
        header("Location: fonctions.php");
        exit();
    }

    $stmt = $pdo->prepare('SELECT * FROM fonction WHERE id_fonction = ?');
    $stmt->execute([$_GET['id_fonction']]);
    $stagiaire = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stagiaire) {
        exit('Le stagiaire avec cet ID n\'existe pas !');
    }
} else {
    exit('Aucun ID spécifié !');
}
ob_start(); // Start output buffering
?>
<div class="content update">
    <h2>Mettre à jour fonction: <?=$stagiaire['titre']?></h2>
    <form action="fonction_update.php?id_fonction=<?=$stagiaire['id_fonction']?>" method="post" >
  <input type="hidden" name="id_fonction" value="<?=$stagiaire['id_fonction']?>">

  <div class="form-group">
    <label for="titre">titre</label>
    <input type="text" class="form-control" name="titre" value="<?=$stagiaire['titre']?>" id_fonction="titre">
  </div>

  
  <input type="submit" class="btn btn-dark" value="Mettre à jour">
</form>

<?php if ($msg): ?>
  <p><?=$msg?></p>
<?php endif; ?>


<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

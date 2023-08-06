

<?php
include 'design.php';
require 'connexion.php';

$msg = '';

extract($_POST);

if (!empty($_POST)) {
    $id_fonction = !empty($id_fonction) && $id_fonction != 'auto' ? $id_fonction : NULL;
    $titre = isset($titre) ? $titre : '';
    

    $stmt = $pdo->prepare('INSERT INTO fonction (titre) VALUES ( ?)');
    $stmt->execute([$titre]);

    $msg = 'Created Successfully!';
    header('Location: fonctions.php');
    exit;
}

ob_start(); // Start output buffering
?>
<h2>Ajouter un poste:</h2>

<form action="fonction_add.php" method="post">
  <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" class="form-control w-25" name="titre" id="titre">
  </div>

  
 
  
  <button type="submit" class="btn btn-dark">Ajouter</button>
</form>

<?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

<?php
include 'design.php';
require 'connexion.php';
$msg = '';

// Vérifier si l'ID du contact est spécifié
if (isset($_GET['id_fonction'])) {
    // Sélectionner l'enregistrement qui va être supprimé
    $stmt = $pdo->prepare('SELECT * FROM fonction WHERE id_fonction = ?');
    $stmt->execute([$_GET['id_fonction']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact non trouvé avec cet ID !');
    }

    // Vérifier si l'utilisateur confirme la suppression
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // L'utilisateur a cliqué sur le bouton "Oui", supprimer l'enregistrement
            $stmt = $pdo->prepare('DELETE FROM fonction WHERE id_fonction = ?');
            $stmt->execute([$_GET['id_fonction']]);
            $msg = 'Vous avez supprimé le contact !';
            header('Location: fonctions.php');
        } else {
            // L'utilisateur a cliqué sur le bouton "Non", les rediriger vers la page de lecture
            header('Location: fonctions.php');
            exit;
        }
    }
} else {
    exit('Aucun ID spécifié !');
}
ob_start(); // Start output buffering
?>

<div class="content delete">
<h2>Supprimer <?=$contact['titre']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Êtes-vous sûr de vouloir supprimer fonction: <?=$contact['titre']?>?</p>
        <div class="yesno">
        <button type="button" class="btn btn-danger text-primary">
               <a href="fonction_delete.php?id_fonction=<?=$contact['id_fonction']?>&confirm=yes" class="delete_yes text-white">Oui</a>
        </button>

        <button type="button" class="btn btn-danger text-danger">
               <a href="fonction_delete.php?id_fonction=<?=$contact['id_fonction']?>&confirm=no" class="delete_no text-white">Non</a>
        </button>


        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

<?php
include 'design.php';
require 'connexion.php';

$msg = '';

extract($_POST);

if (!empty($_POST)) {
    $id = !empty($id) && $id != 'auto' ? $id : NULL;
    $name = isset($name) ? $name : '';
    $prenom = isset($prenom) ? $prenom : '';
    $email = isset($email) ? $email : '';
    $date_d = isset($date_d) ? $date_d : date('Y-m-d');
    $date_f = isset($date_f) ? $date_f : date('Y-m-d');
    $adresse = isset($adresse) ? $adresse : '';
    $tele = isset($tele) ? $tele : '';
    $username = isset($username) ? $username : '';
    $password = isset($password) ? $password : '';
    $image = isset($_FILES['image']) ? $_FILES['image']['name'] : '';
    $image_tmp = isset($_FILES['image']) ? $_FILES['image']['tmp_name'] : '';
    $id_fonction = isset($fonction) ? $fonction : '';
    $cv = isset($_FILES['cv']) ? $_FILES['cv']['name'] : '';
    $cv_tmp = isset($_FILES['cv']) ? $_FILES['cv']['tmp_name'] : '';

    // Upload image file
    move_uploaded_file($image_tmp, "images/$image");

    // Upload CV file
    move_uploaded_file($cv_tmp, "cvs/$cv");

    $stmt = $pdo->prepare('INSERT INTO stagiaire (id, Nom, Prenom, Email, `Date-D`, Date_F, Adresse, Tele, Username, `Password`, Image, id_fonction, CV) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $prenom, $email, $date_d, $date_f, $adresse, $tele, $username, $password, $image, $id_fonction, $cv]);

    $msg = 'Created Successfully!';
    header('Location: admin.php');
    exit;
}

ob_start(); // Start output buffering
?>

<h2>Ajouter un stagiaire:</h2>

<form action="create.php" method="post" class="col d-flex" enctype="multipart/form-data">
  <div class="w-50">
    <div class="form-group">
      <label for="name">Nom</label>
      <input type="text" class="form-control" name="name" id="name">
    </div>

    <div class="form-group">
      <label for="prenom">Prenom</label>
      <input type="text" class="form-control" name="prenom" id="prenom">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" class="form-control" name="email" id="email">
    </div>

    <div class="form-group">
      <label for="date_d">Date Debut</label>
      <input type="date" class="form-control" name="date_d" value="<?= date('Y-m-d') ?>" id="date_d">
    </div>

    <div class="form-group">
      <label for="date_f">Date Fin</label>
      <input type="date" class="form-control" name="date_f" value="<?= date('Y-m-d') ?>" id="date_f">
    </div>

    <div class="form-group">
      <label for="adresse">Adresse</label>
      <input type="text" class="form-control" name="adresse" id="adresse">
    </div>
  </div>

  <div class="w-50 ml-5">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username" id="username">
    </div>

    <div class="form-group">
      <label for="tele">Telephone</label>
      <input type="text" class="form-control" name="tele" id="tele">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="text" class="form-control" name="password" id="password">
    </div>

    <div class="form-group">
      <label for="image">Image</label>
      <input type="file" class="form-control" name="image" id="image">
    </div>

    <div class="form-group">
      <label for="fonction">Fonction</label>
      <div class="input-group mb-3">
        <select class="custom-select" name="fonction" id="fonction">
          <?php
          $fonction_stmt = $pdo->prepare('SELECT id_fonction, titre FROM fonction');
          $fonction_stmt->execute();
          $fonctions = $fonction_stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach ($fonctions as $fonction) {
            echo "<option value='{$fonction['id_fonction']}'>{$fonction['titre']}</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cv">CV</label>
      <input type="file" class="form-control" name="cv" id="cv">
    </div>

    <div style="margin-left:-75px;">
    <button type="submit" class="btn btn-dark">Ajouter</button>
  </div>
  </div>


  
</form>

<?php if ($msg): ?>
    <p><?= $msg ?></p>
<?php endif; ?>

<?php
$content = ob_get_clean(); // Get the buffered output and clean the buffer
generateCustomHTML($content);
?>

<?php
if (!empty($_POST)) {
    require 'connexion.php';
    extract($_POST);

    $userType = $_POST['userType'];

    $allowedUserTypes = ['stagiaire', 'admin'];
    if (!in_array($userType, $allowedUserTypes)) {
        echo "Invalid user type";
        exit();
    }

    $table = ($userType === 'stagiaire') ? 'stagiaire' : 'admin';

    $query = "SELECT * FROM $table WHERE Username = :username AND Password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $Username);
    $stmt->bindParam(':password', $Password);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    if ($data) {
        session_start();
        $_SESSION['Username'] = $data->Username;
        $_SESSION['idConnecte'] = $stagiaire->id; // Updated variable name
    
        if ($userType === 'stagiaire') {
            header('location: profile.php?id=' . $data->id); // Updated variable name
        } else {
            header('location: admin.php');
        }
    } else {
        header('location: erreur.php');
    }
}
?>




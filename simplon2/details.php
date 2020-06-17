<?php
// On démarre une session
session_start();

// id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connection.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `utilisateurs` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère la donnée
    $produit = $query->fetch();

    // On vérifie si la donnée existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails des données de <?= $produit['nom']. "" .$produit['prenom']?></h1>
                <p>ID : <?= $produit['id'] ?></p> <!--< ?= équivaut à < ? echo-->
                <p>Nom : <?= $produit['nom'] ?></p>
                <p>Prenom : <?= $produit['prenom'] ?></p>
                <p>Email : <?= $produit['email'] ?></p>
                <p>PC : <?= $produit['pc'] ?></p>
                <p>Heure : <?= $produit['heure'] ?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>
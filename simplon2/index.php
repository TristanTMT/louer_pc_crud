<?php
// On démarre une session
session_start();

// Connexion à la base
require_once('connection.php');

$sql = 'SELECT * FROM `utilisateurs`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
            <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-danger" role="alert">
                    '. $_SESSION['erreur'].'
                    </div>';
                    $_SESSION['erreur'] = "";
                    }
            ?>
            <?php
                if(!empty($_SESSION['message'])){
                    echo '<div class="alert alert-success" role="alert">
                         '. $_SESSION['message'].'
                         </div>';
                        $_SESSION['message'] = "";
                }
            ?>
<div class="info"></div>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">E-mail</th>
            <th scope="col">PC</th>
            <th scope="col">Heure</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // On boucle sur la variable result
        foreach($result as $produit){
        ?>
                        <tr>
                            <th scope="row"><?php echo $produit["id"]; ?></th>
                            <td><?php echo $produit["nom"]; ?></td>
                            <td><?php echo $produit["prenom"]; ?></td>
                            <td><?php echo $produit["email"]; ?></td>
                            <td><?php echo $produit["pc"]; ?></td>
                            <td><?php echo $produit["heure"]; ?></td>
                            <td>
                            <td><a type ="button" href="desactiver.php?id=<?= $produit['id'] ?>" class="btn btn-default">A/D</a> 
                            <a type="button" class="btn btn-info" href="details.php?id=<?= $produit['id'] ?>">Infos</a> 
                            <a type="button" class="btn btn-warning" href="edit.php?id=<?= $produit['id'] ?>">Modifier</a> 
                            <a type="button" class="btn btn-danger" href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="formulaire.php" class="btn btn-primary">Louez un Pc portable chez TristanPC!</a>
            </section>
        </div>
    </main>
</body>
</html>

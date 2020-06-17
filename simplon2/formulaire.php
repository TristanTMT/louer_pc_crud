<?php

session_start();

if($_POST){
    if(isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['pc']) && !empty($_POST['pc'])
    && isset($_POST['heure']) && !empty($_POST['heure'])){
        // connexion à la base
        require_once('connection.php');


        // On nettoie les données envoyées
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $email = strip_tags($_POST['email']);
        $pc = strip_tags($_POST['pc']);
        $heure = strip_tags($_POST['heure']);

        $sql = 'INSERT INTO `utilisateurs` (`nom`, `prenom`, `email`, `pc`, `heure`) VALUES (:nom, :prenom, :email, :pc, :heure);';

        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':pc', $pc, PDO::PARAM_STR);
        $query->bindValue(':heure', $heure, PDO::PARAM_INT);


        $query->execute();

        $_SESSION['message'] = "Produit ajouté";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include("partitions/head.php"); ?>

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
    <h1>Remplissez le formulaire</h1>
    <div class="formdiv">
    <div class="info"></div>
    <form method="POST">
        <div class="form-group">
            <label for="nom" class="col-sm-3 col-form label">Nom</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" name="nom" id="nom" placeholder="TIEN-MI-TIEE">
            </div>
        </div>
        <div class="form-group">
            <label for="prenom" class="col-sm-3 col-form label">Prénom</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Tristan">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-3 col-form label">E-mail</label>
            <div class="col-sm-7">
            <input type="email" class="form-control" name="email" id="email" placeholder="azerty@gmail.com" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-group text-muted">We'll never share your email with anyone else.</small>
            </div>
        </div>
        <div class="form-group">
            <label for="pc" class="col-sm-3 col-form label">PC</label>
            <div class="col-sm-7">
            <select name="pc" id="pc" class="form-group">
                <option value="">Sélectionnez un ordinateur</option>
                <option value="Apple">Apple</option>
                <option value="Huawei">Huawei</option>
                <option value="Lenevo">Lenevo</option>
                <option value="Asus">Asus</option>
                <option value="MSI">MSI</option>
                <option value="HP">HP</option>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label for="heure" min="09:00" max="18:00" required>Choisissez une heure (entre 9:00 et 18:00) : </label>
                <input id="heure" type="time" name="heure"
                min="09:00" max="18:00" required>
            <span class="validity"></span>
        </div>
            
        <div class="form-group form-check">
            <button type="submit" name="submit" class="btn btn-primary col-sm-3 col-form" value="submit">Valider</button>
        </div>
    </form>
    </div>
</div>

</body>
</html>
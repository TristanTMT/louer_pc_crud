<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['pc']) && !empty($_POST['pc'])
    && isset($_POST['heure']) && !empty($_POST['heure'])){
        // On inclut la connexion à la base
        require_once('connection.php');

       // refresh les données envoyées
       $nom = strip_tags($_POST['nom']);
       $prenom = strip_tags($_POST['prenom']);
       $email = strip_tags($_POST['email']);
       $pc = strip_tags($_POST['pc']);
       $heure = strip_tags($_POST['heure']);


        $sql = 'UPDATE `utilisateurs` SET `nom`=:nom, `prenom`=:prenom, `email`=:email, `pc`=:pc `heure`=:heure WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':pc', $pc, PDO::PARAM_STR);
        $query->bindValue(':heure', $heure, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Donnée modifiée";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connection.php');

    // Refresh id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `utilisateurs` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $produit = $query->fetch();

    // On vérifie si le produit existe
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
                <h1>Modifier une donnée</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= $produit['nom']?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" value="<?= $produit['prenom']?>">

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?= $produit['email']?>">
                    </div>
                    <div class="form-group">
                    <label for="pc" class="col-sm-3 col-form label">PC</label>
                        <div class="col-sm-7">
                            <select name="pc" id="pc" class="form-group" value="<?= $produit['pc']?>">>
                                <option value="">Sélectionnez un ordinateur</option>
                                <option value="Apple">Apple</option>
                                <option value="Huawei">Huawei</option>
                                <option value="Lenevo">Lenevo</option>
                                <option value="Asus">Asus</option>
                                <option value="MSI">MSI</option>
                                <option value="HP">HP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="heure" min="09:00" max="18:00" required>Choisissez une heure (entre 9:00 et 18:00) : </label>
                            <input id="heure" type="time" name="heure"
                            min="09:00" max="18:00" required>
                            <span class="validity"></span>
                        </div>
                    <input type="hidden" value="<?= $produit['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
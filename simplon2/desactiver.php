<?php
session_start();

// id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connection.php');

    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `utilisateurs` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    

    $query->execute();

    // On récupère le produit (donnée)
    $produit = $query->fetch();
    // On vérifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }

    $actif = ($produit['actif'] == 0) ? 1 : 0;

    $sql = 'UPDATE `utilisateurs` SET `actif`=:actif WHERE `id` = :id;';

 
    $query = $db->prepare($sql);

    // On "accroche" les paramètres
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);

    $query->execute();
    
    header('Location: index.php');

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
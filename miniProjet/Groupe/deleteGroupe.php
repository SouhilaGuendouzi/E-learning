<?php
$id_groupe=$_GET['id_groupe'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.séance where id_groupe=?");
$req->bindParam(1,$id_groupe);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("update elearn.séance set id_groupe=-1 where id_séance=?");
    $req1->bindParam(1,$result['id_séance']);
    $req1->execute();
}
$req=$pdo->prepare("select * from elearn.etudiant where id_groupe=?");
$req->bindParam(1,$id_groupe);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("update elearn.etudiant set id_groupe=-1 where id_etud=?");
    $req1->bindParam(1,$result['id_etud']);
    $req1->execute();
}
$req=$pdo->prepare("delete from elearn.groupe where id_groupe=?");
$req->bindParam(1,$id_groupe);
$req->execute();
header('Location: listes_groupes.php');  
?>
<?php
$id_ens=$_GET['id_ens'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.module where id_ens=?");
$req->bindParam(1,$id_ens);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("update elearn.module set id_ens=-1 where id_mod=?");
    $req1->bindParam(1,$result['id_mod']);
    $req1->execute();
}
$req=$pdo->prepare("delete from elearn.enseignant where id_ens=?");
$req->bindParam(1,$id_ens);
$req->execute();
header('Location: liste_enseignants.php');  
?>
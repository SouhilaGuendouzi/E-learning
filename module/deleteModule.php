<?php
$id_mod=$_GET['id_mod'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.séance where id_mod=?");
$req->bindParam(1,$id_mod);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("update elearn.séance set id_mod=-1 where id_séance=?");
    $req1->bindParam(1,$result['id_séance']);
    $req1->execute();
}

$req=$pdo->prepare("delete from elearn.module where id_mod=?");
$req->bindParam(1,$id_mod);
$req->execute();
header('Location: listes_module.php');  
?>
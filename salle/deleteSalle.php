<?php
$id_salle=$_GET['id_salle'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.séance where id_salle=?");
$req->bindParam(1,$id_salle);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("update elearn.séance set id_salle=-1 where id_séance=?");
    $req1->bindParam(1,$result['id_séance']);
    $req1->execute();
}
$req=$pdo->prepare("delete from elearn.salle where id_salle=?");
$req->bindParam(1,$id_salle);
$req->execute();
header('Location: liste_salles.php');  
?>
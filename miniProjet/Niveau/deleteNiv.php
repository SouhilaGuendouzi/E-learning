<?php
$id_niv=$_GET['id_niv'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.module where id_niv=?");
$req->bindParam(1,$id_niv);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req2=$pdo->prepare("update elearn.module set id_niv=-1 where id_mod=?");
    $req2->bindParam(1,$result['id_mod']);
    $req2->execute();
}
$req3=$pdo->prepare("select * from elearn.groupe where id_niv=?");
$req3->bindParam(1,$id_niv);
$req3->execute();
while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
{   
    $req6=$pdo->prepare("update elearn.etudiant set id_groupe=-1 where id_groupe=?");
    $req6->bindParam(1,$result3['id_groupe']);
    $req6->execute();
    $req4=$pdo->prepare("delete from elearn.groupe where id_groupe=?");
    $req4->bindParam(1,$result3['id_groupe']);
    $req4->execute();
}
$req5=$pdo->prepare("delete from elearn.niveau where id_niv=?");
$req5->bindParam(1,$id_niv);
$req5->execute();
header('Location: listes_niveaux.php');  
?>
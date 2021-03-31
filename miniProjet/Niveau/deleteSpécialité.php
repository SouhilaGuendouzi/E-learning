<?php
$id_spec=$_GET['id_spec'];
$id_spec=(int)$id_spec;
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.niveau  where id_spec=?");
$req->bindParam(1,$id_spec);
$req->execute();
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{
    $req1=$pdo->prepare("select * from elearn.groupe  where id_niv=?");
    $req1->bindParam(1,$result["id_niv"]);
    $req1->execute();
    while ($result1 = $req->fetch(PDO::FETCH_ASSOC))
    {
        $req2=$pdo->prepare("update elearn.etudiant set id_groupe=-1  where id_groupe=?");
        $req2->bindParam(1,$result1["id_groupe"]);
        $req2->execute();
    }
    $req3=$pdo->prepare("delete from elearn.groupe  where id_niv=?");
    $req3->bindParam(1,$result["id_niv"]);
    $req3->execute();
  }
$req4=$pdo->prepare("delete from elearn.niveau  where id_spec=?");
$req4->bindParam(1,$id_spec);
$req4->execute();
$req5=$pdo->prepare("delete from elearn.spécialité where id_spec=?");
$req5->bindParam(1,$id_spec);
$req5->execute();
header('Location: listes_niveaux.php'); 
 
?>
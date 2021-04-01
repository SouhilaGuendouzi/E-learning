<?php
$id_séance=$_GET["id_séance"];
$host = "mysql:host = localhost ; dbname =elearn";
try {
    $pdo = new PDO( $host, "root", "");
    $req=$pdo->prepare("delete from elearn.séance where id_séance=?");
    $req->bindParam(1,$id_séance);
    $req->execute();
}
catch (PDOException $e){
    echo $e->getMessage();
}
header('Location: liste_séances.php');  
?>
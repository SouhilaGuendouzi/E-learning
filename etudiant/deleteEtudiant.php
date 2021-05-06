<?php
$id_etud=$_GET['id_etud'];
$host = "mysql:host = localhost ; dbname =elearn";
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("delete from elearn.etudiant where id_etud=?");
$req->bindParam(1,$id_etud);
$req->execute();
header('Location: listes_etudiants.php');  
?>
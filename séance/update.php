<?php
$id_séance=$_POST["id_séance"];
$type=$_POST["type"];
$id_groupe=$_POST["groupe"];  
$id_salle=$_POST["salle"];
$id_mod=$_POST["module"];
$jour=$_POST["jour"];
$heure_debut=$_POST["heure_debut"];
$heure_fin=$_POST["heure_fin"];
$host = "mysql:host = localhost ; dbname =elearn"; 
$stop=FALSE;
$stop1=FALSE; 
if (!empty($id_séance)&&!empty($id_salle)&&!empty($type)&&!empty($id_groupe)&&!empty($id_mod)&&!empty($jour)&&!empty($heure_debut)&&!empty($heure_fin))
{  if ($heure_debut<$heure_fin)

    {  $pdo = new PDO( $host, "root", "");
       $req=$pdo->prepare("select count(*) as total from elearn.séance where id_séance=? ");
       $req->bindParam(1,$id_séance);
       $req->execute();
        while ($result=$req->fetch(PDO::FETCH_ASSOC))
       {
        if ($result["total"]) $stop=TRUE;
        
        }
        if ($stop==TRUE){
       
            $req=$pdo->prepare("update elearn.séance set type=?,jour=?,heure_debut=?,heure_fin=?,id_mod=?,id_groupe=?,id_salle=? where id_séance=? ");   
            $req->execute([$type,$jour,$heure_debut,$heure_fin,$id_mod,$id_groupe,$id_salle,$id_séance]);
            header('Location: liste_séances.php');  

        }

        else {echo "L'identifiant existe déja";}
    }
    else {
        echo "Vérifier les heures ";
    }
}
else {echo "khawyine";}
?>
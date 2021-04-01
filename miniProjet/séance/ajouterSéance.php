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
                if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.séance where (id_groupe=? and jour=? and heure_debut=? and heure_fin=?) or (id_salle=? and jour=? and heure_debut=? and heure_fin=?) ");
                $req->execute([$id_groupe,$jour,$heure_debut,$heure_fin,$id_salle,$jour,$heure_debut,$heure_fin]);
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.séance (id_séance,type,jour,heure_debut,heure_fin,id_mod,id_groupe,id_salle) values(?,?,?,?,?,?,?,?) ");   
                    $req->execute([$id_séance,$type,$jour,$heure_debut,$heure_fin,$id_mod,$id_groupe,$id_salle]);
                    header('Location: liste_séances.php');  
                }
            
                else {echo "La séance ne peut pas écraser une autre séance ";}
                }

                else {echo "L'identifiant existe déja";}
            }
            else {
                echo "Vérifier les heures ";
            }
        }
        else {echo "khawyine";}
?>
<?php

        $id_salle=$_POST["id_salle"];
        $id_salle=(int)$id_salle;
        $salle=$_POST["nom"];
        $type=$_POST["type"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_salle)&&!empty($salle)&&!empty($type))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.salle where id_salle=? ");
            $req->bindParam(1, $id_salle);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;        
            }
             if ($stop==TRUE){
                $req=$pdo->prepare("update elearn.salle set salle=? , type=?  where id_salle=? ");
                $req->execute([$salle,$type,$id_salle]);
                header('Location: liste_salles.php');  
            }
            else {
                echo "L'identifiant' n'existe pas ";
            }
        }
        else {
            echo "khawyine";
        }
?>
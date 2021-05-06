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
            $req->bindParam(1,$id_salle);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.salle where salle=?  ");
                $req->bindParam(1,$salle);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.salle (id_salle,salle,type) values(?,?,?) ");
                    $req->bindParam(1,$id_salle);
                    $req->bindParam(2,$salle);
                    $req->bindParam(3,$type);
                    $req->execute();
                    header('Location: liste_salles.php');  
                }
            
                else {echo "Le salle existe déja";}
                }

            else {echo "L'identifiant existe déja";}
        }
        else {echo "khawyine";}
?>
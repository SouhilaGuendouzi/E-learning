<?php

        $id_niv=$_POST["niveau"];
        $id_niv=(int)$id_niv;
        $id_groupe=$_POST["id_groupe"];
        $id_groupe=(int) $id_groupe;
        $nomGroupe=$_POST["nomGroupe"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_niv)&&!empty($id_groupe)&&!empty($nomGroupe))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.groupe where id_groupe=? ");
            $req->bindParam(1,$id_groupe);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.groupe where nomGroupe=? and id_niv=? ");
                $req->bindParam(1,$nomGroupe);
                $req->bindParam(2,$id_niv);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.groupe (id_groupe,nomGroupe,id_niv) values(?,?,?) ");
                    $req->bindParam(1,$id_groupe);
                    $req->bindParam(2,$nomGroupe);
                    $req->bindParam(3,$id_niv);
                    $req->execute();
                    header('Location: listes_groupes.php');  
                }
            
                else {echo "Le Groupe existe déja";}
                }

            else {echo "L'identifiant existe déja";}
        }
        else {echo "khawyine";}
?>
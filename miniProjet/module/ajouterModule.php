<?php

        $id_mod=$_POST["id_mod"];
        $id_ens=$_POST["responsable"];
        $nom=$_POST["nom"];  
        $id_niv=$_POST["niveau"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_mod)&&!empty($id_niv)&&!empty($nom)&&!empty($id_ens))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.module where id_mod=? ");
            $req->bindParam(1,$id_mod);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.module where nom=? and id_niv=? ");
                $req->bindParam(1,$nom);
                $req->bindParam(2,$id_niv);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.module (id_mod,nom,id_ens,id_niv) values(?,?,?,?) ");
                    $req->bindParam(1,$id_mod);
                    $req->bindParam(2,$nom);
                    $req->bindParam(3,$id_ens);
                    $req->bindParam(4,$id_niv);
                    $req->execute();
                    header('Location: listes_module.php');  
                }
            
                else {echo "Le module existe déja";}
                }

            else {echo "L'identifiant existe déja";}
        }
        else {echo "khawyine";}
?>
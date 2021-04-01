<?php

        $id_mod=$_POST["id_mod"];
        $nom=$_POST["nom"];
        $id_niv=$_POST["niveau"];
        $id_ens=$_POST["responsable"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_mod)&&!empty($nom)&&!empty($id_ens)&&!empty($id_niv))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.module where id_mod=? ");
            $req->bindParam(1, $id_mod);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;        
            }
             if ($stop==TRUE){
                $req=$pdo->prepare("update elearn.module set nom=? , id_ens=? , id_niv=?  where id_mod=? ");
                $req->execute([$nom,$id_ens,$id_niv,$id_mod]);
                header('Location: listes_module.php');  
            }
            else {
                echo "L'identifiant' n'existe pas ";
            }
        }
        else {
            
        }
?>
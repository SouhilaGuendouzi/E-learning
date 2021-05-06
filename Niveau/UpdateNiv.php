<?php

        $id_niv=$_POST["id_niv"];
        $id_niv=(int)$id_niv;
        $id_spec=$_POST["spécialité"];
        $id_spec=(int)$id_spec;
        $id_année=$_POST["année"];
        $id_année=(int)$id_année;
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_niv)&&!empty($id_spec)&&!empty($id_année))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.niveau where id_niv=? ");
            $req->bindParam(1, $id_niv);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;        
            }
             if ($stop==TRUE){
                $req1=$pdo->prepare("select count(*) as total from elearn.niveau where id_spec=? and id_année=? ");
                $req1->bindParam(1, $id_spec);
                $req1->bindParam(2, $id_année);
                $req1->execute();
                while ($result1=$req1->fetch(PDO::FETCH_ASSOC))
                 {
                if ($result1["total"]) $stop1=TRUE;        
                  }
                 if ($stop1==FALSE) 
                 {
                  $req=$pdo->prepare("update elearn.niveau set id_spec=? , id_année=?  where id_niv=? ");
                  $req->execute([$id_spec,$id_année,$id_niv]);
                  header('Location: listes_niveaux.php');    
                 } 
                 else {
                     echo "ce niveau Existe ";
                 }
                 
            }
            else {
                echo "L'identifiant' n'existe pas ";
            }
        }
        else {
            
        }
?>
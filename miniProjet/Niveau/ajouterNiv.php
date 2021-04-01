<?php

        $id_niv=$_POST["id_niv"];
        $id_spec=$_POST["spécialité"];
        $id_année=$_POST["année"];
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
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.niveau where id_année=? and id_spec=? ");
                $req->bindParam(1,$id_année);
                $req->bindParam(2,$id_spec);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.niveau (id_niv,id_spec,id_année) values(?,?,?) ");
                    $req->bindParam(1,$id_niv);
                    $req->bindParam(2,$id_spec);
                    $req->bindParam(3,$id_année);
                    $req->execute();
                    header('Location: listes_niveaux.php');  
                }
                else {
                    echo "Le Niveau existe déja";
                }
            }
            else {
                echo "L'identifiant' existe déja";
            }
        }
        else {echo "khawyine".$id_niv.$id_spec.$id_année;}
?>
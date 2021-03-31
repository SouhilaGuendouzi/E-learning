<?php

       
        $id_année=$_POST["id_année"];
        $id_année=(int) $id_année;
        $année=$_POST["année"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($année)&&!empty($id_année))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.année where id_année=? ");
            $req->bindParam(1, $id_niv);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.année where année=? ");
                $req->bindParam(1,$année);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.année (id_année,année) values(?,?) ");
                    $req->bindParam(1,$id_année);
                    $req->bindParam(2,$année);
                    $req->execute();
                    header('Location: listes_niveaux.php');  
                }
                else {
                    echo "L'année existe déja";
                }
            }
            else {
                echo "L'identifiant' existe déja";
            }
        }
        else {echo "khawyine".$id_année;}
?>
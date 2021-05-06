<?php 
        $id_spec=$_POST["id_spec"];
        $nom=$_POST["spécialité"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($nom)&&!empty($id_spec))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.spécialité where id_spec=? ");
            $req->bindParam(1, $id_niv);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.spécialité where nom=? ");
                $req->bindParam(1,$nom);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.spécialité (id_spec,nom) values(?,?) ");
                    $req->bindParam(1,$id_spec);
                    $req->bindParam(2,$nom);
                    $req->execute();
                    header('Location: listes_niveaux.php');  
                }
                else {
                    echo "La Spécialité existe déja";
                }
            }
            else {
                echo "L'identifiant' existe déja";
            }
        }
        else {echo "khawyine".$id_spec;}
?>
<?php
        $id_etud=$_POST["id_etud"];
        $nom=$_POST["nom"];
        $prénom=$_POST["prénom"];
        $date_naissance=$_POST["date_naissance"];
        if(empty($date_naissance)===TRUE ) {$date_naissance=null; }
        $id_groupe=$_POST["groupe"];
        $host = "mysql:host = localhost ; dbname =elearn";
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_etud)&&!empty($nom)&&!empty($prénom)&&!empty($id_groupe))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.etudiant where id_etud=? ");
            $req->bindParam(1, $id_etud);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.etudiant where nom=? and prénom=? ");
                $req->bindParam(1,$nom);
                $req->bindParam(2,$prénom);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.etudiant (id_etud,nom,prénom,date_naissance,id_groupe) values(?,?,?,?,?) ");
                    $req->bindParam(1,$id_etud);
                    $req->bindParam(2,$nom);
                    $req->bindParam(3,$prénom);
                    $req->bindParam(4,$date_naissance);
                    $req->bindParam(5,$id_groupe);
                    $req->execute();
                    header('Location: listes_etudiants.php');  
                }
                else {
                    echo "Le nom ou prénom existe déja";
                }
            }
            else {
                echo "L'identifiant' existe déja";
            }
        }
        else {
            echo $id_etud.$nom.$prénom.$date_naissance.$id_groupe;
        }
?>
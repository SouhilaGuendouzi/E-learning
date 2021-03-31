<?php

        $id_ens=$_POST["id_ens"];
        $id_ens=(int)$id_ens;
        $nom=$_POST["nom"];
        $prénom=$_POST["prénom"];
        $date_naissance=$_POST["date_naissance"];
        if(empty($date_naissance)===TRUE ) {$date_naissance=null; }
        $grade=$_POST["grade"];
        $host = "mysql:host = localhost ; dbname =elearn"; 
        $stop=FALSE;
        $stop1=FALSE; 
        if (!empty($id_ens)&&!empty($nom)&&!empty($prénom)&&!empty($grade))
        {
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select count(*) as total from elearn.enseignant where id_ens=? ");
            $req->bindParam(1, $id_ens);
            $req->execute();
            while ($result=$req->fetch(PDO::FETCH_ASSOC))
            {
                if ($result["total"]) $stop=TRUE;
                
            }
             if ($stop==False){
                $req=$pdo->prepare("select count(*) as total from elearn.enseignant where nom=? and prénom=? ");
                $req->bindParam(1,$nom);
                $req->bindParam(2,$prénom);
                $req->execute();
                while ($result=$req->fetch(PDO::FETCH_ASSOC))
                {
                    if ($result["total"]) $stop1=TRUE;
                    
                }
                if ($stop1==FALSE)
                {
                    $req=$pdo->prepare("insert into elearn.enseignant (id_ens,nom,prénom,date_naissance,grade) values(?,?,?,?,?) ");
                    $req->bindParam(1,$id_ens);
                    $req->bindParam(2,$nom);
                    $req->bindParam(3,$prénom);
                    $req->bindParam(4,$date_naissance);
                    $req->bindParam(5,$grade);
                    $req->execute();
                    header('Location: liste_enseignants.php');  
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
            echo $id_ens.$nom.$prénom.$date_naissance.$grade;
        }
?>
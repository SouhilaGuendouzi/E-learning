<?php

        $id_ens=$_POST["id_ens"];
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
             if ($stop==TRUE){
                $req=$pdo->prepare("update elearn.enseignant set nom=? , prénom=? , date_naissance=? , grade=? where id_ens=? ");
                $req->execute([$nom,$prénom,$date_naissance,$grade,$id_ens]);
                header('Location: liste_enseignants.php');  
            }
            else {
                echo "L'identifiant' n'existe pas ";
            }
        }
        else {
            
        }
?>
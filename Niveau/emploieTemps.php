<?php
session_start()
?>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="../jquery.min.js">
    var s=null;</script>
        <title>
            Liste
         </title>
         <style>
body{
  font: 1em normal Arial,sans-serif;
  color:#34495E;
  padding:3%;
  size:20px;
}

h1{
  text-align:center;
  font-size:2em;
  margin:20px 0;
  color:#777;
  margin-bottom:3%;
}

table{
  
  width:100%;
}

.blue{
  border:2px solid #3498DB;
}

.blue thead{
  background:#3498DB;
}
thead{
  color:white;
}

th,td{
  border:2px solid #3498DB;
  text-align:center;
  padding:5px 0;
}

tbody tr:nth-child(even){
  background:#ECF0F1;
}

hr {
  color:blue;
}
h3 {
  margin-top:8%;
    color: #777;
    margin-left:3%;    
  }
    </style>
</head>

<body class="bd">
    <?php
    $array=array();
    $count=0;
    $khaoula=FALSE;
    $ens=null;
    $année=null;
    $spec=null;
    $stop=FALSE;
    $boucle=FALSE;
    $id_niv=$_GET["id_niv"];
    $login=$_SESSION["login"];
    $pass=$_SESSION["pass"];
    $host = "mysql:host = localhost ; dbname =elearn";
;
    if (!empty($login)&&(!empty($pass))){
        try
         {  
            $pdo = new PDO( $host, "root", "");
            $req=$pdo->prepare("select * from elearn.users where login=? and pass =?");
            $req->bindParam(1,$login);
            $req->bindParam(2,$pass);
            $req->execute();
            
            while ($req->fetchAll())
            {
              $stop=TRUE;
            }
            if ($stop==TRUE)
            {   $req=$pdo->prepare("select id_niv , id_spec , id_année from elearn.niveau where id_niv=?");
                $req->bindParam(1,$id_niv);
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {  $req1=$pdo->prepare("select * from elearn.spécialité where id_spec=?");
                    $req1->bindParam(1,$result["id_spec"]);
                    $req1->execute();
                    while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                    {
                        $spec=$result1["nom"];
                    }
                    $req2=$pdo->prepare("select * from elearn.année where id_année=?");
                    $req2->bindParam(1,$result["id_année"]);
                    $req2->execute();
                    while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        $année=$result2["année"];
                    }
                 ?>
                 <h1>Emploie du temps de la <?php echo $année; ?> Année <?php echo $spec; ?> </h1>
                 <table class="blue">
                  <thead>
                  <tr>
                  <th></th>
                  <?php 
                     $req2=$pdo->prepare("select distinct heure_debut,heure_fin  from elearn.séance s natural join elearn.groupe g  where g.id_niv=? order by heure_debut" );
                     $req2->bindParam(1,$id_niv);
                     $req2->execute();
                     while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {  array_push($array,array($result2["heure_debut"],$result2["heure_fin"]) );
                       
                        echo "<th>".$result2["heure_debut"]." <br/>-<br/> ".$result2["heure_fin"]."</th>";
                    }
                  ?>     
              </tr>
            </thead>

            <tbody>
            
                  <?php 
                   $req2=$pdo->prepare("select count(*) as total from elearn.séance s  natural join elearn.groupe g  where g.id_niv=? and s.jour=1" );
                   $req2->bindParam(1,$id_niv);
                   $req2->execute();
                   while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($result2["total"]>0) {
                            ?><tr><?php
                            echo " <th>Samedi</th><td>";
                            foreach ( $array as $heure)
                             {  
                              $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                              sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                             from elearn.séance s natural join elearn.groupe g  
                              natural join elearn.module m  
                              natural join elearn.salle sa
                              where g.id_niv=? and s.jour=1 order by heure_debut,heure_fin" );
                            $req3->bindParam(1,$id_niv);
                            $req3->execute();
                            $khaoula=FALSE;
                             while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                             { 
                              
                               if ($khaoula==FALSE){
                                   if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                   {   
                                $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                                $req4->bindParam(1,$result3["id_ens"]);
                                $req4->execute();
                                while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                                {
                                   $ens=$result4["nom"];
                                }
                                if ($result3["typeSéance"]==="COURS")
                                 {
                                     echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                    
                                    }
                                 else {
                                    echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                   
                                  } 
                                }
                                else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                  $khaoula=TRUE;
                                  echo "</td><td>";
                                }
                                 }
                                 
                                }
                               
      
                             }?></tr>
                             <?php
                        };
                    }
                    
                    
                    $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=2" );
                    $req2->bindParam(1,$id_niv);
                    $req2->execute();
                    while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                     {
                         if ($result2["total"]>0) {
                             ?><tr><?php
                             echo " <th>Dimanche</th><td>";
                             
                             foreach ( $array as $heure)
                             {  
                              $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                              sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                             from elearn.séance s natural join elearn.groupe g  
                              natural join elearn.module m  
                              natural join elearn.salle sa
                              where g.id_niv=? and s.jour=2 order by heure_debut,heure_fin" );
                            $req3->bindParam(1,$id_niv);
                            $req3->execute();
                            $khaoula=FALSE;
                             while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                             { 
                              
                               if ($khaoula==FALSE){
                                   if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                   {   
                                $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                                $req4->bindParam(1,$result3["id_ens"]);
                                $req4->execute();
                                while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                                {
                                   $ens=$result4["nom"];
                                }
                                if ($result3["typeSéance"]==="COURS")
                                 {
                                     echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                    
                                    }
                                 else {
                                    echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                   
                                  } 
                                }
                                else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                  $khaoula=TRUE;
                                  echo "</td><td>";
                                }
                                 }
                                 
                                }
                               
      
                             }?></tr>
                             <?php
                         }
                        
                     }
                    $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=3" );
                   $req2->bindParam(1,$id_niv);
                   $req2->execute();
                   while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($result2["total"]>0) {
                            ?><tr><?php
                            echo " <th>Lundi</th><td>";
                            foreach ( $array as $heure)
                            {  
                             $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                             sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                            from elearn.séance s natural join elearn.groupe g  
                             natural join elearn.module m  
                             natural join elearn.salle sa
                             where g.id_niv=? and s.jour=3 order by heure_debut,heure_fin" );
                           $req3->bindParam(1,$id_niv);
                           $req3->execute();
                           $khaoula=FALSE;
                            while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                            { 
                             
                              if ($khaoula==FALSE){
                                  if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                  {   
                               $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                               $req4->bindParam(1,$result3["id_ens"]);
                               $req4->execute();
                               while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                               {
                                  $ens=$result4["nom"];
                               }
                               if ($result3["typeSéance"]==="COURS")
                                {
                                    echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                   
                                   }
                                else {
                                   echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                  
                                 } 
                               }
                               else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                 $khaoula=TRUE;
                                 echo "</td><td>";
                               }
                                }
                                
                               }
                              
     
                            }?></tr>
                            <?php
                        };
                    }
                   $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=4" );
                   $req2->bindParam(1,$id_niv);
                   $req2->execute();
                   while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($result2["total"]>0) {
                            ?><tr><?php
                            echo " <th>Mardi</th><td>";
                            foreach ( $array as $heure)
                            {  
                             $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                             sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                            from elearn.séance s natural join elearn.groupe g  
                             natural join elearn.module m  
                             natural join elearn.salle sa
                             where g.id_niv=? and s.jour=4 order by heure_debut,heure_fin" );
                           $req3->bindParam(1,$id_niv);
                           $req3->execute();
                           $khaoula=FALSE;
                            while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                            { 
                             
                              if ($khaoula==FALSE){
                                  if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                  {   
                               $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                               $req4->bindParam(1,$result3["id_ens"]);
                               $req4->execute();
                               while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                               {
                                  $ens=$result4["nom"];
                               }
                               if ($result3["typeSéance"]==="COURS")
                                {
                                    echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                   
                                   }
                                else {
                                   echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                  
                                 } 
                               }
                               else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                 $khaoula=TRUE;
                                 echo "</td><td>";
                               }
                                }
                                
                               }
                              
     
                            }?></tr>
                            <?php
                        };
                    }
                    $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=5" );
                   $req2->bindParam(1,$id_niv);
                   $req2->execute();
                   while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($result2["total"]>0) {
                            ?><tr><?php
                            echo " <th>Mercredi</th><td>";
                            foreach ( $array as $heure)
                             {  
                              $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                              sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                             from elearn.séance s natural join elearn.groupe g  
                              natural join elearn.module m  
                              natural join elearn.salle sa
                              where g.id_niv=? and s.jour=5 order by heure_debut,heure_fin" );
                            $req3->bindParam(1,$id_niv);
                            $req3->execute();
                            $khaoula=FALSE;
                             while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                             { 
                              
                               if ($khaoula==FALSE){
                                   if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                   {   
                                $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                                $req4->bindParam(1,$result3["id_ens"]);
                                $req4->execute();
                                while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                                {
                                   $ens=$result4["nom"];
                                }
                                if ($result3["typeSéance"]==="COURS")
                                 {
                                     echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                    
                                    }
                                 else {
                                    echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                   
                                  } 
                                }
                                else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                  $khaoula=TRUE;
                                  echo "</td><td>";
                                }
                                 }
                                 
                                }
                               
      
                             }?></tr>
                             <?php
                        };
                    }
                    $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=6" );
                   $req2->bindParam(1,$id_niv);
                   $req2->execute();
                   while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($result2["total"]>0) {
                            ?><tr><?php
                            echo " <th>Jeudi</th><td>";
                            foreach ( $array as $heure)
                            {  
                             $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                             sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                            from elearn.séance s natural join elearn.groupe g  
                             natural join elearn.module m  
                             natural join elearn.salle sa
                             where g.id_niv=? and s.jour=6 order by heure_debut,heure_fin" );
                           $req3->bindParam(1,$id_niv);
                           $req3->execute();
                           $khaoula=FALSE;
                            while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                            { 
                             
                              if ($khaoula==FALSE){
                                  if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                  {   
                               $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                               $req4->bindParam(1,$result3["id_ens"]);
                               $req4->execute();
                               while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                               {
                                  $ens=$result4["nom"];
                               }
                               if ($result3["typeSéance"]==="COURS")
                                {
                                    echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                   
                                   }
                                else {
                                   echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                  
                                 } 
                               }
                               else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                 $khaoula=TRUE;
                                 echo "</td><td>";
                               }
                                }
                                
                               }
                              
     
                            }?></tr>
                            <?php
                        };
                    }
                    $req2=$pdo->prepare("select count(*) as total from elearn.séance s natural join elearn.groupe g where g.id_niv=? and s.jour=7" );
                    $req2->bindParam(1,$id_niv);
                    $req2->execute();
                    while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                     {
                         if ($result2["total"]>0) {
                            ?><tr><?php
                             echo " <th>Vendredi</th><td>";
                             foreach ( $array as $heure)
                             {  
                              $req3=$pdo->prepare("select s.type as typeSéance , m.nom as nomModule , g.nomGroupe,
                              sa.salle , sa.type as typeSalle , m.id_ens , heure_debut , heure_fin
                             from elearn.séance s natural join elearn.groupe g  
                              natural join elearn.module m  
                              natural join elearn.salle sa
                              where g.id_niv=? and s.jour=7 order by heure_debut,heure_fin" );
                            $req3->bindParam(1,$id_niv);
                            $req3->execute();
                            $khaoula=FALSE;
                             while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                             { 
                              
                               if ($khaoula==FALSE){
                                   if ($result3["heure_debut"]==$heure[0] && $result3["heure_fin"]==$heure[1])
                                   {   
                                $req4=$pdo->prepare("select * from elearn.enseignant where id_ens=?" );
                                $req4->bindParam(1,$result3["id_ens"]);
                                $req4->execute();
                                while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                                {
                                   $ens=$result4["nom"];
                                }
                                if ($result3["typeSéance"]==="COURS")
                                 {
                                     echo $result3["nomModule"]."<br/> <mark>".$ens."</mark><br/>".$result3["salle"]."<mark><br/>"."<mark> COURS </mark><hr/>" ;
                                    
                                    }
                                 else {
                                    echo $result3["nomModule"]."<br/><mark>".$ens."</mark><br/>".$result3["salle"]."<br/>"."<mark>".$result3["nomGroupe"]." ".$result3["typeSéance"]."</mark><hr/>";
                                   
                                  } 
                                }
                                else if ($result3["heure_debut"]>$heure[0] || $result3["heure_fin"]>$heure[1]) {
                                  $khaoula=TRUE;
                                  echo "</td><td>";
                                }
                                 }
                                 
                                }
                               
      
                             }?></tr>
                             <?php
                         };
                     }
                  
                  ?>     
              
              <?php          
            }
        }
    }
        catch (PDOException $e){
            echo $e->getMessage();
         }
    }
         ?>
</tbody>
</body>
</html>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="jquery.min.js"></script>
        <title>
            Edit Module
         </title>
</head>
<body>
<?php
$id_séance=$_POST['id_séance'];
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_séance)){
    $pdo = new PDO( $host, "root", "");
    $req=$pdo->prepare("select * from elearn.séance where id_séance=?");
    $req->bindParam(1,$id_séance);
    $req->execute();
    }
    while ($result = $req->fetch(PDO::FETCH_ASSOC))
    { 
        ?>
        <h3> Informations sur la  Séance </h3>
              <form class ="form" action="update.php?id_séance=<?php echo $result["id_séance"];?>" method="post" >
              <div class="control-group">
                   <input class="in"type="hidden" name="id_séance" id="id_séance" value=<?php echo $result["id_séance"];?>>   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="type">Type &nbsp&nbsp&nbsp</label>
                   <select name="type" id="type">    
                   <option <?php if(strcmp($result["type"],"TD")==0){echo "selected";}?> value="TD">TD</option>
                   <option  <?php if(strcmp($result["type"],"TP")==0){echo "selected";}?>  value="TP">TP</option>      
                   <option  <?php if(strcmp($result["type"],"COURS")==0){echo "selected";}?>   value="COURS">COURS</option>   
                   </select> 
                </div> &nbsp&nbsp&nbsp

                <div class="control-group">
                   <label  for="groupe">Groupe &nbsp&nbsp&nbsp</label>
                   <select class="select" name="groupe" id="groupe"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.groupe ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                      $req5=$pdo->prepare("select * from  elearn.niveau where id_niv=?");
                      $req5->bindParam(1,$result4["id_niv"]);
                      $req5->execute();
                      while ($result5 = $req5->fetch(PDO::FETCH_ASSOC))
                      {
                        $spec=$result5["id_spec"];
                        $année=$result5["id_année"];
                      }
                      $req5=$pdo->prepare("select * from  elearn.spécialité where id_spec=?");
                      $req5->bindParam(1,$spec);
                      $req5->execute();
                      while ($result5 = $req5->fetch(PDO::FETCH_ASSOC))
                      {
                        $spec=$result5["nom"];
                      }
                      $req5=$pdo->prepare("select * from  elearn.année where id_année=?");
                      $req5->bindParam(1,$année);
                      $req5->execute();
                      while ($result5 = $req5->fetch(PDO::FETCH_ASSOC))
                      {
                        $année=$result5["année"];
                      }
                      if ($result4["id_groupe"]!=-1){
                      ?>
               <option <?php if(strcmp($result["id_groupe"],$result4["id_groupe"])==0){echo "selected";}?> value="<?php echo $result4["id_groupe"];?>"><?php echo $result4["nomGroupe"]." ".$année." année  ".$spec;?></option>
                        <?php
                      }
                    }
                   ?> 
                   </select> 
                   </div>   
                   <div class="control-group">&nbsp&nbsp&nbsp
                   <label  for="salle">Salle &nbsp&nbsp&nbsp</label>
                   <select  name="salle" id="salle"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.salle ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  if ($result4["id_salle"]!=-1){
                      ?>
               <option <?php if(strcmp($result["id_salle"],$result4["id_salle"])==0){echo "selected";}?>  value="<?php echo $result4["id_salle"];?>"><?php echo $result4["salle"]." ".$result4["type"];?></option>
                        <?php
                    }
                    }
                   ?> 
                   </select> 
                   </div> <br/><br/>&nbsp&nbsp&nbsp
                   <div class="control-group">
                   <label  for="module">Module </label>
                   <select  name="module" id="module"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.module");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  if($result4["id_mod"]!=-1){
                      ?>
               <option <?php if(strcmp($result["id_mod"],$result4["id_mod"])==0){echo "selected";}?> value="<?php echo $result4["id_mod"];?>"><?php echo $result4["nom"];?></option>
                        <?php
                    }
                    }
                   ?> 
                   </select> 
                   </div> &nbsp&nbsp&nbsp
                   <div class="control-group">
                   <label  for="jour">Jour &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                   <select name="jour" id="jour">    
                   <option <?php if(strcmp($result["jour"],"1")==0){echo "selected";}?> value="1">Samedi</option>
                   <option <?php if(strcmp($result["jour"],"2")==0){echo "selected";}?> value="2">Dimanche</option>      
                   <option <?php if(strcmp($result["jour"],"3")==0){echo "selected";}?> value="3">Lundi</option> 
                   <option <?php if(strcmp($result["jour"],"4")==0){echo "selected";}?> value="4">Mardi</option> 
                   <option <?php if(strcmp($result["jour"],"5")==0){echo "selected";}?> value="5">Mercredi</option>
                   <option <?php if(strcmp($result["jour"],"6")==0){echo "selected";}?> value="6">Jeudi</option>
                   <option <?php if(strcmp($result["jour"],"7")==0){echo "selected";}?> value="7">Vendredi</option>     
                   </select> 
                </div>  &nbsp&nbsp&nbsp&nbsp&nbsp                 
                <div class="control-group">
                <label for="heure_debut">Heure début  &nbsp&nbsp&nbsp </label>
                <input class="in" type="time" id="heure_debut" name="heure_debut" value="<?php echo $result["heure_debut"];?>">
                </div><br/><br/>&nbsp&nbsp&nbsp
                <div class="control-group">
                <label for="heure_fin">Heure Fin  &nbsp&nbsp&nbsp </label>
                <input class="in"type="time" id="heure_fin" name="heure_fin"value="<?php echo $result["heure_fin"];?>">
                </div> <br/></br>
               
                 <div class="btngroup">             
                   <input id ="A" class="save" type="submit" value="Confirmer">
                   <input class="cancel"type="reset" onclick="cacher()"value="annuler">
                    </div> 
               </form>
               <?php 
    }
    ?>
    </body>
    </html>
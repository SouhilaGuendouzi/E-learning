<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="jquery.min.js"></script>
        <title>
            Update
         </title>
</head>
<body>
<?php
$id_niv=$_POST['id_niv'];
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_niv)){
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.niveau where id_niv=?");
$req->bindParam(1,$id_niv);
$req->execute();
}
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{ 
    ?>
          <h3> Informations sur le Niveau  </h3>
              <form class ="form" action="UpdateNiv.php" method="post" >
              <div class="control-group">
                   <input class="in"type="hidden" name="id_niv" id="id_niv" value=<?php echo $result["id_niv"];?>>   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="année">Année &nbsp&nbsp&nbsp</label>
                   <select name="année" id="année"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.année");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {
                        $année=TRUE;
                   ?> <option <?php if(strcmp($result["id_année"],$result4["id_année"])==0){echo "selected";}?> value="<?php echo $result4["id_année"];?>"><?php echo $result4["année"];?></option>
                        <?php
                    }
                   ?> 
                   </select>               
              </div>&nbsp&nbsp&nbsp 
              <div class="control-group">
                   <label  for="spécialité">Spécialité &nbsp&nbsp&nbsp</label>
                   <select name="spécialité" id="spécialité"> 
                   <?php 
                    $req3=$pdo->prepare("select * from elearn.spécialité");
                    $req3->execute();
                    while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                    { $spec=TRUE;
                   ?> <option <?php if(strcmp($result["id_spec"],$result3["id_spec"])==0){echo "selected";}?> value="<?php echo $result3["id_spec"];?>"><?php echo $result3["nom"];?></option>
                        <?php
                    }
                   ?>    
                   </select>               
              </div>&nbsp&nbsp&nbsp 
              <div class="btngroup">             
                   <input id ="A" class="save" type="submit" value="Confirmer">
                   <input class="cancel"type="reset" onclick="document.getElementById('d2').style.display='none'" value="annuler">
                    </div>
               </form>
              </div>
    
    
    <?php
}

?>
</body>
</html>
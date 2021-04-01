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
$id_mod=$_POST['id_mod'];
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_mod)){
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.module where id_mod=?");
$req->bindParam(1,$id_mod);
$req->execute();
}
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{ 
    ?>
  <h3> Informations sur le Module</h3>      
        <form class ="form" action="update.php?id_mod=<?php echo $result["id_mod"];?>" method="post" >
        <div class="control-group">
                   <input class="in"type="hidden" name="id_mod" id="id_mod" value=<?php echo $result["id_mod"];?>>
            </div>
            <div class="control-group">
                   <label  for="nom">Nom &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="nom" id="nom" value=<?php echo $result["nom"];?>>   
             </div>&nbsp&nbsp&nbsp
             <div class="control-group">
             <label  for="niveau">Niveau &nbsp&nbsp&nbsp </label>
             <select name="niveau" id="niveau"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.niveau ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                      $req5=$pdo->prepare("select * from  elearn.année where id_année=?");
                      $req5->bindParam(1,$result4["id_année"]);
                      $req5->execute();
                      while ($result5 = $req5->fetch(PDO::FETCH_ASSOC))
                      {
                        $id_année=$result5["année"];
                      }
                      $req5=$pdo->prepare("select * from  elearn.spécialité where id_spec=?");
                      $req5->bindParam(1,$result4["id_spec"]);
                      $req5->execute();
                      while ($result5 = $req5->fetch(PDO::FETCH_ASSOC))
                      {
                        $id_spec=$result5["nom"];
                      }
                      ?>
                   <option <?php if(strcmp($result["id_niv"],$result4["id_niv"])==0){echo "selected";}?>value="<?php echo $result4["id_niv"];?>"><?php echo $id_année." année  ".$id_spec;?></option>
                        <?php
                   
                    }
                   ?> 
                   </select> 
                   </div> &nbsp&nbsp&nbsp
                   <div class="control-group">
                   <label  for="responsable">Responsable &nbsp&nbsp&nbsp</label>
                   <select name="responsable" id="responsable"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.enseignant ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                
                      ?>
                  <option <?php if(strcmp($result["id_ens"],$result4["id_ens"])==0){echo "selected";}?> value="<?php echo $result4["id_ens"];?>"><?php echo $result4["nom"]." ".$result4["prénom"];?></option>
                        <?php
                   
                    }
                   ?> 
                   </select>   
                  
            <div class="btngroup">             
                   <input class="save" type="submit" value="Confirmer">
                   <input class="cancel"type="reset" onclick="document.getElementById('d2').style.display='none'"value="annuler">
                    </div>
            </form>
    
    
    <?php
}

?>
</body>
</html>
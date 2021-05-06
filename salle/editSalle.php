<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="jquery.min.js"></script>
        <title>
            Edit Salle
         </title>
</head>
<body>
<?php
$id_salle=$_POST['id_salle'];
$id_salle=(int)$id_salle;
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_salle)){
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.salle where id_salle=?");
$req->bindParam(1,$id_salle);
$req->execute();
}
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{ 
    ?>
  <h3> Informations sur la Salle</h3>      
        <form class ="form" action="update.php?id_salle=<?php echo $result["id_salle"];?>" method="post" >
        <div class="control-group">
                   <input class="in"type="hidden" name="id_salle" id="id_salle" value=<?php echo $result["id_salle"];?>>
            </div>
            <div class="control-group">
                   <label  for="nom">Salle &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="nom" id="nom" value=<?php echo $result["salle"];?>>   
             </div>&nbsp&nbsp&nbsp
             <div class="control-group">
                   <label  for="type">Type &nbsp&nbsp&nbsp</label>
                   <select name="type" id="type">    
                   <option <?php if(strcmp($result["type"],'TD')==0){echo "selected";}?> value="TD">TD</option>
                   <option <?php if(strcmp($result["type"],'TP')==0){echo "selected";}?> value="TP">TP</option>      
                   <option <?php if(strcmp($result["type"],'COURS')==0){echo "selected";}?> value="COURS">COURS</option>   
                   </select> 
                </div>  
                  
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
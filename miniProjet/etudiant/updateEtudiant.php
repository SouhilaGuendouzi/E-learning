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
$id_etud=$_POST['id_etud'];
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_etud)){
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.etudiant where id_etud=?");
$req->bindParam(1,$id_etud);
$req->execute();
}
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{ 
    ?>
  <h3> Informations sur l'Etudiant</h3>      
            <form class ="form" action="update.php?id_etud=<?php echo $result["id_etud"];?>" method="post" >
            <div class="control-group">
                   <input class="in"type="hidden" name="id_etud" id="id_etud" value=<?php echo $result["id_etud"];?>>
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
                   <label  for="nom">Nom &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="nom" id="nom" value="<?php echo $result["nom"];?>">                    
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
                   <label  for="prénom">Prénom &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="prénom" id="prénom" value="<?php echo$result["prénom"];?>">                    
            </div><br/><br/>
            <div class="control-group">
                   <label  for="date_naissance1">&nbsp&nbsp&nbspDate de naissance &nbsp&nbsp&nbsp</label>
                   <input class="in"type="date" name="date_naissance" id="date_naissance" value="<?php echo $result["date_naissance"];?>">                    
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
            <label  for="groupe">Groupe &nbsp&nbsp&nbsp</label>
            <select name="groupe" id="groupe">
            <?php 
                    $req3=$pdo->prepare("select * from elearn.groupe natural join elearn.niveau natural join elearn.spécialité natural join elearn.année "); 
                    $req3->execute();
                    while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                    { 
                   ?> <option <?php if(strcmp($result["id_groupe"],$result3["id_groupe"])==0){echo "selected";}?> value="<?php echo $result3["id_groupe"];?>"><?php echo $result3["nomGroupe"]." ".$result3["année"]."année ".$result3["nom"];?></option>
                        <?php
                    }
                   ?>   
    
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
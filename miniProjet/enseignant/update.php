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
$id_ens=$_POST['id_ens'];
$id_ens=(int)$id_ens;
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($id_ens)){
$pdo = new PDO( $host, "root", "");
$req=$pdo->prepare("select * from elearn.enseignant where id_ens=?");
$req->bindParam(1,$id_ens);
$req->execute();
}
while ($result = $req->fetch(PDO::FETCH_ASSOC))
{ 
    ?>
  <h3> Informations sur l'enseignant</h3>      
            <form class ="form" action="updateE.php?id_ens=<?php echo $result["id_ens"];?>" method="post" >
            <div class="control-group">
                   
                   <input class="in"type="hidden" name="id_ens" id="id_ens" value=<?php echo $result["id_ens"];?>>
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
                   <label  for="nom1">Nom &nbsp&nbsp&nbsp</label>
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
            <label  for="grade">Grade &nbsp&nbsp&nbsp</label>
            <select name="grade" id="grade">
            <option <?php if(strcmp($result["grade"],'Dr')==0){echo "selected";}?> value="Dr">Doctorant</option>
            <option <?php if(strcmp($result["grade"],'MCA')==0){echo "selected";}?> value="MCA">Maitre conférence classe A</option>
            <option <?php if(strcmp($result["grade"],'MCB')==0){echo "selected";}?> value="MCB">Maitre conférence classe B</option>
            <option <?php if(strcmp($result["grade"],'MCC')==0){echo "selected";}?> value="MCC">Maitre conférence classe C</option>
            <option <?php if(strcmp($result["grade"],'Pr')==0){echo "selected";}?> value="Pr">Proffeseur</option>
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
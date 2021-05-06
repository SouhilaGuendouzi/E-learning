<?php
session_start()
?>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="../jquery.min.js"></script>
        <title>
            Liste
         </title>

<style>
body{
  font:1.2em normal Arial,sans-serif;
  color:#34495E;
  padding:3%;
}
h2{
  text-align:center;
  font-size:2em;
  margin:20px 0;
  color:#777;
  margin-bottom:3%;
}

table{
  border-collapse:collapse;
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
  text-align:center;
  padding:5px 0;
}

tbody tr:nth-child(even){
  background:#ECF0F1;
}

tbody tr:hover{
background:#BDC3C7;
  color:#FFFFFF;
}
.ajouter {
        background: transparent;
        color: #1172c4;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;
        margin-left:40%;   
        margin-bottom:2%;     
    }
h3 {
  margin-top:8%;
    color: #777;
    margin-left:3%;
    
  }

  


</style>
<body>
<?php 
$id_groupe=$_GET["id_groupe"];
$login=$_SESSION["login"];
$pass=$_SESSION["pass"];
$host = "mysql:host = localhost ; dbname =elearn";
if (!empty($login)&&(!empty($pass))){
    try {
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
        {  
        $req=$pdo->prepare("select * from elearn.groupe natural join elearn.niveau natural join elearn.année natural join elearn.spécialité where id_groupe=?");
        $req->bindParam(1,$id_groupe);
        $req->execute(); 
        while ($result = $req->fetch(PDO::FETCH_ASSOC))
        {
        ?>
         <h2>Groupe :<?php echo $result["nomGroupe"]." de la ".$result["année"]." année ".$result["nom"] ?> </h2>
        <?php
        }
        
        ?>    
        <button href="#d1" onclick="afficherEtudiants('<?php echo $id_groupe;?>')") class="ajouter"> Afficher les étudiants </button>
        <script>
        function afficherEtudiants(id) {
         var theObject = new XMLHttpRequest();
        theObject.open('POST', 'afficherEtudiants.php', true);
        theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        theObject.onreadystatechange = function() {
        if(theObject.readyState === 4 & theObject.status === 200) {
            document.getElementById("d2").innerHTML = theObject.responseText;
      }
          }
        theObject.send('id_groupe='+id);
              } 
  </script>
        <div id="d2">
       
        </div>
                    
        <?php
        }
    
    else {
        echo "erreur de se connecter avec le serveur";
    }
       ?>
         <?php  
    
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }}

?>
</body>

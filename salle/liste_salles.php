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
#d1 {
  display: none;
}
h1{
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
.modifier {
    text-decoration: none;
    
}
.supprimer {
    text-decoration: none;
    color:#B71C1C;
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
        margin-left:45%;   
        margin-bottom:2%;     
    }
  
input.in,select{
  text-align: center;
  background-color: #ECF0F1;
  border: 2px solid transparent;
  border-radius: 3px;
  font-size: 16px;
  padding: 10px 0;
  width: 200px;
  }
input:focus {
  border: 2px solid #3498DB;
  box-shadow: none;
  }
.control-group {
  margin-bottom: 10px;
  display:inline;
  }

h3 {
  margin-top:8%;
    color: #777;
    margin-left:3%;
    
  }
  .form {  
   margin-top:2%;
   margin-left:5%;
 
}
  
.save {
        background: #1172c4;
        color: white;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;
        margin-left:50 %;
}
.cancel {
    border: 2px solid transparent;
    background: #B71C1C;
    color: #ffffff;
    font-size: 16px;
    line-height: 25px;
    padding: 5px 0;
    border-radius: 22px;
    width: 130px;
    text-align: center;
}
.btngroup{ 
    margin-left:60%;
    margin-top:5%;
}
select {
    width :25%;
}

    </style>
</head>
<body class="bd">
    <?php
    $login=$_SESSION["login"];
    $id_ann??e=null;
    $id_spec=null;
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
            {  ?>

            <h1>La liste des Salles</h1>
            <button href="#d1" onclick="display()" class="ajouter">Ajouter Une Salle</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Salle </th>
              <th>Type </th>
              <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select * from elearn.salle");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {   if ($result["id_salle"]!=-1){
                       ?>
                       <tr>
                        <td>
                       <?php     
                       echo $result["id_salle"];
                       ?>
                     
                   </td>
                   <td>
                       <?php
                       echo $result["salle"];
                       ?>
                      </td>
                      <td>
                       <?php
                      echo $result["type"];
                       ?>                     
                           <td>
                           <button class="save"href="#d2" onclick="update(<?php echo $result['id_salle'];?>)">Modifier</button>
                           <script>
                           function update(a){                       
                        var theObject = new XMLHttpRequest();
                         theObject.open('POST', 'editSalle.php', true);
                         theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          theObject.onreadystatechange = function() {
                         if(theObject.readyState === 4 & theObject.status === 200) {
                          document.getElementById('d1').style.display="none";
                          document.getElementById('d2').style.display="block";
                          document.getElementById('d2').innerHTML = theObject.responseText;
                          window.location.href='liste_salles.php#d2'
                          }
                              }
                       theObject.send('id_salle='+a);
  }
                           </script>
                           <button class="cancel" onclick="window.location.href='deleteSalle.php?id_salle=<?php echo $result['id_salle'];?>'">Supprimer</button>
                          </td>
                            <?php
                }}                
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur la Nouvelle Salle</h3>
              <form class ="form" action="ajouterSalle.php" method="post" >
              <div class="control-group">
                   <label  for="id_salle">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_salle" id="id_salle">   
             </div>&nbsp&nbsp&nbsp
             <div class="control-group">
                   <label  for="nom">Salle &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="nom" id="nom">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="type">Type &nbsp&nbsp&nbsp</label>
                   <select name="type" id="type">    
                   <option value="TD">TD</option>
                   <option value="TP">TP</option>      
                   <option value="COURS">COURS</option>   
                   </select> 
                </div>              
             
              <div class="btngroup">             
                   <input id ="A" class="save" type="submit" value="Ajouter">
                   <input class="cancel"type="reset" onclick="cacher()"value="annuler">
                    </div>
               </form>
              </div>
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
    <script>
    

    function display() {
  $('#d2').hide();
  $('#d1').show();
 
window.location.href='liste_enseignants.php#d1'
}
function cacher() {
  $('#d1').hide();
}


 </script>
    </body>
    </html>
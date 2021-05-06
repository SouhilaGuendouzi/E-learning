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
   margin-left:10%;
 
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
  width:25%;
}

    </style>
</head>
<body class="bd">
    <?php
    $login=$_SESSION["login"];
    $id_ens=null;
    $nom=null;
    $prénom=null;
    $date_naissance=null;
    $grade=null;
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

            <h1>La liste des Enseignants </h1>
            <button onclick="display()" class="ajouter">Ajouter</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Nom </th>
              <th>Prénom</th>
              <th>grade</th>
              <th>Date de Naissance</th>
              <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select id_ens , nom , prénom , grade , date_naissance from elearn.enseignant");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {   if ($result["id_ens"]!=-1){
                       ?>
                       <tr>
                        <td>
                       <?php     
                      
                       echo $result["id_ens"];
                       ?>
                     
                   </td>
                   <td>
                       <?php
                       echo $result["nom"];
                       ?>
                      </td>
                      <td>
                       <?php
                   echo $result["prénom"];
                       ?>
                       </td>
                       <td>
                       <?php
                       echo $result["grade"];
                       ?>
                        </td>
                       <td>
                       <?php                    
                       echo $result["date_naissance"];
                       ?>
                        </td>                           
                           <td>
                           <button class="save"href="#d2" onclick="update(<?php echo $result['id_ens'];?>)">Modifier</button>
                           <script>
                           function update(a){                         
                        var theObject = new XMLHttpRequest();
                         theObject.open('POST', 'update.php', true);
                         theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          theObject.onreadystatechange = function() {
                         if(theObject.readyState === 4 & theObject.status === 200) {
                          document.getElementById('d1').style.display="none";
                          window.location.href='liste_enseignants.php#d2';
                          document.getElementById('d2').style.display="block";
                          document.getElementById('d2').innerHTML = theObject.responseText;
    }
}
                       theObject.send('id_ens='+a);
  }
                           </script>
                           <button class="cancel" onclick="window.location.href='delete_enseignant.php?id_ens=<?php echo $result['id_ens'];?>'">Supprimer</button>
                          </td>
                            <?php
                }   
              }             
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur le nouveau enseignant</h3>
            
            <form class ="form" action="ajouter.php" method="post" >
            <div class="control-group">
                   <label  for="id_ens">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_ens" id="id_ens">   
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
                   <label  for="nom">Nom &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="nom" id="nom">                    
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
                   <label  for="prénom">Prénom &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="prénom" id="prénom">                    
            </div><br/><br/>
            <div class="control-group">
                   <label  for="date_naissance">Date de naissance &nbsp&nbsp&nbsp</label>
                   <input class="in"type="date" name="date_naissance" id="date_naissance">                    
            </div>&nbsp&nbsp&nbsp
            <div class="control-group">
            <label  for="grade">Grade &nbsp&nbsp&nbsp</label>
            <select name="grade" id="grade">
            <option value="Dr">Doctorant</option>
            <option value="MCA">Maitre conférence classe A</option>
            <option value="MCB">Maitre conférence classe B</option>
            <option value="MCC">Maitre conférence classe C</option>
            <option value="Pr">Proffeseur</option>
              </select>
            </div>
            <div class="btngroup">             
                   <input class="save" type="submit" value="Ajouter">
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
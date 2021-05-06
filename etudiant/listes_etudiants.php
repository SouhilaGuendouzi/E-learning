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
    width:30%;
}

    </style>
</head>
<body class="bd">
    <?php
    $touch=FALSE;
    $login=$_SESSION["login"];
    $id_ens=null;
    $nom=null;
    $prénom=null;
    $date_naissance=null;
    $id_groupe=null;
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

            <h1>La liste des Etudiants </h1>
            <button href="#d1" onclick="display()" class="ajouter">Ajouter</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Nom </th>
              <th>Prénom</th>
              <th>Date de Naissance</th>
              <th>Groupe</th>
              <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select id_etud , nom , prénom , id_groupe , date_naissance from elearn.etudiant");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {
                       ?>
                       <tr>
                        <td>
                       <?php     
                 echo $result["id_etud"];
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
                       echo $result["date_naissance"];
                       ?>
                        </td>
                        <td>
                       <?php
                       if ($result["id_groupe"]==-1) { echo "Aucun Groupe";}
                       else {
                        $req1=$pdo->prepare("select * from elearn.groupe where id_groupe=?");
                        $req1->bindParam(1,$result["id_groupe"]);
                        $req1->execute();
                        while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                        {
                           echo $result1["nomGroupe"];
                        }
                       }
                      
                       ?>
                        </td>                           
                           <td>
                           <button class="save"href="#d2" onclick="update(<?php echo $result['id_etud'];?>)">Modifier</button>
                           <script>
                           function update(a){                         
                        var theObject = new XMLHttpRequest();
                         theObject.open('POST', 'updateEtudiant.php', true);
                         theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          theObject.onreadystatechange = function() {
                         if(theObject.readyState === 4 & theObject.status === 200) {
                          document.getElementById('d1').style.display="none";
                          document.getElementById('d2').innerHTML = theObject.responseText;
                          document.getElementById('d2').style.display="block";
                          window.location.href='listes_etudiants.php#d2';
    }
}
                       theObject.send('id_etud='+a);
  }
                           </script>
                           <button class="cancel" onclick="window.location.href='deleteEtudiant.php?id_etud=<?php echo $result['id_etud'];?>'">Supprimer</button>
                          </td>
                            <?php
                }                
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur le nouveau Etudiant</h3>
            
            <form class ="form" action="ajouterEtudiant.php" method="post" >
            <div class="control-group">
                   <label  for="id_etud">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_etud" id="id_etud">   
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
            <label  for="groupe">Groupe &nbsp&nbsp&nbsp</label>
            <select name="groupe" id="groupe">
            <?php 
                    $req3=$pdo->prepare("select * from elearn.groupe natural join elearn.niveau natural join elearn.spécialité natural join elearn.année order by nom");    
                    $req3->execute();
                    while ($result3 = $req3->fetch(PDO::FETCH_ASSOC))
                    { $spec=TRUE;
                      if ($result3["id_groupe"]!=-1){
                   ?> <option value="<?php echo $result3["id_groupe"];?>"><?php echo $result3["nomGroupe"]." ".$result3["année"]."année ".$result3["nom"];?></option>
                        <?php
                    }}
                   ?>   
          
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
  document.getElementById('d2').style.display="none";
document.getElementById('d1').style.display="block";
window.location.href='listes_etudiants.php#d1';
}
function cacher() {
document.getElementById('d1').style.display="none";
}


 </script>
    </body>
    </html>
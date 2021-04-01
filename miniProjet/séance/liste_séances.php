<?php
session_start()
?>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="../jquery.min.js"></script>
        <title>
            Liste Des Séances
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
    border:2px solid #3498DB;
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
        margin-left:43%;   
        margin-bottom:2%;     
    }
  
input.in,select,time{
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
.select {
    width :25%;
}

    </style>
</head>
<body class="bd">
    <?php
    $login=$_SESSION["login"];
    $année=null;
    $spec=null;
    $niveau=null;
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

            <h1>La liste des Séances</h1>
            <button href="#d1" onclick="display()" class="ajouter">Ajouter Une Séance</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Type  </th>
              <th>Module</th>
              <th>Groupe</th>
              <th>Salle</th>
              <th>Jour</th>
              <th>Heure Début </th>
              <th>Heure Fin </th>
              <th>Options</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select * from elearn.séance");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {
                       ?>
                       <tr>
                        <td>
                       <?php     
                       echo $result["id_séance"];
                       ?>
                     
                   </td>
                   <td>
                       <?php
                       echo $result["type"];
                       ?>
                      </td>
                      <td>
                       <?php
                      $req1=$pdo->prepare("select * from elearn.module where id_mod=?");
                      $req1->bindParam(1,$result["id_mod"]);
                      $req1->execute();
                      while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                      {
                          echo $result1["nom"];
                      }
                       ?>
                       </td>
                       <td>
                       <?php
                      $req1=$pdo->prepare("select * from elearn.groupe natural join elearn.niveau natural join elearn.année natural join elearn.spécialité   where id_groupe=?");
                      $req1->bindParam(1,$result["id_groupe"]);
                      $req1->execute();
                      while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                      {
                        echo $result1["année"]." année ".$result1["nom"];
                          ?>
                          <br/>
                          <?php echo $result1["nomGroupe"];
                      }
                       ?>
                       </td>
                       
                       <td>
                       <?php
                      $req1=$pdo->prepare("select * from elearn.salle where id_salle=?");
                      $req1->bindParam(1,$result["id_salle"]);
                      $req1->execute();
                      while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                      {
                          echo $result1["salle"]." ".$result1["type"];
                      }
                       ?>
                       </td>
                       <td>
                       <?php     
                       echo $result["jour"];
                       ?>
                      </td>
                      <td>
                       <?php     
                       echo $result["heure_debut"];
                       ?>
                      </td>
                      <td>
                       <?php     
                       echo $result["heure_fin"];
                       ?>
                      </td>
                           <td>
                           <button class="save"href="#d2" onclick="update(<?php echo $result['id_séance'];?>)">Modifier</button>
                           <script>
                           function update(a){                       
                        var theObject = new XMLHttpRequest();
                         theObject.open('POST', 'editSéance.php', true);
                         theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          theObject.onreadystatechange = function() {
                         if(theObject.readyState === 4 & theObject.status === 200) {
                          document.getElementById('d2').innerHTML = theObject.responseText;}
                              }
                       theObject.send('id_séance='+a);
  }
                           </script>
                           <button class="cancel" onclick="window.location.href='deleteSéance.php?id_séance=<?php echo $result['id_séance'];?>'">Supprimer</button>
                          </td>
                            <?php
                }                
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur la Nouvelle Séance</h3>
              <form class ="form" action="ajouterSéance.php" method="post" >
              <div class="control-group">
                   <label  for="id_séance">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_séance" id="id_séance">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="type">Type &nbsp&nbsp&nbsp</label>
                   <select name="type" id="type">    
                   <option value="TD">TD</option>
                   <option value="TP">TP</option>      
                   <option value="COURS">COURS</option>   
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
                      ?>
               <option value="<?php echo $result4["id_groupe"];?>"><?php echo $result4["nomGroupe"]." ".$année." année  ".$spec;?></option>
                        <?php
                   
                    }
                   ?> 
                   </select> 
                   </div> <br/><br/>  
                   <div class="control-group">
                   <label  for="salle">Salle &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                   <select  name="salle" id="salle"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.salle ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                      ?>
               <option value="<?php echo $result4["id_salle"];?>"><?php echo $result4["salle"]." ".$result4["type"];?></option>
                        <?php
                   
                    }
                   ?> 
                   </select> 
                   </div> &nbsp&nbsp&nbsp
                   <div class="control-group">
                   <label  for="module">Module &nbsp&nbsp&nbsp</label>
                   <select  name="module" id="module"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.module");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                      ?>
               <option value="<?php echo $result4["id_mod"];?>"><?php echo $result4["nom"];?></option>
                        <?php
                   
                    }
                   ?> 
                   </select> 
                   </div> <br/><br/>
                   <div class="control-group">
                   <label  for="jour">Jour &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                   <select name="jour" id="jour">    
                   <option value="samedi">Samedi</option>
                   <option value="dimanche">Dimanche</option>      
                   <option value="lundi">Lundi</option> 
                   <option value="mardi">Mardi</option> 
                   <option value="mercredi">Mercredi</option>
                   <option value="jeudi">Jeudi</option>
                   <option value="vendredi">Vendredi</option>     
                   </select> 
                </div>  &nbsp&nbsp&nbsp                     
                <div class="control-group">
                <label for="heure_debut">Heure début  &nbsp&nbsp&nbsp </label>
                <input class="in" type="time" id="heure_debut" name="heure_debut">
                </div>&nbsp&nbsp&nbsp
                <div class="control-group">
                <label for="heure_fin">Heure Fin  &nbsp&nbsp&nbsp </label>
                <input class="in"type="time" id="heure_fin" name="heure_fin">
                </div> <br/></br>
               
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
document.getElementById('d2').style.display="none";
document.getElementById('d1').style.display="block";
}
function cacher() {
document.getElementById('d1').style.display="none";
}


 </script>
    </body>
    </html>
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
#d1,#d3 {
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
        margin-left:22%;   
        margin-bottom:2%;
        width:19%;    
    }
    .emploie{
        background: transparent;
        color: #1172c4;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;
       
    }
    .ajouterannée {
        background: #1172c4;
        color: white;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;
        margin-left:80%;   
        margin-top:3%;
        margin-bottom:2%; 
    }
 .annéeButton {
     background: transparent;
        color: #1172c4;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;  
        margin-bottom:2%;
        width:19%;      
    }
    .specButton {
     background: transparent;
        color: #1172c4;
        font-size: 14px;
        border-color: #1172c4;
        border-style: solid;
        border-width: 2px;
        border-radius: 22px;
        padding: 10px 40px;
     
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

    </style>
</head>
<body class="bd">
    <?php
    $stop=FALSE;
    $login=$_SESSION["login"];
    $pass=$_SESSION["pass"];
    $host = "mysql:host = localhost ; dbname =elearn";
    $spec=FALSE;
    $année=FALSE;
    if (!empty($login)&&(!empty($pass))){
        try
         {
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

              <h1>La liste des Niveaux </h1>
              <button href="#d1" onclick="display()" class="ajouter">Ajouter Un Niveau</button>
              <button href="#d2" onclick="afficherAnnée()" class="annéeButton">Visualiser les Années</button>
              <script>
                 function afficherAnnée(){                         
                 var theObject = new XMLHttpRequest();
                 theObject.open('POST', 'listes_années.php', true);
                 theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                 theObject.onreadystatechange = function() {
                  if(theObject.readyState === 4 & theObject.status === 200) {
                    document.querySelector(".specButton").style.backgroundColor="transparent";
                      document.querySelector(".specButton").style.color="#1172c4";
                    document.querySelector(".annéeButton").style.backgroundColor="#1172c4";
                    document.querySelector(".annéeButton").style.color="white";
                    document.querySelector(".ajouter").style.backgroundColor="transparent";
                    document.querySelector(".ajouter").style.color="#1172c4";
                    document.getElementById('d1').style.display="none";
                    document.getElementById('d2').innerHTML = theObject.responseText;
                    window.location.href='listes_niveaux.php#d2'
                  }
                }
               theObject.send();
               }
                </script>
             
              <button href="#d1" onclick="display3()" class="specButton">Visualiser Les Spécialités</button>
              <script>
                 function display3(){                         
                 var theObject = new XMLHttpRequest();
                 theObject.open('POST', 'listes_spécialité.php', true);
                 theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                 theObject.onreadystatechange = function() {
                  if(theObject.readyState === 4 & theObject.status === 200) {
                    document.querySelector(".specButton").style.backgroundColor="#1172c4";
                    document.querySelector(".specButton").style.color="white";
                    document.querySelector(".ajouter").style.backgroundColor="transparent";
                    document.querySelector(".ajouter").style.color="#1172c4";
                    document.querySelector(".annéeButton").style.backgroundColor="transparent";
                    document.querySelector(".annéeButton").style.color="#1172c4";
                    document.getElementById('d1').style.display="none";
                    document.getElementById('d2').innerHTML = theObject.responseText;
                    window.location.href='listes_niveaux.php#d2'
                  }
                }
               theObject.send();
               }
                </script>
                <table class="blue">
              <thead>
              <tr>
              <th>Identifiant</th>
              <th>Année </th>
              <th>Spécialité</th>
              <th>Option</th>
              </tr>
              </thead>
              <tbody>
              <?php
                $req=$pdo->prepare("select id_niv , id_spec , id_année from elearn.niveau");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))

                {  
                  if ($result["id_niv"]!=-1){
                  $req1=$pdo->prepare("select * from elearn.spécialité where id_spec=?");
                    $req1->bindParam(1,$result["id_spec"]);
                    $req1->execute();
                    while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                    {
                        $req2=$pdo->prepare("select * from elearn.année where id_année=?");
                        $req2->bindParam(1,$result["id_année"]);
                        $req2->execute();
                        while ($result2 = $req2->fetch(PDO::FETCH_ASSOC))
                        {
                            ?>
                            <tr>
                             <td>
                            <?php     
                            echo $result["id_niv"];
                            ?>
                          
                           </td>
                            <td>
                            <?php
                            echo $result2["année"];
                            ?>
                           </td>
                           <td>
                            <?php
                            echo $result1["nom"];
                            ?>
                            </td>                           
                                <td>
                                <button class="save"href="#d2" onclick="update(<?php echo $result['id_niv'];?>)">Modifier</button>
                                <script>
                                function update(a){                         
                             var theObject = new XMLHttpRequest();
                              theObject.open('POST', 'EditNiv.php', true);
                              theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                               theObject.onreadystatechange = function() {
                              if(theObject.readyState === 4 & theObject.status === 200) {
                               document.getElementById('d2').innerHTML = theObject.responseText;
                               window.location.href='listes_niveaux.php#d2'
                                     }
                                  }
                            theObject.send('id_niv='+a);
                                 }
                                </script>
                                <button class="emploie"href="#d2" onclick="window.location.href='emploieTemps.php?id_niv=<?php echo $result['id_niv'];?>'">Emploie du temps</button>
                                <button class="cancel" onclick="window.location.href='deleteNiv.php?id_niv=<?php echo $result['id_niv'];?>'">Supprimer</button>                                        
                               </td></tr>
                         <?php      
                        }
                    }
                        
                }  
              }              
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur le Niveau à Ajouter </h3>
              <form class ="form" action="ajouterNiv.php" method="post" >
              <div class="control-group">
                   <label  for="id_niv">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_niv" id="id_niv">   
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
                        if ($result4["id_année"]!=-1){
                   ?> <option value="<?php echo $result4["id_année"];?>"><?php echo $result4["année"];?></option>
                        <?php
                    }}
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
                      if ($result3["id_spec"]!=-1){
                   ?> <option value="<?php echo $result3["id_spec"];?>"><?php echo $result3["nom"];?></option>
                        <?php
                    }}
                   ?>    
                   </select>               
              </div>&nbsp&nbsp&nbsp 
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
        }
    catch (PDOException $e){
            echo $e->getMessage();
         }
}
    ?>
    <script>
function display() {
document.getElementById('d1').style.display="block";
document.querySelector(".ajouter").style.backgroundColor="#1172c4";
document.querySelector(".ajouter").style.color="white";
document.querySelector(".annéeButton").style.backgroundColor="transparent";
 document.querySelector(".annéeButton").style.color="#1172c4";
 document.querySelector(".specButton").style.backgroundColor="transparent";
 document.querySelector(".specButton").style.color="#1172c4";
 window.location.href='listes_niveaux.php#d1'
}
function cacher() {
document.getElementById('d1').style.display="none";
document.querySelector(".ajouter").style.backgroundColor="transparent";
document.querySelector(".ajouter").style.color="#1172c4";
document.querySelector(".specButton").style.backgroundColor="transparent";
 document.querySelector(".specButton").style.color="#1172c4";
}
function displayAnnée() {

document.getElementById('d3').style.display="block";
document.getElementById('C').style.display="none";
}
function cacherAnnée() {
document.getElementById('d3').style.display="none";
document.getElementById('C').style.display="block";
}


 </script>
    </body>
    </html>
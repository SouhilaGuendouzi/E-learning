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
        margin-left:40%;   
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
    $année=null;
    $spec=null;
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

            <h1>La liste des Modules</h1>
            <button href="#d1" onclick="display()" class="ajouter">Ajouter Un Module</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Nom  </th>
              <th>Niveau </th>
              <th>Responsable</th>
              <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select * from  elearn.module natural join elearn.niveau   ");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                { if ($result["id_mod"]!=-1)
                  {
                       ?>
                       <tr>
                        <td>
                       <?php     
                       echo $result["id_mod"];
                       ?>
                     
                   </td>
                   <td>
                       <?php
                       echo $result["nom"];
                       ?>
                      </td>
                      <td>
                       <?php

                    $req1=$pdo->prepare("select * from elearn.année where id_année=?");
                    $req1->bindParam(1,$result["id_année"]);
                    $req1->execute();
                    while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                    {
                          $année=$result1["année"];
                        
                    }
                    $req1=$pdo->prepare("select * from elearn.spécialité where id_spec=?   ");
                    $req1->bindParam(1,$result["id_spec"]);
                    $req1->execute();
                    while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                    {
                          $spec=$result1["nom"];
                    }

                      echo $année." année ".$spec;
                       ?> 
                       </td>

                       <td>
                      
                      <?php 
                      if ($result["id_ens"]!=-1)
                      {
                      $req1=$pdo->prepare("select * from elearn.enseignant where id_ens=?   ");
                            $req1->bindParam(1,$result["id_ens"]);
                            $req1->execute();
                            while ($result1 = $req1->fetch(PDO::FETCH_ASSOC))
                            {
                                  echo $result1["nom"]." ".$result1["prénom"];
                            }
                          }
                      else echo "Aucun";
                    ?>
                       </td>                    
                           <td>
                           <button class="save"  onclick="update(<?php echo $result['id_mod'];?>)">Modifier</button>
                           <script>
                           function update(a){                       
                        var theObject = new XMLHttpRequest();
                         theObject.open('POST', 'editModule.php', true);
                         theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                          theObject.onreadystatechange = function() {
                         if(theObject.readyState === 4 & theObject.status === 200) {
                          document.getElementById('d1').style.display="none";
                          document.getElementById('d2').innerHTML = theObject.responseText;
                          document.getElementById('d2').style.display="block";
                          window.location.href='listes_module.php#d2'
                          }
                              }
                       theObject.send('id_mod='+a);
  }
                           </script>
                           <button class="cancel" onclick="window.location.href='deleteModule.php?id_mod=<?php echo $result['id_mod'];?>'">Supprimer</button>
                          </td>
                            <?php
                }  
              }              
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur le Nouveau Module </h3>
              <form class ="form" action="ajouterModule.php" method="post" >
              <div class="control-group">
                   <label  for="id_mod">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_mod" id="id_mod">   
             </div>&nbsp&nbsp&nbsp
             <div class="control-group">
                   <label  for="nom">Nom &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="nom" id="nom">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="niveau">Niveau &nbsp&nbsp&nbsp</label>
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
                      if ($result4["id_niv"]!=-1){
                      ?>
               <option value="<?php echo $result4["id_niv"];?>"><?php echo $id_année." année  ".$id_spec;?></option>
                        <?php
                   }
                    }
                   ?> 
                   </select>
                   </div>   <br/> <br/>
                   <div class="control-group">
                   <label  for="responsable">Responsable &nbsp&nbsp&nbsp</label>
                   <select name="responsable" id="responsable"> 
                   <?php 
                    $req4=$pdo->prepare("select * from elearn.enseignant ");
                    $req4->execute();
                    while ($result4 = $req4->fetch(PDO::FETCH_ASSOC))
                    {  
                      if ($result4["id_ens"]!=-1){
                      ?>
                  <option value="<?php echo $result4["id_ens"];?>"><?php echo $result4["nom"]." ".$result4["prénom"];?></option>
                        <?php
                   
                    }
                  }
                   ?> 
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
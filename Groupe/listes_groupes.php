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
    $id_année=null;
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

            <h1>La liste des Groupes</h1>
            <button href="#d1" onclick="display()" class="ajouter">Ajouter Un groupe</button>
            <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Nom  </th>
              <th>Niveau </th>
              <th>Option</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $req=$pdo->prepare("select id_groupe , nomGroupe, nom , année from elearn.groupe natural join elearn.niveau natural join elearn.année natural join elearn.spécialité ");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {    if ($result["id_groupe"]!=-1){
                       ?>
                       <tr>
                        <td>
                       <?php     
                       echo $result["id_groupe"];
                       ?>
                     
                   </td>
                   <td>
                       <?php
                       echo $result["nomGroupe"];
                       ?>
                      </td>
                      <td>
                       <?php
                      echo $result["année"]."année ".$result["nom"];;
                       ?>                     
                           <td>
                           <button class="save"href="#d2" onclick="window.location.href='afficherGroupe.php?id_groupe=<?php echo $result['id_groupe'];?>'">Plus de détails</button>
                           <button class="cancel" onclick="window.location.href='deleteGroupe.php?id_groupe=<?php echo $result['id_groupe'];?>'">Supprimer</button>
                          </td>
                            <?php
                } }             
             ?>
             <tbody>
             </table>
             <div id="d1">
             <h3> Informations sur le Nouveau Groupe  </h3>
              <form class ="form" action="ajouterGroupe.php" method="post" >
              <div class="control-group">
                   <label  for="id_groupe">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_groupe" id="id_groupe">   
             </div>&nbsp&nbsp&nbsp
             <div class="control-group">
                   <label  for="nomGroupe">Nom &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="nomGroupe" id="nomGroupe">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="nomGroupe">Niveau &nbsp&nbsp&nbsp</label>
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
                      if ($result4["id_niv"]!=-1 ){
                      ?>
                      
               <option value="<?php echo $result4["id_niv"];?>"><?php echo $id_année." année  ".$id_spec;?></option>
                        <?php
                   
                    }
                  }
                   ?> 
                   </select>               
             
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
  $('#d1').show();
 
window.location.href='liste_enseignants.php#d1'
}
function cacher() {
  $('#d1').hide();
}


 </script>
    </body>
    </html>
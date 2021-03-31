<?php
session_start()
?>
<!DOCTYPE html>
<html>
    <head>
    <link   href="style.css"     type="text/css"    rel="stylesheet" >
        <title>
            Profile 
         </title>
</head>
<style>
* {
  box-sizing: border-box;
  }
  
  *:focus {
    outline: none;
  }
  body {
  font-family: Arial;
  background-color: white;
  padding: 50px;
  }
  .login {
  margin: 20px auto;
  width: 300px;
  }
  .login-screen {
  background-color: #FFF;
  padding: 20px;
  border-radius: 5px
  }
 
  
  .app-title {
  text-align: center;
  color: #777;
  }
  
  .login-form {
  text-align: center;
  }
  .control-group {
  margin-bottom: 10px;
  }
  
  input {
  text-align: center;
  background-color: #ECF0F1;
  border: 2px solid transparent;
  border-radius: 3px;
  font-size: 16px;
  font-weight: 200;
  padding: 10px 0;
  width: 250px;
  transition: border .5s;
  }
  
  input:focus {
  border: 2px solid #3498DB;
  box-shadow: none;
  }
  
  .btn {
    border: 2px solid transparent;
    background: #3498DB;
    color: #ffffff;
    font-size: 16px;
    line-height: 25px;
    padding: 10px 0;
    text-decoration: none;
    text-shadow: none;
    border-radius: 3px;
    box-shadow: none;
    transition: 0.25s;
    display: block;
    width: 250px;
    margin: 0 auto;
    margin-bottom:2%;
    text-align: center;
  }
  .btn1 {
    border: 2px solid transparent;
    background: #3498DB;
    color: #ffffff;
    font-size: 16px;
    line-height: 25px;
    padding: 10px 0;
    text-align: center;
    text-decoration: none;
    text-shadow: none;
    border-radius: 3px;
    box-shadow: none;
    transition: 0.25s;
    display: block;
    width: 250px;
    margin: 0 auto;
    margin-bottom:2%;
    text-align: center;
  }
  .btn:hover {
    background-color: #2980B9;
  }
  
  .login-link {
    font-size: 12px;
    color: #444;
    display: block;
    margin-top: 12px;
  }
  h1 {
    color: #777;
    margin-bottom:5%;
  }
  p {
      color:#B71C1C;
      margin-left:40%;
  }
</style>
<html>
<body>
<?php
    $stop=FALSE;
    @$login=$_SESSION["login"];
    @$pass=$_SESSION["pass"];
    if (!empty($login)&&(!empty($pass))){
    $host = "mysql:host = localhost ; dbname =elearn";
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
          ?>
            <div class="welcome">
           <h1>Soyez les Bienvenus <?php echo $login; ?> ! </h1> 
           <a class="btn1  "href="enseignant/liste_enseignants.php">Afficher les Enseignants </a> 
           <a class="btn1  " href="Niveau/listes_niveaux.php"> Afficher les étudiants </a>
           <a class="btn1  " href="service_employes.php"> Afficher les niveaux</a>
           <a class="btn1  " href="service_employes.php"> Afficher les modules </a>
           <a class="btn1  " href="service_employes.php"> Afficher les groupes </a>
           
           </div>
           <?php
        }
       else {
            echo "erreur dans le serveur";
        }}
        catch (PDOException $e){
            echo $e->getMessage();
        }}
        else  {
            echo "souhila";
        }
        ?>
</body>

</html>


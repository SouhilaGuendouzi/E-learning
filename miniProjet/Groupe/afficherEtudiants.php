<?php 
$id_groupe=$_POST["id_groupe"];
try {
    $host = "mysql:host = localhost ; dbname =elearn";
    $pdo = new PDO( $host, "root", "");
    $req=$pdo->prepare("select * from elearn.etudiants where id_groupe=?");
    $req->bindParam(1,$id_groupe);
   ?>
   <table class="blue">
            <thead>
              <tr>
              <th>Identifiant</th>
              <th>Nom  </th>
              <th>Prénom</th>
              <th>Date_naissance</th>
              </tr>
            </thead>
            <tbody>
   <?php
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
         </tr>

        <?php
    }
}
catch (PDOException $e){
    echo $e->getMessage();
}
?>

<h3> Liste des Années </h3>
<table class="blue">
 <thead>
<tr>
<th>Identifiant</th>
<th>Année </th>
<th>Option</th>
</tr>
</thead>
<tbody>
              <?php
               $host = "mysql:host = localhost ; dbname =elearn";
               $pdo = new PDO( $host, "root", "");
                $req=$pdo->prepare("select * from elearn.année");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {      if ($result["id_année"]!=-1){
                     ?>
                            <tr>
                             <td>
                            <?php     
                            echo $result["id_année"];
                            ?>
                          
                           </td>
                            <td>
                            <?php
                            echo $result["année"];
                            ?>
                           </td>                             
                                <td>
                                <button class="cancel" onclick="window.location.href='Delete_année.php?id_année=<?php echo $result['id_année'];?>'">Supprimer</button>                              
                               
                               </td></tr>
                         <?php            
                }  }              
             ?>
<tbody>
</table>
<div id="d3">
<h3> Informations sur la Nouvelle Année</h3>
              <form class ="form" action="ajouterAnnée.php" method="post" >
              <div class="control-group">
                   <label  for="id_année">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_année" id="id_année">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="année">Année &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="année" id="année">          
              </div>&nbsp&nbsp&nbsp 
              <div class="btngroup">             
                   <input id ="A" class="save" type="submit" value="Ajouter">
                   <input id="B" class="cancel"type="reset" onclick="cacherAnnée()"value="annuler">
                    </div>
               </form>
</div>

<button id="C" class="ajouterannée" onclick="displayAnnée()"> Ajouter Une Année </button>
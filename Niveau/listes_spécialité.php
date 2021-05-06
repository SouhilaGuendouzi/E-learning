<h3> Liste des Spécialités </h3>
<table class="blue">
 <thead>
<tr>
<th>Identifiant</th>
<th>Spécialité </th>
<th>Option</th>
</tr>
</thead>
<tbody>
              <?php
               $host = "mysql:host = localhost ; dbname =elearn";
               $pdo = new PDO( $host, "root", "");
                $req=$pdo->prepare("select * from elearn.spécialité");
                $req->execute();
                while ($result = $req->fetch(PDO::FETCH_ASSOC))
                {     if ($result["id_spec"]!=-1){
                      ?>
                            <tr>
                             <td>
                            <?php     
                            echo $result["id_spec"];
                            ?>
                           </td>
                            <td>
                            <?php
                            echo $result["nom"];
                            ?>
                           </td>                             
                                <td>
                                <button class="cancel" onclick="window.location.href='deleteSpécialité.php?id_spec=<?php echo $result['id_spec'];?>'">Supprimer</button>                              
                               </td></tr>
                         <?php            
                } }               
             ?>
<tbody>
</table>
<div id="d3">
<h3> Informations sur la Nouvelle spécialité</h3>
              <form class ="form" action="ajouterspécialité.php" method="post" >
              <div class="control-group">
                   <label  for="id_spec">Identifiant &nbsp&nbsp&nbsp </label>
                   <input class="in"type="text" name="id_spec" id="id_spec">   
             </div>&nbsp&nbsp&nbsp
              <div class="control-group">
                   <label  for="spécialité">Spécialité &nbsp&nbsp&nbsp</label>
                   <input class="in"type="text" name="spécialité" id="spécialité">          
              </div>&nbsp&nbsp&nbsp 
              <div class="btngroup">             
                   <input id ="A" class="save" type="submit" value="Ajouter">
                   <input id="B" class="cancel"type="reset" onclick="cacherAnnée()"value="annuler">
                    </div>
               </form>
</div>

<button id="C" class="ajouterannée" onclick="displayAnnée()"> Ajouter Une spécialité</button>
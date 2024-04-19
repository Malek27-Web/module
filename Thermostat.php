<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermostat connectée</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist\css\bootstrap.css">
  


</head>
<body>
<button class="btn "><a href="TousLesModules.php"><svg stroke="white" fill="white" stroke-width="0" version="1.1" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 10v-2h-5v-2h5v-2l3 3zM11 9v4h-5v3l-6-3v-13h11v5h-1v-4h-8l4 2v9h4v-3z"></path></svg></a></button>

<!-- popup pour un message de succes -->
<div id="popup-overlay" >
<div class="popup-content d-flex gap-5 align-items-center justify-content-center">
    <h2 class="etat text-nowrap"></h2>
    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M912 190h-69.9c-9.8 0-19.1 4.5-25.1 12.2L404.7 724.5 207 474a32 32 0 0 0-25.1-12.2H112c-6.7 0-10.4 7.7-6.3 12.9l273.9 347c12.8 16.2 37.4 16.2 50.3 0l488.4-618.9c4.1-5.1.4-12.8-6.3-12.8z"></path></svg>
</div>
</div>

<div class="wrapper d-flex align-items-center justify-content-around p-2 ">
    <div class="d-flex flex-column align-items-center ">
        <h1 class="text-light">Ajouter Un thermostat</h1>
        <br>
        <!-- formulaire -->
        <div class="form-card ">
            <div class="form-group">
                <form action="" method="POST">
                <input type="hidden" name="id" id="idThermostat" value="" > 
                <label class="text-light fs-4 fw-semibold" for="temperatue actuelle">Températue actuelle:</label>
                <input name="temp_actuelle" type="number" pattern="^\d+(,\d+)?$" id="temp_actuelle" required>
            </div>

            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="Temperatue choisie">Temperature choisie</label>
                <input name="temp_choisie" type="number" id="temp_choisie" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="humidite">Humidite:</label>
                <input name="humidite"  type="number" id="humidite" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="duration">Durée de fonctionnement:</label>
                <input name="duree_fonctionnement" type="text" id="duration" pattern="^[0-9]{2}:[0-9]{2}$" title="Format HH:MM" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="etat">Etat:</label>
                <input name="etat" type="text" id="etat" pattern="^(en marche|en panne)$" title=" il faut choisir entre en marche ou en panne"  required>
            </div>
            <div class="button-container">
                <button  type="submit" id="ajouter"  name="ajouter" class="glow-on-hover fs-5 fw-semibold">Ajouter</button>
                <button type="submit" name="modifier" id="modifier" class="glow-on-hover fs-5 fw-semibold">Modifier</button>
                <button type="submit" name="supprimer" id="supprimer" class="glow-on-hover fs-5 fw-semibold">Supprimer</button>
            </div>
            </form>
        </div>
    </div>
      
        <div class="watch-image">
            <img src="./img/Thermostat.png" alt="thermostat">
        </div>
    </div>

<!-- Ajoutez un thermostat, et si il est correctement insérée, un popup apparaîtra avec un message significatif. -->
    <?php
    include 'database.php'; 
    $isDataInserted = false; //cette variable est utilisé pour tester si les données sont bien inserés pour pouvoir afficher le popup après
    if (isset($_POST['ajouter'])) {
        
        $sql = "INSERT INTO thermostat (temp_actuelle, temp_choisie, humidite, duree_fonctionnement, etat) VALUES (:temp_actuelle, :temp_choisie, :humidite, :duree_fonctionnement, :etat)";
        $stmt = $conn->prepare($sql);
        $exec =  $stmt->execute([':temp_actuelle' => $_POST['temp_actuelle'], ':temp_choisie' => $_POST['temp_choisie'], ':humidite' => $_POST['humidite'], ':duree_fonctionnement' => $_POST['duree_fonctionnement'], 'etat'=>$_POST['etat']]);
        if ($exec) {
            $isDataInserted = true; 
        }
    } 
  ?>
  <?php if ($isDataInserted): ?>
    <!-- Le role de ce script est d'afficher le popup -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var popupOverlay = document.getElementById('popup-overlay');
    const etat=document.querySelector(".etat");
    etat.innerHTML="Thermostat ajouté avec Succés ";
    if (popupOverlay) {
        popupOverlay.classList.add('open');
        setTimeout(() => {
            popupOverlay.classList.remove('open');
        }, 2000);
    }
});
</script>
<?php endif; ?>
<?php
$isDataUpdated = false; 
    if (isset($_POST['modifier'])) {
     
        $id = $_POST['id'];
        $temp_actuelle = $_POST['temp_actuelle'];
        $temp_choisie = $_POST['temp_choisie'];
        $humidite = $_POST['humidite'];
        $duree_fonctionnement= $_POST['duree_fonctionnement'];
        $etat=$_POST['etat'];
    
      
        if (!empty($id) && is_numeric($id)) {
            $sql = "UPDATE thermostat SET temp_actuelle = :temp_actuelle, temp_choisie = :temp_choisie, humidite = :humidite, duree_fonctionnement = :duree_fonctionnement, etat = :etat WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':temp_actuelle', $temp_actuelle, PDO::PARAM_INT);
            $stmt->bindParam(':temp_choisie', $temp_choisie, PDO::PARAM_INT);
            $stmt->bindParam(':humidite', $humidite, PDO::PARAM_INT);
            $stmt->bindParam(':duree_fonctionnement', $duree_fonctionnement, PDO::PARAM_STR);
            $stmt->bindParam(':etat', $etat, PDO::PARAM_STR);
           $exec=$stmt->execute();
        }
        if ($exec) {
            $isDataUpdated = true; 
        }
    }
    ?>
    <?php if ($isDataUpdated): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var popupOverlay = document.getElementById('popup-overlay');
    const etat=document.querySelector(".etat");
    etat.innerHTML="Thermostat modifié avec Succes";
    if (popupOverlay) {
        popupOverlay.classList.add('open');
        setTimeout(() => {
            popupOverlay.classList.remove('open');
        }, 2000);
    }
});
</script>
<?php endif; ?>

<?php
$isDataDeleted=false;
    if (isset($_POST['supprimer'])) {
        $id = $_POST['id'];  
    
        $sql = "DELETE FROM thermostat WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);  
       $exec=$stmt->execute();
       if($exec){
        $isDataDeleted=true;
       }
    }
    ?>
 <?php if ($isDataDeleted): ?>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var popupOverlay = document.getElementById('popup-overlay');
    const etat=document.querySelector(".etat");
    etat.innerHTML="Thermostat Supprimé avec Succés";
    if (popupOverlay) {
        popupOverlay.classList.add('open');
        setTimeout(() => {
            popupOverlay.classList.remove('open');
        }, 2000);
    }
});
</script>
<?php endif; ?>
    
<?php

   
            $query = "SELECT COUNT(*) FROM thermostat"; 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $nombreThermostat = $stmt->fetchColumn(); 
            ?>
            <br>
            <div class="mt-3  d-flex justify-content-center align-items-center flex-column">
                <h2 class="text-light">Thermostat Connectés : <?php echo $nombreThermostat; ?> </h2>
                
            <table class="table table-hover table-dark  ">
                <thead>
                    <tr>
                        <th scope="col">ID:</th>
                        <th scope="col">Température actuelle</th>
                        <th scope="col">Température choisie</th>
                        <th scope="col">humidite</th>
                        <th scope="col">Durée de fonctionnement</th>
                        <th scope="col">Etat</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $query = "SELECT * FROM thermostat";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        //ce code est fait lorsqu'on clique sur une ligne du tableau les inputs du formulaire se emplissent automatiquement 
        echo "<tr onclick='document.getElementById(\"temp_actuelle\").value = \"" . htmlspecialchars($row['temp_actuelle']) . 
        "\"; document.getElementById(\"temp_choisie\").value = \"" . htmlspecialchars($row['temp_choisie']) .
        "\"; document.getElementById(\"humidite\").value = \"" . htmlspecialchars($row['humidite']) .
        "\"; document.getElementById(\"duration\").value = \"" . htmlspecialchars($row['duree_fonctionnement']) . 
        "\"; document.getElementById(\"etat\").value = \"" . htmlspecialchars($row['etat']) . 
        "\"; document.getElementById(\"idThermostat\").value = \"" . htmlspecialchars($row['id']) . "\";'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['temp_actuelle']) . "</td>";
        echo "<td>" . htmlspecialchars($row['temp_choisie']) . "</td>";
        echo "<td>" . htmlspecialchars($row['humidite']) . "</td>";
        echo "<td>" . htmlspecialchars($row['duree_fonctionnement']) . "</td>";
        echo "<td>" . htmlspecialchars($row['etat']) . "</td>";
        echo "</tr>";
    }
    ?>
</tbody>
            </table>
        </div>
    </div>

</body>
</html>

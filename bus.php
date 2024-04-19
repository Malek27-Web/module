<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus connectée</title>
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
        <h1 class="text-light">Ajouter Un Bus</h1>
        <br>
        <!-- formulaire -->
        <div class="form-card ">
            <div class="form-group">
                <form action="" method="POST">
                <input type="hidden" name="id" id="idBus" value="" > 
                <label class="text-light fs-4 fw-semibold" for="position">Position:</label>
                <input name="position" type="number" pattern="^\d+(,\d+)?$" id="position" required>
            </div>

            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="Temperatue choisie">Vitesse:</label>
                <input name="vitesse" type="number" id="vitesse" pattern="^\d+(,\d+)?$" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="humidite">Nombre de passgers a bord:</label>
                <input name="nb_passagers"  type="number" id="nb_passagers" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="heure_depart">Heure depart:</label>
                <input name="heure_depart" type="time" id="heure_depart" pattern="^[0-9]{2}:[0-9]{2}$" title="Format HH:MM" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="heure_arrivee">Heure arrivée:</label>
                <input name="heure_arrivee" type="time" id="heure_arrivee" pattern="^[0-9]{2}:[0-9]{2}$" title="Format HH:MM" required>
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
            <img src="./img/Bus.png" alt="buss">
        </div>
    </div>

<!-- Ajoutez un bus, et si il est correctement insérée, un popup apparaîtra avec un message significatif. -->
    <?php
    include 'database.php'; 
    $isDataInserted = false; //cette variable est utilisé pour tester si les données sont bien inserés pour pouvoir afficher le popup après
    if (isset($_POST['ajouter'])) {
        
        $sql = "INSERT INTO bus (position, vitesse, nb_passagers, heure_depart, heure_arrivee, etat) VALUES (:position, :vitesse, :nb_passagers, :heure_depart,:heure_arrivee, :etat )";
        $stmt = $conn->prepare($sql);
        $exec =  $stmt->execute([':position' => $_POST['position'], ':vitesse' => $_POST['vitesse'], ':nb_passagers' => $_POST['nb_passagers'], ':heure_depart' => $_POST['heure_depart'], ':heure_arrivee'=>$_POST['heure_arrivee'], 'etat'=>$_POST['etat']]);
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
    etat.innerHTML="bus ajouté avec Succés ";
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
        $position = $_POST['position'];
        $vitesse = $_POST['vitesse'];
        $nb_passagers = $_POST['nb_passagers'];
        $heure_depart= $_POST['heure_depart'];
        $heure_arrivee= $_POST['heure_arrivee'];
        $etat=$_POST['etat'];
    
      
        if (!empty($id) && is_numeric($id)) {
            $sql = "UPDATE bus SET position = :position, vitesse = :vitesse, nb_passagers = :nb_passagers, heure_depart = :heure_depart, heure_arrivee = :heure_arrivee, etat = :etat WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':position', $position, PDO::PARAM_INT);
            $stmt->bindParam(':vitesse', $vitesse, PDO::PARAM_INT);
            $stmt->bindParam(':nb_passagers', $nb_passagers, PDO::PARAM_INT);
            $stmt->bindParam(':heure_depart', $heure_depart, PDO::PARAM_STR);
            $stmt->bindParam(':heure_arrivee', $heure_arrivee, PDO::PARAM_STR);
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
    etat.innerHTML="Bus modifié avec Succes";
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
    
        $sql = "DELETE FROM bus WHERE id = :id";
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
    etat.innerHTML="Bus Supprimé avec Succés";
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
   
   
            $query = "SELECT COUNT(*) FROM bus"; 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $nombreBus = $stmt->fetchColumn(); 
            ?>
            <br>
            <div class="mt-3  d-flex justify-content-center align-items-center flex-column">
                <h2 class="text-light">Bus Connectés : <?php echo $nombreBus; ?> </h2>
                
            <table class="table table-hover table-dark  ">
                <thead>
                    <tr>
                        <th scope="col">ID:</th>
                        <th scope="col">Position</th>
                        <th scope="col">Vitesse</th>
                        <th scope="col">nombre de passagers</th>
                        <th scope="col">Heure de départ</th>
                        <th scope="col">Heure d'arrivée</th>
                        <th scope="col">Etat</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $query = "SELECT * FROM bus";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
     //ce code est fait lorsqu'on clique sur une ligne du tableau les inputs du formulaire se emplissent automatiquement 
        echo "<tr onclick='document.getElementById(\"position\").value = \"" . htmlspecialchars($row['position']) . 
        "\"; document.getElementById(\"vitesse\").value = \"" . htmlspecialchars($row['vitesse']) .
        "\"; document.getElementById(\"nb_passagers\").value = \"" . htmlspecialchars($row['nb_passagers']) .
        "\"; document.getElementById(\"heure_depart\").value = \"" . htmlspecialchars($row['heure_depart']) .
        "\"; document.getElementById(\"heure_arrivee\").value = \"" . htmlspecialchars($row['heure_arrivee']) .  
        "\"; document.getElementById(\"etat\").value = \"" . htmlspecialchars($row['etat']) . 
        "\"; document.getElementById(\"idBus\").value = \"" . htmlspecialchars($row['id']) . "\";'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
        echo "<td>" . htmlspecialchars($row['vitesse']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nb_passagers']) . "</td>";
        echo "<td>" . htmlspecialchars($row['heure_depart']) . "</td>";
        echo "<td>" . htmlspecialchars($row['heure_arrivee']) . "</td>";
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

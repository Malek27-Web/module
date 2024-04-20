<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montre connectée</title>
    <link rel="stylesheet" href="style.css">
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  


</head>
<body class="bg-dark">
<button class="btn "><a href="TousLesModules.php"><svg stroke="white" fill="white" stroke-width="0" version="1.1" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 10v-2h-5v-2h5v-2l3 3zM11 9v4h-5v3l-6-3v-13h11v5h-1v-4h-8l4 2v9h4v-3z"></path></svg></a></button>


<!-- popup pour un message de succes -->
<div id="popup-overlay" >
<div class="popup-content d-flex gap-5 align-items-center justify-content-center">
    <h2 class="etat"></h2>
    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><path d="M912 190h-69.9c-9.8 0-19.1 4.5-25.1 12.2L404.7 724.5 207 474a32 32 0 0 0-25.1-12.2H112c-6.7 0-10.4 7.7-6.3 12.9l273.9 347c12.8 16.2 37.4 16.2 50.3 0l488.4-618.9c4.1-5.1.4-12.8-6.3-12.8z"></path></svg>
</div>
</div>

<div class="wrapper d-flex align-items-center justify-content-around p-2 ">
    <div class="d-flex flex-column align-items-center ">
        <h1 class="text-light">Ajouter une montre</h1>
        <br>
        <!-- formulaire -->
        <div class="form-card ">
            <div class="form-group">
                <form action="" method="POST">
                <input type="hidden" name="id" id="idMontre" value="" > 
                <label class="text-light fs-4 fw-semibold" for="stepCount">Nombre de pas:</label>
                <input name="nb_pas" type="number" pattern="^\d+(,\d+)?$" id="stepCount" required>
            </div>

            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="distance">Distance parcourue en km:</label>
                <input name="distance" type="number" id="distance" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="calories">Calories brûlées:</label>
                <input name="calories"  type="number" pattern="^(en marche|en panne)$" title=" il faut choisir entre en marche ou en panne" id="calories" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="duration">Durée de l'activité:</label>
                <input name="duree" type="text" id="duration" pattern="^[0-9]{2}:[0-9]{2}$" title="Format HH:MM" required>
            </div>
            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="etat">Etat:</label>
                <input name="etat" type="text" id="etat"   required>
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
            <img src="./img/Montre.png" alt="montre">
        </div>
    </div>

<!-- Ajoutez une montre, et si elle est correctement insérée, un popup apparaîtra avec un message significatif. -->
    <?php
    include 'database.php'; 
    $isDataInserted = false; //cette variable est utilisé pour tester si les données sont bien inserés pour pouvoir afficher le popup après
    if (isset($_POST['ajouter'])) {
        
        $sql = "INSERT INTO montre (nb_pas, distance, calories, duree,etat) VALUES (:nb_pas, :distance, :calories, :duree ,:etat)";
        $stmt = $conn->prepare($sql);
        $exec =  $stmt->execute([':nb_pas' => $_POST['nb_pas'], ':distance' => $_POST['distance'], ':calories' => $_POST['calories'], ':duree' => $_POST['duree'],':etat' => $_POST['etat']]);
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
    etat.innerHTML="Montre ajouté avec Succés ";
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
        $nb_pas = $_POST['nb_pas'];
        $distance = $_POST['distance'];
        $calories = $_POST['calories'];
        $duree = $_POST['duree'];
        $etat = $_POST['etat'];
    
      
        if (!empty($id) && is_numeric($id)) {
            $sql = "UPDATE montre SET nb_pas = :nb_pas, distance = :distance, calories = :calories, duree = :duree, etat=:etat WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nb_pas', $nb_pas, PDO::PARAM_INT);
            $stmt->bindParam(':distance', $distance, PDO::PARAM_INT);
            $stmt->bindParam(':calories', $calories, PDO::PARAM_STR);
            $stmt->bindParam(':duree', $duree, PDO::PARAM_INT);
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
    etat.innerHTML="Montre modifié avec Succes";
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
    
        $sql = "DELETE FROM montre WHERE id = :id";
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
    etat.innerHTML="Montre Supprimé avec Succés";
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
   
   
            $query = "SELECT COUNT(*) FROM montre"; 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $nombreMontres = $stmt->fetchColumn(); 
            ?>
            <br>
            <div class="mt-3  d-flex justify-content-center align-items-center flex-column">
                <h2 class="text-light">Montres Connectées : <?php echo $nombreMontres; ?> </h2>
                
            <table class="table table-hover table-dark  ">
                <thead>
                    <tr>
                        <th scope="col">ID:</th>
                        <th scope="col">Nombre de pas</th>
                        <th scope="col">Distance parcourue</th>
                        <th scope="col">Calories brûlées</th>
                        <th scope="col">Durée de l'activité</th>
                        <th scope="col">Etat</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $query = "SELECT * FROM montre";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
                        //ce code est fait lorsqu'on clique sur une ligne du tableau les inputs du formulaire se emplissent automatiquement 
        echo "<tr onclick='document.getElementById(\"stepCount\").value = \"" . htmlspecialchars($row['nb_pas']) . 
        "\"; document.getElementById(\"distance\").value = \"" . htmlspecialchars($row['distance']) .
        "\"; document.getElementById(\"calories\").value = \"" . htmlspecialchars($row['calories']) .
        "\"; document.getElementById(\"duration\").value = \"" . htmlspecialchars($row['duree']) . 
        "\"; document.getElementById(\"etat\").value = \"" . htmlspecialchars($row['etat']) .
        "\"; document.getElementById(\"idMontre\").value = \"" . htmlspecialchars($row['id']) . "\";'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nb_pas']) . "</td>";
        echo "<td>" . htmlspecialchars($row['distance']) . "</td>";
        echo "<td>" . htmlspecialchars($row['calories']) . "</td>";
        echo "<td>" . htmlspecialchars($row['duree']) . "</td>";
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

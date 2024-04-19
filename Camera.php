<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera connectée</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist\css\bootstrap.css">
  


</head>
<body>
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
        <h1 class="text-light">Ajouter une image</h1>
        <br>
        <!-- formulaire -->
        <div class="form-card ">
            <div class="form-group">
                <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="idCamera" value="" > 
                <label class="text-light fs-4 fw-semibold" for="nom photo">Nom de la photo:</label>
                <input name="nom_photo" type="text"  id="nom_photo" required>
            </div>

            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="date">Date de prise de la photo:</label>
                <input name="date_photo" type="date" id="date_photo" required>
            </div>

            <div class="form-group">
                <label class="text-light fs-4 fw-semibold" for="img">Choisir une photo:</label>
            </div>
            <input name="photo" type="file" class="file" id="photo" >
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
            <img src="./img/Camera.png" alt="camera">
        </div>
    </div>

    <?php
    include 'database.php'; 
    $isDataInserted = false; //cette variable est utilisé pour tester si les données sont bien inserés pour pouvoir afficher le popup après
    if (isset($_POST['ajouter']) && isset($_FILES['photo'])){
        $nom_photo = $_POST['nom_photo'];
        $date_photo = $_POST['date_photo'];
        $photo = $_FILES['photo']['name'];
        $upload = "img/" . basename($photo); 
        $etat=$_POST['etat'];
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload)) {
         
            $sql = "INSERT INTO camera (nom_photo, date_photo, photo, etat) VALUES (:nom_photo, :date_photo, :photo, :etat)";
            $stmt = $conn->prepare($sql);
    
        
            $stmt->bindParam(':nom_photo', $nom_photo);
            $stmt->bindParam(':date_photo', $date_photo);
            $stmt->bindParam(':photo', $upload); 
            $stmt->bindParam(':etat', $etat);
    
            
            if ($stmt->execute()) {
                $isDataInserted = true;
            }
        }
    }
  ?>
  <!-- Ajoutez une image , et si elle est correctement insérée, un popup apparaîtra avec un message significatif. -->

  <?php if ($isDataInserted): ?>
    <!-- Le role de ce script est d'afficher le popup -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var popupOverlay = document.getElementById('popup-overlay');
    const etat=document.querySelector(".etat");
    etat.innerHTML="image ajouté avec Succés ";
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
    $nom_photo = $_POST['nom_photo'];
    $date_photo = $_POST['date_photo'];
    $etat = $_POST['etat'];
    $exec = false;

  
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    
        $photo = $_FILES['photo']['name'];
        $upload = "img/" . basename($photo); 

        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload)) {
          
            $sql = "UPDATE camera SET nom_photo = :nom_photo, date_photo = :date_photo, photo = :photo, etat = :etat WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom_photo', $nom_photo, PDO::PARAM_STR);
            $stmt->bindParam(':date_photo', $date_photo, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $upload, PDO::PARAM_STR);
            $stmt->bindParam(':etat', $etat, PDO::PARAM_STR);

            $exec = $stmt->execute();
        }
    } else {
        
        $sql = "UPDATE camera SET nom_photo = :nom_photo, date_photo = :date_photo, etat = :etat WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom_photo', $nom_photo, PDO::PARAM_STR);
        $stmt->bindParam(':date_photo', $date_photo, PDO::PARAM_STR);
        $stmt->bindParam(':etat', $etat, PDO::PARAM_STR);

        $exec = $stmt->execute();
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
    etat.innerHTML="image modifié avec Succes";
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

if (isset($_POST['supprimer'], $_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    
    $fetchSql = "SELECT photo FROM camera WHERE id = :id";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bindValue(':id', $id, PDO::PARAM_INT);
    $fetchStmt->execute();
    $photo = $fetchStmt->fetchColumn();

    
    if ($photo !== false && file_exists("img/".$photo)) {
        if (!unlink("img/".$photo)) {
            echo "Error: Could not delete the file.";
          
        }
    }

    $sql = "DELETE FROM camera WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    try {
        $exec = $stmt->execute();
        if ($exec) {
            $isDataDeleted = true;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

    ?>
 <?php if ($isDataDeleted): ?>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var popupOverlay = document.getElementById('popup-overlay');
    const etat=document.querySelector(".etat");
    etat.innerHTML="image Supprimé avec Succés";
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
   
   
            $query = "SELECT COUNT(*) FROM camera"; 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $nombreImages = $stmt->fetchColumn(); 
            ?>
            <br>
            <div class="mt-3 d-flex justify-content-center align-items-center flex-column">
    <h2 class="text-light">Images ajoutées : <?php echo $nombreImages; ?> </h2>
    
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">ID:</th>
                <th scope="col">Nom photo</th>
                <th scope="col">Date photo</th>
                <th scope="col">Etat</th>
                <th scope="col">Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM camera";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                //ce code est fait lorsqu'on clique sur une ligne du tableau les inputs du formulaire se emplissent automatiquement 
        echo "<tr onclick='document.getElementById(\"nom_photo\").value = \"" . htmlspecialchars($row['nom_photo']) . 
        "\"; document.getElementById(\"date_photo\").value = \"" . htmlspecialchars($row['date_photo']) .
        "\"; document.getElementById(\"etat\").value = \"" . htmlspecialchars($row['etat']) . 
        "\"; document.getElementById(\"idCamera\").value = \"" . htmlspecialchars($row['id']) . "\";'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom_photo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_photo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['etat']) . "</td>";
        $filePath = htmlspecialchars($row['photo']);
        if (file_exists($filePath)) {
            echo '<td><img src="' . $filePath . '" width="50px" height="50px"/></td>';
        } else {
            echo "<td>Image not found</td>"; 
        }
        
        echo "</tr>";
            }
           
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<!DOCTYPE html> 
<html lang="en"> 

<head> 
	<meta charset="UTF-8"> 
	<meta name="viewport" content="width=device-width, 
								initial-scale=1.0"> 
	<title>Tableau de bord des modules</title> 
	<script src="/script.js" defer></script> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<link rel="stylesheet" href="module.css">

</head> 

<!-- Récuperer les données d'une montre -->
<?php

include 'database.php';  

// Initialiser les variables pour le compte
$montresEnMarche = 0;
$montresEnPanne = 0;

// Requête pour compter les montres "en marche"
$queryEnMarche = "SELECT COUNT(*) FROM montre WHERE etat = 'en marche'";
$stmt = $conn->prepare($queryEnMarche);
$stmt->execute();
$montresEnMarche = $stmt->fetchColumn();

// Requête pour compter les montres "en panne"
$queryEnPanne = "SELECT COUNT(*) FROM montre WHERE etat = 'en panne'";
$stmt = $conn->prepare($queryEnPanne);
$stmt->execute();
$montresEnPanne = $stmt->fetchColumn();


// Requête pour compter les montres
$query = "SELECT COUNT(*) FROM montre"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$nombreMontres = $stmt->fetchColumn(); 
?>


<!-- Récuperer les données d'un bus -->

<?php
include 'database.php';
$busEnMarche=0;
$busEnPanne=0;
// Requête pour compter les bus "en marche"
$queryEnMarche = "SELECT COUNT(*) FROM bus WHERE etat = 'en marche'";
$stmt = $conn->prepare($queryEnMarche);
$stmt->execute();
$busEnMarche= $stmt->fetchColumn();

// Requête pour compter les bus "en panne"
$queryEnPanne = "SELECT COUNT(*) FROM bus WHERE etat = 'en panne'";
$stmt = $conn->prepare($queryEnPanne);
$stmt->execute();
$busEnPanne = $stmt->fetchColumn();

// Requête pour compter les bus
$query = "SELECT COUNT(*) FROM bus"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$nombreBus = $stmt->fetchColumn(); 
?>

<!-- recuperer les données d'un Thermostat -->
<?php
include 'database.php';
$thermoEnMarche=0;
$thermoEnPanne=0;
// Requête pour compter les thermostat "en marche"
$queryEnMarche = "SELECT COUNT(*) FROM thermostat WHERE etat = 'en marche'";
$stmt = $conn->prepare($queryEnMarche);
$stmt->execute();
$thermoEnMarche= $stmt->fetchColumn();

// Requête pour compter les thermostat "en panne"
$queryEnPanne = "SELECT COUNT(*) FROM thermostat WHERE etat = 'en panne'";
$stmt = $conn->prepare($queryEnPanne);
$stmt->execute();
$thermoEnPanne = $stmt->fetchColumn();

// Requête pour compter les thermostat
$query = "SELECT COUNT(*) FROM thermostat"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$nombrethermo = $stmt->fetchColumn(); 
?>

<!-- recuperer les données d'une Camera -->
<?php
include 'database.php';
$cameraEnMarche=0;
$cameraEnPanne=0;
// Requête pour compter les camera "en marche"
$queryEnMarche = "SELECT COUNT(*) FROM camera WHERE etat = 'en marche'";
$stmt = $conn->prepare($queryEnMarche);
$stmt->execute();
$cameraEnMarche= $stmt->fetchColumn();

// Requête pour compter les camera "en panne"
$queryEnPanne = "SELECT COUNT(*) FROM camera WHERE etat = 'en panne'";
$stmt = $conn->prepare($queryEnPanne);
$stmt->execute();
$cameraEnPanne = $stmt->fetchColumn();

// Requête pour compter les camera
$query = "SELECT COUNT(*) FROM camera"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$nombrecamera = $stmt->fetchColumn(); 
?>
<body > 

	<div class="wrapper"> 
		<i id="left" class="fa-solid fas fa-angle-left"></i> 
		<ul class="carousel"> 
			<li class="card"> 
				<div class="img"><img src= "./img/Montre.png" alt="" draggable="false"> </div> 
				<h2 style="color: #121212; font-weight:bold;"> 
					Montre connecté </h2> 

                <button class="glow-on-hover" type="button"><a style href="Montre.php">Ajouter une Montre</a></button>
                <br>
                <p class="nombre">Nombre de montres en marche : <?php echo $montresEnMarche; ?></p>
                <p class="nombre">Nombre de montres en panne : <?php echo $montresEnPanne; ?></p>
                <p class="nombre">Total des montres connectées : <?php echo $nombreMontres; ?></p>
			</li> 
			<li class="card"> 
				<div class="img"><img src= "./img/Bus.png" alt="" draggable="false"> </div> 
				<h2 style="color:#121212; font-weight:bold;">Smart Bus</h2>
                <button class="glow-on-hover" type="button"><a  href="bus.php">Ajouter un Bus</a></button>
                <br>
                <p class="nombre">Nombre de bus en marche : <?php echo $busEnMarche; ?></p>
                <p class="nombre">Nombre de bus en panne : <?php echo $busEnPanne; ?></p>
                <p class="nombre">Total des bus connectées : <?php echo $nombreBus; ?></p>               
			</li> 


			<li class="card"> 
				<div class="img"><img src= "./img/Thermostat.png"alt="" draggable="false"> </div> 
				<h2 style="color:#121212; font-weight:bold;">Thermostat connectée</h2> 
                <button class="glow-on-hover" type="button"><a style href="Thermostat.php">Ajouter un Thermostat</a></button>
                <br>
                <p class="nombre">Nombre de Thermostat en marche : <?php echo $thermoEnMarche; ?></p>
                <p class="nombre">Nombre de Thermostat en panne : <?php echo $thermoEnPanne; ?></p>
                <p class="nombre">Total des Thermostat connectées : <?php echo $nombrethermo; ?></p>   
			</li> 
			<li class="card"> 
				<div class="img"><img src= "./img/Camera.png"alt="" draggable="false"> </div> 
				<h2 style="color:#121212; font-weight:bold;">Camera connectée</h2> 
                <button class="glow-on-hover" type="button"><a style href="Camera.php">Ajouter une camera</a></button>
                <br>
                <p class="nombre">Nombre de Camera en marche : <?php echo $cameraEnMarche; ?></p>
                <p class="nombre">Nombre de Camera en panne : <?php echo $cameraEnPanne; ?></p>
                <p class="nombre">Total des Camera connectées : <?php echo $nombrecamera; ?></p>
		
		</ul> 
		<i id="right" class="fa-solid fas fa-angle-right"></i> 
	</div> 
<script src="./module.js"></script>
</body> 

</html>

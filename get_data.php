<!-- Copyright ©Maxime GUILLERMO SANCHEZ -->



<?php

// Récupère le paramètre du département envoyé via la requête GET
$departement = $_GET['departement'];

// Connexion à la base de données PhpMyAdmin
require_once 'config/config.php';

$connexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Vérifier si la connexion a réussi
if ($connexion->connect_error){
    die("La connexion à la base de données (db_carte_interactive) à échoué: " . $connexion->connect_error);
}

// Effectue une commande SQL pour récupérer les données du département sélectionné 
$sql = "SELECT * FROM carte WHERE nom_departement = '$departement'"; # Query (commande) sql
$result = $connexion->query($sql);

// Vérifie si des résultats ont été obtenus et envoie le résultat
if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
		?>
		<style>
			a {
				color: white;
				font-size: 12px;
				text-decoration: none;
			}

			.container {
				position: relative;
			}

			.ligne {
				width: 400px;
				height: 1px;
				background-color: rgb(16, 23, 40);
				border-radius: 5px;
				position: relative;

				animation-name: ligne;
				animation-duration: 1s;
			}

			@keyframes ligne {
				0% {
					width: 0px;
				}

				100% {
					width: 400px;
				}
			}
		</style>

		<div class="container">
			<strong><h3 style="color: black; font-size: 14px;"><?=$row['correspondant']?></h3></strong>
			<div class="ligne"></div> <!-- ligne de démarcation animée -->
			<p style="color: black; font-size: 12px;"><?=$row['infos']?></p>
			<p style="color: black; font-size: 12px;"><?=$row['enquetes']?></p>
			<?php
			$links = $row['liens'];
			$titres = $row['articles'];

			$linkArray = explode(", ", $links);
			$titreArray = explode(", ", $titres);

			$count = min(count($linkArray), count($titreArray));
			
			for($i = 0; $i < $count; $i++) {
				$link = $linkArray[$i];
				$titre = $titreArray[$i];
				?>
				<a href="<?=$link?>" style="
				background-color: #1581ff; 
				border-radius: 15px; 
				padding: 5px;
				box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.15);
				"><?=$titre?></a><br><br>
				<?php
			}
		?>
		</div><br>
		<?php
    }
} else {
	?>
		<p style="color: black; font-size: 16px;">Aucune donnée n'a été trouvée pour ce département.</p>
	<?php
}
?>
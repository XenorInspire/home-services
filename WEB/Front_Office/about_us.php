	<?php

	require_once('include/check_identity.php');
	if (isset($_GET['vr']) && $_GET['vr'] == "true") {

		$vrMode = 1;
	} else {

		$vrMode = 2;
	}

	?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - <?= $about_us['aboutUs'] ?></title>
		<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>

	<body>

		<?php require_once("include/header.php"); ?>

		<main>
			<div id="blocker">
				<div id="instructions">
					<div id="overlay">
						<video src="video/menu_video.mp4" autoplay loop id="video">
						</video>
						<audio id="menu">
							<source src="sounds/menu.mp3" type="audio/mpeg">
						</audio>
						<script type="text/javascript">
							var audio = document.getElementById("menu");
							var video = document.getElementById("video");
							video.volume = 0;
							audio.autoplay = true;
							audio.loop = true;
							audio.volume = 0.1;
						</script>
						<div>
							<button id="startButton">Voir la présentation</button>
							<br>
							<br>
							<p>Une conciergerie comme vous en avez jamais vu...</p>
							<?php
							if ($vrMode == 1) {

							?>

								<a href="about_us.php?vr=false" id="startVR">Mode classique</a>

							<?php

							} else {

							?>

								<a href="about_us.php?vr=true" id="startVR">Mode VR</a>

							<?php

							}

							?>


						</div>
					</div>
				</div>
			</div>

		</main>

	</body>

	<?php

	if ($vrMode == 1) {

	?>

		<script src="js/webglVR.js"></script>

	<?php

	} else {

	?>

		<script src="js/webgl.js"></script>

	<?php

	}

	?>

	</html>
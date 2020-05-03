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
		<main id="container">
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
							<p id="home-services">Home - Services,</p>
							<p id="slogan"><?= $about_us['slogan'] ?></p>
							<br>
							<button id="startButton"><?= $about_us['presentation'] ?></button>
							<?php
							if ($vrMode == 1) {

							?>

								<a href="about_us.php?vr=false" id="startVR"><?= $about_us['classicalMode'] ?></a>

							<?php

							} else {

							?>

								<a href="about_us.php?vr=true" id="startVR"><?= $about_us['VRMode'] ?></a>

							<?php

							}

							?>

						</div>
					</div>
				</div>
			</div>

		</main>

	</body>

	<script type="x-shader/x-vertex" id="vertexshader">

		attribute float size;
			attribute vec3 customColor;

			varying vec3 vColor;

			void main() {

				vColor = customColor;

				vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );

				gl_PointSize = size * ( 300.0 / -mvPosition.z );

				gl_Position = projectionMatrix * mvPosition;

			}

		</script>

	<script type="x-shader/x-fragment" id="fragmentshader">

		uniform vec3 color;
			uniform sampler2D pointTexture;

			varying vec3 vColor;

			void main() {

				gl_FragColor = vec4( color * vColor, 1.0 );

				gl_FragColor = gl_FragColor * texture2D( pointTexture, gl_PointCoord );

				if ( gl_FragColor.a < ALPHATEST ) discard;

			}

		</script>

	<?php

	if ($vrMode == 1) {

	?>

		<script type="module" src="js/webglVR.js"></script>

	<?php

	} else {

	?>

		<script type="module" src="js/webgl.js"></script>

	<?php

	}

	?>

	</html>
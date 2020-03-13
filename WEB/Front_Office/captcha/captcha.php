<?php

		session_start();

		header('Content-type:image/png');
		$_SESSION['captcha'] = mt_rand(1000,9999);

		$font_number = mt_rand(1,20);

		$img = imagecreate(100, 30);

		$font  = 'fonts/font (';
		$font .= $font_number;
		$font .= ').ttf';

		$background = imagecolorallocate($img, 255, 255, 255);

		$textcolor = imagecolorallocate($img, 0, 0, 0);

		imagettftext($img, 20, 0, 20, 25, $textcolor, $font, $_SESSION['captcha']);
		//imagettftext(image, size, angle, x, y, color, fontfile, text)


		imagejpeg($img);
		imagedestroy($img);

?>

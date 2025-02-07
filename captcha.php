<?php
session_start();

// Generate a random string
$captcha_text = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION['captcha'] = $captcha_text;

// Create an image
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height);

// Colors
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 64, 64, 64);

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

// Add noise lines
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Add CAPTCHA text
$font = __DIR__ . '/styles/arial.ttf'; // Make sure you have a font file in the same directory

imagettftext($image, 20, rand(-10, 10), 10, 30, $text_color, $font, $captcha_text);

// Output the image
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>

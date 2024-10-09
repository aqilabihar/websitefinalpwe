<?php
session_start();

$code = rand(1000, 9999);  // Generate random number for captcha
$_SESSION['captcha'] = $code;  // Store captcha in session

$im = imagecreatetruecolor(100, 30);
$bg = imagecolorallocate($im, 22, 86, 165); // Background color
$fg = imagecolorallocate($im, 255, 255, 255); // Text color
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 30, 8, $code, $fg);

header('Content-Type: image.png');
imagepng($im);
imagedestroy($im);

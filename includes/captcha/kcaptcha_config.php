<?php
$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!
$allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)
$fontsdir = 'fonts';
$length = mt_rand(5,6); # random 5 or 6
$width = 138;
$height = 40;
$fluctuation_amplitude = 5;
$no_spaces = true;
$show_credits = false; # set to false to remove credits line. Credits adds 12 pixels to image height
$credits = 'www.it-industry.biz';

# CAPTCHA image colors (RGB, 0-255)
//$foreground_color = array(0, 0, 0);
//$background_color = array(220, 230, 255);
$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$jpeg_quality = 90;
?>
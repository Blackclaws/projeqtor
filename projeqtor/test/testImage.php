<?php
header("Content-type: image/png"); //la ligne qui change tout !
$x = 50; //largeur de mon image en PIXELS uniquement !
$y = 50; //hauteur de mon image en PIXELS uniquement !

/* on créé l'image en vraies couleurs avec une largeur de 50 pixels et une hauteur de 100 pixels */
$image = imagecreatetruecolor($x,$y);
$white = imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$white);
$color = "BEDFFE";
$rouge = hexdec(substr($color,0,2)); //conversion du canal rouge
$vert = hexdec(substr($color,2,4)); //conversion du canal vert
$bleu = hexdec(substr($color,4,6)); //conversion du canal bleu
$couleur = imagecolorallocate($image,$rouge,$vert,$bleu);
imagefilledellipse($image,$x/2, $y/2, $x-1, $y-1, $couleur);
imagepng($image); //renvoie une image sous format png
imagedestroy($image); //détruit l'image, libérant ainsi de la mémoire
?>
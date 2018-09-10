<?php 
$content = file_get_contents(dirname(__FILE__).'/template.html'); 

$content = str_replace('##LOGO##', "../view/img/logoSmall.png", $content);
$content = str_replace('##CIVILITE##', "M.", $content);
$content = str_replace('##NOM##', "DUCHMOLL", $content);
$content = str_replace('##PRENOM##', "Charle-Antoine", $content);
$content = str_replace('##ADRESSE##', "99 rue du pont à l'huile", $content);
$content = str_replace('##CP##', "75001", $content);
$content = str_replace('##VILLE##', "PARIS", $content);

$filename = "facture.doc";// Vérifie que l'on peut écrire dans le fichier if(!is_writable($filename)) exit();// Vérifie que l'on peut ouvrir le fichier
if (!$handle = fopen($filename, 'a')) 
exit("Impossible d'ouvrir le fichier ($filename)");

// On ajoute le contenu de exemple.html
if (fwrite($handle, $content) === FALSE) 
exit("Impossible d'écrire dans le fichier ($filename)");

echo "OK:";
echo "<a href='$filename'>Telecharger le fichier</a>";
fclose($handle);
?>
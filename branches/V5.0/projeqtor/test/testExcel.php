<?php
header("Content-type: application/vnd.ms-excel");


$bdd = mysql_connect('localhost','root','mysql');
mysql_select_db('projeqtor_v50',$bdd);

$requete=@mysql_query("SELECT name, fullName as username, email FROM resource");
// on vérifie le contenu de  la requête, si elle est vide, on en informe l'utilisateur à l'aide d'un Javascript 
if (@mysql_numrows($requete) ==0) {   
  echo "<script> alert('La requête n\'a pas abouti !')</script>";
} 

// construction du tableau HTML
echo '<table border=1>
<!-- impression des titres de colonnes -->
<TR><TD colspan="2" style="background-color:#FF0000">Prenom et Nom</TD><TD>email</TD></TR><TR>';


// lecture du contenu de la requête avec 2 boucles imbriquées; par ligne et par colonne
for ($ligne = 0 ; $ligne < @mysql_numrows($requete); $ligne++) {
  for ($colonne = 0; $colonne < 3; $colonne++)  {
    print '<TD>' .mysql_result($requete , $ligne,$colonne).  '</TD>';
  }
  print '</TR>';
}
print '</TABLE>';
mysql_close();

// on informe l'utilisateur de la réussite 
if (@mysql_numrows($requete) > 0) {   
  print "<script> alert('La table est bien mise à jour !')</script>";
} 
?>
<?php
    $content = "

    <h2>Exemple d'utilisation</h2>
    <br>
    Ceci est un <b>exemple d'utilisation</b>
    de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
";
    require_once('../external/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A3','fr');
    for ($i=1;$i<20;$i++) {
    $html2pdf->WriteHTML("<h1>" . $i . "</h1>" . $content);
    }
    
    $html2pdf->Output('exemple.pdf');
?>

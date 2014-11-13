<?php

try {
    $p = new PDFlib();

    /*  ouvre un nouveau fichier PDF ; insert un nom de fichier pour créer le PDF sur le disque */
    if ($p->begin_document("", "") == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "hello.php");
    $p->set_info("Author", "Rainer Schaaf");
    $p->set_info("Title", "Bonjour le monde (PHP)!");

    $p->begin_page_ext(595, 842, "");

    $font = $p->load_font("Helvetica-Bold", "winansi", "");

    $p->setfont($font, 24.0);
    $p->set_text_pos(50, 700);
    $p->show("Hello world!");
    $p->continue_text("(dit PHP)");
    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=hello.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in hello sample:\n" .
    "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
    $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}
$p = 0;
?> 

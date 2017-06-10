<?php
/*
 * Beispielaufrufe:
 * http://localhost/JS_jQuery_Slideshow_Loesung/php/galleryservice.php?album=Jordanien
 * http://localhost/JS_jQuery_Slideshow_Loesung/php/galleryservice.php?all=1
 */



$imagedir = '../images';
$gallery_array = array();

/* Files und Verzeichnisse rekursiv auslesen */
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../images'));

$files = array(); 

foreach ($rii as $file) {

    if ($file->getFilename() != '..' && $file->getFilename() != '.'){ 
       $files[$file->getPath()][] = $file->getPathname();
       continue;
    }
    elseif ($file->isDir())
    {
         //$dirs[] = $file->getPath(); 
    }
}


/* Ausgabe */
if (isset($_GET['all']))
{
    header('Content-Type: application/json');
     header('Access-Control-Allow-Origin: http://localhost:8383');
    echo json_encode($files);
}
elseif (isset($_GET['album'])) {
    $album = filter_input(INPUT_GET, 'album', FILTER_SANITIZE_STRING);
    foreach ($files as $key => $value) {
        if (strpos($key, $album) != false)
        {
               header('Access-Control-Allow-Origin: http://localhost:8383');
             header('Content-Type: application/json');
             echo json_encode($files[$key]);
        }
    }
}




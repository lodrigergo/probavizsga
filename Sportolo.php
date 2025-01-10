<?php

// Sportoló osztály definiálása
class Sportolo
{
    public $helyezes;
    public $eredmeny;
    public $sportolo;
    public $orszagkod;
    public $helyszin;
    public $datum;

    public function __construct($helyezes, $eredmeny, $sportolo, $orszagkod, $helyszin, $datum)
    {
        $this->helyezes = intval($helyezes);
        $this->eredmeny = floatval(str_replace(',', '.', $eredmeny));
        $this->sportolo = $sportolo;
        $this->orszagkod = $orszagkod;
        $this->helyszin = $helyszin;
        $this->datum = $datum;
    }
}
$myfile = fopen("kalapacsvetes.txt", "r") or die("Unable to open file!");
echo fread($myfile, filesize("kalapacsvetes.txt"));
fclose($myfile);

// $sportolok = [];
// foreach ($lines as $line) {
//     list($helyezes, $eredmeny, $sportolo, $orszagkod, $helyszin, $datum)
//     $sportolok[] = new Sportolo($helyezes, $eredmeny, $sportolo, $orszagkod, $helyszin, $datum);
// }



?>
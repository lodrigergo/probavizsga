<?php

// Sportoló osztály definiálása
class Sportolo
{
    public $helyezes;
    public $eredmeny;
    public $nev;
    public $orszagkod;
    public $helyszin;
    public $datum;

    public function __construct($helyezes, $eredmeny, $nev, $orszagkod, $helyszin, $datum)
    {
        $this->helyezes = intval($helyezes);
        $this->eredmeny = floatval(str_replace(',', '.', $eredmeny)); // Eredmény átalakítása float típusra
        $this->nev = $nev;
        $this->orszagkod = $orszagkod;
        $this->helyszin = $helyszin;
        $this->datum = $datum;
    }
}

// Fájl beolvasása
$filename = "kalapacsvetes.txt";
if (!file_exists($filename)) {
    die("Hiba: A fájl nem található!");
}

$lines = file($filename, FILE_IGNORE_NEW_LINES);
$fejlec = array_shift($lines); // Fejléc eltávolítása

$sportolok = [];
foreach ($lines as $line) {
    list($helyezes, $eredmeny, $nev, $orszagkod, $helyszin, $datum) = explode(";", $line);
    $sportolok[] = new Sportolo($helyezes, $eredmeny, $nev, $orszagkod, $helyszin, $datum);
}

// 4. Dobások száma
echo "Dobások száma: " . count($sportolok) . PHP_EOL;

// 5. Magyar sportolók dobásainak átlaga
$hunEredmenyek = array_filter($sportolok, fn($s) => $s->orszagkod === "HUN");
$hunAtlag = array_sum(array_map(fn($s) => $s->eredmeny, $hunEredmenyek)) / count($hunEredmenyek);
echo "Magyar sportolók dobásainak átlaga: " . number_format($hunAtlag, 2) . " m" . PHP_EOL;

// 6. Évszám alapú keresés
echo "Kérem, adjon meg egy évszámot: ";
$evszam = intval(trim(fgets(STDIN)));
$evDobasok = array_filter($sportolok, fn($s) => strpos($s->datum, strval($evszam)) !== false);

if (count($evDobasok) > 0) {
    echo "A(z) $evszam évben " . count($evDobasok) . " dobás került be a legjobbak közé." . PHP_EOL;
    echo "Sportolók: " . implode(", ", array_map(fn($s) => $s->nev, $evDobasok)) . PHP_EOL;
} else {
    echo "A(z) $evszam évben nem került be egyetlen dobás sem a legjobbak közé." . PHP_EOL;
}

// 7. Statisztika az országkódok szerint
$orszagStatisztika = [];
foreach ($sportolok as $sportolo) {
    if (!isset($orszagStatisztika[$sportolo->orszagkod])) {
        $orszagStatisztika[$sportolo->orszagkod] = 0;
    }
    $orszagStatisztika[$sportolo->orszagkod]++;
}
echo "Országkód szerinti statisztika:" . PHP_EOL;
foreach ($orszagStatisztika as $orszag => $db) {
    echo "$orszag: $db dobás" . PHP_EOL;
}

// 8. magyarok.txt fájl létrehozása
$hunFajl = fopen("magyarok.txt", "w");
foreach ($hunEredmenyek as $sportolo) {
    $sor = implode(";", [
        $sportolo->helyezes,
        $sportolo->eredmeny,
        $sportolo->nev,
        $sportolo->orszagkod,
        $sportolo->helyszin,
        $sportolo->datum
    ]) . PHP_EOL;
    fwrite($hunFajl, $sor);
}
fclose($hunFajl);

echo "A magyar sportolók eredményei a magyarok.txt fájlba kerültek." . PHP_EOL;



?>
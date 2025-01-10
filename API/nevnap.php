<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "probavizsga";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['nap'])) {
    $nap = $_GET['nap'];
    $parts = explode('-', $nap);

    if (count($parts) == 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
        $stmt = $pdo->prepare("SELECT nev1, nev2 FROM nevnap WHERE ho = :ho AND nap = :nap");
        $stmt->execute(['ho' => $parts[0], 'nap' => $parts[1]]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(["datum" => "{$parts[0]}-{$parts[1]}", "nevnap1" => $result['nev1'], "nevnap2" => $result['nev2']]);
        } else {
            echo json_encode(["hiba" => "nincs találat"]);
        }
    } else {
        echo json_encode(["hiba" => "Érvénytelen dátum formátum"]);
    }
} elseif (isset($_GET['nev'])) {
    $nev = $_GET['nev'];
    $stmt = $pdo->prepare("SELECT ho, nap FROM nevnap WHERE nev1 = :nev OR nev2 = :nev LIMIT 1");
    $stmt->execute(['nev' => $nev]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(["datum" => "{$result['ho']}-{$result['nap']}", "nev" => $nev]);
    } else {
        echo json_encode(["hiba" => "nincs találat"]);
    }
} else {
    echo json_encode(["minta1" => "/?nap=12-31", "minta2" => "/?nev=Szilveszter"]);
}
?>
?>
<?php
$dataFile = "data.json";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = (int)$_POST['index'];

    if (!file_exists($dataFile)) {
        echo "DATAFILE_NOT_FOUND";
        exit;
    }

    $data = json_decode(file_get_contents($dataFile), true);

    if (!is_array($data)) {
        echo "JSON_ERROR";
        exit;
    }

    if (!isset($data[$index])) {
        echo "INVALID_INDEX";
        exit;
    }

    array_splice($data, $index, 1);

    if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT))) {
        echo "OK";
    } else {
        echo "WRITE_ERROR";
    }
} else {
    echo "ERROR";
}
?>
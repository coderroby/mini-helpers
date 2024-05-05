<?php
$jsonData = file_get_contents('data.json');
$dataArray = json_decode($jsonData, true);
$filteredData = [];

foreach ($dataArray as $data) {
    if (strlen($data) < 13) {
        $filteredData[] = $data;
    }
}

$total = count($filteredData);
// Print the separated data
echo "Separated Data: $total <br>";
foreach ($filteredData as $value) {
    echo $value . "<br>";
}



?>
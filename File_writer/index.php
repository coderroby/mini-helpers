<?php

for($i=0;$i < 10 ; $i++){
    $logFile = __DIR__ . '/car_data_log.txt';
    $logData = "Car Data: " . $i . "\n";
    file_put_contents($logFile, $logData, FILE_APPEND);
}


?>
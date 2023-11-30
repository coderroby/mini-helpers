<?php
$json = file_get_contents("https://api.drivegood.com/api/make/models");

//generate json file
// $path = wp_get_upload_dir()['basedir']."/make_model/";
$path = '';
// if (!file_exists($path)) {
//     mkdir($path, 0777, true);
// }

if ($json === false) {
	$message = 'Error fetching remote JSON. <br>';
	file_put_contents($path."data_update_record.txt", $message);
    die($message);
}


// file_put_contents($path."models.json", $json);

// $localJson = file_get_contents($path."models.json");
$localJson = file_get_contents("models.json");
if ($localJson === false) {
	$message = 'Error reading local JSON file. There was no models.json named file. <br>';
	file_put_contents($path."data_update_record.txt", $message);
	file_put_contents($path."models.json", $json);
	$message = 'There was no models.json named file. So data updated with response data.<br>';
	file_put_contents($path."data_update_record.txt", $message);
    die($message);
}

// Compare the data
if ($json != $localJson) {
    // Update the local file with the remote data
	$result = file_put_contents($path."models.json", $json);
//     $result = file_put_contents("models.json", $remoteJson);

    if ($result === false) {
		$message = 'Error writing to local JSON file. <br>';
		file_put_contents($path."data_update_record.txt", $message);
        die($message);
    }
	$message = 'Updated models.json with remote data. <br>';
	file_put_contents($path."data_update_record.txt", $message);
    echo $message;
} else {
	$message = 'No changes in data. <br>';
	file_put_contents($path."data_update_record.txt", $message);
    echo $message;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Address Example</title>
</head>

<body>
    <h1>Welcome to My Website!</h1>
    <?php
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];


    // Output the IP address
    echo "User IP Address: $user_ip <br>";
    echo "User Agent: $user_agent <br>";

    echo '<pre>';
    // print_r($_SERVER);
    ?>

        <!-- <script src="getip.js"></script> -->
</body>

</html>
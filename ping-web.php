<?php
// Get Server Address
echo "Server IP Address is: " . $_SERVER['SERVER_ADDR'] .  "<br><br>";

// ping start
$ports = [80, 443];
$hosts = [
        'example.com',
        '103.26.139.87',
        'sandbox.sslcommerz.com',
        '103.26.139.148',
        'securepay.sslcommerz.com',
    ];

$waitTimeoutInSeconds = 1;
for ($i = 0; $i < count($hosts); $i++) {
    for ($j = 0; $j < count($ports); $j++) {
        $host = $hosts[$i];
        $port = $ports[$j];
        if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            echo "connected to $host on port $port" . '<br>';
        } else {
            echo "<b>can not connect</b> to $host on port $port" . '<br>';
        }
    }
    echo '<br>';
}
@fclose($fp);
exit;
// ping end

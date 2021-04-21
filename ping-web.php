<?php
// Get Server Address
echo "Server IP Address is: <b>" . json_decode(file_get_contents('https://httpbin.org/ip'))->origin .  "</b><br><br>";

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
            echo "<span style='color:green'><b>connected</b></span> to $host on port $port" . '<br>';
        } else {
            echo "<span style='color:red'><b>failed to connect</b></span> to $host on port $port" . '<br>';
        }
    }
    echo '<br>';
}
@fclose($fp);
exit;
// ping end

<?php
// ping start
$ports = [80, 443];
$hosts = [
        'example.com',
        '144.76.92.216',
        'sandbox.sslcommerz.com',
        '103.26.139.148',
        'securepay.sslcommerz.com'
    ];

$waitTimeoutInSeconds = 1;
for ($i = 0; $i < count($hosts); $i++) {
    for ($j = 0; $j < count($ports); $j++) {
        $host = $hosts[$i];
        $port = $ports[$j];
        if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            echo "connected to $host on port $port" . '<br>';
        } else {
            echo "can not connect to $host on port $port" . '<br>';
        }
    }
    echo '<br>';
}
@fclose($fp);
exit;
// ping end

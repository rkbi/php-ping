<?php
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
            echo "connected to $host on port $port" . PHP_EOL;
        } else {
            echo "can not connect to $host on port $port" . PHP_EOL;
        }
    }
    echo PHP_EOL;
}
@fclose($fp);
exit;
// ping end

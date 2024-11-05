<?php

$waitTimeoutInSeconds = 1;
$ports = [80, 443];
$hosts = [
    'example.com',
    '103.26.139.87',
    'sandbox.sslcommerz.com',
    '103.26.139.148',
    'securepay.sslcommerz.com',
];

echo system_info();
test_ports($ports, $hosts);


# Function Definitions #
function newline($n = 1) 
{
    $return = "";
    foreach (range(1, $n) as $i) {
        $return .= "<br>";
    }

    return $return;
}


function server_ip_address()
{
    $ch = curl_init('https://httpbin.org/ip');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response || !($data = json_decode($response)) || !isset($data->origin)) {
        return "Unable to fetch server IP address." . newline();
    }
    return "Server IP Address is: <b>" . htmlspecialchars($data->origin, ENT_QUOTES, 'UTF-8') . "</b>" .newline();
}


function system_info()
{
    $return = "";
    $return .= "Server Software: <b>".htmlspecialchars($_SERVER['SERVER_SOFTWARE'], ENT_QUOTES, 'UTF-8') . "</b>" . newline();
    $return .= "PHP version: <b>".htmlspecialchars(phpversion(), ENT_QUOTES, 'UTF-8')."</b>" . newline();
    if (function_exists('curl_version')) {
        $return .= server_ip_address();
        $curl_version = curl_version();
        $return .= "cURL version: <b>".htmlspecialchars($curl_version['version'], ENT_QUOTES, 'UTF-8')."</b>" . newline();
        $return .= "openSSL version: <b>".htmlspecialchars($curl_version['ssl_version'], ENT_QUOTES, 'UTF-8')."</b>" . newline();
        $return .= tls_info() . newline();
    } else {
        $return .= "<span style='color:red'><b>Curl extension is disabled.</b></span> Please enable it from cpanel/php.ini or contact your hosting provider." . newline();
    }

    return $return . newline();
}

function tls_info()
{
    $ch = curl_init('https://www.howsmyssl.com/a/check');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);

    if (!$data) return "Error fetching data." . newline(2);
    
    $json = json_decode($data);
    if (!$json || !isset($json->tls_version)) return "Error: Could not retrieve TLS version." . newline(2);

    return "Server can support TLS version up to <b>" . htmlspecialchars($json->tls_version, ENT_QUOTES, 'UTF-8') . "</b><sup>*not reliable</sup>";
}


function test_ports($ports, $hosts)
{
    global $waitTimeoutInSeconds;
    foreach ($hosts as $host) {
        foreach ($ports as $port) {
            if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
                echo "<span style='color:green'><b>connected</b></span> to $host on port $port" . newline();
                fclose($fp);
            } else {
                echo "<span style='color:red'><b>failed to connect</b></span> to $host on port $port ($errCode : $errStr)" . newline();
            }
        }
        echo newline();
    }
}

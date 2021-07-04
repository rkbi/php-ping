<?php
// Get Server Address
echo server_ip_address();

// Get php/cURL/openssl info
echo system_info();

// Get supported TLS version
echo supported_tls();

// Test connection over ports
$ports = [80, 443];
$hosts = [
        'example.com',
        '103.26.139.87',
        'sandbox.sslcommerz.com',
        '103.26.139.148',
        'securepay.sslcommerz.com',
    ];

test_ports($ports, $hosts);


# Function definitions #
function server_ip_address()
{
    return "Server IP Address is: <b>" . json_decode(file_get_contents('https://httpbin.org/ip'))->origin .  "</b><br><br>";
}

function system_info()
{
    $return = "";
    $return .= "Server Software: <b>".$_SERVER["SERVER_SOFTWARE"]."</b><br>";
    $return .= "PHP version: <b>".phpversion()."</b><br>";
    if (function_exists('curl_version')) {
        $curl_version = curl_version();
        $return .= "cURL version: <b>".$curl_version['version']."</b><br>";
        $return .= "openSSL version: <b>".$curl_version['ssl_version']."</b><br>";
    } else {
        $return .= "<span style='color:red'><b>Curl extension is disabled.</b></span> Please enable it from cpanel/php.ini or contact your hosting provider<br>";
    }

    return $return;
}

function supported_tls()
{
    $ch = curl_init('https://www.howsmyssl.com/a/check');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return "Server can support TLS version upto <b>" . json_decode($data)->tls_version .  "</b><sup>*not reliable</sup><br><br>";
}

function test_ports($ports, $hosts)
{
    $waitTimeoutInSeconds = 1;
    for ($i = 0; $i < count($hosts); $i++) {
        for ($j = 0; $j < count($ports); $j++) {
            $host = $hosts[$i];
            $port = $ports[$j];
            if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
                echo "<span style='color:green'><b>connected</b></span> to $host on port $port <br>";
            } else {
                echo "<span style='color:red'><b>failed to connect</b></span> to $host on port $port ($errCode : $errStr) <br>";
            }
        }
        echo '<br>';
    }
    @fclose($fp);
}

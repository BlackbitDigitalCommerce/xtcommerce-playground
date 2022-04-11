<?php
use function GuzzleHttp\json_decode;

require_once('xtFramework/library/vendor/autoload.php');

date_default_timezone_set('Europe/Berlin');

// Check if license file exists
$lic_file = false;// dirname(__DIR__) . DIRECTORY_SEPARATOR . "lic" . DIRECTORY_SEPARATOR . "license.txt";

// check if license dir is write-able
$isWriteable = true;
if (!is_writable( dirname(__DIR__) . DIRECTORY_SEPARATOR . "lic" . DIRECTORY_SEPARATOR)) {
    $isWriteable = false;
}

$data = array();
$data['email']= 'xt@blackbit.de';
$data['company']= 'Blackbit';
$data['first_name']= 'Ted';
$data['last_name']= 'Tester';
$data['street_address']= 'Ernst-Ruhstrat-Straße 6';
$data['city']= 'Göttingen';
$data['zip_code']= '37079';
$data['country_code']= 'DE';
$data['phone']= '';
$data['language_code']= 'de';
$data['domain']= 'loalhost';
$data['remote_ip']= '127.0.0.1';

$webservice = 'https://webservices.xt-commerce.com/';

$client = new GuzzleHttp\Client ( [
    'base_uri' => $webservice,
    'auth' => [
        'public',
        'public'
    ]
] );
$_field_errors = array ();
$fatal = false;
try {
    $response = $client->request ( 'POST', 'license/register_trial', [
        'json' => $data
    ] );
} catch (GuzzleHttp\Exception\ClientException $e) {
    if ($e->hasResponse ()) {
        $response = json_decode ( $e->getResponse ()->getBody () );
        if ($response->error == 'INVALID_PARAMETER') {
            foreach ( $response as $e_field => $e_msg ) {
                $_field_errors [$e_field] = $e_msg [0];
            }
        }
    }
} catch (GuzzleHttp\Exception\RequestException $e) {
    $message = $e->getMessage();
    if (strstr($message,'cURL error 60: SSL certificate problem: unable to get local issuer certificate')) {
        $errors[]=_ERROR_CURL_SSL . "\n";
    } else {
        $errors[]=$message . "\n";
    }
    $fatal=true;
}

if (count($_field_errors)==0 && !$fatal) {
    $body = $response->getBody();
    $body = json_decode($body);

    $lic_file = __DIR__ . "/lic/";
    foreach ($body->LIC_FILE as $file) {
        $fileName = (string)$file->Name;
        $fileContent = (string)$file->Content;
        $fileContent = base64_decode($fileContent);

        if (!file_exists($lic_file . $fileName)); {
            file_put_contents($lic_file . $fileName, $fileContent);
        }
    }
    header("Location: index.php");
}
else {
    echo '<pre>';
    print_r($errors);
    echo '</pre>';
}
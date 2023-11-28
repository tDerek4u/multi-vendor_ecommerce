<?php
/* Code for SMS Script Starts */

$request = "";
$param['authorization'] = "0fghGt706rJ1C8fsddpUXSEPLWv2aDRuMkyeif7mKBwNHxdvw0gKcTfrhemqdsFS8gb6Do59Nzp1Ry5fi";
$param['sender_id'] = 'FSTSMS';
$param['message'] = 'This is the test SMS from Building Business Site';
$param['numbers'] = '980000000';
$param['language'] = "english";
$param['route'] = "p";

foreach ($param as $key => $val) {
    $request.= $key. "=".urlencode($val);
    $request.="&";

}

$request = substr($request, 0, strlen($request)-1);

$url = "https://www.fast2sms.com/dev/bluk?". $request;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_scraped_page = curl_exec($ch);
/*Code for SMS Script Ends */
?>

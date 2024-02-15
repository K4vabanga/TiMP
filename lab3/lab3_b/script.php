<?php
include_once '/home/petr/lab3/LAB3B/spyc/Spyc.php';
require_once '/home/petr/lab3/LAB3B/device-detector/autoload.php';

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use DeviceDetector\Parser\OperatingSystem;
use DeviceDetector\Parser\Client\Browser;

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$dir=__DIR__;

$clientHints = ClientHints::factory($_SERVER);
$userAgent = $_SERVER['HTTP_USER_AGENT'];

if ($_SERVER['REMOTE_USER']) {
	echo 'NAME: ' . $_SERVER['REMOTE_USER']; 
	echo "<br>";
}
	
if ($_SERVER['REMOTE_HOST']) {	
	echo 'COMPUTER: ' . $_SERVER['REMOTE_HOST']; 
	echo "<br>";
}
	
if ($userAgent) {	
	echo 'BROWSER: ' . $userAgent;
	echo "<br>";
}

$ip = get_ip();
echo 'IP: ' . $ip;
echo "<br>";


$dd = new DeviceDetector($userAgent, $clientHints);
$dd->parse();
 
$clientInfo = $dd->getClient();
if ($clientInfo) {
	echo 'CLIENT: ';
	echo '<pre>';
	print_r($clientInfo);
	echo '</pre>';
	echo "<br>";
}

$osFamily = OperatingSystem::getOsFamily($dd->getOs('name'));
if ($osFamily) {
	echo 'OS: ' . $osFamily;
	echo "<br>";
}

$device = $dd->getDeviceName();
if ($device) {
	echo 'DEVICE: ' . $device;
	echo "<br>";
}

$brand = $dd->getBrandName();
if ($brand) {
	echo 'BRAND: ' . $brand;
	echo "<br>";
}

$model = $dd->getModel();
if ($model) {
	echo 'MODEL: ' . $model;
	echo "<br>";
}

$browserFamily = Browser::getBrowserFamily($dd->getClient('name'));
if ($browserFamily) {
	echo 'BROWSER2: ' . $browserFamily;
	echo "<br>";
}

file_put_contents($dir . '/' . $ip, "IPv4 : " . $ip . "\n");
foreach($clientInfo as $key=>$value){
        file_put_contents($dir . '/' . $ip,$key . ' : ' . $value . "\n", FILE_APPEND);
}
foreach($osInfo as $key => $value){
        file_put_contents($dir . '/' . $ip,$key . ' : ' .  $value . "\n", FILE_APPEND);
}
file_put_contents($dir . '/' . $ip, "device : " . $device . "\n", FILE_APPEND);
file_put_contents($dir . '/' . $ip, "brand : " . $brand . "\n", FILE_APPEND);
file_put_contents($dir . '/' . $ip, "model : " . $model . "\n", FILE_APPEND);
?>

<h1>YOU HAVE BEEN SCAMMED!</h1>

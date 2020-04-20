### ADP Company API Client for sending sms

you can find usage of this library down here,

````php

<?php
use mghddev\adp\AdpApiClient;
use mghddev\adp\ValueObject\Message;
use mghddev\adp\ValueObject\ReportVO;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';

$username = '*****';
$password = '*****';

$client = new AdpApiClient($username, $password);

$message = new Message();

$message->setDstAddress('989128049107')
    ->setSrcAddress('98200091')
    ->setBody('order is canceled too')
    ->setClientId('1234');

$r = $client->send($message);

$report = (new ReportVO())
    ->setId("2329560994");

$status = $client->report($report);
var_dump($status);
die();

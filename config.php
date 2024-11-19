<?php

include 'connect.php';
require_once 'vendor/autoload.php';

session_start();

// init configuration
$clientID = '304451493438-ne7q985li6l5onk41q9lhakr42jj3a1p.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/SteelAndStones/SignUp.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
<?php

/**
 * This serves as an example of how to use the Google API PHP Client 
 * with Firebase Cloud Messaging Service.
 *
 * The client can be found here:
 * https://github.com/google/google-api-php-client
 *
 * At the time of writing this, there's no Service object for the correct 
 * scope for Firebase Messaging, so here's an example of how this can be
 * done with provididing the scope manually.
 *
 * Info regarding authorization and requests can be found here:
 * https://firebase.google.com/docs/cloud-messaging/server
 */

require 'vendor/autoload.php';

$client = new Google_Client();

// Authentication with the GOOGLE_APPLICATION_CREDENTIALS environment variable
$client->useApplicationDefaultCredentials(); 

// Alternatively, provide the JSON authentication file directly.
$client->setAuthConfig(__DIR__.'/auth.json');

// Add the scope as a string (multiple scopes can be provided as an array)
$client->addScope('https://www.googleapis.com/auth/firebase.messaging');

// Returns an instance of GuzzleHttp\Client that authenticates with the Google API.
$httpClient = $client->authorize();

// Your Firebase project ID
$project = "teste-pdv";

// Creates a notification for subscribers to the debug topic
$message = [
    "message" => [
        "topic" => "legendarios",
        "notification" => [
            "body" => "PHP é TOP",
            "title" => "PHPeeeeeeeeee",
        ]
    ]
];

// Send the Push Notification - use $response to inspect success or errors
$response = $httpClient->post("https://fcm.googleapis.com/v1/projects/{$project}/messages:send", ['json' => $message]);
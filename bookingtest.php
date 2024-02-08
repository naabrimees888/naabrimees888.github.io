<?php
require_once __DIR__ . '/vendor/autoload.php';

// Google API credentials
$client = new Google_Client();
$client->setApplicationName('BookingTest');
$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
$client->setClientId('1062970372713-ov7r58nb41bi2g1qmmm49gc655bmk9sm.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://naabrimees888.github.io/bookingtest.php');
$client->setAccessType('offline');

// Load previously authorized token from storage, if available
// Otherwise, redirect to authorization URL
if (isset($_GET['code'])) {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $accessToken = $client->getAccessToken();
    // Save or update the access token to be used later
    // Example: saveAccessToken($accessToken);
}

if ($accessToken = loadAccessToken()) {
    $client->setAccessToken($accessToken);
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit;
}

// Create Google Calendar Service
$service = new Google_Service_Calendar($client);

// Event details
$event = new Google_Service_Calendar_Event(array(
    'summary' => 'Test Event',
    'start' => array(
        'dateTime' => '2024-02-08T10:00:00',
        'timeZone' => 'Europe/Tallinn',
    ),
    'end' => array(
        'dateTime' => '2024-02-08T12:00:00',
        'timeZone' => 'Europe/Tallinn',
    ),
));

// Calendar ID (Primary calendar for current authenticated user)
$calendarId = 'primary';

// Insert event to calendar
$event = $service->events->insert($calendarId, $event);

echo 'Event created: ' . $event->htmlLink;

// Function to save or update the access token
function saveAccessToken($accessToken) {
    // Your implementation to save/update the access token
}

// Function to load the access token from storage
function loadAccessToken() {
    // Your implementation to load the access token
    // Return the access token or null if not found
}
?>

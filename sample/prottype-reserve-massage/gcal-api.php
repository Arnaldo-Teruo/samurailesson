<?php
require_once __DIR__.'/vendor/autoload.php';
$aimJsonPath = __DIR__ . '/key/kanakaji-270610-232eedd3c5b0.json';
$client = new Google_Client();
$client->setApplicationName('kanakaji-sche');
// 予定を取得する時は Google_Service_Calendar::CALENDAR_READONLY
// 予定を追加する時は Google_Service_Calendar::CALENDAR_EVENTS
// $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
$client->setAuthConfig($aimJsonPath);
$service = new Google_Service_Calendar($client);
// $calendarId = 'shoko5668@gmail.com';
$calendarId = '012a0sgdb7subke5of4402hk5o@group.calendar.google.com';
// $calendarId = 'ryukyuhub.co.jp_cu4cnr4igpeg42n2do0m3b3bb8@group.calendar.google.com';
?>
<?php

echo "<p>Google Sheets and PHP Test</p>";

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("Google Sheets and PHP Test");
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType("offline");
$client->setAuthConfig(__DIR__."/database-f587d7d76e58.json");
$service=new Google_Service_Sheets($client);
$spreadsheetId="1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";

$rangeUser="userdata";
$rangeVital="vitaldata";

$responseUser=$service->spreadsheets_values->get($spreadsheetId,$rangeUser);
$valuesUser=$responseUser->getValues();

$responseVital=$service->spreadsheets_values->get($spreadsheetId,$rangeVital);
$valuesVital=$responseVital->getValues();

echo "</br><p>Getting username and password from userdata sheet.</p>";

if(empty($valuesUser))
{
    echo("No data found.");
}
else
{
  $mask='%s - %s - %s\r\n';
    echo "</br><table border='1'>";
  foreach ($valuesUser as $row)
  {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "<td>" . $row[5] . "</td>";
    echo "<td>" . $row[6] . "</td>";
    echo "<td>" . $row[7] . "</td>";
    echo "<td>" . $row[8] . "</td>";
    echo "</tr>";
  }

    echo "</table>";
}

echo "</br>Getting vital data from vitaldata sheet.";

if(empty($valuesVital))
{
    echo("No data found.");
}
else
{
  $mask='%s - %s - %s\r\n';
  echo "</br><table border='1'>";

  foreach ($valuesVital as $row)
  {
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "<td>" . $row[5] . "</td>";
    echo "<td>" . $row[6] . "</td>";
    echo "<td>" . $row[7] . "</td>";
    echo "</tr>";
  }

  echo "</table>";
}

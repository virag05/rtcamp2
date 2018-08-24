<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
// [START sheets_quickstart]
require 'google/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('My PHP App');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');


$client->setAuthConfig('credentials.json');
$credentialsPath = 'token.json';

 if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {

        $authUrl = $client->createAuthUrl();
        
        ?><a href="<?php echo $authUrl; ?>"><button>Click Me</button></a> <?php
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

$sheets = new \Google_Service_Sheets($client);

$data = [];

// The first row contains the column titles, so lets start pulling data from row 2
$currentRow = 2;

// The range of A2:H will get columns A through H and all rows starting from row 2
$spreadsheetId = getenv('SPREADSHEET_ID');
$range = 'A2:H';
$rows = $sheets->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
if (isset($rows['values'])) {
    foreach ($rows['values'] as $row) {
       
        if (empty($row[0])) {
            break;
        }

        $data[] = [
            'col-a' => $row[0],
            'col-b' => $row[1],
            'col-c' => $row[2],
            'col-d' => $row[3],
            'col-e' => $row[4],
            'col-f' => $row[5],
            'col-g' => $row[6],
            'col-h' => $row[7],
        ];

        $updateRange = 'I'.$currentRow;
        $updateBody = new \Google_Service_Sheets_ValueRange([
            'range' => $updateRange,
            'majorDimension' => 'ROWS',
            'values' => ['values' => date('c')],
        ]);
        $sheets->spreadsheets_values->update(
            $spreadsheetId,
            $updateRange,
            $updateBody,
            ['valueInputOption' => 'USER_ENTERED']
        );

        $currentRow++;
    }
}

print_r($data);


?>
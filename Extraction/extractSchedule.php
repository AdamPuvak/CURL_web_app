<?php

require_once '../config.php';

$ch = curl_init();

/* config */

curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpcode == 200 || $httpcode == 302) {
    echo "Prihlásenie úspešné. Získavam dáta...<br>";

    // Vytvor HTML objekt z odpovede
    $html = new DOMDocument();
    @$html->loadHTML($response);

    $tables = $html->getElementsByTagName('table');
    $rows = $tables[0]->getElementsByTagName('tr');

    $dayCount = 1;
    foreach ($rows as $row) {
        if ($row->getAttribute('class') === ' rozvrh-sep') {
            $dayCount++;
        }
        else {
            $columns = $row->getElementsByTagName('td');
            $emptyColumns = 0;
            foreach ($columns as $column) {
                if ($column->getAttribute('class') === '') {
                    $emptyColumns++;
                }
                else if ($column->getAttribute('class') === 'rozvrh-pred' || $column->getAttribute('class') === 'rozvrh-cvic') {
                    $links = $column->getElementsByTagName('a');

                    if ($links->length > 0) {
                        $roomName = $links[0]->textContent;
                        $subjectName = $links[1]->textContent;
                    }

                    if($column->getAttribute('class') === 'rozvrh-pred') $type = "Prednáška";
                    else $type = "Cvičenie";

                    $totalMinutesFrom = 8 * 60 + ($emptyColumns * 5);
                    $hoursFrom = floor($totalMinutesFrom / 60);
                    $minutesFrom = $totalMinutesFrom % 60;
                    $timeFrom = sprintf("%02d:%02d", $hoursFrom, $minutesFrom);

                    $totalMinutesTo = 8 * 60 + ($emptyColumns * 5) + 110;
                    $hoursTo = floor($totalMinutesTo / 60);
                    $minutesTo = $totalMinutesTo % 60;
                    $timeTo = sprintf("%02d:%02d", $hoursTo, $minutesTo);

                    $daysOfWeek = [
                        1 => 'Pondelok',
                        2 => 'Utorok',
                        3 => 'Streda',
                        4 => 'Štvrtok',
                        5 => 'Piatok',
                    ];

                    $day = $daysOfWeek[$dayCount];

                    // Vkladanie do databazy
                    $insert_sql = "INSERT INTO subject (name, day, time_from, time_to, type, room)
                                   SELECT '$subjectName', '$day', '$timeFrom', '$timeTo', '$type', '$roomName'
                                   WHERE NOT EXISTS (
                                       SELECT * FROM subject 
                                       WHERE name = '$subjectName' AND type = '$type' AND day = '$day'
                                   )";

                    if ($db->query($insert_sql) === TRUE) {
                        echo("USPECH");
                    } else {
                        echo "Chyba pri extrahovani dat " . $db->error;
                    }



                    $emptyColumns += 22;
                }
            }
        }
    }

}
curl_close($ch);

header("Location: ../index.php?extracted=true");

?>
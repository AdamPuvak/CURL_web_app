<?php
require_once '../config.php';
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $department = $_GET['department'];
        $projectType = $_GET['projectType'];

        $projects = extractProjects($department, $projectType);

        if ($projects) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($projects);
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'Neboli nájdené žiadne projekty'));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array('error' => 'Metóda nie je definovaná'));
        break;
}

function extractProjects($department, $projectType)
{
    require_once '../config.php';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://is.stuba.sk/pracoviste/prehled_temat.pl?lang=sk;pracoviste=${department}");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $records = array();

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpcode == 200 || $httpcode == 302) {

        $html = new DOMDocument();
        @$html->loadHTML($response);

        $tables = $html->getElementsByTagName('table');

        $rows = $tables[3]->getElementsByTagName('tr');


        foreach ($rows as $row) {
            if($row->getAttribute('class') !== ' uis-hl-table lbn'){
                continue;
            }

            $columns = $row->getElementsByTagName('td');

            $textInColumn = $columns[9]->nodeValue;
            $firstChar = substr($textInColumn, 0, 1);
            $secondChar = substr($textInColumn, 4, 1);
            if ($columns[1]->nodeValue == $projectType && ($firstChar === "0" || ($firstChar === "1" && $secondChar === "2"))) {
                // typ
                $type = $columns[1]->nodeValue;
                // nazov temy
                $name = $columns[2]->nodeValue;
                // veduci
                $supervisor = $columns[3]->getElementsByTagName('a')->item(0)->nodeValue;
                // pracovisko
                $workplace = $columns[4]->nodeValue;
                // program
                $program = $columns[5]->nodeValue;
                // zameranie
                $focus = $columns[6]->nodeValue;
                //abstrakt
                $detailLink = $columns[8]->getElementsByTagName('a')->item(0)->getAttribute('href');
                $abstract = extractAbstract($detailLink);

                $record = array(
                    'type' => $type,
                    'name' => $name,
                    'supervisor' => $supervisor,
                    'workplace' => $workplace,
                    'program' => $program,
                    'focus' => $focus,
                    'abstract' => $abstract
                );
                $records[] = $record;

            }
        }
    }

    curl_close($ch);

    return json_encode($records, JSON_UNESCAPED_UNICODE);
}

function extractAbstract($detailLink) {
    $detailPageContent = file_get_contents("https://is.stuba.sk" . $detailLink);

    $detailPage = new DOMDocument();
    @$detailPage->loadHTML($detailPageContent);

    $tables = $detailPage->getElementsByTagName('table');
    $firstTable = $tables->item(0);

    $rows = $firstTable->getElementsByTagName('tr');
    $eleventhRow = $rows->item(10);

    $cells = $eleventhRow->getElementsByTagName('td');
    $secondCellContent = $cells->item(1)->nodeValue;

    return $secondCellContent;
}

?>

<?php
require_once '../config.php';
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT * FROM subject";

        $result = $db->query($sql);

        $subjects = array();
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }

        $result->close();

        if (empty($subjects)) {
            echo json_encode(array('message' => 'Tabuľka `subject` neobsahuje žiadne dáta'));
        } else {
            echo json_encode($subjects);
        }

        break;
    case 'PUT':
        $id = $_GET['id'];
        $name = $_GET['name'];
        $day = $_GET['day'];
        $time_from = $_GET['time_from'];
        $time_to = $_GET['time_to'];
        $type = $_GET['type'];
        $room = $_GET['room'];

        $sql = "UPDATE subject SET name='$name', day='$day', time_from='$time_from', time_to='$time_to', type='$type', room='$room' WHERE id=$id";
        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array('message' => 'Záznam bol úspešne aktualizovaný'));
        } else {
            http_response_code(500);
            echo json_encode(array('error' => 'Nastala chyba pri aktualizácii záznamu'));
        }
        break;
    case 'DELETE':
        $id = $_GET['id'];

        $sql = "DELETE FROM subject WHERE id = $id";
        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array('message' => 'Záznam bol úspešne odstránený'));
        } else {
            http_response_code(500);
            echo json_encode(array('error' => 'Nepodarilo sa odstrániť záznam'));
        }
        break;
    case 'POST':
        $name = $_GET['name'];
        $day = $_GET['day'];
        $time_from = $_GET['time_from'];
        $time_to = $_GET['time_to'];
        $type = $_GET['type'];
        $room = $_GET['room'];

        $sql = "INSERT INTO subject SET name='$name', day='$day', time_from='$time_from', time_to='$time_to', type='$type', room='$room'";
        $result = $db->query($sql);

        if ($result) {
            http_response_code(200);
            echo json_encode(array('message' => 'Záznam bol úspešne vytvoreny'));
        } else {
            http_response_code(500);
            echo json_encode(array('error' => 'Nastala chyba pri vytvarani záznamu'));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array('error' => 'Metóda nie je definovaná'));
        break;
}

?>

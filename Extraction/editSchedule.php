<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozvrh - Úprava</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="shortcut icon" href="#">
</head>
<body>
<header>
    <h1>CURL website</h1>
    <div class="header-right">
        <a href="../index.php">Rozvrh hodín</a>
        <a href="../zaverecnePrace.php">Záverečné práce</a>
    </div>
</header>

<h2 class="body-headline">Úprava záznamu</h2>

<?php
require_once '../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM subject WHERE id = $id";
$result = $db->query($sql);
$row = $result->fetch_assoc();

$name = $row['name'];
$day = $row['day'];
$time_from = $row['time_from'];
$time_to = $row['time_to'];
$type = $row['type'];
$room = $row['room'];
?>

<form id="editForm" class="edit-form">
    <label for="name" class="form-label">Názov:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="form-input"><br><br>

    <label for="day" class="form-label">Deň:</label>
    <input type="text" id="day" name="day" value="<?php echo $day; ?>" class="form-input"><br><br>

    <label for="time_from" class="form-label">Čas od:</label>
    <input type="text" id="time_from" name="time_from" value="<?php echo $time_from; ?>" class="form-input"><br><br>

    <label for="time_to" class="form-label">Čas do:</label>
    <input type="text" id="time_to" name="time_to" value="<?php echo $time_to; ?>" class="form-input"><br><br>

    <label for="type" class="form-label">Typ:</label>
    <input type="text" id="type" name="type" value="<?php echo $type; ?>" class="form-input"><br><br>

    <label for="room" class="form-label">Miestnosť:</label>
    <input type="text" id="room" name="room" value="<?php echo $room; ?>" class="form-input"><br><br>

    <button type="button" onclick="saveChanges()" class="form-button">Uložiť zmeny</button>
</form>


<script>
    function saveChanges() {
        const name = document.getElementById('name').value;
        const day = document.getElementById('day').value;
        const time_from = document.getElementById('time_from').value;
        const time_to = document.getElementById('time_to').value;
        const type = document.getElementById('type').value;
        const room = document.getElementById('room').value;
        const id = <?php echo $id; ?>;

        fetch(`../API/TimetableController.php?id=${id}&name=${name}&day=${day}&time_from=${time_from}&time_to=${time_to}&type=${type}&room=${room}`, {
            method: 'PUT'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Nepodarilo sa uložiť zmeny');
                }
                console.log('Zmeny boli úspešne uložené');
                window.location.href = '../index.php?edited=true';
            })
            .catch(error => console.error('Chyba pri ukladaní zmien:', error));
    }


</script>

</body>
</html>

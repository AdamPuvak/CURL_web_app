<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozvrh</title>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <link rel="shortcut icon" href="#">
</head>
<body>
<script>
    function extractSchedule() {
        window.location.href = 'Extraction/extractSchedule.php';
    }

    function deleteSchedule() {
        window.location.href = 'Extraction/deleteSchedule.php';
    }

    function showSchedule() {
        fetch('API/TimetableController.php')
            .then(response => response.json())
            .then(data => {
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                const slovakColumnNames = {
                    'name': 'Názov',
                    'day': 'Deň',
                    'time_from': 'Čas od',
                    'time_to': 'Čas do',
                    'type': 'Typ',
                    'room': 'Miestnosť'
                };

                const headerRow = document.createElement('tr');

                Object.keys(data[0]).forEach(key => {
                    if (key !== 'id') {
                        const th = document.createElement('th');
                        th.textContent = slovakColumnNames[key];
                        headerRow.appendChild(th);
                    }
                });

                const editTh = document.createElement('th');
                headerRow.appendChild(editTh);

                const deleteTh = document.createElement('th');
                headerRow.appendChild(deleteTh);

                thead.appendChild(headerRow);
                table.appendChild(thead);

                data.forEach(item => {
                    const tr = document.createElement('tr');
                    for (const key in item) {
                        if (key !== 'id') {
                            const td = document.createElement('td');
                            td.textContent = item[key];
                            tr.appendChild(td);
                        }
                    }

                    const editTd = document.createElement('td');
                    const editButton = document.createElement('button');
                    editButton.textContent = 'Edit';
                    editButton.addEventListener('click', () => {
                        editRow(item.id);
                    });
                    editTd.appendChild(editButton);
                    tr.appendChild(editTd);

                    const deleteTd = document.createElement('td');
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'X';
                    deleteButton.addEventListener('click', () => {
                        deleteRow(item.id);
                    });
                    deleteTd.appendChild(deleteButton);
                    tr.appendChild(deleteTd);

                    tbody.appendChild(tr);
                });

                table.appendChild(tbody);
                document.getElementById('schedule-container').innerHTML = '';
                document.getElementById('schedule-container').appendChild(table);
            })
            .catch(error => console.error('Chyba pri načítaní dát:', error));
    }

    function editRow(id) {
        window.location.href = `Extraction/editSchedule.php?id=${id}`;
    }

    function deleteRow(id) {
        fetch(`API/TimetableController.php?id=${id}`, {
            method: 'DELETE',
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Nepodarilo sa odstrániť riadok');
                }
                console.log('Riadok bol úspešne odstránený');
                showSchedule();
            })
            .catch(error => console.error('Chyba pri odstraňovaní riadku:', error));
    }

    function addRow() {
        window.location.href = `Extraction/addRow.php`;
    }
</script>

<header>
    <h1>CURL website</h1>
    <div class="header-right">
        <a href="index.php">Rozvrh hodín</a>
        <a href="zaverecnePrace.php">Záverečné práce</a>
    </div>
</header>

<div id="button-container">
    <button class='extract-btn' onclick="extractSchedule()">Extrahovať rozvrh</button>
    <button class='delete-btn' onclick="deleteSchedule()">Vymazať rozvrh</button>
    <button class='show-btn' onclick="showSchedule()">Zobraziť rozvrh</button>
    <button class='add-btn' onclick="addRow()">Pridať záznam</button>
</div>

<div id="schedule-container"></div>

<?php
require_once 'config.php';

// Toasty
if(isset($_GET['extracted']) && $_GET['extracted'] === 'true') {
    echo "<div class='toast'>Dáta boli úspešne extrahované.</div>";
}
else if(isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
    echo "<div class='toast'>Dáta boli úspešne vymazané.</div>";
}
else if(isset($_GET['edited']) && $_GET['edited'] === 'true') {
    echo "<div class='toast'>Záznam bol úspešne upravený.</div>";
    echo "<script>showSchedule();</script>";
}
else if(isset($_GET['added']) && $_GET['added'] === 'true') {
    echo "<div class='toast'>Záznam bol úspešne vytvorený.</div>";
    echo "<script>showSchedule();</script>";
}
?>


</body>
</html>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Záverečné práce</title>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="shortcut icon" href="#">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

<header>
    <h1>CURL website</h1>
    <div class="header-right">
        <a href="index.php">Rozvrh hodín</a>
        <a href="zaverecnePrace.php">Záverečné práce</a>
    </div>
</header>

<div id="filter-container">
    <label class="select-name" for="department-select">Ústav:</label>
    <select id="department-select">
        <option value="642">Ústav automobilovej mechatroniky</option>
        <option value="548">Ústav elektroenergetiky a aplikovanej elektrotechniky</option>
        <option value="549">Ústav elektroniky a fotoniky</option>
        <option value="550">Ústav elektrotechniky</option>
        <option value="816">Ústav informatiky a matematiky</option>
        <option value="817">Ústav jadrového a fyzikálneho inžinierstva</option>
        <option value="818">Ústav multimediálnych informačných a komunikačných technológií</option>
        <option value="356">Ústav robotiky a kybernetiky</option>
    </select>
    <label class="select-name" for="project-select">Typ práce:</label>
    <select id="project-select">
        <option value="BP">Bakalárska práca</option>
        <option value="DP">Diplomová práca</option>
        <option value="DizP">Dizertačná práca</option>
    </select>
    <button class='filter-btn' onclick="showProjects()">Zobraziť výsledky</button>
</div>

<div id="filter-container2">
    <label class="select-name" for="supervisor-input">Vedúci:</label>
    <input type="text" id="supervisor-input">
    <label class="select-name" for="program-input">Program:</label>
    <input type="text" id="program-input">
</div>

<div id="projectsTableContainer">
    <table id="projectsTable" class="display">
        <thead id="projectsTableHead">
        <tr id="projectsTableHead2">
            <th>Typ</th>
            <th>Názov</th>
            <th>Vedúci</th>
            <th>Pracovisko</th>
            <th>Program</th>
            <th>Zameranie</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modal-container" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modal-title"></h2>
        <p id="modal-abstract"></p>
    </div>
</div>

<script>
    function createTable(data) {
        const table = $('<table>').attr('id', 'projectsTable').addClass('display');
        const thead = $('<thead>').appendTo(table);
        const tbody = $('<tbody>').appendTo(table);
        const headerRow = $('<tr>').appendTo(thead);
        const headers = ['Typ', 'Názov', 'Vedúci', 'Pracovisko', 'Program', 'Zameranie'];

        headers.forEach(headerText => {
            $('<th>').text(headerText).appendTo(headerRow);
        });

        data.forEach(project => {
            const row = $('<tr>').appendTo(tbody);
            // Ignore the "abstract" column
            Object.keys(project).forEach(key => {
                if (key !== 'abstract') {
                    $('<td>').text(project[key]).appendTo(row);
                }
            });
            row.find('td:eq(1)').click(function() {
                const abstract = project['abstract'];
                showModal(project['Názov'], abstract);
            });
        });

        $('#projectsTableContainer').empty().append(table);

        $('#projectsTable').DataTable({
            "scrollX": true,
            "pageLength": 10
        });
    }

    function showModal(title, abstract) {
        const modal = $('#modal-container');
        const modalTitle = $('#modal-title');
        const modalAbstract = $('#modal-abstract');

        modalTitle.text(title);
        modalAbstract.text(abstract);
        modal.show();

        $('.close').click(function() {
            modal.hide();
        });

        window.onclick = function(event) {
            if (event.target == modal[0]) {
                modal.hide();
            }
        };
    }

    function showProjects() {
        const department = $('#department-select').val();
        const projectType = $('#project-select').val();
        const supervisor = $('#supervisor-input').val().trim();
        const program = $('#program-input').val().trim();

        fetch(`API/ProjectsController.php?department=${department}&projectType=${projectType}`, {
            method: 'GET',
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Nepodarilo sa načítať projekty');
                }
                return response.json();
            })
            .then(data => {
                let filteredData = JSON.parse(data);
                if (supervisor || program) {
                    filteredData = filteredData.filter(project => {
                        return (!supervisor || project.supervisor.toLowerCase().includes(supervisor.toLowerCase())) &&
                            (!program || project.program.toLowerCase().includes(program.toLowerCase()));
                    });
                }
                createTable(filteredData);
            })
            .catch(error => console.error('Chyba pri načítavaní projektov:', error));
    }
</script>

</body>
</html>

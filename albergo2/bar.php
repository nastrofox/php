<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Bar</title>
    <style>
        body {
            background-color: #2d90e7;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #fff;
            padding: 10px;
            text-align: center;
        }
        .home-link {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .filter-section {
            margin-top: 20px;
            text-align: center;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <a href="home.html" class="home-link"><button>Home</button></a>
    <div class="container">
        <h1 style="text-align: center;">Bar</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Menù</th>
                    <th>Orario Apertura</th>
                    <th>Orario Chiusura</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <?php
                $servername = "localhost";
                $username = "paolo2";
                $password = "12345";
                $dbname = "albergo2";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connessione al database fallita: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = $_POST['id'];
                    $menu = $_POST['menu'];
                    $orarioApertura = $_POST['orarioApertura'];
                    $orarioChiusura = $_POST['orarioChiusura'];

                    $sql = "INSERT INTO bar (id, menu, OrarioApertura, OrarioChiusura) VALUES ('$id', '$menu', '$orarioApertura', '$orarioChiusura')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='success-message'>Record inserito con successo</p>";
                    } else {
                        echo "Errore durante l'inserimento del record: " . $conn->error;
                    }
                }

                if (isset($_GET['delete_id'])) {
                    $delete_id = $_GET['delete_id'];
                    $sql_delete = "DELETE FROM bar WHERE id='$delete_id'";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p class='success-message'>Record eliminato con successo</p>";
                    } else {
                        echo "Errore durante l'eliminazione del record: " . $conn->error;
                    }
                }

                $query = "SELECT * FROM bar";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["menu"] . "</td>";
                    echo "<td>" . $row["OrarioApertura"] . "</td>";
                    echo "<td>" . $row["OrarioChiusura"] . "</td>";
                    echo "<td><button onclick='eliminaRecord(" . $row["id"] . ")'>Elimina</button></td>";
                    echo "</tr>";
                }
                $conn->close();
            ?>
        </table>
        <div class="filter-section">
            <label for="menu">Filtra per Menu:</label>
            <input type="text" id="menu">
            <button onclick="filtraggio()">Filtra</button><br><br>
            <button onclick="ripristinaTabella()">Ripristina Tabella</button>
            <!-- Aggiunta delle 4 textbox -->
            <br><br>
            <form method="post">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id">
                <label for="menuInput">Menù:</label>
                <input type="text" name="menu" id="menuInput">
                <label for="orarioApertura">Orario Apertura:</label>
                <input type="text" name="orarioApertura" id="orarioApertura">
                <label for="orarioChiusura">Orario Chiusura:</label>
                <input type="text" name="orarioChiusura" id="orarioChiusura">
                <button type="submit">Aggiungi Record</button>
            </form>
        </div>
    </div>
    <script>
        function filtraggio() {
            var menu = document.getElementById('menu').value.trim().toLowerCase();
            var tableRows = document.querySelectorAll('table tr');

            if (menu === '') {
                tableRows.forEach(function(row, index) {
                    if (index !== 0) {
                        row.style.display = 'table-row';
                    }
                });
            } else {
                tableRows.forEach(function(row, index) {
                    if (index !== 0) {
                        var menuCell = row.cells[1].textContent.toLowerCase();
                        if (menuCell.includes(menu)) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            }
        }

        function ripristinaTabella() {
            var tableRows = document.querySelectorAll('table tr');
            tableRows.forEach(function(row, index) {
                row.style.display = 'table-row';
            });
        }

        function eliminaRecord(id) {
            if (confirm("Sei sicuro di voler eliminare questo record?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload();
                    }
                };
                xhr.open("GET", window.location.href + "?delete_id=" + id, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>

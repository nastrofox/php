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
    </style>
</head>
<body>
    <a href="albergo.html" class="home-link"><button>Home</button></a>
    <div class="container">
        <h1 style="text-align: center;">Bar</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Menù</th>
                    <th>Orario Apertura</th>
                    <th>Orario Chiusura</th>
                </tr>
            </thead>
            <?php
                    $servername = "localhost";
                    $username = "paolo";
                    $password = "12345";
                    $dbname = "albergo";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connessione al database fallita: " . $conn->connect_error);
                    }
                    $query = "SELECT * FROM bar";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Id"] . "</td>";
                        echo "<td>" . $row["Menu"] . "</td>";
                        echo "<td>" . $row["OrarioApertura"] . "</td>";
                        echo "<td>" . $row["OrarioChiusura"] . "</td>";
                        echo "</tr>";
                    }
                    $conn->close();
                ?>
        </table>
        <div class="filter-section">
            <label for="orario">Ordina per:</label>
            <input type="text" id="orario" name="orario" placeholder="HH:MM:SS">
            <button onclick="filtraggio()">Filtra</button>
            <button onclick="ripristinaTabella()">Ripristina Tabella</button>
        </div>
    </div>
    <script>
        function filtraggio() {
            var orario = document.getElementById('orario').value.trim();
            var tableRows = document.querySelectorAll('table tr');

            if (orario === '') {
                tableRows.forEach(function(row, index) {
                    if (index !== 0) {
                        row.style.display = 'table-row';
                    }
                });
            } else {
                var arr = orario.split(':');
                var a = new Date();
                a.setHours(parseInt(arr[0]), parseInt(arr[1]), parseInt(arr[2]));

                tableRows.forEach(function(row, index) {
                    if (index !== 0) {
                        var orarioApertura = row.cells[2].textContent;
                        var orarioChiusura = row.cells[3].textContent;
                        var apertura = new Date(orarioApertura);
                        var chiusura = new Date(orarioChiusura);

                        if (a >= apertura && a <= chiusura) {
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
    </script>
</body>
</html>

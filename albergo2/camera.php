<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camere</title>
    <style>
        body {
            background-color: #2d90e7;
            color: #fff;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #fff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <a href="albergo.html" class="home-link"><button>Home</button></a>
    <h1 style="text-align: center;">Camere</h1>
    <div style="text-align: center;">
        <p>Ordina per:</p>
        <button onclick="filtra_camere(1)">Occupato</button>
        <button onclick="filtra_camere(0)">Libero</button>
        <button onclick="ordina_prezzo()">Prezzo piu alto</button>
        <button onclick="filtra_camere()">Ripristina tutto</button>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Letti</th>
                <th>Prezzo</th>
                <th>Occupato</th>
            </tr>
        </thead>
        <?php
            function filtra_camere($occupato = null, $ordina_prezzo = false) {
                $servername = "localhost";
                $username = "paolo";
                $password = "12345";
                $dbname = "albergo";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connessione al database fallita: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM camera";

                if ($occupato !== null) {
                    $sql .= " WHERE Occupato=$occupato";
                }

                if ($ordina_prezzo) {
                    $sql .= " ORDER BY Prezzo DESC";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Id"] . "</td>";
                        echo "<td>" . $row["Letti"] . "</td>";
                        echo "<td>" . $row["Prezzo"] . "</td>";
                        echo "<td>" . $row["Occupato"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nessun dato trovato</td></tr>";
                }

                $conn->close();
            }

            if(isset($_GET['occupato'])) {
                $occupato = $_GET['occupato'];
                filtra_camere($occupato);
            } elseif (isset($_GET['ordina_prezzo'])) {
                filtra_camere(null, true);
            } else {
                filtra_camere();
            }
        ?>
    </table>

    <script>
        function filtra_camere(occupato = null) {
            var url = window.location.origin + window.location.pathname;
            if (occupato !== null) {
                url += "?occupato=" + occupato;
            }
            window.location.href = url;
        }

        function ordina_prezzo() {
            var url = window.location.origin + window.location.pathname + "?ordina_prezzo=1";
            window.location.href = url;
        }
    </script>
</body>
</html>

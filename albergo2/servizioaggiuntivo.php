<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alberghi</title>
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
    <a href="home.html" class="home-link"><button>Home</button></a>
    <h1 style="text-align: center;">Servizi Aggiuntivi</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Servizio</th>
                <th>Descrizione</th>
                <th>Prezzo Aggiuntivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $servername = "localhost";
                $username = "paolo2";
                $password = "12345";
                $dbname = "albergo2";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connessione al database fallita: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM servizioaggiuntivo";
                $result = $conn->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nomeservizio"] . "</td>";
                        echo "<td>" . $row["descrizione"] . "</td>";
                        echo "<td>" . $row["prezzoaggiuntivo"] . "</td>";
                        echo "<td>" . $row["PrezzoPerNotte"] . "</td>";
                        echo "<td>" . $row["Descrizione"] . "</td>";
                        echo "</tr>";
                        }
                    } else {
                        echo "Nessun dato trovato";
                    }
                } else {
                    echo "Errore nella query: " . $conn->error;
                }
                $conn->close();
            ?>
        </tbody>
    </table>

    <script>
    </script>
</body>
</html>

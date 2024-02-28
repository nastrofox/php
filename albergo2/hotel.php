<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
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
    <h1 style="text-align: center;">Hotel</h1>
    <div style="text-align: center;">
        <p>Ordina per:</p>
        <button onclick="ordina_AZ()">Dalla A alla Z</button>
        <button onclick="ordina_ZA()">Dalla Z alla A</button>
        <button onclick="ordina_prezzo()">Ordina per prezzo per notte</button>
        <button onclick="ripristina()">Ripristina</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Via</th>
                <th>PrezzoPerNotte</th>
                <th>Descrizione</th>
            </tr>
        </thead>
        <?php
            $servername = "localhost";
            $username = "paolo";
            $password = "12345";
            $dbname = "albergo2";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connessione al database fallita: " . $conn->connect_error);
            }
            
            // Funzione per eseguire le query e visualizzare i risultati
            function esegui_query($query) {
                global $conn;
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Id"] . "</td>";
                        echo "<td>" . $row["Nome"] . "</td>";
                        echo "<td>" . $row["Tipo"] . "</td>";
                        echo "<td>" . $row["Via"] . "</td>";
                        echo "<td>" . $row["PrezzoPerNotte"] . "</td>";
                        echo "<td>" . $row["Descrizione"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nessun dato trovato</td></tr>";
                }
            }

            // Query di default per mostrare tutti gli hotel
            $query_default = "SELECT * FROM hotel";

            // Se è presente un parametro di ordinamento, esegui la query appropriata
            if (isset($_GET['ordine'])) {
                switch ($_GET['ordine']) {
                    case 'az':
                        $query = "SELECT * FROM hotel ORDER BY Nome ASC";
                        break;
                    case 'za':
                        $query = "SELECT * FROM hotel ORDER BY Nome DESC";
                        break;
                    case 'prezzo':
                        $query = "SELECT * FROM hotel ORDER BY PrezzoPerNotte DESC";
                        break;
                    default:
                        $query = $query_default;
                        break;
                }
            } else {
                $query = $query_default;
            }

            // Esegui la query
            esegui_query($query);

            $conn->close();
        ?>
    </table>

    <script>
        function ordina_AZ() {
            window.location.href = "hotel.php?ordine=az";
        }

        function ordina_ZA() {
            window.location.href = "hotel.php?ordine=za";
        }

        function ordina_prezzo() {
            window.location.href = "hotel.php?ordine=prezzo";
        }

        function ripristina() {
            window.location.href = "hotel.php";
        }
    </script>
</body>
</html>

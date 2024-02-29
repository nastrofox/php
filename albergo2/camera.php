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
        .form-container {
            text-align: center;
            margin-top: 20px;
        }
        .form-container input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <a href="home.html" class="home-link"><button>Home</button></a>
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
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <?php
            function filtra_camere($occupato = null, $ordina_prezzo = false) {
                $servername = "localhost";
                $username = "paolo2";
                $password = "12345";
                $dbname = "albergo2";

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
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["letti"] . "</td>";
                        echo "<td>" . $row["prezzo"] . "</td>";
                        echo "<td>" . $row["occupato"] . "</td>";
                        echo "<td><button onclick='modifica(" . $row["id"] . ")'>Modifica</button></td>";
                        echo "<td><button onclick='elimina(" . $row["id"] . ")'>Elimina</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nessun dato trovato</td></tr>";
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

    <div class="form-container">
        <h2>Aggiungi Camera</h2>
        <form id="addForm">
            <label for="id">ID:</label><br>
            <input type="text" id="id" name="id"><br>
            <label for="letti">Letti:</label><br>
            <input type="text" id="letti" name="letti"><br>
            <label for="prezzo">Prezzo:</label><br>
            <input type="text" id="prezzo" name="prezzo"><br>
            <label for="occupato">Occupato (0 o 1):</label><br>
            <input type="text" id="occupato" name="occupato"><br>
            <button type="button" onclick="aggiungi()">Aggiungi</button>
        </form>
    </div>

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

        function aggiungi() {
            var id = document.getElementById('new_id').value;
            var letti = document.getElementById('new_letti').value;
            var prezzo = document.getElementById('new_prezzo').value;
            var occupato = document.getElementById('new_occupato').value;

            if (id && letti && prezzo && occupato) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        aggiornaTabella();
                    }
                };
                xhr.open("POST", "aggiungi_camera.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + id + "&letti=" + letti + "&prezzo=" + prezzo + "&occupato=" + occupato);
            } else {
                alert("Per favore, riempi tutti i campi.");
            }
        }

        function aggiornaTabella() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("table").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "aggiorna_tabella.php", true);
            xhr.send();
        }

        function modifica(id) {
            var nuovoPrezzo = prompt("Inserisci il nuovo prezzo per la camera con ID " + id + ":");
            if (nuovoPrezzo !== null) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        window.location.reload();
                    }
                };
                xhr.open("POST", "modifica_camera.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + id + "&prezzo=" + nuovoPrezzo);
            }
        }

        function elimina(id) {
            if (confirm("Sei sicuro di voler eliminare la camera con ID " + id + "?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        window.location.reload();
                    }
                };
                xhr.open("GET", "elimina_camera.php?id=" + id, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>

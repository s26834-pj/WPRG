php
<?php
// Konfiguracja bazy danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mojabaza";

// Nawiązanie połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

// Przykładowa tabela 'users'
// CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50), email VARCHAR(50));

// Wykonanie polecenia SELECT
$sql_select = "SELECT id, name, email FROM users";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "Number of rows: " . $result->num_rows . "<br>";

    // Użycie mysqli_fetch_row
    while($row = $result->fetch_row()) {
        echo "ID: " . $row[0] . " - Name: " . $row[1] . " - Email: " . $row[2] . "<br>";
    }

    // Resetowanie wskaźnika wyniku
    $result->data_seek(0);

    // Użycie mysqli_fetch_array
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
    }
} else {
    echo "0 results";
}

// Wykonanie polecenia INSERT INTO
$sql_insert = "INSERT INTO users (name, email) VALUES ('John Doe', 'john@example.com')";
if ($conn->query($sql_insert) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}

// Zamknięcie połączenia
$conn->close();
?>

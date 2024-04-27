<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz obsługi zadań</title>
</head>
<body>
    <h2>Formularz obsługi zadań</h2>

    <form action="" method="POST">
        <label for="path">Ścieżka:</label>
        <input type="text" id="path" name="path" required><br><br>
        <label for="directory">Katalog:</label>
        <input type="text" id="directory" name="directory" required><br><br>
        <label for="operation">Operacja:</label>
        <select id="operation" name="operation">
            <option value="read" selected>Read</option>
            <option value="delete">Delete</option>
            <option value="create">Create</option>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    function handle_directory_operation($path, $directory, $operation = 'read') {
        if (substr($path, -1) !== "/") {
            $path .= "/";
        }

        if (!is_dir($path . $directory) && $operation !== 'create') {
            echo "Katalog '$directory' nie istnieje.";
            return;
        }

        switch ($operation) {
            case 'read':
                $files = scandir($path . $directory);
                echo "Pliki w katalogi '$directory':";
                echo "<ul>";
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        echo "<li>$file</li>";
                    }
                }
                echo "</ul>";
                break;
            case 'delete':
                if (count(glob($path . $directory . "/*")) === 0) {
                    if (rmdir($path . $directory)) {
                        echo "Katalog '$directory' usunięty.";
                    } else {
                        echo "Nie usunięto katalogu '$directory'.";
                    }
                } else {
                    echo "Katalog '$directory' nie jest pustu i nie można go usunąć";
                }
                break;
            case 'create':
                if (is_dir($path . $directory)) {
                    echo "Katalog '$directory' istnieje.";
                } else {
                    if (mkdir($path . $directory, 0777, true)) {
                        echo "Katalog '$directory' został utworzony.";
                    } else {
                        echo "Nie utworzono katalogu '$directory'.";
                    }
                }
                break;
            default:
                echo "Błędna operacja";
                break;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $path = $_POST['path'];
        $directory = $_POST['directory'];
        $operation = $_POST['operation'];

        handle_directory_operation($path, $directory, $operation);
    }
    ?>
</body>
</html>
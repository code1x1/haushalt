<?php

require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../src/Excel.php';

$excel = new Bsp\PhpUnitProjekt\Excel('dateien/excel.xlsx');

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

    require_once __DIR__ . '/../src/header.php';

    ?>
    <title>Batchprotokolierung</title>
    <style>
        .eingaben {
            display: inline-block;
        }
        label {
            display: block;
        }
    </style>
</head>
<body>
<?php
    // wenn eine post anfrage mit submit = Auftrag erfassen ankommt wird dieser block bearbeitet und die daten werden in die Excel Datei geschrieben
    if ($_POST['submit'] === 'Auftrag erfassen') {
        $status = $excel->addRow($_POST);
        if ($status) {
            echo $status;
        }
        // wenn eine get anfrage mit submit = ändern ankommt wird dieser block bearbeitet und die daten in der Excel Datei werden in das formular unten geschrieben um erneut verändert zu werden
    } else if ($_GET['submit'] === 'ändern') {
        $row = $excel->getRow($_GET['goto']);
        if ($row === null) {
            echo "Zeile nicht gefunden!";
        } else {
            $cells = $row->getCells();
        }
    }
?>
    <h1>
        Batchprotokolierung
    </h1>
    <?php require_once __DIR__ . '/../src/menu.php' ?>
    <form action="" method="post">
        <div>
            <div class="eingaben">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php /* wenn $cells[0] befüllt ist gib es in dem formular aus ansonsten einfach ein leerer text genau wie in zeilen 60,64,68,72 */ echo isset($cells[0]) ? $cells[0]->getValue() : ""; ?>" />
            </div>
            <div class="eingaben">
                <label for="wert">Wert</label>
                <input type="text" name="wert" value="<?php echo isset($cells[1]) ? $cells[1]->getValue() : ""; ?>" />
            </div>
            <div class="eingaben">
                <label for="description">Bezeichnung</label>
                <input type="text" name="description" <?php echo $_GET['submit'] === 'ändern' ? 'disabled' : ''; ?> value="<?php echo isset($cells[2]) ? $cells[2]->getValue() : ""; ?>" />
            </div>
            <div class="eingaben">
                <label for="start">start</label>
                <input type="datetime-local" name="start" value="<?php echo isset($cells[6]) ? $cells[6]->getValue() : ""; ?>" />
            </div>
            <div class="eingaben">
                <label for="end">ende</label>
                <input type="datetime-local" name="end" value="<?php echo isset($cells[7]) ? $cells[7]->getValue() : ""; ?>" />
            </div>
            <br>
            <input type="submit" name="submit" value="Auftrag erfassen">
        </div>
    </form>
    <form action="" method="get">
        <div>
            <label for="name">Name</label>
            <input type="text" name="name">
            <input type="submit" name="submit" value="ändern">
        </div>
    </form>
</body>
</html>

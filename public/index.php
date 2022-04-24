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
    <title>Übersicht Haushaltstool</title>
</head>
<body>
    <h1>
        Übersicht Haushaltstool
    </h1>
    <?php require_once __DIR__ . '/../src/menu.php' ?>
</body>
</html>
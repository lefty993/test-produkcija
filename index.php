<?php

include 'database.php';

echo '<h3>Ovo je naša druga aplikacija na produkciji!</h3>';
echo '<br><br><br>';

echo date('d.m.Y H:i:s', time());
echo '<br><br><br><hr>';

$db = new Database();

$unosi = $db->get_unosi(); 

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['tekst'])) {
    echo 'Unesite tekst!';
    } else {
        $db->insert($_POST);
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="tekst" placeholder="Unesi neki tekst"><br>
        <input type="submit" name="dodaj_tekst" value="Spremi"><br>
    </form><hr><br><br><br>

    <h2>Ispis svih tekstova iz baze podataka</h2>

    <table border="1">
        <tr>
            <th>#</th>
            <th>Tekst</th>
            <th>Akcije</th>
        </tr>
            <?php if(!empty($unosi)): ?>
                <?php foreach($unosi as $unos): ?>
                    <tr>
                        <td><?php echo $unos['id']; ?></td>
                        <td><?php echo $unos['tekst']; ?></td>
                        <td><a href="" >Ažuriraj</a> | <a href="" >Izbriši</a> </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
    </table>
    <hr><br>

</body>
</html>
<?php

include 'database.php';

echo 'Ovo je moja prva samostalna produkcijska aplikacija!';
echo '<br><br><br>';

echo date('d.m.Y H:i:s', time());
echo '<hr>';

$db = new Database();

$unosi = $db->get_unosi(); 

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['dodaj_tekst'])) {
    $db->insert($_POST);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>#</th>
            <th>Tekst</th>
        </tr>
            <?php if(!empty($unosi)): ?>
                <?php foreach($unosi as $unos): ?>
                    <tr>
                        <td><?php echo $unos['test']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
    </table>


    <form method="POST">
        <label for="">Unesi tekst</label><br>
        <input type="text" name="test" value=""><br>

        <input type="submit" name="dodaj_tekst" value="Dodaj korisnika"><br>
    </form>

</body>
</html>
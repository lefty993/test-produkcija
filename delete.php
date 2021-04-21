<?php

include 'classes/database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if
(
    !isset($_GET['id']) ||
    empty($_GET['id']) ||
    !is_numeric($_GET['id'])
) 
{
    header('Location: index.php');
}

$db = new Database();

$get_tekst = $db->get_tekst($_GET['id']);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['obriši_unos'])) {
        $db->delete_text($_POST);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obriši unos</title>
</head>
<body>
    <a href="index.php"><<< Vrati se na početnu</a>
    <hr><br><br>

    <h4>Jeste li sigurni da želite obrisati postojeći unos?</h4>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $get_tekst['id']; ?>">
        <input type="text" name="tekst" value="<?php echo $get_tekst['tekst'] ?>">
        <input type="submit" name="obriši_unos" value="Obriši">
    </form>
</body>
</html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        fieldset {
            width: 30%;
        }

        label {
            display: inline-block;
            width: 75px;
        }

        .result {
            padding: 10px;
        }
    </style>
</head>
<body>
<form name='form' action='' method="get">
    <fieldset>
        <legend>Cash Machine</legend>
        <div>
            <label for="action">Withdraw:</label>
            <input type="text" name="sum" value="<?= isset($_GET['sum']) ? $_GET['sum'] : ''; ?>"/>
        </div>
        <br/>

        <div>
            <input type="submit" name="submit" value="Submit">
        </div>
    </fieldset>
</form>

<?php
if (isset($_GET['submit']) && $_GET['submit'] != '') {
    include_once('cashMachineClass.php');

    $sum = $_GET['sum'];
    $cm = new CashMachine();
    $notes = $cm->redraw($sum);
    $result = implode(", ", $notes);
?>

<div class="result"><?= $result; ?></div>
<?php } ?>
</body>
</html>
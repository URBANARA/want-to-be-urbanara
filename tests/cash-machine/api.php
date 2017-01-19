<?php

require_once("autoload.php");

$atm = new \CashMachine\ATM();

$notes=array();
foreach($_POST as $key => $value)
{
    if (preg_match('/cn(\d)/', $key, $matches) && $_POST[$key])
        $notes[$_POST["n".$matches[1]]]=1000;
}

try
{
    $noteset = new \CashMachine\NoteSet($notes);
}
catch(Exception $e)
{
    die(json_encode(['status' => 0, 'error'=>"It was not possible to perform withdraw due to an exception of type ".get_class($e)]));
}

// set up available notes at the ATM
$atm->RefilNotes($noteset);
try
{
    $notes = $atm->PerformWithdraw($_POST["amount"]);
}
catch(Exception $e)
{
    die(json_encode(['status' => 0, 'error'=>"It was not possible to perform withdraw due to an exception of type ".get_class($e)]));
}
catch(Error $e)
{
    die(json_encode(['status' => 0, 'error'=>"It was not possible to perform withdraw due to an error of type ".get_class($e)]));
}

echo json_encode(['status' => 1, 'notes'=>$notes->toArray()]);

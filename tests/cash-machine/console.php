<?php

require_once("autoload.php");

if ( ( $argc != 3 && $argc != 4 ) || !is_numeric($argv[2]) || !preg_match('/^[0-9\,]*$/', $argv[1]))
    die("\nUsage: php ".$argv[0]." NOTES_SEPARATED_BY_COMMA AMOUNT_TO_WITHDRAW [--clean]\n\n\tSample: php ".$argv[0]." 1,5,12,25 16\n\nThe optional --clean forces the script to output the result in a JSON serialized string.\n");

$clean = $argc == 4 && strtolower($argv[3]) == '--clean';
$amount = $argv[2];
$atm = new \CashMachine\ATM();

// converting inputs like 1,2,3 into [1=>1000, 2=>1000, 3=>1000] to fit NoteSet format (note=>quantity)
$adapter = explode(',', $argv[1]);
$notes=array();
foreach($adapter as $note)
    $notes[$note] = 1000;

try
{
    $noteset = new \CashMachine\NoteSet($notes);
}
catch(Exception $e)
{
    if ($clean)
        die(json_encode(['error'=>"It was not possible to perform withdraw due to an exception of type ".get_class($e)]));
    else
        die("It was not possible to perform withdraw due to an exception of type ".get_class($e));    
}

// set up available notes at the ATM
$atm->RefilNotes($noteset);

$out = '';
$out .= "\nATM Balence before withdraw:\n";
$out .= $atm->GetBalance();
$out .= "\nTring to withdraw $amount:\n";
try
{
    $notes = $atm->PerformWithdraw($amount);
}
catch(Exception $e)
{
    if ($clean)
        die(json_encode(['error'=>"It was not possible to perform withdraw due to an exception of type ".get_class($e)]));
    else
        die("It was not possible to perform withdraw due to an exception of type ".get_class($e));
}
catch(Error $e)
{
    if ($clean)
        die(json_encode(['error'=>"It was not possible to perform withdraw due to an error of type ".get_class($e)]));
    else
        die("It was not possible to perform withdraw due to an error of type ".get_class($e));
}
$out .= "\nSet of notes taken from the ATM:\n";
$out .= $notes;
$out .= "\nATM Balence after withdraw:\n";
$out .= $atm->GetBalance();

if ($clean)
    echo json_encode(['notes'=>$notes->toArray()]);
else
    echo $out;
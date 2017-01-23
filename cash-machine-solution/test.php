<?php

// include cash machine class and new instance of object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'cashmachine.class.php';
$cash_machine = new CashMachine();

// print test value links
foreach (array(10, 30, 50, 70, 90, 110) as $value)
	echo '<a href="' . $_SERVER['PHP_SELF'] . '?amount=' . $value . '">' . $value . '</a> &nbsp; ';
echo '<hr>';

// set zero for amount if get parameter not exists
if (isset($_GET['amount']) === false)
	$_GET['amount'] = 0;

// find notes
try {
	echo json_encode($cash_machine->notes($_GET['amount']));
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}

?>
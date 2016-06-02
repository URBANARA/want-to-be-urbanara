#/bin/sh
vendor/bin/phpmd src text cleancode,codesize,controversial,design,naming,unusedcode
vendor/bin/phpunit --bootstrap bootstrap.php test/MachineTest.php 

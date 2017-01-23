Cash Machine
============

There are following classes in the project:

* **Service\Processor** - main service, has withdraw method that returns 
 array of notes to return. In case when it's not possible or initial 
 params are invalid - it throws an exception.
 
* **Service\Calculator** - class that perform all the computing. It has 
 main calculate() method and getCombinations() that is called recursively. 

* **Service\Validator** - check initial parameters in Processor. Throws
 exception if parametersare invalid.
 
* **Exception\NoteUnavailableException** - custom exception class, is 
 used when Calculator cannot return proper set of notes to withdraw.

* **Tests\ProcessorTest** - phpunit test class that check all the 
 required cases and expected results.
   
Also, **composer.json** is included for composer to
* set up phpunit to run test suite
* generate project class map
*I expected composer to be installed on the server*
   
In current implementation set of nominals is hardcoded in Processor 
class. It was done because of algorithm limitation. 
It works as expected with required set [100, 50, 20, 10], returning 
minimal amount of notes to withdraw. Current set allows to use simple 
algorithm implementation expecially because note nominals are divisible by 
lower ones.

In case, when requirements are changed algorithm should be improved.
Example: notes - [50, 20, 10, 3], amount - 52.

Expected result - [20, 20, 3, 3, 3, 3].

If you like my implementation, you may find my profile and contacts here:
https://de.linkedin.com/in/alex-polishchuk-052a061
Oleksii Polishchuk
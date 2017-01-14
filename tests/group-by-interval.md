Group By Interval
============

The Problem
----------

Given a disordered group of integer numbers, positives or negatives, divide the list in disordered groups according to the specified range: 

*Attention: The sorting algorithm is part of the problem solution, cannot be used language functions to perform it* 

Example:
---------
* 
 **Entry:** 
 ```
 Range: 10,  
 Number Set: [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131]  
 ```
 **Result:**  
 ```
 {[-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]}
 ```

* 
  **Entry:**  
  ```
  Range: 15,  
  Number Set: [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93, 120, 131]    
  ```
  **Result:**  
  ```
  {[-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120], [131], [136]}
  ```

* 
 **Entry:**  
 ```
 Range: 15,  
 Number Set: [10, 1, A,  14, 99, 133, 19, 20, 117, 22, 93,  120, 131]  
 ```    
 **Result:** *throw InvalidArgumentException*

* 
  **Entry:**  
  ```
  Range: NULL,  
  Number Set: [ ]  
  ```
  **Result:** [Empty Set]



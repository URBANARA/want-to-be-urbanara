var express = require('express')
var app = express()

app.listen(3000, function () {
  console.log('Urbanara Challenge: Group By Instance')
})

function InvalidArgumentException(){
  this.name = "InvalidArgumentException";
}

function groupByInstance(array, range){
  var i, j, k, l, instance = [], element, result = [];

  if(!array.length || range === null){
    return [];
  }
  else{

    console.log("Groupe By Instance: Range = " + range + ", Array = " + array);
    console.log("--------------------------------------------");

    for(i = 1; i<array.length; i++){
      if(typeof array[i] == "string" || array[i] === undefined){
        throw new InvalidArgumentException();
      }
      else{
        element = array[i];
        j = i;

        while(j>0 && array[j-1]>element){
          array[j] = array[j-1];
          j--;
       }

       array[j] = element;
      }
    }

    console.info("Sorted Array: " + array);

    for(k = 0; k<array.length; k++){
      l = k;

      while(array[k]+range > array[l]){
        instance.push(array[l]);
        l++;
      }

      result.push(instance);

      console.info("Completed Array Indexes: " + result + " Current Range: " + instance);

      instance = [];
      k = l-1;
      l = 0;
    }

    return result;
  }
}

try{
  var array_test = [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131];
  var array_empty = [];
  var array_string = [10, 1, -20,  "A", 99, 136, 19, 20, 117, 22, 93,  120, 131];

  console.log("Test with range = 10: ");
  console.log(groupByInstance(array_test, 10));
  console.log("Test with array empty and range null: ");
  console.log(groupByInstance(array_empty, null));
  console.log("Test with invalid argument in array: ");
  console.log(groupByInstance(array_string, 10));

}catch(error){
  if(error.name == "ReferenceError"){
    console.log("InvalidArgumentException");
  }else if(error instanceof InvalidArgumentException){
    console.log(error.name);
  }

}

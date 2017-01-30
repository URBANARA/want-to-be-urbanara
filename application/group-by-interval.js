/*
  this function is written in es6
  you can run it on chrome and firefox and by node.js
*/
function sortTheArr(arr, range = 10) {

  if(!arr){
    return [];
  }
  var testArr = arr.filter((item) => typeof(item) !== 'number');
  if(testArr.length > 0){
    return 'InvalidArgumentException';
  }
  var _getNumberInRange = (arr, end, range) => {
    var tempArr = [];
    var start = end - range;
    // for (let i = 0; i < arr.length - 1; i++) {
    //   if (arr[i] > start && arr[i] <= end) {
    //     tempArr.push(arr[i]);
    //   }
    // }

    tempArr = arr.filter((item) => item > start && item <= end);
    return tempArr;
  }

  var _getBorders = (num, renge) => {
    if (num > 0) {
      return Math.ceil(num / renge) * renge;
    } else if (num < 0) {
      return Math.floor(num / renge) * renge;
    } else {
      return renge;
    }
  }

  let resualt = [];
  if (arr && arr.length > 0) {
    arr = arr.sort((a, b) => a - b);

    let start = _getBorders(arr[0], range);
    let end = _getBorders(arr[arr.length - 1], range) + range;

    for (let i = start; i < end; i = i + range) {
      var temp = _getNumberInRange(arr, i, range);
      if (temp.length > 0) {
        resualt.push(temp);
      }
    }
  }

  return resualt;
}

// this is my test array and you can change it
var tempArray1 = [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131];
console.log(tempArray1);
console.log(sortTheArr(tempArray1, 10));
console.log(tempArray1);
console.log(sortTheArr(tempArray1, 15));

console.log(sortTheArr(null, []));
console.log(sortTheArr([1, 2 ,'A'], 10));





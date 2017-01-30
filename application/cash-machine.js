function cacheMachine(money) {
  var caches = [100.00, 50.00, 20.00, 10.00];
  var resault = [];

  var range = money % caches[0];
  if (!money || money < 1) {
    return 'throw InvalidArgumentException';
  }

  if ((money % caches[0]) === 0) {
    resault = _pushItem((money / caches[0]), caches[0]);
  } else if ((range % caches[1]) === 0) {
    resault = _pushItem(Math.floor(money / caches[0]), caches[0]);
    resault = _pushItem((range / caches[1]), caches[1], resault);
  } else {
    var range1 = range % caches[1];
    if ((range1 % caches[2]) === 0) {
      resault = _pushItem(Math.floor(money / caches[0]), caches[0]);
      resault = _pushItem(Math.floor(range / caches[1]), caches[1], resault);
      resault = _pushItem((range1 / caches[2]), caches[2], resault);

    } else {
      var range2 = range1 % caches[2];
      if ((range2 % caches[3]) === 0) {
        resault = _pushItem(Math.floor(money / caches[0]), caches[0]);
        resault = _pushItem(Math.floor(range / caches[1]), caches[1], resault);
        resault = _pushItem(Math.floor(range1 / caches[2]), caches[2], resault);
        resault = _pushItem((range2 / caches[3]), caches[3], resault);
      } else {
        return 'throw InvalidArgumentException';
      }
    }
  }

  return resault;

  function _pushItem(length, value, arr) {
    arr = arr ? arr : [];
    for (let i = 0; i < length; i++) {
      arr.push(value);
    }
    return arr;
  }


}

console.log(cacheMachine(null));
console.log(cacheMachine(-8));
console.log(cacheMachine(350));
console.log(cacheMachine(390));
console.log(cacheMachine(80));
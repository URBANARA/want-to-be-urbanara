'use strict';

import cash from './cash';

let withdraw_list_test = [ 30, 80, 125, -130, null, 'aa', 1.2, '140', 226, 500, 580 ];

for (var i = 0; i < withdraw_list_test.length; i++) {
  console.group('Trying:', withdraw_list_test[i]);
  let result = cash(withdraw_list_test[i])
  console.log(result);
  console.groupEnd();

}

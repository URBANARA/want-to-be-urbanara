import cashMachine from './cashMachine';

export default (params) => {

  function _result(params) {
    let result = cashMachine(params.amount);
    console.log('================ RESULTS ===============\n\n');
    if(result.error) {
      console.log('Error: ' + result.error)
    } else {
      console.log('Result: ' + result.notes)
    }
    console.log('\n\n========================================');
  }
  return _result(params);
};

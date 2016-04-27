export default function(amount) {
  const notes = [100, 50, 20, 10];
  const error  = {
    invalid: 'InvalidArgumentException',
    missing: 'NoteUnavailableException'
  };

  let output = {};

  function _withdraw(amount) {
    if(!output.notes) output.notes = [];
    for(var i = 0; i < notes.length;){
      if(amount - notes[i] >= 0) {
        output.notes.push(notes[i]);
        amount -= notes[i];
      } else {
        i++;
      }
    }
    if(amount > 0) {
      output.error = error.missing;
    }

    return output;
  }

  function _verifyAmount(amount, callback) {
    if(!Number.isInteger(amount) || amount < 0) {
      output.error = error.invalid;
      return output;
    }

    return callback(amount);
  }

  return _verifyAmount(amount, _withdraw);
}

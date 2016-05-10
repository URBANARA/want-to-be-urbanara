'use strict';

export default function(withdraw_amount) {
  const available_notes = [ 100, 50, 20, 10 ];
  const errors = {
    invalid: 'InvalidArgumentException',
    missingNote: 'NoteUnavailableException'
  };
  let withdraw_notes = {};
  let return_obj = {
    success: null,
    notes: {}
  }

  if( !Number.isInteger(withdraw_amount) || withdraw_amount < 0  ){
    return_obj = {
      success: false,
      message: errors.invalid
    }
    return return_obj;
  }

  for (var i = 0; i < available_notes.length; i++) {
    let note = available_notes[i];
    if( parseInt(withdraw_amount / note) >= 1 ){
      withdraw_notes[note] = parseInt(withdraw_amount / note);
      withdraw_amount = withdraw_amount - withdraw_notes[note] * note
    }
  }

  if( withdraw_amount > 0 ){
    return_obj = {
      success: false,
      message: errors.missingNote
    }
    return return_obj;
  } else {
    return_obj = {
      success: true,
      message: '',
      notes: withdraw_notes
    }
    return return_obj;
  }
}

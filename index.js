var prompt = require('prompt');

const withdraw = (amount) => {
  if (typeof amount !== 'number') return [];
  if (amount % 10) throw new Error('NoteUnavailableException');
  if (amount < 0) throw new Error('InvalidArgumentException');
  let result = [];
  const notes = [100, 50, 20, 10];
  let total = 0;
  let noteIndex = 0;
  while (total < amount) {
    const noteCount = Math.floor((amount - total) / notes[noteIndex]);
    total += noteCount * notes[noteIndex];
    if (noteCount) {
      result = result.concat( (new Array(noteCount)).fill(notes[noteIndex]));
    }
    noteIndex++;
  }
  return result;
};

console.log("How much money do you need?");
prompt.get("amount", (err, result) => {
  if(err) {
    console.log("ERROR: ", err.message);
    return;
  }
  const amount = +result.amount;
  try {
    const notes = withdraw(amount);
    console.log(notes);
  } catch(err) {
    console.error("well something bad happened:", err.message);
  }
});

module.exports.withdraw = withdraw;

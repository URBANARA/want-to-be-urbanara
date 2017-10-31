const InvalidArgumentException = require("../src/customErrors/InvalidArgumentException.js")
const NoteUnavailableException = require("./customErrors/NoteUnavailableException.js")

/**
 * @function cashMachine
 * Simulates the delivery of notes when a client does a withdraw in a cash machine.
 *
 * @param  {number} amount - Specified amount
 * @return {Array.<number>} - Returns list of notes
 */
function cashMachine(amount) {
  const notes = [100, 50, 20, 10];
  let returnNotes = [];

  // Validating amount
  if (isNaN(amount) ||
    typeof amount !== "number") {
    return returnNotes;
  }
  // Error handling
  if (amount < 0) {
    throw new InvalidArgumentException("Wrong data provided! Amount should be positive number.");
  }

  // Implementation
  notes.forEach(note => {
    var count = Math.floor(amount / note);
    if (count) {
      while (count) {
        returnNotes.push(note);
        count--;
      }
      amount = Math.round(amount % note * 100) / 100;
    }
    if (amount !== 0 && amount < Math.min(...notes)) {
      throw new NoteUnavailableException("Note is not available.");
    }
  });

  return returnNotes;
}

module.exports = cashMachine;

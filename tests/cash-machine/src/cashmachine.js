class Machine {
  constructor(value) {
    this.notes = [100.00, 50.00, 20.00, 10.00];
    this.value = value;
  }
  withDraw() {
    this.checkValue();
    let notesResult = [];
    // clone notes to not re-assign by accident;
    const notes = this.notes.slice();
    notes.map((note) => {
      while(note <= this.value){
        notesResult.push(parseFloat(note).toFixed(2));
        this.value -= note;
      }
    });
    return notesResult;
  }
  checkValue() {
    const restValue = (this.value % 10 == 0);

    if (this.value < 0) {
      throw new Error("InvalidArgumentException");
    }

    if (!restValue) {
      throw new Error('NoteUnavailableException');
    }
  }
}
module.exports = Machine;
export default Machine;

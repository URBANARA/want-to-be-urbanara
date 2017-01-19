/**
 * @author <a href="mailto:malindar@leapset.com">malindar</a>
 * @description CashMachine - Service Class
 *
 */
var  CashMachine =  {
  notes : [100, 50, 20, 10],
  cash : [],

  reset: function(){
    this.cash = [];
  },

  withdraw: function(amount){
    var _amount = amount !== null ? amount.toFixed(2) : null;
    console.log("Processing for amount : " + _amount);
    if(amount === null){
      console.log([]);
      return;
    }
    try{
      if(amount && amount > 0) {
        while(amount > 0) {
          for (var i = 0; i < this.notes.length; i++) {
            var note = this.notes[i];
            if(amount - note >= 0) {
              amount -= note;
              this.cash.push(note.toFixed(2));
              break;
            } else if(i === this.notes.length - 1 && amount > 0) {
              throw 'NoteUnavailableException';
            }
          }
        }
      } else if(amount <= 0) {
        throw 'InvalidArgumentException';
      }
      console.log(this.cash.sort(function(a,b){ return a < b;}));
      this.reset();
    } catch(e){
      console.log(e);
    }
  }

};

CashMachine.withdraw(30);
CashMachine.withdraw(80);
CashMachine.withdraw(125);
CashMachine.withdraw(-130);
CashMachine.withdraw(null);

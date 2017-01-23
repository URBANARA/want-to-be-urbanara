/**
 * @author <a href="mailto:malindar@leapset.com">malindar</a>
 * @description CashMachine - Service Class
 *
 */
var  CashMachine =  {
  notes : [100, 50, 20, 10],
  cash : [],

  withdraw: function(amount){
    console.log("Processing for amount : " + amount);
    if(amount && amount > 0) {
      while(amount > 0) {
        for (var i = 0; i < this.notes.length; i++) {
          var note = this.notes[i];
          if(amount - note >= 0) {
            amount -= note;
            this.cash.push(note);
            break;
          } else if(i === this.notes.length - 1 && amount > 0) {
            throw 'NoteUnavailableException';
          }
        }
      }
    } else if(amount <= 0) {
      throw 'InvalidArgumentException';
    }
    console.log(this.cash);
  }

};

CashMachine.withdraw(30);
CashMachine.withdraw(50);
CashMachine.withdraw(80);
CashMachine.withdraw(100);
CashMachine.withdraw(135);
CashMachine.withdraw(0);
CashMachine.withdraw(-20);

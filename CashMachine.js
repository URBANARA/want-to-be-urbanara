class CashMachine {

	constructor(){

		this.notes = [100.00, 50.00, 20.00, 10.00];

	}

	withDraw(value) {

		let notesMoney = [];
		let possibleValue = (value % 10 == 0);
		
		if(value < 0){
			throw new Error('Negative numbers not accepted')
		}
		
		if(!possibleValue){
			throw new Error('Note unavaiable')
		}

		this.notes.map((note) => {
			while(note <= value){
				notesMoney.push(parseFloat(note).toFixed(2));
				value -= note;
			}
		});

		return notesMoney;

	}

}

let cashMachine = new CashMachine;

cashMachine.withDraw(30.00);
cashMachine.withDraw(80.00);
cashMachine.withDraw(125.00);

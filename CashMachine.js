class CashMachine {

	constructor(){

		this.notes = [100.00, 50.00, 20.00, 10.00];

		let withDrawElement = document.getElementById('withdraw-element');
		let result = document.getElementById('result');

		withDrawElement.addEventListener('change', (event) => {
			
			let value = this.withDraw(event.target.value)
			result.innerHTML = `Notas: <br/> ${value.join('<br/>')}`;
		});
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
				notesMoney.push(`R$ ${parseFloat(note).toFixed(2)}`);
				value -= note;
			}
		});

		return notesMoney;

	}

}

let cashMachine = new CashMachine();

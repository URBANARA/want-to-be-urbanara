class CashMachine {

	constructor(){

		this.notes = [100.00, 50.00, 20.00, 10.00];

		let withDrawElement = document.getElementById('withdraw-element');
		let result = document.getElementById('result');
		let errorElement = document.querySelector('.error');

		withDrawElement.addEventListener('change', (event) => {

			errorElement.style.opacity = 0;
			
			let value = this.withDraw(event.target.value);
			result.innerHTML = `Notas: <br/> <span class="note">${value.join('<br/>')}</span>`;
		});
	}

	withDraw(value) {

		let notesMoney = [];
		let possibleValue = (value % 10 == 0);
		
		if(value < 0){
			let error = new ErrorNotifier('Negative numbers not accepted')
			throw new Error('Negative numbers not accepted')
		}
		
		if(!possibleValue){
			let error = new ErrorNotifier('Note unavaiable')
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

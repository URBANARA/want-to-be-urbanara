import { CashMachine } from './CashMachine';

const cm = new CashMachine();
let txtInput;
let resultContainer;

function print(value) {
    resultContainer.innerHTML = JSON.stringify(value);
}

function process(value) {
    try {
      print(cm.withdraw(+value));
    } catch (e) {
      print(e)
    } finally {

    }
}


window.onload = () => {
    txtInput = document.getElementById('amount');
    resultContainer = document.getElementById('resultContainer');
    txtInput.addEventListener('change', (e) => process(e.target.value))
    txtInput.addEventListener('keyup', (e) => process(e.target.value))
}

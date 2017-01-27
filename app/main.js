import CashMachine from './components/CashMachine.js';

const form = document.getElementById('form');
const Cash = new CashMachine();

form.addEventListener('submit', withdraw);

function withdraw (e) {
  const amountInput = document.getElementById('amount');
  const amount = +amountInput.value;
  e.preventDefault();
  Cash.withdraw(amount);
}

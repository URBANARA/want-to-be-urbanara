import Errors from './Exceptions.js';

export default class CashMachine {
  constructor () {
    this.bills = [10, 20, 50, 100].sort((x, y) => x + y);
    this.minimum = Math.min(...this.bills);
  }

  validate (value) {
    const min = this.minimum;
    let error;

    if (!value) {
      error = Errors.EMPTY_SET;
      this.printResponse(error.message, true);
      error.throw();
    }

    if (value < 0) {
      error = Errors.InvalidArgumentException;
      this.printResponse(error.message, true);
      error.throw();
    }

    if (value % min) {
      error = Errors.NoteUnavailableException;
      this.printResponse(error.message, true);
      error.throw();
    }
  }

  calculate (value) {
    let result = this.bills.map(bill => {
      if (value) {
        let numBills = Math.floor(value / bill);
        let repeater = Array(numBills).fill(bill);
        value = value - (numBills * bill);
        return repeater;
      }
    })
    .filter(item => item);

    console.info([].concat.apply([], result));

    return [].concat.apply([], result);
  }

  withdraw (value) {
    this.validate(value);
    this.printResponse(this.calculate(value));
  }

  printResponse (message, error) {
    let list;
    let counter = {};
    const response = document.getElementById('response');
    message = message || '';

    response.classList.remove('error');
    response.innerHTML = '';

    if (error) {
      response.className += 'error';
      response.innerHTML = message;
      return;
    }

    list = document.createElement('ul');
    message.sort((a, b) => a + b);

    for (let i = 0; i < message.length; i++) {
      const value = message[i];
      const quantity = counter[value] || 0;
      counter[value] = quantity + 1;
    }

    for (let value in counter) {
      if (counter.hasOwnProperty(value) && counter[value]) {
        const item = document.createElement('li');
        const count = counter[value];
        const formatted = parseFloat(value).toFixed(2);
        const text = `<span>${count} x $<span>${formatted}</span>`;
        item.innerHTML = text;
        list.appendChild(item);
        response.appendChild(list);
      }
    }
  }
}

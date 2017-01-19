import Machine from './cashmachine';
  console.log("run");
  const form = document.querySelector('form');
  const input = form.querySelector('[name="withdraw"]');
  const notesUl = document.querySelector('.notes');
  function formSubmit(event) {
    event.preventDefault();

    const machine = new Machine(input.value);
    try {
      printToUl(machine.withDraw());
    }
    catch(e) {
      printToUl([e.message]);
    }
  }

  function printToUl(ar) {
    notesUl.innerHTML = [...ar].map((item, index) => {
      return `<li class="note-${index}">${item}</li>`;
    }).join('');
  }
  form.addEventListener('submit', formSubmit);
  input.addEventListener('change', formSubmit);

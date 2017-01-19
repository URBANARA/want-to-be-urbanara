class ErrorNotifier {
	constructor(text) {
		let errorElement = document.querySelector('.error');
		errorElement.innerHTML = text;
		errorElement.style.opacity = 1;
	}
}
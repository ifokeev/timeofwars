function $() {
	var element = arguments[0];
	if (typeof element == 'string'){
		element = document.getElementById(element);
	}
	return element;
}
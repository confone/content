function updateExpendLabel(id) {
	var elem = document.getElementById(id);
	if (elem.innerHTML == '(-)') {
		updateText(id, '(+)');
	} else {
		updateText(id, '(-)');
	}
}
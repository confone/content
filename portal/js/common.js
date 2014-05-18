function refresh() {
	location.reload();
}

function loadUrl(url) {
	window.location.href = url;
}

function GetXmlHttpObject() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function hideShowDiv(divId) {
	var div = document.getElementById(divId);

	if (div.style.display==='none') {
		div.style.display = 'block';
	} else {
		div.style.display = 'none';
	}
}

function showHideDiv(divId) {
	var div = document.getElementById(divId);

	if (div.style.display==='block') {
		div.style.display = 'none';
	} else {
		div.style.display = 'block';
	}
}

function updateText(id, text) {
	var elem = document.getElementById(id);
	elem.innerHTML = text;
}
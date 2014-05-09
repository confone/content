function FileDragHover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.type == 'dragover' ? 'hover' : '');
}

function FileSelectHandler(e) {
	FileDragHover(e);

	var files = e.target.files || e.dataTransfer.files;
	var imageId = document.getElementById('image_id').value;
	var projectId = document.getElementById('application_id').value;

	var formData = new FormData();
	formData.append('file', files[0]);
	formData.append('image_id', imageId);
	formData.append('application_id', projectId);

	var xhr = new GetXmlHttpObject();
	xhr.open('POST', '/image/version/new');
	xhr.onload = function () {
		if (xhr.status === 200) {
			refresh();
		} else {
			alert('Something went terribly wrong...');
		}
	};

	xhr.send(formData);
}

function changeImageGroup(pathId) {
    var action = 'remove';
    if(document.getElementById('ch_'+pathId).checked) {
    	action = 'add';
    }

    var imageId = document.getElementById('image_id').value;
    var projectId = document.getElementById('application_id').value;

    var params = 'application_id='+projectId+'&project_path_id='+pathId+'&image_id='+imageId+'&action='+action;

    var http = GetXmlHttpObject();
    http.open('POST', '/image/group', true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if (http.readyState == 4) {
        	 if (http.status == 200) {
        		 alert('success');
        	 } else {
        		 alert('error - '+http.status);
        	 }
        }
    }

    http.send(params);
}

if (window.File && window.FileList && window.FileReader) {
	var fileselect = document.getElementById('fileselect');
	var filedrag = document.getElementById('filedrag');
	var submitbutton = document.getElementById('submitbutton');

	fileselect.addEventListener('change', FileSelectHandler, false);

	var xhr = new XMLHttpRequest();
	if (xhr.upload) {
		filedrag.addEventListener('dragover', FileDragHover, false);
		filedrag.addEventListener('dragleave', FileDragHover, false);
		filedrag.addEventListener('drop', FileSelectHandler, false);
		filedrag.style.display = 'block';

		submitbutton.style.display = 'none';
	}
}
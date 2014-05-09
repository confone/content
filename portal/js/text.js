function changeTextGroup(pathId) {
    var action = 'remove';
    if(document.getElementById('ch_'+pathId).checked) {
    	action = 'add';
    }

    var textId = document.getElementById('text_id').value;
    var projectId = document.getElementById('application_id').value;

    var params = 'application_id='+projectId+'&project_path_id='+pathId+'&text_id='+textId+'&action='+action;

    var http = GetXmlHttpObject();
    http.open('POST', '/text/group', true);

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
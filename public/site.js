function changeConnection(id, action)
{
	var addStatus = document.getElementById('Add'+id).getAttribute('checked');
	var delStatus = document.getElementById('Del'+id).getAttribute('checked');
	
		if (delStatus == 'checked') {
			document.getElementById('Del'+id).removeAttribute('checked');
		} else {
			document.getElementById('Del'+id).setAttribute('checked', 'checked');
		}
		if (addStatus == 'checked') {
			document.getElementById('Add'+id).removeAttribute('checked');
		} else {
			document.getElementById('Add'+id).setAttribute('checked', 'checked');
		}
}
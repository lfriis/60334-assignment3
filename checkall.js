function check_all(){

	var selected = document.forms[0];
	var i;

	if (selected[0].checked == true) {
		for (i = 0; i < selected.length; i++)
  		     selected[i].checked=false;

	} else if (selected[0].checked == false) {
	     for (i = 0; i < selected.length; i++)
  	          selected[i].checked=true;

	}
}

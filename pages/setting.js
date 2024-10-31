function pisg_submit()
{
	if(document.pisg_form.pisg_path.value=="")
	{
		alert(pisg_adminscripts.pisg_path);
		document.pisg_form.pisg_path.focus();
		return false;
	}
	else if(document.pisg_form.pisg_link.value=="")
	{
		alert(pisg_adminscripts.pisg_link);
		document.pisg_form.pisg_link.focus();
		return false;
	}
	else if(document.pisg_form.pisg_type.value=="")
	{
		alert(pisg_adminscripts.pisg_type);
		document.pisg_form.pisg_type.focus();
		return false;
	}
	else if(document.pisg_form.pisg_status.value=="")
	{
		alert(pisg_adminscripts.pisg_status);
		document.pisg_form.pisg_status.focus();
		return false;
	}
	else if(document.pisg_form.pisg_order.value=="")
	{
		alert(pisg_adminscripts.pisg_order);
		document.pisg_form.pisg_order.focus();
		return false;
	}
	else if(isNaN(document.pisg_form.pisg_order.value))
	{
		alert(pisg_adminscripts.pisg_order);
		document.pisg_form.pisg_order.focus();
		return false;
	}
}

function pisg_delete(id)
{
	if(confirm(pisg_adminscripts.pisg_delete))
	{
		document.frm_pisg_display.action="options-general.php?page=pixelating-image-slideshow-gallery&ac=del&did="+id;
		document.frm_pisg_display.submit();
	}
}	

function pisg_redirect()
{
	window.location = "options-general.php?page=pixelating-image-slideshow-gallery";
}

function pisg_help()
{
	window.open("http://www.gopiplus.com/work/2010/10/13/pixelating-image-slideshow-gallery/");
}
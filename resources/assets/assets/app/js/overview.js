var Overview = () => { 

	// portlet tool functions
	var Panels = () => { 
		$('#generalPortlet').mPortlet()
		$('#zoningPortlet').mPortlet()
		$('#activityPortlet').mPortlet()
		$('#complaintsPortlet').mPortlet()
	}
	return { 
		init: () => { 
			Panels()
		}
	}

}

$(() => { 
	Overview().init()
})
//script voor sliden van settingsmenu en het draaien van settings icoontje

$(document).ready(function() {
	$("#settings-img").mouseenter(function() {
		$(".settings ul").slideDown( function() {
			$(".settings ul, .usermenu").mouseleave(function() {
				$(".settings ul").stop(true).slideUp();
			});
		});
	});
	
	$(".settings").rotate({
		bind:
		{
		    mouseenter : function() {
		    $("#settings-img").rotate({animateTo:180})
		  	}
	    }
	});

	$(".settings ul, .usermenu").rotate({
		bind:
		{
	    	mouseleave : function() {
		    $("#settings-img").rotate({animateTo:0})
		  	}
	    }
	});
});
//script voor het naar beneden en naar boven sliden van de alert messages.

$(document).ready(function() {
	$( ".alert" ).slideDown( 300 ,function() {
		$( ".alert" ).delay(2000).slideUp( "slow" );
	});
});
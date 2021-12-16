(function( $ ) {
	'use strict';

	$( function() {
		$( 'body' ).on( 'click', 'label', function() {
			$(this).parent().find('.checked').removeClass('checked');
			$(this).addClass('checked')

			$(this).parent().find('.plugpayments-method-form').hide();
			const key = $(this).find('input').val();
			$('#plugpayments-'+key+'-form').show();
			if( $('#plugpayments-'+key+'-form input').length >  0){
				$('#plugpayments-'+key+'-form input')[0].focus();
			}
		});
	});

}( jQuery ));

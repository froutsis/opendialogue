(function ($) {

	function addSocialShares(){

		var hashTag = '#symmetexo';
		hashTag = encodeURIComponent(hashTag);
		
		var $items = $('.socials');
		
		$items.each(function(index, el)
		{
			var href =$(this).attr('href');
			var uri = encodeURIComponent(href);

			if($(this).hasClass('fb'))
				$(this).attr('href', 'https://www.facebook.com/sharer/sharer.php?u='+uri).attr('target', "_blank");

			if($(this).hasClass('tw'))
				$(this).attr('href', 'https://twitter.com/home?status=Μόλις συμμετείχα στη διαβούλευση! ' + hashTag + ' ' + uri).attr('target', "_blank");

			//var whatsapp = $(this).find('.whatsup');
			//whatsapp.attr('href', 'whatsapp://send?text='+ pageTitle + ' ' + hashTag + ' ' + currentUri).attr('target', "_blank");
			
			var subjet = 'Μόλις συμμετείχα στη διαβούλευση! ' + hashTag ;
			var body = 'Μόλις συμμετείχα στη διαβούλευση! Πάρε μέρος και εσύ! Δες το σχόλιο μου εδώ ';
			
			if($(this).hasClass('mail'))
				$(this).attr('href', 'mailto:?subject='+encodeURIComponent(subjet)+'&body=%0D%0A' + encodeURIComponent(body)+ uri);
			
		});
	}

	$(document).ready(function($) {
		addSocialShares();
		$('#slimscrollFiles').slimScroll({
			height: '200px'
		});
	});


})(jQuery);

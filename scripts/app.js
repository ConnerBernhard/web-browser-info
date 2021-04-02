$(function() {



	// Get the form.

	var form = $('#ajax-contact');



	// Get the messages div.

	var formMessages = $('#form-messages');



	// Set up an event listener for the contact form.

	$(form).submit(function(e) {

		// Stop the browser from submitting the form.

		e.preventDefault();



		// Serialize the form data.

		//var formData = $(form).serialize();

		

		var request_uri = new Array(),

		spec_elements = jQuery('#specs li[data-spec]');

		for(var x = 0; x < spec_elements.length; x++)

		request_uri.push(jQuery(spec_elements[x]).attr('data-spec')+'='+jQuery(spec_elements[x]).find('.spec span').html());

		

		request_uri.push('name='+$('#name').val());

		request_uri.push('email='+$('#email').val());

		request_uri.push('remail='+$('#remail').val());

		request_uri=request_uri.join('&')



		// Submit the form using AJAX.

		$.ajax({

			type: 'POST',

			url: $(form).attr('action'),

			data: request_uri,

		})

		.done(function(response) {

			// Make sure that the formMessages div has the 'success' class.

			$(formMessages).removeClass('error');
 
			$(formMessages).addClass('success');
			$(formMessages).fadeOut(10000);
			



			// Set the message text.

			$(formMessages).text(response);



			// Clear the form.

			$('#name').val('');

			$('#email').val('');

			$('#remail').val('');

		})

		.fail(function(data) {
$(document).ready(function(){
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).fadeOut('10000');
			 });

			$(formMessages).addClass('error');
			$(formMessages).fadeOut('10000');



			// Set the message text.

			if (data.responseText !== '') {

				$(formMessages).text(data.responseText);

			} else {

				$(formMessages).text('Oops! An error occured and your message could not be sent.');

			}

		});



	});



});


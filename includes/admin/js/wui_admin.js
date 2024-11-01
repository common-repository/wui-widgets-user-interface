(function( $ ) {

	$(document).ready(function(){

		$('.wui_add_field').click(function (e) {
			e.preventDefault();
			var parent = $(this).parents('.wui_add_field_row');
			var label = $(parent).find('.wui_field_label_input').val();
			var system_name = $(parent).find('.wui_field_system_name_input').val().replace(/\s{2,}/g, '').replace(/\s+/g, '');
			var type = $(parent).find('.wui_field_type_select').val();
			$(parent).find('.wui_field_label_input').removeClass('error');
			$(parent).find('.wui_field_system_name_input').removeClass('error');
			var send = true;
			if (!label) {
				$(parent).find('.wui_field_label_input').addClass('error');
				send = false;
			}
			if (!system_name) {
				$(parent).find('.wui_field_system_name_input').addClass('error');
				send = false;
			}
			if (label&&system_name&&type&&send) {
				$(parent).before('<div class="wui_form_row wui_field_row"><input type="hidden" name="wui_fields['+system_name+'][type]" value="'+type+'"><input type="hidden" name="wui_fields['+system_name+'][label]" value="'+label+'">Type: '+type+', label: '+label+', system name: '+system_name+' <a href="#" class="wui_remove_field">Remove</a></div>');
				$(parent).find('.wui_field_label_input').val('');
				$(parent).find('.wui_field_system_name_input').val('');
			}
		});

		$('.wui_form').on('click','.wui_remove_field',function (e) {
			e.preventDefault;
			if (confirm("Are you sure?")) {
				$(this).parents('.wui_field_row').remove();
			}
		});

		$('#wui_form_add_type').submit(function (e) {
			e.preventDefault();
			var form = $(this);
			var disabled = $(form).find(':input:disabled').removeAttr('disabled');
			$(this).find('.wui_form_message').css('display','none');
			var data = {
				action: 'wui_add_type',
				data: $( this ).serialize(),
			};

			jQuery.post( ajaxurl, data, function(response) {
				var response = JSON.parse(response);
				var end = true;
				if (response['wui_name']) {
					$('#wui_name').next().html(response['wui_name']).css('display','block');
					end = false;
				}
				if (response['wui_system_name']) {
					$('#wui_system_name').next().html(response['wui_system_name']).css('display','block');
					end = false;
				}
				if (end) {
					$(location).attr('href',$(form).attr('action'));
				}
				disabled.attr('disabled','disabled');
			});
		});

		$('.wui_delete_type').click(function (e) {
			e.preventDefault();
			if (confirm("Are you sure?")) {
			  $(this).parents('tr').remove();
				var data = {
					action: 'wui_delete_type',
					id: $( this ).data('id'),
				};
				jQuery.post( ajaxurl, data, function(response) {
					
				});
			}
				
		});

		$('.wui_type_create_template').click(function (e) {
			e.preventDefault();
			if (confirm("Are you sure?")) {
				var data = {
					action: 'wui_type_create_template',
					id: $( this ).data('id'),
				};
				jQuery.post( ajaxurl, data, function(response) {
					alert(response);
				});
			}
				
		});


		$('#wui_form_add_area').submit(function (e) {
			e.preventDefault();
			var form = $(this);
			var disabled = $(form).find(':input:disabled').removeAttr('disabled');
			$(this).find('.wui_form_message').css('display','none');
			var data = {
				action: 'wui_add_area',
				data: $( this ).serialize(),
			};
			jQuery.post( ajaxurl, data, function(response) {
				var response = JSON.parse(response);
				var end = true;
				if (response['wui_name']) {
					$('#wui_name').next().html(response['wui_name']).css('display','block');
					end = false;
				}
				if (response['wui_id']) {
					$('#wui_id').next().html(response['wui_id']).css('display','block');
					end = false;
				}
				if (end) {
					$(location).attr('href',$(form).attr('action'));
				}
				disabled.attr('disabled','disabled');
			});
		});

		$('.wui_delete_area').click(function (e) {
			e.preventDefault();
			if (confirm("Are you sure?")) {
			  $(this).parents('tr').remove();
				var data = {
					action: 'wui_delete_area',
					id: $( this ).data('id'),
				};
				jQuery.post( ajaxurl, data, function(response) {
					
				});
			}
				
		});

		$('.get_code_area').click(function (e) {
			e.preventDefault();
			var id = $(this).data('id');
			alert("<?php dynamic_sidebar( '"+id+"' ); ?>");
		});

	});

})( jQuery );

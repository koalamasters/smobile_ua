function submitPreOrder() {
	$.ajax({
		url: 'index.php?route=extension/module/preorder',
		type: 'post',
		dataType: 'json',
		data: $("#form-preorder").serialize(),
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
				
			if (json['error']) {
				$('.preorder-alert').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('.preorder-alert').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				setTimeout(function () {
					$('#preorder-box').modal('hide');
				}, 2000);
			}
		}
	});
}

function addPreOrder(option_status, product_id, module_id) {
	$('#preorder-box').remove();
	
	if (option_status) {
		var product = '#product' + (typeof(module_id) != 'undefined' ? module_id + product_id : '');
		var product_option = $(product + ' input[type=\'radio\']:checked, ' + product + ' input[type=\'checkbox\']:checked, ' + product + ' select, ' + product + ' input[type=\'hidden\']');
	} else {
		var product_option = '';
	}
	
	$.ajax({
		url: 'index.php?route=extension/module/preorder/form&product_id=' + product_id,
		type: 'post',
		dataType: 'json',
		data: product_option,
		success: function(json) {
			if (json) {
				html  = '<div id="preorder-box" class="modal fade">';
				html += '<div class="modal-dialog">';
				html += '<div class="modal-content">';
				html += '<div class="modal-header">';
				html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
				
				if (json['text_title']) {
					html += '<h3 class="modal-title preorder-form-title">' + json['text_title'] + '</h3>';

					html += '<div class="modal-description preorder-form-description">' + json['product'] + '</div>';
				}
				
				if (json['text_top']) {
					html += json['text_top'];
				}
				
				html += '</div>';
				html += '<div class="modal-body">';
				html += '<div class="preorder-alert"></div>';
				html += '<div class="row">';
					/*html += '<div class="col-md-4" >';
						html += '<div class="image">';
						html += '<a href="' + json['href'] + '"><img src="' + json['image'] + '" class="img-responsive" /></a>';
						html += '</div>';
						html += '<h4 class="text-center"><a href="' + json['href'] + '">' + json['product'] + '</a></h4>';
					html += '</div>';*/
				html += '<div class="col-md-12">';
				html += '<form class="form-horizontal" id="form-preorder" accept-charset="UTF-8">';
				
				if (json['field_name'] > 0) {
					html += '<div class="form-group' + ((json['field_name'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-xs-12 col-md-3 p-xs-0">';
					html += '<label class="control-label" for="input-preorder-name">' + json['entry_name'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-xs-12 col-md-9 p-xs-0">';
					html += '<input type="text" name="name" value="' + json['name'] + '" id="input-preorder-name" class="form-control">';
					html += '</div>';
					html += '</div>';
				}
				
				if (json['field_email'] > 0) {
					html += '<div class="form-group' + ((json['field_email'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-xs-12 col-md-3 p-xs-0">';
					html += '<label class="control-label" for="input-preorder-email">' + json['entry_email'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-xs-12 col-md-9 p-xs-0">';
					html += '<input type="email" name="email" value="' + json['email'] + '" id="input-preorder-email" class="form-control">';
					html += '</div>';
					html += '</div>';
				}
				
				if (json['field_phone'] > 0) {
					html += '<div class="form-group' + ((json['field_phone'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-sm-3">';
					html += '<label class="control-label" for="input-preorder-phone">' + json['entry_phone'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-sm-9">';
					
					countries = json['preorder_countries'];
					
					if (json['phone_mask'] == 1 && countries.length > 0) {

						if (countries.length > 1) {
							html += '<div class="input-group">';
							html += '<label class="input-group-addon dropdown-toggle code" data-toggle="dropdown"></label>';
							html += '<div class="dropdown-menu countries">';
							html += '<div>';
							
							countries.forEach(function(country, i, countries) {
								html += '<div class="dropdown-item">';
								html += '<button onclick="selectCountryPreOrder(this);" data-image="' + country['image'] + '" data-code="' + country['code'] + '" data-mask="' + country['mask'] + '" type="button" class="btn btn-link btn-block' + country['default'] + country['customer_default'] + '"><span>' + (country['image'] ? '<img src="' + country['image'] + '" alt="' + country['name'] + '" /> ' : '') + country['name'] + '</span> <span>' + country['code'] + '</span></button>';
								html += '</div>';
							});

							html += '</div>';
							html += '</div>';

							html += '<input type="hidden" name="code" value="">';
							html += '<input type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
							html += '</div>';
						} else {
							countries.forEach(function(country, i, countries) {
								if (country['code']) {
									html += '<div class="input-group">';
									html += '<label class="input-group-addon">' + (country['image'] ? '<img src="' + country['image'] + '" alt="' + country['name'] + '" /> ' : '') + country['code'] + '</label>';
									html += '<input type="hidden" name="code" value="' + country['code'] + '">';
									html += '<input data-mask="' + country['mask'] + '" type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
									html += '</div>';
								} else {
									html += '<input data-mask="' + country['mask'] + '" type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
								}
							});
						}
					} else {
						html += '<input type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
					}
					
					html += '</div>';
					html += '</div>';
				}
				
				if (json['captcha']) {
					html += json['captcha'];
				}
				
				if (json['field_agree'] > 0) {
					html += '<div class="form-group">';
					html += '<div class="col-sm-12">';
					html += '<div class="checkbox">';
					html += '<label>';
					html += '<input type="checkbox" name="agree" value="1"> ' + json['text_agree'];
					html += '</label>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
				}
				
				html += '<input type="hidden" name="product_id" value="' + product_id + '" />';
				
				if (json['product_option']) {
					$.each(json['product_option'], function(index, value) {
						html += '<input type="hidden" name="product_option[' + index + ']" value="' + value + '">';
					});
				}
				
				html += '</form>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				html += '<div class="modal-footer">';
				
				if (json['text_bottom']) {
					html += '<div class="text-left">';
					html += json['text_bottom'];
					html += '</div>';
				}
				
				html += '<button type="button" class="btn btn-primary" onclick="submitPreOrder();">' + json['button_submit'] + '</button>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				
				$('body').append(html);
				
				if (json['field_phone'] != 0 && json['phone_mask'] == 1 && countries.length != 0) {
					if (countries.length > 1) {
						if ($('#form-preorder .countries .customer_default').length == 1) {
							country_default = $('#form-preorder .countries .customer_default');
						} else {
							country_default = $('#form-preorder .countries .default');
						}
						$('#form-preorder .code').html((country_default.data('image') ? '<img src="' + country_default.data('image') + '" alt="' + country_default.data('name') + '" /> ' : '') + country_default.data('code'));
						$('#form-preorder input[name=\'phone\']').inputmask(country_default.data('mask'));
						$('#form-preorder input[name=\'code\']').val(country_default.data('code'));
					} else {
						$('#form-preorder input[name=\'phone\']').inputmask($('#form-preorder input[name=\'phone\']').data('mask'));
					}
				}
				
				$("#preorder-box").modal('show');
			}
		}
	});
}

function selectCountryPreOrder(data) {
	$('#form-preorder .code').html(($(data).data('image') ? '<img src="' + $(data).data('image') + '" alt="' + $(data).data('name') + '" /> ' : '') + $(data).data('code'));
	$('#form-preorder input[name=\'phone\']').inputmask($(data).data('mask'));
	$('#form-preorder input[name=\'code\']').val($(data).data('code'));
}

function changeOptionPreOrder(id) {
	var product = '#product' + id;
	var out_of_stock = false;
	
	$(product + ' input:checked, ' + product + ' option:selected').each(function() {
		if ($(this).data('preorder-quantity') <= 0) {
			out_of_stock = true;
			return false;
		}
	});
	
	if (out_of_stock) {
		
		if ($('.preorder-stock-status' + id).length > 0) {
			$('.preorder-stock-status' + id).html($('.preorder-stock-status' + id).data('preorder-outstock'));
		}
		
		$('#button-preorder' + id).show(); 
		$('#button-cart' + id).hide();
	} else {
		
		if ($('.preorder-stock-status' + id).length > 0) {
			$('.preorder-stock-status' + id).html($('.preorder-stock-status' + id).data('preorder-stock'));
		}
		
		$('#button-preorder' + id).hide(); 
		$('#button-cart' + id).show();
	}
}
var ex_pak = {
	url: 'index.php?route=extension/module/ex_pak/',
	loader:'<div class="dop-tovary-loader"></div>',
	overlay:'<div class="dop-tovary-overlay"></div>',

	initTab: function(){
		$('#tab-design').after('<div class="tab-pane" id="tab-dop-tovary">' + this.loader + '</div>');
		this.query('tab', {'ex_pak' : {'product_id': getURLVar('product_id')}}, ex_pak.initTabCallback);

		$('body').on('hide.bs.modal', '.modal',  function (e) {
			$('.modal').remove();
			$('.modal-backdrop').remove();
		});
	},

	initTabCallback: function(result){
		if(result['html']){
			$('#tab-dop-tovary').html(result['html']);
			ex_pak_list.init();
			ex_pak_group.init();
			ex_pak_complect.init();
		}
	},

	getSetting: function(){
		if(ex_pak_setting != undefined){
			return ex_pak_setting;
		} else {
			return false;
		}
	},

	addGroup: function(){
		this.overlayOn('#tab-dop-tovary');
		this.removeAlerts();
		data = this.getTabData() + '&action=addGroup';
		result = ex_pak.query('tab', data);
		if(result['html']){
			$('#tab-dop-tovary').html(result['html']);
		}
		this.overlayOff();
	},

	removeAlerts: function(){
		$('#tab-dop-tovary .alert').remove();
	},

	getTabData: function(query_data){
		tab_data = $('#tab-dop-tovary :input').serialize();
		if(query_data != undefined){
			for(key in query_data){
				tab_data += '&ex_pak[' + key + ']=' + query_data[key];
			}
		}
		return tab_data;
	},

	setEvenOddBlocks: function(selector){
		if($(selector).children().length % 2){
			$(selector).addClass('odd-items');
		} else {
			$(selector).addClass('even-items');
		}
	},

	showModal: function(query, data, callback){
		ex_pak.overlayOn('body');
		ex_pak.query(query, data, [ex_pak.showModalCallback, callback]);
	},

	showModalCallback: function(result){
		if(result['html']){
			ex_pak.modal(result['html']);
		}
		ex_pak.overlayOff();
		return result;
	},

	modal: function(html){
		$('.modal').remove();
		$('.modal-backdrop').remove();
		$('#tab-dop-tovary').append(html);
		$('#tab-dop-tovary .modal').modal('show');
	},

	calendar: function(selector){
		$(selector).datetimepicker({
			pickTime: false,
			useCurrent: false,
		});
	},

	overlayOn: function(target){
		$(target).append(this.loader);
		$(target).append(this.overlay);
	},

	overlayOff: function(){
		$('.dop-tovary-loader').remove();
		$('.dop-tovary-overlay').remove();
	},

	query: function(func, data, callbacks){
		let result = false;

		if(typeof callbacks != 'undefined'){
			async = true;
		} else {
			callbacks = false;
			async = false;
		}
		$.ajax({
			url: this.url + func + '&user_token=' + getURLVar('user_token'),
			type: 'post',
			data: data,
			dataType: 'json',
			async: async,
			beforeSend: function() {},
			complete: function() {},
			success: function(json) {
				if(callbacks){
					if(Array.isArray(callbacks)){
						for(i in callbacks){
							if(callbacks[i] != undefined){
								callbacks[i](json);
							}
						}
					} else {
						callbacks(json);
					}
				} else {
					result = json;
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
		return result;
	}
}
var ex_pak_list = {

	init:function(){
		//List group open 
		$('body').on('click', '#tab-dop-tovary .button-group-open', function(){
			$(this).parents('.group').toggleClass('active');
		});

		// List group remove 
		$('body').on('click', '#tab-dop-tovary .button-group-remove', function(){
			$(this).parents('.group').next('.group-setting').remove();
			$(this).parents('.group').remove();
			return false;
		});

		// List product check
		$('body').on('change', '#tab-dop-tovary .group-list .group-products .check', function(){
			ex_pak_list.setProductCheck(ex_pak_list.getGroup(this));
		});

		// List check/uncheck all
		$('body').on('change', '#tab-dop-tovary .group-list .group-products .check-all', function(){
			group = ex_pak_list.getGroup(this);
			group.find('.group-products .product .check').prop('checked', $(this).is(':checked'));
			ex_pak_list.setProductCheck(group);
		});

		// Toolbar check all
		$('body').on('click', '#tab-dop-tovary .group-list .toolbar .check-all', function(){
			group = ex_pak_list.getGroup(this);
			group.find('.group-products .check-all').prop('checked', true).trigger('change');
			return false;
		});

		// Toolbar uncheck all
		$('body').on('click', '#tab-dop-tovary .group-list .toolbar .uncheck-all', function(){
			group = ex_pak_list.getGroup(this);
			group.find('.group-products .check-all').prop('checked', false).trigger('change');
			return false;
		});

		// List product remove
		$('body').on('click', '#tab-dop-tovary .group-list .button-product-remove', function(){
			group = ex_pak_list.getGroup(this);
			$(this).parents('.product').remove();
			ex_pak_list.checkNoProducts(group);
			return false;
		});

		// List all products remove
		$('body').on('click', '#tab-dop-tovary .group-list .button-products-remove', function(){
			group = ex_pak_list.getGroup(this);
			group.find('.group-products .check:checked').each(function(){
				$(this).parents('.product').remove();
			});
			ex_pak_list.checkNoProducts(group);
			return false;
		});

		// List all products remove
		$('body').on('change', '#tab-dop-tovary .group-list .toolbar-show-in-checkout input', function(){
			group = ex_pak_list.getGroup(this);
			show_in_checkout_status = $(this).prop('checked')

			if(group.find('.group-products .check:checked').length){
				group.find('.group-products .check:checked').each(function(){
					$(this).parents('.product').find('.product-show-in-checkout input').prop('checked', show_in_checkout_status);
				});
				ex_pak_list.checkNoProducts(group);
			}

			return false;
		});
	},


	getGroup: function(el){
		return $(el).parents('.group-setting');
	},

	getGroupId: function(el){
		return $(el).parents('.group-setting').attr('data-group-id');
	},

	setProductCheck: function(group){
		product_list = group.find('.group-products');

		product_all = product_list.find('.check').length;
		product_selected = product_list.find('.check:checked').length;

		group.find('.toolbar .count').text(product_selected);

		if(product_selected == product_all){
			product_list.find('.check-all').prop('checked', true);
		} else {
			product_list.find('.check-all').prop('checked', false);
		}

		if(product_selected){
			group.addClass('product-checked');
		} else {
			group.removeClass('product-checked');
			product_list.find('.check-all').prop('checked', false);
		}

		if(group.find('.toolbar-show-in-checkout').length){
			show_in_checkout_status = true;
			product_list.find('.check:checked').each(function(){
				if(!$(this).parents('.product').find('.product-show-in-checkout input').is(':checked')){
					show_in_checkout_status = false;
				}
			});
			group.find('.toolbar-show-in-checkout input').prop('checked', show_in_checkout_status);
		}

	},

	checkNoProducts: function(group){
		group_products = group.find('.group-products');
		if(!group_products.find('.product').length){
			group_products.find('table').addClass('no-products');
		} else {
			group_products.find('table').removeClass('no-products');
		}
		this.setProductCheck(group);
	},

	addToList: function(group_id, html){
		$('#tab-dop-tovary .group-setting[data-group-id=' + group_id + '] .group-products table').removeClass('no-products');
		$('#tab-dop-tovary .group-setting[data-group-id=' + group_id + '] .group-products table tbody').prepend(html);
	}
}

var ex_pak_group = {

	init: function(){
		// Group calculator
		$('body').on('click', '#tab-dop-tovary .button-calculator', function(){
			ex_pak_group.showCalculator(ex_pak_list.getGroupId(this));
		});

		// Modal calculator - calculate
		$('body').on('click', '#tab-dop-tovary .calculator .button-calculate', function(){
			ex_pak_group.calculatorCalculate();
		});

		// Modal calculator - change button
		$('body').on('change', '#tab-dop-tovary .calculator .date', function(){
			ex_pak_group.calculatorChangeButton();
		});
		$('body').on('keyup', '#tab-dop-tovary .calculator input', function(){
			ex_pak_group.calculatorChangeButton();
		});

		// Group add products
		$('body').on('click', '#tab-dop-tovary .button-products-add', function(){
			ex_pak_group.showAddProducts(ex_pak_list.getGroupId(this));
		});

		// Modal add products - clear
		$('body').on('click', '#tab-dop-tovary .add-products .button-clear', function(){
			ex_pak_group.addProductsClear();
		});

		// Modal add products - filter
		$('body').on('click', '#tab-dop-tovary .add-products .button-filter', function(){
			ex_pak_group.addProductsFilter();
		});

		// Modal add products - add
		$('body').on('click', '#tab-dop-tovary .add-products .button-add', function(){
			ex_pak_group.addProductsAddProducts();
		});

		// Modal add products - add
		$('body').on('change', '#tab-dop-tovary .group-show-in-checkout', function(){
			group = ex_pak_list.getGroup($(this));
			if($(this).prop('checked')){
				group.addClass('show-in-checkout');
			} else {
				group.removeClass('show-in-checkout');
			}
		});

		// Modal add products - double click
		$('body').on('dblclick', '#tab-dop-tovary .add-products .products .product', function(){
			product_id = $(this).attr('data-product-id');
			ex_pak_group.addProductsAddProduct(product_id);
			return false;

		});
	},

	showCalculator: function(group_id){
		ex_pak.showModal('groupCalculator', ex_pak.getTabData({'group_id':group_id}), ex_pak_group.showCalculatorCallback);
	},
	showCalculatorCallback: function(result){
		if(result['html']){
			ex_pak.calendar('#tab-dop-tovary .calculator .date');
		}
	},
	calculatorCalculate: function(){
		group_id = $('#tab-dop-tovary .calculator').attr('data-group-id');
		ex_pak.showModal('groupCalculator', ex_pak.getTabData({'group_id':group_id, 'action':'calculate'}), ex_pak_group.calculatorCalculateCallback);
	},

	calculatorCalculateCallback: function(result){
		if(result['html']){
			ex_pak.calendar('#tab-dop-tovary .calculator .date');
		}
		if(result['products']){
			for (i in result['products']) {
				product = $('#tab-dop-tovary .group-setting[data-group-id=' + result['group_id'] + '] .product-' + result['products'][i]);
				if(result['prices'][result['products'][i]]){
					product.find('.product-price').val(result['prices'][result['products'][i]]);
				}
				if(result['date']){
					product.find('.product-date-text').text(result['date']['text']);
					product.find('.product-date-from').val(result['date']['date_from']);
					product.find('.product-date-to').val(result['date']['date_to']);
				}
			}
		}
	},
	calculatorChangeButton: function(){
		calculator_button = $('#tab-dop-tovary .calculator .button-calculate');
		if(!calculator_button.attr('data-text-default')){
			calculator_button.attr('data-text-default', calculator_button.text());
		}
		calculator_button_text = calculator_button.attr('data-text-default');
		$('#tab-dop-tovary .calculator .date').each(function(){
			if($(this).val()){
				calculator_button_text = calculator_button.attr('data-text-date');
			}
		});
		if($('#tab-dop-tovary .calculator .formula-val').val()){
			calculator_button_text = calculator_button.attr('data-text-calculate');
		}
		calculator_button.text(calculator_button_text);
	},
	showAddProducts: function(group_id){
		ex_pak.showModal('groupAddProducts', ex_pak.getTabData({'group_id':group_id}));
	},

	addProductsClear: function(){
		ex_pak.overlayOn('#tab-dop-tovary .modal .modal-content');
		group_id = $('#tab-dop-tovary .add-products').attr('data-group-id');
		ex_pak.query('groupAddProducts', ex_pak.getTabData({'group_id':group_id, 'action': 'clear'}), ex_pak_group.addProductsClearCallback);
	},

	addProductsClearCallback: function(result){
		ex_pak.overlayOff();
		if(result['html']){
			$('#tab-dop-tovary .add-products .modal-content').replaceWith($(result['html']).find('.modal-content'));
		}
	},

	addProductsFilter: function(){
		ex_pak.overlayOn('#tab-dop-tovary .modal .modal-content');
		group_id = $('#tab-dop-tovary .add-products').attr('data-group-id');
		ex_pak.query('groupAddProducts', ex_pak.getTabData({'group_id':group_id, 'action': 'filter'}), ex_pak_group.addProductsFilterCallback);
	},

	addProductsFilterCallback: function(result){
		ex_pak.overlayOff();
		if(result['html']){
			$('#tab-dop-tovary .add-products .result-products').replaceWith($(result['html']).find('.result-products'));
		}
	},

	addProductsAddProduct: function(product_id){
		ex_pak.overlayOn('#tab-dop-tovary .modal-content');
		group_id = $('#tab-dop-tovary .add-products').attr('data-group-id');
		$('#tab-dop-tovary .add-products input[name="ex_pak[add_product][product_id]"]').val(product_id);
		ex_pak.query('groupAddProducts', ex_pak.getTabData({'group_id':group_id, 'action': 'addProduct'}), ex_pak_group.addProductsAddProductsCallback);
	},
	addProductsAddProducts: function(){
		ex_pak.overlayOn('#tab-dop-tovary .modal-content');
		group_id = $('#tab-dop-tovary .add-products').attr('data-group-id');
		ex_pak.query('groupAddProducts', ex_pak.getTabData({'group_id':group_id, 'action': 'addProducts'}), ex_pak_group.addProductsAddProductsCallback);
	},
	addProductsAddProductsCallback: function(result){
		if(result['products_html']){
			ex_pak_list.addToList(result['group_id'], result['products_html']);
		}
		if(result['added_products']){
			for(i in result['added_products']){
				$('#tab-dop-tovary .add-products .products .product[data-product-id=' + result['added_products'][i] + ']').remove();
			}
		}
		ex_pak.overlayOff();
	}
};

var ex_pak_complect = {
	init: function(){
		// complect-form - autocomplete
		$('body').on('keyup', '#tab-dop-tovary .complect-form .product-search', function(e){
			value = $('#tab-dop-tovary .complect-form .product-search').val();
			if(value){
				//$('#tab-dop-tovary .complect-form').addClass('active-search');
				$('#tab-dop-tovary .complect-form .autocomplete').append(ex_pak.loader)
				setTimeout(function(){
					if(!$('#tab-dop-tovary .complect-form .autocomplete').hasClass('loading')){
						$('#tab-dop-tovary .complect-form .autocomplete').addClass('loading');
						ex_pak.query('complectForm', ex_pak.getTabData({'action':'autocomplete'}), ex_pak_complect.autocompleteCallback);
					}
				}, 200);
			} else {
				//$('#tab-dop-tovary .complect-form').removeClass('active-search');
				$('#tab-dop-tovary .complect-form .autocomplete .result').html('');
			}
		});

		// complect-form - select autocomplete product
		$('body').on('click', '#tab-dop-tovary .complect-form .result .product', function(){
			ex_pak.overlayOn('#tab-dop-tovary .complect-form');
			$('#tab-dop-tovary .complect-form .finded-product').val($(this).attr('data-product-id'));
			ex_pak.query('complectForm', ex_pak.getTabData({'action':'add_product'}), ex_pak_complect.addProductCallback);
		});

		// complect-form - delete product
		$('body').on('click', '#tab-dop-tovary .complect-form .complect-products .product .button-product-remove', function(){
			$(this).parents('.product').remove();
		});

		// complect-form - save
		$('body').on('click', '#tab-dop-tovary .complect-form .complect-form-save', function(){
			ex_pak.overlayOn('#tab-dop-tovary .complect-form');
			ex_pak.query('complectForm', ex_pak.getTabData({'action':'save'}), ex_pak_complect.saveCallback);
		});

		// complect discount - on page load
		ex_pak_complect.calcProductListDiscount('#tab-dop-tovary .complect-list .group-products .product');

		// complect discount - on input change 
		$('body').on('change keyup', '#tab-dop-tovary .calc-complect-discount', function(){
			ex_pak_complect.calcProductDiscount($(this).parents('.product'));
		});
	},
	showForm: function(complect_row){
		data = {};
		if(complect_row != undefined){
			data = {'complect_row': complect_row };
		}
		ex_pak.showModal('complectForm', ex_pak.getTabData(data), ex_pak_complect.showFormCallback);
	},
	showFormCallback: function(result){
		if(result['html']){
			ex_pak.setEvenOddBlocks('#tab-dop-tovary .complect-form .languages-list');
			ex_pak.calendar('#tab-dop-tovary .complect-form .date');
			ex_pak_complect.calcProductListDiscount('#tab-dop-tovary .complect-form .complect-products .product');
		}
	},
	autocompleteCallback: function(result){
		ex_pak.overlayOff();
		$('#tab-dop-tovary .complect-form .autocomplete').removeClass('loading');
		if(result['html']){
			$('#tab-dop-tovary .complect-form .autocomplete .result').replaceWith($(result['html']).find('.autocomplete .result'));
		}
	},
	addProductCallback: function(result){
		ex_pak.overlayOff();
		$('#tab-dop-tovary .complect-form .product-search').val('');
		//$('#tab-dop-tovary .complect-form').removeClass('active-search');
		$('#tab-dop-tovary .complect-form .result').html('');

		if(result['html']){
			$('#tab-dop-tovary .complect-form .complect-products').replaceWith($(result['html']).find('.complect-products'));
			ex_pak_complect.calcProductListDiscount('#tab-dop-tovary .complect-form .complect-products .product');
		}
	},
	saveCallback: function(result){
		if(result['complect']){
			$('#tab-dop-tovary .modal .close').trigger('click');

			complect_selector = '#tab-dop-tovary .complect-list .group[data-complect-row="' + result['complect']['complect_row'] + '"]';
			complect_setting_selector = '#tab-dop-tovary .complect-list .group-setting[data-complect-row="' + result['complect']['complect_row'] + '"]';

			if($(complect_selector).length){
				sort_order = $(complect_selector).find('.complect-sort-order').val();
				$(complect_setting_selector).remove();
				$(complect_selector).replaceWith(result['complect']['html']);
				$(complect_selector).find('.complect-sort-order').val(sort_order);
			} else {
				$('#tab-dop-tovary .complect-list .complect-list-body').append(result['complect']['html']);
				$('#tab-dop-tovary .complect-list').addClass('active');
			}

			$(complect_selector).addClass('active');
			ex_pak_list.checkNoProducts($(complect_setting_selector));
			ex_pak_complect.calcProductListDiscount(complect_setting_selector + ' .product');

		} else if(result['html']){
			ex_pak.modal(result['html']);
			ex_pak.calendar('#tab-dop-tovary .complect-form .date');
			ex_pak.overlayOff();
		}
	},
	calcProductListDiscount: function(list_selector){
		$(list_selector).each(function(){
			ex_pak_complect.calcProductDiscount($(this));
		});;
	},
	calcProductDiscount: function(product){
		price = product.find('.result-price').attr('data-price');
		discount_type = product.find('.discount-type').val();
		discount_value = product.find('.discount-value').val();

		discount = 0;
		if(discount_type == 'procent'){
			discount = price * discount_value / 100;
		} else if(discount_type == 'sum'){
			discount = discount_value;
		}

		result_price = price - discount;
		result_price = Math.round(result_price * 100) / 100
		result_price = result_price.toFixed(2);

		setting = ex_pak.getSetting();
		if(setting.currency){
			if(setting.currency.value){
				result_price = result_price * setting.currency.value;
				result_price = result_price.toFixed(2);
			}
			if(setting.currency.symbol_left){
				result_price = setting.currency.symbol_left + result_price;
			}
			if(setting.currency.symbol_right){
				result_price = result_price + setting.currency.symbol_right;
			}

		}

		product.find('.result-price').text(result_price);
	},
};

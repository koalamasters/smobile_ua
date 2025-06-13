var ex_pak = {
	url: 'index.php?route=extension/module/ex_pak/',
	setting: {},
	init: function (setting) {
		if (setting) {
			this.setting = JSON.parse(setting);
		}
		// Button cart
		$('body').on('click', '.dop-product-product-list .product .button-cart', function () {
			data = ex_pak_cart.getProductData($(this));
			if ($(this).hasClass('in-cart')) {
				ex_pak_cart.remove(data);
			} else {
				ex_pak_cart.add(data);
			}
			return false;
		});
	},
	setCategories: function (selector, mobile_status) {
		window_width = $(window).width();
		animation_duration = 300;
		$(selector + ' .dop-product-categories').each(function () {
			wrap = $(this);
			if (!wrap.hasClass('init')) {
				wrap.addClass('init');
				category_list = wrap.find('.category-list');

				if ((window_width > 991) || mobile_status) {
					category_list.find('.toggle a').on('click', function () {
						category_list = $(this).parents('.category-list');
						hidden_categories = category_list.find('.hidden');
						animation_per_category = Math.round(animation_duration / hidden_categories.length, 2);
						delay = 0;
						if (category_list.hasClass('open')) {
							category_list.animate({height: category_list.attr('data-min-height')}, animation_duration, function () {
								category_list.removeClass('open');
							});
							iterator = 0;
							an_interval = setInterval(function () {
								if (hidden_categories[iterator]) {
									$(hidden_categories[iterator]).removeClass('show');
								} else {
									clearInterval(an_interval);
								}
								iterator++;
							}, animation_per_category);
						} else {
							category_list.addClass('open');

							category_list.animate({height: category_list.attr('data-max-height')}, animation_duration);

							iterator = 0;
							an_interval = setInterval(function () {
								if (hidden_categories[iterator]) {
									$(hidden_categories[iterator]).addClass('show');
								} else {
									clearInterval(an_interval);
								}
								iterator++;
							}, animation_per_category);
						}
					});
				}

				category_list.find('.category').on('click', function () {
					wrap = $(this).parents('.dop-product-categories');
					wrap.find('.active').removeClass('active');
					$(this).addClass('active');
					wrap.find('.category-content-' + $(this).attr('data-category-id')).addClass('active');
					if (wrap.find('.category-list').attr('data-callback')) {
						callback = wrap.find('.category-list').attr('data-callback').split('.');
						if (callback.length == 2) {
							window[callback[0]][callback[1]]();
						} else {
							window[callback]();
						}
					}
				});

				if (category_list.length) {
					if (!category_list.find('.active').length) {
						category_list.find('.category:first-child').trigger('click');
					}
					if ((window_width > 991) || mobile_status) {
						min_height = category_list.height();
						category_list.addClass('full');
						max_height = category_list.height();
						category_list.removeClass('full');
						if (max_height > min_height) {
							// need toggle
							category_list.addClass('with-toglle');
							category_list.attr('data-min-height', min_height);
							category_list.attr('data-max-height', max_height);
							category_list_ofset_left = category_list.offset().left + category_list.width();
							category_list.find('.category').each(function () {
								if ($(this).offset().left > category_list_ofset_left) {
									$(this).addClass('hidden');
								}
							});
						}
					}
				}
			}
		});
	},

	setShowMore: function (selector) {
		window_width = $(window).width();
		if (window_width < 991) {
			hidden_elements_class = 'hide_mobile';
		} else if (window_width < 1200) {
			hidden_elements_class = 'hide_tablet';
		} else {
			hidden_elements_class = 'hide_desktop';
		}
		$(selector + ' .dop-product-product-list[data-show-more]').each(function () {
			if ($(this).find('.' + hidden_elements_class).length) {
				$(this).append('<a class="button-show-more"><span>' + $(this).attr('data-text-show') + '</span><div><img src="catalog/view/javascript/ex_pak/images/show-more-icon.svg" alt="" width="8" height="8"></div></a>')
				$(this).addClass('show-more')
			}
		});
		$('body').on('click', '.dop-product-product-list .button-show-more', function () {
			product_list = $(this).parents('.dop-product-product-list');
			if (product_list.hasClass('show')) {
				product_list.removeClass('show');
				$(this).find('span').text(product_list.attr('data-text-show'));
				$(this).find('img').attr('src', 'catalog/view/javascript/ex_pak/images/show-more-icon.svg');
				product_list.find('.' + hidden_elements_class).hide();
			} else {
				product_list.addClass('show');
				$(this).find('span').text(product_list.attr('data-text-hide'));
				$(this).find('img').attr('src', 'catalog/view/javascript/ex_pak/images/show-more-icon-minus-black.svg');
				product_list.find('.' + hidden_elements_class).css('display', 'inline-block');
			}
		});
	},

	setSlider: function (selector, setting, mobile_status) {
		if ($(window).width() > 991 || mobile_status) {
			if ($(selector + ' .swiper').length) {
				if (!$(selector + ' .swiper').hasClass('swiper-initialized')) {
					slider_setting = {
						shortSwipes: false,
						onlyExternal: true,
						noSwiping: true,
						slidesPerView: 3,
						slidesPerGroup: 1,
						spaceBetween: 10,
						navigation: {},
						breakpoints: {},
						on: {
							init: function () {
								if (this.isLocked) {
									$(this.$el).parent().addClass('locked');

								}
							},
						},
					};
					for (i in setting) {
						slider_setting[i] = setting[i];
					}
					return new Swiper(selector + ' .swiper', slider_setting);
				}
			}
		}
		return false;
	},

	setHtml: function (selector, type, html) {
		if (type == 'before') {
			$(selector).before(html);
		} else if (type == 'after') {
			$(selector).after(html);
		} else if (type == 'prepend') {
			$(selector).prepend(html);
		} else if (type == 'append') {
			$(selector).append(html);
		}
	},
	setSelectorHtml: function (page, selector, html) {
		if (ex_pak.setting) {
			if (ex_pak.setting.selectors) {

				if (ex_pak.setting.selectors[page]) {
					if (ex_pak.setting.selectors[page][selector]) {
						if (ex_pak.setting.selectors[page][selector]['value'] && ex_pak.setting.selectors[page][selector]['type']) {
							ex_pak.setHtml(ex_pak.decodeHTMLEntities(ex_pak.setting.selectors[page][selector]['value']), ex_pak.setting.selectors[page][selector]['type'], html);
						}
					}
				}
			}
		}
	},
	decodeHTMLEntities: function (str) {
		var element = document.createElement('div');

		if (str && typeof str === 'string') {
			str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
			str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
			element.innerHTML = str;
			str = element.textContent;
			element.textContent = '';
		}
		return str;
	},

	modal: function (html) {
		$('.modal').remove();
		$('.modal-backdrop').remove();
		$('body').append(html);
		$('.modal.dop-product').modal('show');
	},

	query: function (func, data, callbacks) {
		let result = false;

		if (typeof callbacks != 'undefined') {
			async = true;
		} else {
			callbacks = false;
			async = false;
		}

		$.ajax({
			url: this.url + func,
			type: 'post',
			data: data,
			dataType: 'json',
			async: async,
			beforeSend: function () {
			},
			complete: function () {
			},
			success: function (json) {
				if (callbacks) {
					if (Array.isArray(callbacks)) {
						for (i in callbacks) {
							if (callbacks[i] != undefined) {
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
			error: function (xhr, ajaxOptions, thrownError) {
				//console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
		return result;
	},
}

var ex_pak_cart = {
	add: function (data) {
		result = ex_pak.query('addToCart', data);
		ex_pak_cart.result(result);
	},
	remove: function (data) {
		result = ex_pak.query('removeFromCart', data);
		ex_pak_cart.result(result);
	},
	result: function (result) {
		if (result['html']) {
			ex_pak.modal(result['html']);
			$('.dop-product-product-option [data-toggle="tooltip"]').tooltip()
		}
		if (result['success']) {
			if (result['cart_product_key']) {
				if (result['default_product_key'] != result['cart_product_key_without_main']) {
					if (ex_pak_cart_page.isCartPage() || ex_pak_checkout_page.isCheckoutPage()) {
						product = $('.product[data-main-product-id="' + result['main_product_id'] + '"][data-default-product-key="' + result['cart_product_key_without_main'] + '"]');
					} else {
						product = $('.product[data-main-product-id="' + result['main_product_id'] + '"][data-default-product-key="' + result['default_product_key'] + '"]');
					}
				} else {
					product = $('.product[data-default-product-key="' + result['default_product_key'] + '"]');
				}
				same_products = $('.product[data-default-product-key="' + result['cart_product_key'] + '"]');
				in_cart_products = $('.product[data-cart-product-key="' + result['cart_product_key'] + '"]');
				if (result['action'] == 'add') {
					product.attr('data-cart-product-key', result['cart_product_key']).find('.button-cart').addClass('in-cart');
					same_products.attr('data-cart-product-key', result['cart_product_key']).find('.button-cart').addClass('in-cart');
				} else {
					in_cart_products.attr('data-cart-product-key', '').find('.button-cart').removeClass('in-cart');
				}
				if ($('.dop-product-product-info').hasClass('show')) {
					$('.dop-product-product-info input[name="cart_product_key"]').val(result['cart_product_key']);
				}
			}
			//console.log(result);
			if (typeof scNotify !== "undefined") {
				scNotify('success', result['success']);
			}
			if (typeof update !== "undefined") {
				update(this, 'update');
			}
			//setTimeout(function () {
			//	if (document.querySelector('.rm-page-title')) {
			//		location.reload();
			//	}
			//	if (document.querySelector('.rm-main-shop-title')) {
			//		location.reload();
			//	}
			//}, 1500);
			setTimeout(function () {
				$('#cart .header-buttons-cart-quantity').html(result['total_products']);
				$('.rm-header-cart-text').html(result['total_amount']);
			}, 100);
		}
	},
	getProductData: function (element) {
		button_data = {};
		product = element.parents('.product');
		if (product.attr('data-main-product-id') != undefined) {
			button_data['main_product_id'] = product.attr('data-main-product-id');
		}
		if (product.attr('data-group-id') != undefined) {
			button_data['group_id'] = product.attr('data-group-id');
		}
		if (product.attr('data-group-product-id') != undefined) {
			button_data['group_product_id'] = product.attr('data-group-product-id');
		}
		if (product.attr('data-kit-id') != undefined) {
			button_data['complect_id'] = product.attr('data-kit-id');
		}
		if (product.attr('data-kit-product-id') != undefined) {
			button_data['complect_product_id'] = product.attr('data-kit-product-id');
		}
		if (product.attr('data-default-product-key') != undefined) {
			button_data['default_product_key'] = product.attr('data-default-product-key');
		}
		if (product.attr('data-cart-product-key') != undefined) {
			button_data['cart_product_key'] = product.attr('data-cart-product-key');
		}
		return button_data;
	},
}

var ex_pak_product_options = {
	init: function () {
		$('body').on('click', '.dop-product-product-option .button-add-options', function () {
			ex_pak_product_options.submitProductOptions();
		});
		$('body').on('change', '.dop-product-product-option input', function () {
			ex_pak_product_options.calcProductPrice();
		});
	},
	submitProductOptions: function () {
		data = ex_pak_product_options.getData();
		if ($('.dop-product-product-info').hasClass('show')) {
			product_info_data = ex_pak_product_info.getData();
			for (i in product_info_data) {
				if (product_info_data[i]) {
					data[i] = product_info_data[i];
				}
			}
		}

		result = ex_pak.query('addToCart', data);
		if (result['success']) {
			$('.dop-product-product-option button.modal-close').trigger('click');
		}
		if (result['error']) {
			if (result['error']['option']) {
				$('.dop-product-product-option #ex-product-options-box .text-danger').remove();

				for (product_id in result['error']['option']) {
					product_option_block = $('.dop-product-product-option .products .product-' + product_id + ' #ex-product-options-box')
					let errorOption = '';
					for (j in result['error']['option'][product_id]) {
						option_error = result['error']['option'][product_id][j];
						var element = product_option_block.find('#input-option' + j.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + option_error + '</div>');
						} else {
							element.after('<div class="text-danger">' + option_error + '</div>');
						}
						errorOption += '<div class="alert-text-item">' + option_error + '</div>';
					}
					scNotify('danger', errorOption);
				}
			}
		}
		result['html'] = false;
		ex_pak_cart.result(result);
	},
	getData: function () {
		ex_pak_product_option_data = {};
		$('.dop-product-product-option .modal-body input[type=\'text\'], .dop-product-product-option .modal-body input[type=\'hidden\'], .dop-product-product-option .modal-body input[type=\'radio\']:checked, .dop-product-product-option .modal-body input[type=\'checkbox\']:checked, .dop-product-product-option .modal-body select, .dop-product-product-option .modal-body textarea').each(function () {
			ex_pak_product_option_data[$(this).attr('name')] = $(this).val();
		});
		return ex_pak_product_option_data;
	},
	calcProductPrice: function () {
		data = ex_pak_product_options.getData();
		data['calculate_price'] = true;
		ex_pak.query('addToCart', data, ex_pak_product_options.calcProductPriceCallback);
	},
	calcProductPriceCallback: function (result) {
		if (result['total_price']) {
			price_html = '';
			if (result['total_special']) {
				price_html += '<div class="old-price">';
				price_html += '<span>' + result['total_price'] + '</span>';
				if (result['total_discount_procent']) {
					price_html += '<div class="procent-discount">-' + result['total_discount_procent'] + '%</div>';
				}
				price_html += '</div>';
				price_html += '<div class="new-price">' + result['total_special'] + '</div>';
			} else {
				price_html += '<div class="new-price">' + result['total_price'] + '</div>';
			}
			$('.dop-product-product-option .price').html(price_html);
		}
	}
}

var ex_pak_product_info = {
	init: function () {
		$('body').on('click', '.dop-product-show-product-info', function (event) {
			event.preventDefault();
			data = ex_pak_cart.getProductData($(this));
			ex_pak_product_info.show(data);
			return false;
		});
		$('body').on('click', '.dop-product-product-info button.modal-close', function () {
			$('.dop-product-product-info').remove();
		});
		$('body').on('click', '.dop-product-product-info .info .button-cart', function () {
			ex_pak_product_info.submit();
			return false;
		});
		$('body').on('change', '.dop-product-product-info .info input', function () {
			ex_pak_product_info.calcProductPrice();
		});
	},

	show: function (data) {
		result = ex_pak.query('productInfo', data);
		if (result['html']) {
			$('body').append(result['html']);
			left = (window.innerWidth - $('.dop-product-product-info .body').width()) / 2;
			$('.dop-product-product-info .body').css('left', left);
			$('.dop-product-product-info').addClass('show');
			$('body').addClass('modal-open');

			if ($.fn.datetimepicker) {
				$('.dop-product-product-info .date').datetimepicker({
					pickTime: false
				});

				$('.dop-product-product-info .datetime').datetimepicker({
					pickDate: true,
					pickTime: true
				});

				$('.dop-product-product-info .time').datetimepicker({
					pickDate: false
				});
			} else {
				console.warn('datetimepicker is not loaded.');
			}


			$('.dop-product-product-info [data-toggle="tooltip"]').tooltip()
		}
	},

	submit: function () {
		$('.dop-product-product-info .body .text-danger').remove();

		if ($('.dop-product-product-info .info .button-cart').hasClass('in-cart')) {
			result = ex_pak.query('removeFromCart', ex_pak_product_info.getData());
			$('.dop-product-product-info .product input[name="cart_product_key"]').val('');
			$('.dop-product-product-info .info .button-cart').removeClass('in-cart');
		} else {
			result = ex_pak.query('addToCart', ex_pak_product_info.getData());
			if (result['cart_product_key']) {
				$('.dop-product-product-info .product input[name="cart_product_key"]').val(result['cart_product_key']);
				$('.dop-product-product-info .info .button-cart').addClass('in-cart');
			}
		}

		if (result['error']) {
			if (result['error']['option']) {
				$(".dop-product-product-info #ex-product-options-box .text-danger").remove();

				sub_product_id = false;
				if (result['complect_product_id']) {
					sub_product_id = result['complect_product_id'];
				} else if (result['group_product_id']) {
					sub_product_id = result['group_product_id'];
				}

				for (product_id in result['error']['option']) {
					if (product_id != sub_product_id) {
						ex_pak.modal(result['html']);
						return;
					}
				}

				for (product_id in result['error']['option']) {
					product_option_block = $('.dop-product-product-info #ex-product-options-box')
					let errorOption = '';
					for (j in result['error']['option'][product_id]) {
						option_error = result['error']['option'][product_id][j];
						var element = product_option_block.find('#input-option' + j.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + option_error + '</div>');
						} else {
							element.after('<div class="text-danger">' + option_error + '</div>');
						}
						errorOption += '<div class="alert-text-item">' + option_error + '</div>';
					}
					scNotify('danger', errorOption);
				}
			}
		}

		result['html'] = false;
		ex_pak_cart.result(result);
	},
	getData: function () {
		ex_pak_product_info_data = {};
		$('.dop-product-product-info .body input[type=\'text\'], .dop-product-product-info .body input[type=\'hidden\'], .dop-product-product-info .body input[type=\'radio\']:checked, .dop-product-product-info .body input[type=\'checkbox\']:checked, .dop-product-product-info .body select, .dop-product-product-info .body textarea').each(function () {
			ex_pak_product_info_data[$(this).attr('name')] = $(this).val();
		});
		return ex_pak_product_info_data;
	},
	calcProductPrice: function () {
		data = ex_pak_product_info.getData();
		data['calculate_price'] = true;
		ex_pak.query('addToCart', data, ex_pak_product_info.calcProductPriceCallback);
	},
	calcProductPriceCallback: function (result) {
		if (result['total_price']) {
			price_html = '';
			if (result['total_special']) {
				price_html += '<div class="price-old">' + result['total_special'] + '</div>';
				price_html += '<div class="price-new">' + result['total_special'] + '</div>';
			} else {
				price_html += '<div class="price-new">' + result['total_price'] + '</div>';
			}
			$('.dop-product-product-info .body .product-wrap .info .price').html(price_html);
		}
	},
	close: function () {
		$('body').removeClass('modal-open');
		$('.dop-product-product-info').remove();
	},
}

var ex_pak_product_page = {
	init: function (product_id, setting) {
		ex_pak.init(setting);
		ex_pak_product_options.init();
		ex_pak_product_info.init();
		ex_pak_product_page.getMain(product_id);
		ex_pak_product_page.getComplects(product_id);
		ex_pak_product_page.getTabs(product_id);
	},
	getMain: function (product_id) {
		if (ex_pak.setting) {
			if (ex_pak.setting.selectors) {
				if (ex_pak.setting.selectors.product) {
					if (ex_pak.setting.selectors.product.products) {
						if (ex_pak.setting.selectors.product.products.value && ex_pak.setting.selectors.product.products.type) {
							ex_pak.query('productMain', {'product_id': product_id}, ex_pak_product_page.getMainCallback);
						}
					}
				}
			}
		}
	},
	getMainCallback: function (result) {
		if (result['html']) {
			ex_pak.setSelectorHtml('product', 'products', result['html']);
		}
	},
	getComplects: function (product_id) {
		ex_pak.query('productComplects', {'product_id': product_id}, ex_pak_product_page.getComplectsCallback);
	},
	getComplectsCallback: function (result) {
		if (result['html']) {
			ex_pak.setSelectorHtml('product', 'complects', result['html']);
			ex_pak.setCategories('.dop-product-kits');
			$('.dop-product-kits > .complect').each(function () {
				ex_pak_product_page.setComplectSlider($(this));
			});
			$('body').on('click', '.dop-product-kits .dop-product-categories .category', function () {
				ex_pak_product_page.setComplectSlider($(this).parents('.complect'));
			});
		}
	},
	setComplectSlider: function (complect) {
		slider_selector = '.dop-product-kits .' + complect.attr('class').split(' ').join('.') + ' .category-content.active';
		setting = {
			slidesPerView: 1,
			navigation: {
				prevEl: slider_selector + ' .swiper-button.prev',
				nextEl: slider_selector + ' .swiper-button.next',
			},
			pagination: {
				el: '.swiper-pagination',
				type: 'bullets',
			},
			breakpoints: {
				991: {slidesPerView: 1},
			},
		}
		ex_pak.setSlider(slider_selector, setting, true);

	},
	getTabs: function (product_id) {
		ex_pak.query('productTabs', {'product_id': product_id}, ex_pak_product_page.getTabsCallback);
	},
	getTabsCallback: function (result) {
		if (result['tabs']) {
			nav_html = '';
			tab_html = '';
			for (i in result['tabs']) {
				tab_id = result['tabs'][i]['group_id'];

				if (result['tabs'][i]['name_tab']) {
					tab_name = result['tabs'][i]['name_tab'];
				} else {
					tab_name = result['tabs'][i]['name'];
				}

				//nav_html += '<li><a class="nav-dop-product nav-dop-product-' + result['tabs'][i]['group_id'] + '" data-toggle="tab" href="#' + tab_id + '">' + tab_name + '</a></li>'
				nav_html += '<div data-tab-target=".ex_product_tab_' + tab_id + '" class="sc-product-tab sc-product-tab-attributes sc-product-tab-ex-tab-' + tab_id + ' d-flex align-items-center justify-content-center">';
				nav_html += '<img src="catalog/view/theme/oct_showcase/img/sprite.svg#include--product-tab-attr-icon" alt="" width="24" height="24">';
				nav_html += '<span class="sc-product-tab-title ps-2 fsz-14">' + tab_name + '</span>';
				nav_html += '</div>';

				tab_html += '<div class="ex_product_tab_' + tab_id + ' pb-4 mb-md-4 pt-4 pt-md-0 px-3 px-lg-4 dop-product-product-tab">';
				tab_html += '    <div class="sc-product-content-title d-flex align-items-center">';
				tab_html += '        <div class="sc-product-content-title-icon d-flex align-items-center justify-content-center br-4">';
				tab_html += '            <img src="catalog/view/theme/oct_showcase/img/sprite.svg#include--product-content-attrs-icon" alt="" width="16" height="16">';
				tab_html += '        </div>';
				tab_html += '        <span class="fsz-24 fw-600 dark-text">' + tab_name + '</span>';
				tab_html += '    </div>';
				tab_html += '    <div class="dark-text fsz-14 mt-3">' + result['tabs'][i]['html'] + '</div>';
				tab_html += '</div>';
			}

			var targetTab = $('#oct-tabs > .sc-product-tab:nth-child(1)');
			var targetTabTwo = $('#oct-tabs > .sc-product-tab:nth-child(2)');

			if (targetTabTwo.length) {
				$(nav_html).insertAfter(targetTabTwo);
			} else {
				$(nav_html).insertAfter(targetTab);
			}

			var targetTabContent = $('.sc-product-content-description');
			var targetTabContentTwo = $('.sc-product-content-attributes');

			if (targetTabContentTwo.length) {
				$(tab_html).insertAfter(targetTabContentTwo);
			} else {
				$(tab_html).insertAfter(targetTabContent);
			}

			//$('.ex-kits-tabs').insertAfter(tab_html);

			//$(tabs_selection_block + ' a.nav-dop-product').on('click', function () {
			//	setTimeout(function () {
			//		ex_pak.setCategories('.dop-product-product-tab');
			//	}, 10);
			//});


			setTimeout(function () {
				ex_pak.setCategories('.dop-product-product-tab');
			}, 500);

			//ex_pak.setCategories('.dop-product-product-tab');

			ex_pak.setShowMore('.dop-product-product-tab');
		}
	},
}

var ex_pak_cart_page = {
	init: function (setting) {
		ex_pak.init(setting);
		ex_pak_product_info.init();
		ex_pak_product_options.init();
		ex_pak_product_sidebar.init();
		ex_pak_cart_page.getProducts();
	},
	getProducts: function () {
		ex_pak.query('productCheckout', {}, ex_pak_cart_page.getProductsCallback);
	},
	getProductsCallback: function (result) {
		if (result['html']) {
			ex_pak.setSelectorHtml('cart', 'products', result['html']);
			breakpoints = {
				540: {slidesPerView: 2},
				991: {slidesPerView: 4},
				1200: {slidesPerView: 5},
				1600: {slidesPerView: 6},
			};
			slider_selector = '.group-checkout-products';
			setting = {
				slidesPerView: 6,
				navigation: {
					prevEl: '.product-checkout-products-swiper-button-prev',
					nextEl: '.product-checkout-products-swiper-button-next',
				},
				breakpoints: breakpoints,
			}
			ex_pak.setSlider(slider_selector, setting, false);
		}
	},
	isCartPage: function () {
		if ($('#content').length) {
			return true;
		} else {
			return false;
		}
	},
}

var ex_pak_checkout_page = {
	init: function (setting) {
		ex_pak.init(setting);
		ex_pak_product_info.init();
		ex_pak_product_options.init();
		ex_pak_product_sidebar.init();
		ex_pak_checkout_page.getProducts();
	},
	getProducts: function () {
		ex_pak.query('productCheckout', {}, ex_pak_checkout_page.getProductsCallback);
	},
	getProductsCallback: function (result) {
		if (result['html']) {
			ex_pak.setSelectorHtml('checkout', 'products', result['html']);
			breakpoints = {
				540: {slidesPerView: 2},
				991: {slidesPerView: 2},
				1200: {slidesPerView: 3},
				1600: {slidesPerView: 4},
			};
			slider_selector = '.group-checkout-products';
			setting = {
				slidesPerView: 6,
				navigation: {
					prevEl: '.product-checkout-products-swiper-button-prev',
					nextEl: '.product-checkout-products-swiper-button-next',
				},
				breakpoints: breakpoints,
			}
			ex_pak.setSlider(slider_selector, setting, false);
		}
	},

	isCheckoutPage: function () {
		if ($('.oct-checkout').length) {
			return true;
		} else {
			return false;
		}
	}
}

var ex_pak_sidebar = {
	init: function () {
		$('body').on('click', '.dop-product-sidebar .close', function () {
			ex_pak_sidebar.close();
		});
		$('body').on('click', '.dop-product-sidebar-overlay', function () {
			ex_pak_sidebar.close();
		});
	},
	show: function (siber_selecetor) {
		$(siber_selecetor).addClass('active');
		document.body.classList.add('sp_body_no_scroll');
		$('.dop-product-sidebar-overlay').show();
	},
	close: function () {
		$('.dop-product-sidebar.active').removeClass('active');
		document.body.classList.remove('sp_body_no_scroll');
		$('.dop-product-sidebar-overlay').hide();
	}
}

var ex_pak_product_sidebar = {
	init: function () {
		ex_pak_sidebar.init();
		$('body').on('click', '.dop-product-show-product-sidebar', function () {
			ex_pak_product_sidebar.show($(this).attr('data-product-id'));
		});
		$('body').on('change', '.dop-product-product-sidebar .product-selector .control select', function () {
			ex_pak_product_sidebar.selectProduct($(this).val());
		});
	},
	show: function (product_id) {
		if ($('.dop-product-product-sidebar').length) {
			ex_pak_sidebar.show('.dop-product-product-sidebar');
			if (product_id) {
				$('.dop-product-product-sidebar .product-selector .control select').val(product_id).trigger('change');
			}
			ex_pak_product_sidebar.setScripts();
		} else {
			if (typeof product_id != 'undefined') {
				data = {'product_id': product_id};
			} else {
				data = {};
			}
			if (typeof masked !== "undefined") {
				masked('body', true);
			}
			ex_pak.query('productSidebar', data, ex_pak_product_sidebar.showCallback);
		}
	},
	showCallback: function (result) {
		if (typeof masked !== "undefined") {
			masked('body', false);
		}
		$('.dop-product-product-sidebar').remove();
		if (result['html']) {
			$('body').append(result['html']);
			ex_pak_sidebar.show('.dop-product-product-sidebar');
			ex_pak.setCategories('.dop-product-product-sidebar .product-content.active');
		}
	},
	selectProduct: function (product_id) {
		// selector image
		$('.dop-product-sidebar .product-image.active').removeClass('active');
		$('.dop-product-sidebar .product-image-' + product_id).addClass('active');
		// content selector
		$('.dop-product-sidebar .product-content.active').removeClass('active');
		$('.dop-product-sidebar .product-content-' + product_id).addClass('active');
		ex_pak.setCategories('.dop-product-product-sidebar .product-content.active');
	},
	setSlider: function () {
		slider_selector = '.dop-product-product-sidebar .product-content.active .category-content.active';
		setting = {
			slidesPerView: 3,
			navigation: {
				prevEl: slider_selector + ' .swiper-button.prev',
				nextEl: slider_selector + ' .swiper-button.next',
			},
			breakpoints: {
				991: {slidesPerView: 3},
			},
		}
		ex_pak.setSlider(slider_selector, setting, false);
	}
}
function flowyTracking_Ajax_Events_Setup() {
	if (typeof $ !== "undefined") {
		$(document).ajaxSuccess(function (event, xhr, settings, json) {
			if (settings.url.includes("checkout/cart/add") && !json.error) {
				//Measuring add to cart
				if (json['gtm_id']) {
					var object = flowyTracking_FormatJsonCart(json);
					_FlowyTracking.trackAddToCart(object);
				}
			} else if (settings.url.includes("account/wishlist/add") && !json.error) {
				//Measuring add to wishlist
				if (json['gtm_id']) {
					var object = flowyTracking_FormatJsonCart(json);
					_FlowyTracking.trackAddToWishlist(object);
				}
			} else if ((settings.url.includes("checkout/cart/remove") || settings.url.includes("extension/d_quickcheckout/cart/update")) && !json.error && typeof json['atc_id'] !== undefined) {
				//Measuring remove from cart
				if (json['gtm_id']) {
					var object = flowyTracking_FormatJsonCart(json);
					_FlowyTracking.trackRemoveFromCart(object);
				}
			}
		});
	} else {
		setTimeout(flowyTracking_Ajax_Events_Setup, 250);
	}
}

flowyTracking_Ajax_Events_Setup();

function flowyTracking_Start(result) {
	//Send main data to FlowyTracking
	var general_data = {
		'store_name': result.general_data.store_name,
		'lang': flowy_tracking_language,
		'current_view': result.general_data.current_view,
		'current_list': result.general_data.current_list,
		'current_currency': result.general_data.current_currency,
		'userId': result.general_data.userId,
		'clientId': result.general_data.clientId,
		'gclDc': result.general_data.gclDc,
		'email': result.general_data.email,
		'debug_enabled': this.debug_enabled,
	}

	_FlowyTracking.init(general_data);

	if (typeof result.products_listed !== 'undefined')
		_FlowyTracking.setProducts(result.products_listed);

	if (typeof result.promotions_listed !== 'undefined')
		_FlowyTracking.trackPromotionsListed(result.promotions_listed);

	if (typeof result.fb_api_track_info !== 'undefined')
		_FlowyTracking.setFacebookApiTrack(result.fb_api_track_info);

	if (typeof result.general_data.cart_products !== 'undefined')
		_FlowyTracking.setCartProducts(result.general_data.cart_products);

	if (typeof result.product_details !== 'undefined') {
		_FlowyTracking.trackProductPage(result.product_details);
	}

	if (
		result.general_data.current_view == 'search' &&
		typeof result.general_data.string_searched !== 'undefined' &&
		typeof result.products_listed !== 'undefined' &&
		typeof result.products_listed) {
		_FlowyTracking.trackSearchPage(result.general_data.string_searched);
	}

	if (result.general_data.current_view == 'category')
		_FlowyTracking.trackCategoryPage(result.general_data.current_categories);

	if (result.general_data.current_view == 'homepage')
		_FlowyTracking.trackHomePage();

	if (result.general_data.current_view == 'cart')
		_FlowyTracking.trackCartPage();

	if (result.general_data.current_view == 'account_success')
		_FlowyTracking.trackAccountRegistered();

	if (result.general_data.current_view == 'checkout')
		_FlowyTracking.trackCheckoutPage();

	if (typeof result.order_data !== 'undefined') {
		_FlowyTracking.trackPurchase(result.order_data, result.order_data.order.valid_status);
	}
}

function flowyTracking_FormatJsonCart(json) {
	var object_formatted = {};
	object_formatted.id = typeof json['gtm_id'] != 'undefined' ? json['gtm_id'] : '';
	object_formatted.id_ee = typeof json['gtm_id_ee'] != 'undefined' ? json['gtm_id_ee'] : '';
	object_formatted.id_gdr_1 = typeof json['gtm_id_gdr_1'] != 'undefined' ? json['gtm_id_gdr_1'] : '';
	object_formatted.id_gdr_2 = typeof json['gtm_id_gdr_2'] != 'undefined' ? json['gtm_id_gdr_2'] : '';
	object_formatted.id_fb = typeof json['gtm_id_fb'] != 'undefined' ? json['gtm_id_fb'] : '';
	object_formatted.price = typeof json['gtm_price'] != 'undefined' ? json['gtm_price'] : '';
	object_formatted.price_eur = typeof json['gtm_price_eur'] != 'undefined' ? json['gtm_price_eur'] : '';
	object_formatted.name = typeof json['gtm_name'] != 'undefined' ? json['gtm_name'] : '';
	object_formatted.category = typeof json['gtm_category'] != 'undefined' ? json['gtm_category'] : '';
	object_formatted.brand = typeof json['gtm_brand'] != 'undefined' ? json['gtm_brand'] : '';
	object_formatted.quantity = typeof json['gtm_quantity'] != 'undefined' ? json['gtm_quantity'] : 1;
	object_formatted.variant = typeof json['gtm_variant'] != '' ? json['gtm_variant'] : '';
	return object_formatted;
}

function flowyTracking_setCheckoutStep(datalayer_data) {
	var current_view = datalayer_data.general_data.current_view;

	if (current_view == 'checkout' && eeMultiChanelVisitCheckoutStep) {
		_FlowyTracking.checkoutStep(eeMultiChanelVisitCheckoutStep);
	} else if (current_view == 'purchase' && typeof measure_purchase != 'undefined' && eeMultiChanelFinishOrderStep) {
		_FlowyTracking.checkoutStep(eeMultiChanelFinishOrderStep);
	} else if (current_view == 'product' && eeMultiChanelVisitProductPageStep) {
		_FlowyTracking.checkoutStep(eeMultiChanelVisitProductPageStep);
	} else if (current_view == 'cart' && eeMultiChanelVisitCartPageStep) {
		_FlowyTracking.checkoutStep(eeMultiChanelVisitCartPageStep);
	}
}

function ft_rand(min, max) {
	if (min == 0) {
		return Math.floor((Math.random() * max) + 0);
	} else {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
}

function removeFromCart_OC15(product_id_key, quantity) {
	$.ajax({
		url: 'index.php?route=extension/module/flowytracking/get_product_datas',
		data: { product_id_key: product_id_key, quantity: quantity },
		type: "POST",
		dataType: 'json',
		beforeSend: function () {
		},
		success: function (data) {
			if (data)
				eventDataLayerRemoveFromCart(data.atc_id, data.atc_price, data.atc_name, data.atc_category, data.atc_brand, data.atc_quantity, data.atc_variant);
		},
		error: function (data) {
		},
	});
}

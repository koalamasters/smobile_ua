	<?php if (isset($remarketing_google_json) && $remarketing_google_json) { ?>
	<script>
	if (typeof sendGoogleRemarketing !== 'undefined') {
		sendGoogleRemarketing(<?php echo json_encode($remarketing_google_json); ?>);
	}
	</script> 
	<?php } ?>
	<?php if (!empty($remarketing_code)) echo $remarketing_code; ?> 
	<?php if (isset($ecommerce_status) && $ecommerce_status && !empty($ga4_datalayer)) { ?>
	<script>
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({ ecommerce: null });
	dataLayer.push(<?php echo json_encode($ga4_datalayer); ?>); 
	<?php if (!empty($ga4_click_datalayer)) { ?>
	if (typeof(localStorage.remarketing_product_id) !== 'undefined' && typeof(localStorage.remarketing_heading) !== 'undefined') {
		dataLayer.push({ ecommerce: null });
		click_data = <?php echo json_encode($ga4_click_datalayer); ?>;
		click_data.ecommerce.items[0].item_list_name = localStorage.remarketing_heading;
		dataLayer.push(click_data);
		delete localStorage.remarketing_product_id;
		delete localStorage.remarketing_heading; 
	}
	<?php } ?>
	</script> 
	<?php } ?>
	<?php if (isset($ga4_product) && $ga4_product) { ?>
	<script>
	if (typeof sendGa4Details !== 'undefined') {
		sendGa4Details(<?php echo json_encode($ga4_product); ?>, <?php echo ($measurement_ga4_status) ? 'true' : 'false'; ?>);
	} 
	</script>
	<?php } ?>
	<?php if (isset($ga4_json) && $ga4_json) { ?>
	<script>
	window.ecommerce_ga4_products = window.ecommerce_ga4_products || {};
	ecommerce_ga4_product_data = <?php echo json_encode($ga4_json); ?>;
	if (typeof sendGa4Impressions !== 'undefined') {
		sendGa4Impressions(ecommerce_ga4_product_data, <?php echo (isset($view_search_results) && $view_search_results) ? 'true' : 'false'; ?>, <?php echo ($measurement_ga4_status) ? 'true' : 'false'; ?>, '<?php echo $ga4_send_to; ?>', '<?php echo $ga4_currency; ?>');
	}
	</script>
	<?php } ?>
	<?php if (isset($facebook_remarketing_status) && $facebook_remarketing_status && !empty($facebook_data_json)) { ?>
	<script>
	if (typeof sendFacebookDetails !== 'undefined') {
		sendFacebookDetails(<?php echo json_encode($facebook_data_json); ?>);
	}
	  </script>
	<?php } ?> 
	<?php if (isset($tiktok_remarketing_status) && $tiktok_remarketing_status && !empty($tiktok_data_json)) { ?>
	<script>
	if (typeof sendTiktokDetails !== 'undefined') {
		sendTiktokDetails(<?php echo json_encode($tiktok_data_json); ?>);
	}
	  </script>
	<?php } ?> 
	<?php if (isset($facebook_remarketing_status) && $facebook_remarketing_status && !empty($facebook_data_json_category)) { ?>
	<script>
	if (typeof sendFacebookCategoryDetails !== 'undefined') {
		sendFacebookCategoryDetails(<?php echo json_encode($facebook_data_json_category); ?>, <?php echo (isset($view_search_results) && $view_search_results) ? 'true' : 'false'; ?>);
	}
	  </script>
	<?php } ?>
	<?php if (isset($esputnik_remarketing_status) && $esputnik_remarketing_status && !empty($esputnik_data_json)) { ?>
	<script>
	if (typeof sendEsputnikDetails !== 'undefined') {
		sendEsputnikDetails(<?php echo json_encode($esputnik_data_json); ?>);
	}
	</script>
	<?php } ?> 
	<?php if (isset($esputnik_remarketing_status) && $esputnik_remarketing_status && !empty($esputnik_data_category_json)) { ?>
	<script>
	if (typeof sendEsputnikCategoryDetails !== 'undefined') {
		sendEsputnikCategoryDetails(<?php echo json_encode($esputnik_data_category_json); ?>);
	}
	</script>
	<?php } ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ukrcredits" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><?php echo $oc15?$button_save:''; ?><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><?php echo $oc15?$button_cancel:''; ?><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ukrcredits" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-pp" data-toggle="tab"><?php echo $tab_pp; ?></a></li>
			<li><a href="#tab-ii" data-toggle="tab"><?php echo $tab_ii; ?></a></li>
			<li><a href="#tab-mb" data-toggle="tab"><?php echo $tab_mb; ?></a></li>
			<li><a href="#tab-ab" data-toggle="tab"><?php echo $tab_ab; ?></a></li>
			<li><a href="#tab-sb" data-toggle="tab"><?php echo $tab_sb; ?></a></li>
			<li><a href="#tab-aa" data-toggle="tab"><?php echo $tab_aa; ?></a></li>
			<li><a href="#tab-pl" data-toggle="tab"><?php echo $tab_pl; ?></a></li>
			<li><a href="#tab-pu" data-toggle="tab"><?php echo $tab_pu; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
          </ul> 
          <div class="tab-content">
            <div class="tab-pane active" id="tab-pp">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-pp"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url;?>
                  <input type="text" name="pp_shop_id" value="<?php echo $pp_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-pp" class="form-control"/>
                  <?php if ($error_shop_id_pp) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-pp"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_shop_password" value="<?php echo $pp_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-pp" class="form-control"/>
                  <?php if ($error_shop_password_pp) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="pp_status" id="input-status" class="form-control">
                    <?php if ($pp_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>		
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-pp"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-pp-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-pp-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="pp_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($pp_info[$language['language_id']])) echo $pp_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			  </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-pp"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_sort_order" value="<?php echo $pp_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-pp" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_payment_type; ?>"><?php echo $entry_payment_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_hold) { ?>
                    <input type="radio" name="pp_hold" value="1" checked="checked" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_hold" value="1" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_hold) { ?>
                    <input type="radio" name="pp_hold" value="0" checked="checked" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_hold" value="0" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_discount) { ?>
                    <input type="radio" name="pp_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_discount) { ?>
                    <input type="radio" name="pp_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_special) { ?>
                    <input type="radio" name="pp_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_special) { ?>
                    <input type="radio" name="pp_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_stock) { ?>
                    <input type="radio" name="pp_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_stock) { ?>
                    <input type="radio" name="pp_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-ii-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_pq" value="<?php echo $pp_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-ii-pq" class="form-control"/>
                  <?php if ($error_pq_pp) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_min_total" value="<?php echo $pp_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-pp_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_max_total" value="<?php echo $pp_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-pp_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_merchant_type; ?>"><?php echo $entry_merchant_type; ?></span></label>
                <div class="col-sm-10">
				  <?php echo $text_merchant_type_url;?>				
                  <label class="radio-inline">
                    <?php if ($pp_merchantType == 'PP') { ?>
                    <input type="radio" name="pp_merchantType" value="PP" checked="checked" />
                    <?php echo $entry_pp_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_merchantType" value="PP" />
                    <?php echo $entry_pp_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pp_merchantType == 'PB') { ?>
                    <input type="radio" name="pp_merchantType" value="PB" checked="checked" />
                    <?php echo $entry_pp_merchantType_period; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_merchantType" value="PB" />
                    <?php echo $entry_pp_merchantType_period; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($pp_markup_type)){$pp_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_markup_type == 'fixed') { ?>
                    <input type="radio" name="pp_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pp_markup_type == 'custom') { ?>
                    <input type="radio" name="pp_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_markup" value="<?php echo $pp_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-pp_markup" class="form-control"/>
                </div>
              </div>  
              <div id="pp_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-pp_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($pp_markup_custom_PP)) {
						$pp_markup_custom_PP = array(1 => 1.5,2 => 2.5,3 => 4.5,4 => 7,5 => 9,6 => 11.5,7 => 13.5,8 => 15.5,9 => 16.5,10 => 17,11 => 17.5,12 => 19,13 => 20.5,14 => 22,15 => 23.5,16 => 24.5,17 => 26,18 => 27,19 => 28.5,20 => 29.5,21 => 31,22 => 32,23 => 33,24 => 34.5); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($pp_markup_custom_PP, ceil(count($pp_markup_custom_PP) / 4), true) as $pp_markup_custom_PP) { ?>
							<div class="col-sm-3">
							<?php foreach ($pp_markup_custom_PP as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="pp_markup_custom_PP[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-pp_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="pp_markup_acquiring" value="<?php echo isset($pp_markup_acquiring)?$pp_markup_acquiring:'2.0'; ?>" placeholder="%" id="input-pp_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>							
					</div>
				</div>
			  </div>  			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_enabled) { ?>
                    <input type="radio" id="enabled_all_pp" name="pp_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_pp" name="pp_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_enabled) { ?>
                    <input type="radio" id="enabled_selected_pp" name="pp_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_pp" name="pp_enabled" value="0" <?php echo $pp_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_pp" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_pp" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_pp" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($pp_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_pp<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="pp_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="pp_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $pp_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

            <div class="tab-pane" id="tab-ii">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-ii"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url;?>
                  <input type="text" name="ii_shop_id" value="<?php echo $ii_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-ii" class="form-control"/>
                  <?php if ($error_shop_id_ii) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-ii"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_shop_password" value="<?php echo $ii_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-ii" class="form-control"/>
                  <?php if ($error_shop_password_ii) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="ii_status" id="input-status" class="form-control">
                    <?php if ($ii_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>		
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-ii"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-ii-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-ii-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="ii_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($ii_info[$language['language_id']])) echo $ii_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			  </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-ii"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_sort_order" value="<?php echo $ii_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-ii" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_payment_type; ?>"><?php echo $entry_payment_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_hold) { ?>
                    <input type="radio" name="ii_hold" value="1" checked="checked" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_hold" value="1" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_hold) { ?>
                    <input type="radio" name="ii_hold" value="0" checked="checked" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_hold" value="0" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_discount) { ?>
                    <input type="radio" name="ii_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_discount) { ?>
                    <input type="radio" name="ii_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_special) { ?>
                    <input type="radio" name="ii_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_special) { ?>
                    <input type="radio" name="ii_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_stock) { ?>
                    <input type="radio" name="ii_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_stock) { ?>
                    <input type="radio" name="ii_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-ii-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_pq" value="<?php echo $ii_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-ii-pq" class="form-control"/>
                  <?php if ($error_pq_ii) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_min_total" value="<?php echo $ii_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-ii_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_max_total" value="<?php echo $ii_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-ii_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_merchant_type; ?>"><?php echo $entry_merchant_type; ?></span></label>
                <div class="col-sm-10">
				  <?php echo $text_merchant_type_url;?>				
                  <label class="radio-inline">
                    <?php if ($ii_merchantType == 'II') { ?>
                    <input type="radio" name="ii_merchantType" value="II" checked="checked" />
                    <?php echo $entry_ii_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_merchantType" value="II" />
                    <?php echo $entry_ii_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($ii_merchantType == 'IA') { ?>
                    <input type="radio" name="ii_merchantType" value="IA" checked="checked" />
                    <?php echo $entry_ii_merchantType_special; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_merchantType" value="IA" />
                    <?php echo $entry_ii_merchantType_special; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($ii_markup_type)){$ii_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_markup_type == 'fixed') { ?>
                    <input type="radio" name="ii_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($ii_markup_type == 'custom') { ?>
                    <input type="radio" name="ii_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_markup" value="<?php echo $ii_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-ii_markup" class="form-control"/>
                </div>
              </div> 
              <div id="ii_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-ii_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($ii_markup_custom_II)) {
						$ii_markup_custom_II = array(1 => 1.5,2 => 2.5,3 => 4.5,4 => 6.4,5 => 7.6,6 => 8.2,7 => 8.7,8 => 9.7,9 => 10.6,10 => 11.6,11 => 12.2,12 => 12.5,13 => 12.8,14 => 13.1,15 => 13.4,16 => 13.7,17 => 14,18 => 14.3,19 => 14.7,20 => 15.5,21 => 16.2,22 => 17,23 => 17.6,24 => 18.3); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($ii_markup_custom_II, ceil(count($ii_markup_custom_II) / 4), true) as $ii_markup_custom_II) { ?>
							<div class="col-sm-3">
							<?php foreach ($ii_markup_custom_II as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="ii_markup_custom_II[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-ii_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="ii_markup_acquiring" value="<?php echo isset($ii_markup_acquiring)?$ii_markup_acquiring:'0'; ?>" placeholder="%" id="input-ii_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  	
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_enabled) { ?>
                    <input type="radio" id="enabled_all_ii" name="ii_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_ii" name="ii_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_enabled) { ?>
                    <input type="radio" id="enabled_selected_ii" name="ii_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_ii" name="ii_enabled" value="0" <?php echo $ii_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_ii" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_ii" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_ii" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($ii_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_ii<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="ii_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="ii_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $ii_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

            <div class="tab-pane" id="tab-mb">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-mb"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_mono;?>
                  <input type="text" name="mb_shop_id" value="<?php echo $mb_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-mb" class="form-control"/>
                  <?php if ($error_shop_id_mb) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-mb"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_shop_password" value="<?php echo $mb_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-mb" class="form-control"/>
                  <?php if ($error_shop_password_mb) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="mb_status" id="input-status" class="form-control">
                    <?php if ($mb_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>	
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-mb"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-mb-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-mb-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="mb_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($mb_info[$language['language_id']])) echo $mb_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($mb_mode) && $mb_mode) { ?>
                    <input type="radio" name="mb_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($mb_mode) || !$mb_mode) { ?>
                    <input type="radio" name="mb_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_mode" value="0" />
                    <?php echo $text_mode_test; ?> 
                    <?php } ?>
                  </label>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-mb"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_sort_order" value="<?php echo $mb_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-mb" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_discount) { ?>
                    <input type="radio" name="mb_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_discount) { ?>
                    <input type="radio" name="mb_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_special) { ?>
                    <input type="radio" name="mb_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_special) { ?>
                    <input type="radio" name="mb_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_stock) { ?>
                    <input type="radio" name="mb_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_stock) { ?>
                    <input type="radio" name="mb_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_merchantType == 'MB') { ?>
                    <input type="radio" name="mb_merchantType" value="MB" checked="checked" />
                    <?php echo $entry_mb_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_merchantType" value="MB" />
                    <?php echo $entry_mb_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-mb-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_pq" value="<?php echo $mb_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-mb-pq" class="form-control"/>
                  <?php if ($error_pq_mb) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_min_total" value="<?php echo $mb_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-mb_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_max_total" value="<?php echo $mb_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-mb_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($mb_markup_type)){$mb_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_markup_type == 'fixed') { ?>
                    <input type="radio" name="mb_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($mb_markup_type == 'custom') { ?>
                    <input type="radio" name="mb_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_markup" value="<?php echo $mb_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-mb_markup" class="form-control"/>
                </div>
              </div>  
              <div id="mb_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-mb_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($mb_markup_custom_MB)) {
						$mb_markup_custom_MB = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($mb_markup_custom_MB, ceil(count($mb_markup_custom_MB) / 4), true) as $mb_markup_custom_MB) { ?>
							<div class="col-sm-3">
							<?php foreach ($mb_markup_custom_MB as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="mb_markup_custom_MB[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-mb_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="mb_markup_acquiring" value="<?php echo isset($mb_markup_acquiring)?$mb_markup_acquiring:'0'; ?>" placeholder="%" id="input-mb_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_enabled) { ?>
                    <input type="radio" id="enabled_all_mb" name="mb_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_mb" name="mb_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_enabled) { ?>
                    <input type="radio" id="enabled_selected_mb" name="mb_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_mb" name="mb_enabled" value="0" <?php echo $mb_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_mb" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_mb" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_mb" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($mb_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_mb<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="mb_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="mb_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $mb_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

            <div class="tab-pane" id="tab-ab">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-ab"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_ab;?>
                  <input type="text" name="ab_shop_id" value="<?php echo $ab_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-ab" class="form-control"/>
                  <?php if ($error_shop_id_ab) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-ab"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_shop_password" value="<?php echo $ab_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-ab" class="form-control"/>
                  <?php if ($error_shop_password_ab) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="ab_status" id="input-status" class="form-control">
                    <?php if ($ab_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>	
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-ab"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-ab-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-ab-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="ab_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($ab_info[$language['language_id']])) echo $ab_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($ab_mode) && $ab_mode) { ?>
                    <input type="radio" name="ab_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($ab_mode) || !$ab_mode) { ?>
                    <input type="radio" name="ab_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_mode" value="0" />
                    <?php echo $text_mode_test; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-ab"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_sort_order" value="<?php echo $ab_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-ab" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_discount) { ?>
                    <input type="radio" name="ab_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ab_discount) { ?>
                    <input type="radio" name="ab_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_special) { ?>
                    <input type="radio" name="ab_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ab_special) { ?>
                    <input type="radio" name="ab_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_stock) { ?>
                    <input type="radio" name="ab_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ab_stock) { ?>
                    <input type="radio" name="ab_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_merchantType == 'AB') { ?>
                    <input type="radio" name="ab_merchantType" value="AB" checked="checked" />
                    <?php echo $entry_ab_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_merchantType" value="AB" />
                    <?php echo $entry_ab_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab_available_terms"><span data-toggle="tooltip" title="<?php echo $help_available_terms; ?>"><?php echo $entry_available_terms; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_available_terms" value="<?php echo (isset($ab_available_terms) && $ab_available_terms)?$ab_available_terms:'3,5,6,12,17,24'; ?>" placeholder="<?php echo $entry_available_terms; ?>" id="input-ab_available_terms" class="form-control"/>
                </div>
              </div>  			  
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
				
				  <input type="text" name="ab_pq" value="<?php echo (isset($ab_pq)&&$ab_pq)?$ab_pq:24; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-ab-pq" class="form-control"/>
				
					<script>				
						$('#input-ab_available_terms').on('input', function() {
							var terms = $(this).val();
							var term = terms.split(',');
							var termlast = term[term.length - 1];
							if (termlast) {
								$('#input-ab-pq').val(termlast);
							}
						});
					</script>
                </div>
              </div>    
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_min_total" value="<?php echo $ab_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-ab_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_max_total" value="<?php echo $ab_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-ab_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($ab_markup_type)){$ab_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_markup_type == 'fixed') { ?>
                    <input type="radio" name="ab_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($ab_markup_type == 'custom') { ?>
                    <input type="radio" name="ab_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="ab_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ab_markup" value="<?php echo $ab_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-ab_markup" class="form-control"/>
                </div>
              </div>  
              <div id="ab_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-ab_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<div class="row">
						<div>
						<?php
						foreach (explode(',',$ab_available_terms) as $term) {
							if (!array_key_exists($term,$ab_markup_custom_AB)) {
								$ab_markup_custom_AB[$term] = 0;
							}
						}
						foreach ($ab_markup_custom_AB as $key=>$value) {
							if (!in_array($key,explode(',',$ab_available_terms))) {
								unset($ab_markup_custom_AB[$key]);
							}
						}
						ksort($ab_markup_custom_AB);
						?>
						<?php foreach (array_chunk($ab_markup_custom_AB, ceil(count($ab_markup_custom_AB) / 4), true) as $ab_markup_custom_AB) { ?>
							<div class="col-sm-3">
							<?php foreach ($ab_markup_custom_AB as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="ab_markup_custom_AB[<?php echo $key; ?>]" value="<?php echo $value?$value:0; ?>" placeholder="0" id="input-ab_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="ab_markup_acquiring" value="<?php echo (isset($ab_markup_acquiring)&&$ab_markup_acquiring)?$ab_markup_acquiring:'0'; ?>" placeholder="%" id="input-ab_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ab_enabled) { ?>
                    <input type="radio" id="enabled_all_ab" name="ab_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_ab" name="ab_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ab_enabled) { ?>
                    <input type="radio" id="enabled_selected_ab" name="ab_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_ab" name="ab_enabled" value="0" <?php echo $ab_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_ab" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_ab" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_ab" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($ab_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_ab<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="ab_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="ab_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $ab_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

			<div class="tab-pane" id="tab-sb">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-login-sb"><?php echo $entry_login; ?></label>
                <div class="col-sm-10">
				  <?php echo $text_paymentparts_url_sb;?>
                  <input type="text" name="sb_login" value="<?php echo $sb_login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-login-sb" class="form-control"/>               
                </div>                
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-frame-sb"><?php echo $entry_frame; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_frameSecretKey" value="<?php echo $sb_frameSecretKey; ?>" placeholder="<?php echo $entry_frame; ?>" id="input-frame-sb" class="form-control"/>             
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-partnerId-sb"><?php echo $entry_partnerId; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_partnerId" value="<?php echo $sb_partnerId; ?>" placeholder="<?php echo $entry_partnerId; ?>" id="input-partnerId-sb" class="form-control"/>                
                </div>                
              </div> 
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shopId-sb"><?php echo $entry_shopId; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_shopId" value="<?php echo $sb_shopId; ?>" placeholder="<?php echo $entry_shopId; ?>" id="input-shop-point-sb" class="form-control"/>               
                </div>                
              </div>
			  
			  
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shopId-sb"><?php echo $entry_credit_sub_products; ?></label>
                <div class="col-sm-10">
				  <div class="table-responsive">
					<table id="images" class="table table-striped table-bordered table-hover">
					  <thead>
						<tr>
						  <td class="text-left"><?php echo $entry_subproduct; ?></td>
						  <td class="text-left"><?php echo $entry_gracePeriod; ?></td>
						  <td></td>
						</tr>
					  </thead>
					  <tbody>
						<?php $credit_row = 0; ?>
						<?php foreach ($sb_credit_sub_products as $credit_sub_product) { ?>
						<tr id="credit-row<?php echo $credit_row; ?>">
						  <td class="text-left"><input type="text" name="sb_credit_sub_products[<?php echo $credit_row; ?>][subproduct]" value="<?php echo $credit_sub_product['subproduct']; ?>" placeholder="<?php echo $entry_subproduct; ?>" id="input-subproduct<?php echo $credit_row; ?>"  class="form-control"/></td>
						  <td class="text-right"><input type="text" name="sb_credit_sub_products[<?php echo $credit_row; ?>][gracePeriod]" value="<?php echo $credit_sub_product['gracePeriod']; ?>" placeholder="<?php echo $entry_gracePeriod; ?>" class="form-control" /></td>
						  <td class="text-left"><button type="button" onclick="$('#credit-row<?php echo $credit_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
						</tr>
						<?php $credit_row++; ?>
						<?php } ?>
					  </tbody>
					  <tfoot>
						<tr>
						  <td colspan="2"></td>
						  <td class="text-left"><button type="button" onclick="addCredit();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
						</tr>
					  </tfoot>
					</table>
				  </div>
					<script type=>
					var credit_row = <?php echo $credit_row; ?>;

					function addCredit() {
						html  = '<tr id="credit-row' + credit_row + '">';
						html += '  <td class="text-left"><input type="text" name="sb_credit_sub_products[' + credit_row + '][subproduct]" value="" id="input-subproduct' + credit_row + '" placeholder="<?php echo $entry_subproduct; ?>" class="form-control"/></td>';
						html += '  <td class="text-right"><input type="text" name="sb_credit_sub_products[' + credit_row + '][gracePeriod]" value="" placeholder="<?php echo $entry_gracePeriod; ?>" class="form-control" /></td>';
						html += '  <td class="text-left"><button type="button" onclick="$(\'#credit-row' + credit_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
						html += '</tr>';

						$('#images tbody').append(html);

						credit_row++;
					}
					</script>
                </div>                
              </div>
			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="sb_status" id="input-status" class="form-control">
                    <?php if ($sb_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>	
			   <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-sb"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-sb-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-sb-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="sb_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($sb_info[$language['language_id']])) echo $sb_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			   </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($sb_mode) && $sb_mode) { ?>
                    <input type="radio" name="sb_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($sb_mode) || !$sb_mode) { ?>
                    <input type="radio" name="sb_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_mode" value="0" />
                    <?php echo $text_mode_test; ?> 
                    <?php } ?>
                  </label>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-sb"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_sort_order" value="<?php echo $sb_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-sb" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($sb_discount) { ?>
                    <input type="radio" name="sb_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$sb_discount) { ?>
                    <input type="radio" name="sb_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($sb_special) { ?>
                    <input type="radio" name="sb_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$sb_special) { ?>
                    <input type="radio" name="sb_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($sb_stock) { ?>
                    <input type="radio" name="sb_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$sb_stock) { ?>
                    <input type="radio" name="sb_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($sb_merchantType) && $sb_merchantType == 'SB') { ?>
                    <input type="radio" name="sb_merchantType" value="SB" checked="checked" />
                    <?php echo $entry_sb_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_merchantType" value="SB" />
                    <?php echo $entry_sb_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-sb-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_pq" value="<?php echo $sb_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-sb-pq" class="form-control"/>      
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-sb_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_min_total" value="<?php echo $sb_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-sb_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-sb_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_max_total" value="<?php echo $sb_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-sb_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($sb_markup_type)){$sb_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($sb_markup_type == 'fixed') { ?>
                    <input type="radio" name="sb_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($sb_markup_type == 'custom') { ?>
                    <input type="radio" name="sb_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="sb_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-sb_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="sb_markup" value="<?php echo $sb_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-sb_markup" class="form-control"/>
                </div>
              </div>  
              <div id="sb_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-sb_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<div class="row">
						<div>
						<?php
						if (!isset($sb_markup_custom_sb)) {
							$sb_markup_custom_sb = array(3 => 0, 5 => 0, 10 => 0, 12 => 0); 
						}						
						if (isset($sb_id_data) && $sb_id_data) {
							foreach ($sb_id_data as $key=>$term) {
								if (!array_key_exists($key,$sb_markup_custom_sb)) {
									$sb_markup_custom_sb[$key] = 0;
									
								}
								$sb_available_terms[] = $key;
							}
							foreach ($sb_markup_custom_sb as $key=>$value) {
								if (!in_array($key,$sb_available_terms)) {
									unset($sb_markup_custom_sb[$key]);
								}
							}
							ksort($sb_markup_custom_sb);
						}
						?>
						<?php foreach (array_chunk($sb_markup_custom_sb, ceil(count($sb_markup_custom_sb) / 4), true) as $sb_markup_custom_sb) { ?>
							<div class="col-sm-3">
							<?php foreach ($sb_markup_custom_sb as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="sb_markup_custom_sb[<?php echo $key; ?>]" value="<?php echo $value?$value:0; ?>" placeholder="%" id="input-sb_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="sb_markup_acquiring" value="<?php echo isset($sb_markup_acquiring)?$sb_markup_acquiring:'0'; ?>" placeholder="%" id="input-sb_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($sb_enabled) { ?>
                    <input type="radio" id="enabled_all_sb" name="sb_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_sb" name="sb_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$sb_enabled) { ?>
                    <input type="radio" id="enabled_selected_sb" name="sb_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_sb" name="sb_enabled" value="0" <?php echo $sb_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_sb" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_sb" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_sb" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($sb_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_sb<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="sb_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="sb_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $sb_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
			<script>
			if ($('input[name=\'sb_markup_type\']:checked').val() == 'fixed') {
				$('#sb_markup_custom').hide();
			} else {
				$('#sb_markup_custom').show();
			}
			$('input[name=\'sb_markup_type\']').change(function() {
				if ($('input[name=\'sb_markup_type\']:checked').val() == 'fixed') {
					$('#sb_markup_custom').hide();
				} else {
					$('#sb_markup_custom').show();
				}
			});
			$('input[name=\'category_allowed_sb\']').autocomplete({
				source: function(request, response) {
				  $.ajax({
					url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {		
					  response($.map(json, function(item) {
						return {
						  label: item['name'],
						  value: item['category_id']
						}
					  }));
					}
				  });
				}, 
				select: function(item) {
				  $.ajax({
					url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
					dataType: 'json',
					success: function(data) {          
					  $.each(data, function(index, item) {
						$('#product-allowed_sb' + item.product_id).remove();
						$('#product-allowed_sb').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="sb_product_allowed[]" value="' + item.product_id + '" /></div>');
						
						$('#enabled_selected_sb').prop('disabled',true);
						$('#enabled_all_sb').attr('checked', 'checked');
						$('#enabled_all_sb').parent().trigger('click');
					  });  
					}
				  });
				  return false;
				},
				focus: function(event, ui) {
					return false;
				}
			});
			$('input[name=\'allowed_sb\']').autocomplete({
				'source': function(request, response) {
					$.ajax({
						url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(json) {
							response($.map(json, function(item) {
								return {
									label: item['name'],
									value: item['product_id']
								}
							}));
						}
					});
				},
				'select': function(item) {
					$('input[name=\'allowed_sb\']').val('');
					$('#product-allowed_sb' + item['value']).remove();
					$('#product-allowed_sb').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="sb_product_allowed[]" value="' + item['value'] + '" /></div>');
					
					$('#enabled_selected_sb').prop('disabled',true);
					$('#enabled_all_sb').attr('checked', 'checked');
					$('#enabled_all_sb').parent().trigger('click');
				}
			});
			$('#product-allowed_sb').delegate('.fa-minus-circle', 'click', function() {
				$(this).parent().remove();
				
				if ($('#product-allowed_sb').html().trim() === '') {
					$('#enabled_selected_sb').prop('disabled',false);
				}
			});
			</script>
            </div>
			
            <div class="tab-pane" id="tab-aa">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-aa"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_aa;?>
                  <input type="text" name="aa_shop_id" value="<?php echo $aa_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-aa" class="form-control"/>
                  <?php if ($error_shop_id_aa) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-aa"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_shop_password" value="<?php echo $aa_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-aa" class="form-control"/>
                  <?php if ($error_shop_password_aa) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="aa_status" id="input-status" class="form-control">
                    <?php if ($aa_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>	
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-aa"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-aa-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-aa-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="aa_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($aa_info[$language['language_id']])) echo $aa_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			</div>
              <div class="form-group" hidden>
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($aa_mode) && $aa_mode) { ?>
                    <input type="radio" name="aa_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($aa_mode) || !$aa_mode) { ?>
                    <input type="radio" name="aa_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_mode" value="0" />
                    <?php echo $text_mode_test; ?> 
                    <?php } ?>
                  </label>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-aa"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_sort_order" value="<?php echo $aa_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-aa" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_discount) { ?>
                    <input type="radio" name="aa_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$aa_discount) { ?>
                    <input type="radio" name="aa_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_special) { ?>
                    <input type="radio" name="aa_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$aa_special) { ?>
                    <input type="radio" name="aa_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_stock) { ?>
                    <input type="radio" name="aa_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$aa_stock) { ?>
                    <input type="radio" name="aa_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_merchantType == 'AA') { ?>
                    <input type="radio" name="aa_merchantType" value="AA" checked="checked" />
                    <?php echo $entry_aa_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_merchantType" value="AA" />
                    <?php echo $entry_aa_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-aa-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_pq" value="<?php echo $aa_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-aa-pq" class="form-control"/>
                  <?php if ($error_pq_aa) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-aa_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_min_total" value="<?php echo $aa_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-aa_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-aa_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_max_total" value="<?php echo $aa_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-aa_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($aa_markup_type)){$aa_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_markup_type == 'fixed') { ?>
                    <input type="radio" name="aa_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($aa_markup_type == 'custom') { ?>
                    <input type="radio" name="aa_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="aa_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-aa_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="aa_markup" value="<?php echo $aa_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-aa_markup" class="form-control"/>
                </div>
              </div>  
              <div id="aa_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-aa_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($aa_markup_custom_AA)) {
						$aa_markup_custom_AA = array(1 => 3.0, 2 => 3.5, 3 => 5.5, 4 => 7.5, 5 => 10.0, 6 => 12.5, 7 => 14.5, 8 => 16.5, 9 => 17.5, 10 => 18.0, 11 => 18.5, 12 => 20.0, 13 => 21.5, 14 => 23.0, 15 => 24.5, 16 => 25.5, 17 => 27.0, 18 => 28.0, 19 => 29.5, 20 => 30.5, 21 => 32.0, 22 => 33.0, 23 => 34.0, 24 => 35.5); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($aa_markup_custom_AA, ceil(count($aa_markup_custom_AA) / 4), true) as $aa_markup_custom_AA) { ?>
							<div class="col-sm-3">
							<?php foreach ($aa_markup_custom_AA as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="aa_markup_custom_AA[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-aa_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="aa_markup_acquiring" value="<?php echo isset($aa_markup_acquiring)?$aa_markup_acquiring:'0'; ?>" placeholder="%" id="input-aa_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($aa_enabled) { ?>
                    <input type="radio" id="enabled_all_aa" name="aa_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_aa" name="aa_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$aa_enabled) { ?>
                    <input type="radio" id="enabled_selected_aa" name="aa_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_aa" name="aa_enabled" value="0" <?php echo $aa_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_aa" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_aa" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_aa" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($aa_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_aa<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="aa_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="aa_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $aa_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>
			

            <div class="tab-pane" id="tab-pl">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-pl"><?php echo $entry_token; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_pl;?>
                  <input type="text" name="pl_shop_id" value="<?php echo $pl_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-pl" class="form-control"/>
                  <?php if ($error_shop_id_pl) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>     
					  <?php if (!$pl_data) { ?>
					  <div class="alert alert-info"><?php echo $help_pl_token; ?></div>
					  <?php } ?>    
					  <button type="button" id="button-pl-getdata" class="btn btn-primary"><?php echo $text_getdata; ?></button>
                </div>
              </div>
              <div class="form-group required hidden">                
                <label class="col-sm-2 control-label" for="input-shop-password-pl"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pl_shop_password" value="<?php echo $pl_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-pl" class="form-control"/>
                  <?php if ($error_shop_password_pl) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="pl_status" id="input-status" class="form-control">
                    <?php if ($pl_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>		
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-pu"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></span></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-pl-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-pl-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="pl_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($pl_info[$language['language_id']])) echo $pl_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($pl_mode) && $pl_mode) { ?>
                    <input type="radio" name="pl_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($pl_mode) || !$pl_mode) { ?>
                    <input type="radio" name="pl_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_mode" value="0" />
                    <?php echo $text_mode_test; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-ab"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pl_sort_order" value="<?php echo $pl_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-ab" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_discount) { ?>
                    <input type="radio" name="pl_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pl_discount) { ?>
                    <input type="radio" name="pl_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_special) { ?>
                    <input type="radio" name="pl_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pl_special) { ?>
                    <input type="radio" name="pl_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_stock) { ?>
                    <input type="radio" name="pl_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pl_stock) { ?>
                    <input type="radio" name="pl_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_merchantType == 'PL') { ?>
                    <input type="radio" name="pl_merchantType" value="PL" checked="checked" />
                    <?php echo $entry_pl_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_merchantType" value="PL" />
                    <?php echo $entry_pl_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ab-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <select name="pl_pq" id="input-pl_pq" class="form-control">
					<?php foreach ($pl_markup_custom_PL as $key=>$value) { ?>
					<?php if ($pl_pq == $key) { ?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $key; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                    <?php } ?>					
					<?php } ?>   
                  </select>
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pl_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pl_min_total" value="<?php echo $pl_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-pl_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pl_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pl_max_total" value="<?php echo $pl_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-pl_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($pl_markup_type)){$pl_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_markup_type == 'fixed') { ?>
                    <input type="radio" name="pl_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pl_markup_type == 'custom') { ?>
                    <input type="radio" name="pl_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="pl_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pl_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pl_markup" value="<?php echo $pl_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-pl_markup" class="form-control"/>
                </div>
              </div>  
              <div id="pl_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-pl_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<div class="row">
						<div class="pl_markup_custom">
						<?php foreach (array_chunk($pl_markup_custom_PL, ceil(count($pl_markup_custom_PL) / 4), true) as $pl_markup_custom_PL) { ?>
							<div class="col-sm-3">
							<?php foreach ($pl_markup_custom_PL as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="pl_markup_custom_PL[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-pl_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="pl_markup_acquiring" value="<?php echo isset($pl_markup_acquiring)?$pl_markup_acquiring:'0'; ?>" placeholder="%" id="input-pl_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pl_enabled) { ?>
                    <input type="radio" id="enabled_all_pl" name="pl_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_pl" name="pl_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pl_enabled) { ?>
                    <input type="radio" id="enabled_selected_pl" name="pl_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_pl" name="pl_enabled" value="0" <?php echo $pl_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_pl" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_pl" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_pl" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($pl_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_pl<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="pl_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="pl_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $pl_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

			<div class="tab-pane" id="tab-pu">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-name-pu"><?php echo $entry_shop_name; ?> / partner_name</label>
                <div class="col-sm-10">
                  <input type="text" name="pu_shop_name" value="<?php echo $pu_shop_name; ?>" placeholder="<?php echo $entry_shop_name; ?>" id="input-shop-name-pu" class="form-control"/>               
                </div>                
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-pu"><?php echo $entry_shop_id; ?> / store_user_login = username</label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_pu;?>
                  <input type="text" name="pu_shop_id" value="<?php echo $pu_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-pu" class="form-control"/>
                  <?php if ($error_shop_id_pu) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-pu"><?php echo $entry_shop_password; ?> / password</label>
                <div class="col-sm-10">
                  <input type="text" name="pu_shop_password" value="<?php echo $pu_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-pu" class="form-control"/>
                  <?php if ($error_shop_password_pu) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div> 
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-point-pu"><?php echo $entry_point_of_sale_code; ?> / point_of_sale_code</label>
                <div class="col-sm-10">
                  <input type="text" name="pu_point_of_sale_code" value="<?php echo $pu_point_of_sale_code; ?>" placeholder="<?php echo $entry_point_of_sale_code; ?>" id="input-shop-point-pu" class="form-control"/>               
                </div>                
              </div>
			  
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-shop-point-pu"><?php echo $text_callback_url; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="" value="<?php echo $callback_pu_url; ?>" placeholder="" id="" class="form-control" disabled/>               
                </div>                
              </div>
			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="pu_status" id="input-status" class="form-control">
                    <?php if ($pu_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>	
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-info-pu"><span data-toggle="tooltip" title="<?php echo $entry_help_description; ?>"><?php echo $entry_description; ?></label>
				<div class="col-sm-10">
				   <ul class="nav nav-tabs popup_tabs">
						 <?php $i=0; foreach ($languages as $language) { ?>
						 <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-pu-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
						 <?php $i++; }?>
				   </ul>
				   <div class="tab-content">
				   <?php $i=0; foreach ($languages as $language) { ?>
				   <div id="tab-pu-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
						<textarea name="pu_info[<?php echo $language['language_id']; ?>]" class="form-control summernote" data-toggle="summernote"><?php if(!empty($pu_info[$language['language_id']])) echo $pu_info[$language['language_id']]; else echo ''; ?></textarea>
				   </div>
				   <?php $i++; } ?>
				   </div>
			   </div>
			</div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_mode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($pu_mode) && $pu_mode) { ?>
                    <input type="radio" name="pu_mode" value="1" checked="checked" />
                    <?php echo $text_mode_real; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_mode" value="1" />
                    <?php echo $text_mode_real; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!isset($pu_mode) || !$pu_mode) { ?>
                    <input type="radio" name="pu_mode" value="0" checked="checked" />
                    <?php echo $text_mode_test; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_mode" value="0" />
                    <?php echo $text_mode_test; ?> 
                    <?php } ?>
                  </label>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-pu"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pu_sort_order" value="<?php echo $pu_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-pu" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pu_discount) { ?>
                    <input type="radio" name="pu_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pu_discount) { ?>
                    <input type="radio" name="pu_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pu_special) { ?>
                    <input type="radio" name="pu_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pu_special) { ?>
                    <input type="radio" name="pu_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pu_stock) { ?>
                    <input type="radio" name="pu_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pu_stock) { ?>
                    <input type="radio" name="pu_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if (isset($pu_merchantType) && $pu_merchantType == 'PU') { ?>
                    <input type="radio" name="pu_merchantType" value="PU" checked="checked" />
                    <?php echo $entry_pu_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_merchantType" value="PU" />
                    <?php echo $entry_pu_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-pu-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pu_pq" value="<?php echo $pu_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-pu-pq" class="form-control"/>
                  <?php if ($error_pq_pu) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pu_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pu_min_total" value="<?php echo $pu_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-pu_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pu_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pu_max_total" value="<?php echo $pu_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-pu_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($pu_markup_type)){$pu_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pu_markup_type == 'fixed') { ?>
                    <input type="radio" name="pu_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pu_markup_type == 'custom') { ?>
                    <input type="radio" name="pu_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="pu_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pu_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pu_markup" value="<?php echo $pu_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-pu_markup" class="form-control"/>
                </div>
              </div>  
              <div id="pu_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-pu_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($pu_markup_custom_pu)) {
						$pu_markup_custom_pu = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($pu_markup_custom_pu, ceil(count($pu_markup_custom_pu) / 4), true) as $pu_markup_custom_pu) { ?>
							<div class="col-sm-3">
							<?php foreach ($pu_markup_custom_pu as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="pu_markup_custom_pu[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-pu_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="pu_markup_acquiring" value="<?php echo isset($pu_markup_acquiring)?$pu_markup_acquiring:'0'; ?>" placeholder="%" id="input-pu_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pu_enabled) { ?>
                    <input type="radio" id="enabled_all_pu" name="pu_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_pu" name="pu_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pu_enabled) { ?>
                    <input type="radio" id="enabled_selected_pu" name="pu_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_pu" name="pu_enabled" value="0" <?php echo $pu_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_pu" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_pu" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_pu" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($pu_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_pu<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="pu_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="pu_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $pu_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>
			
            <div class="tab-pane" id="tab-status">
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_completed_status; ?></label>
				  <div class="col-sm-10">
					<select name="completed_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $completed_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_canceled_status; ?></label>
				  <div class="col-sm-10">
					<select name="canceled_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $canceled_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_clientwait_status; ?></label>
				  <div class="col-sm-10">
					<select name="clientwait_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $clientwait_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_created_status; ?></label>
				  <div class="col-sm-10">
					<select name="created_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $created_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>                                                     
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_failed_status; ?></label>
				  <div class="col-sm-10">
					<select name="failed_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $failed_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_rejected_status; ?></label>
				  <div class="col-sm-10">
					<select name="rejected_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $rejected_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>                               
            </div>
			<div class="tab-pane" id="tab-design">
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-button_name"><?php echo $entry_button_name; ?></label>
                <div class="col-sm-10">
					<?php foreach ($languages as $language) { ?>
                        <div class="input-group"><span class="input-group-addon"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="button_name[<?php echo $language['language_id']; ?>]" value="<?php echo $button_name[$language['language_id']]; ?>" placeholder="<?php echo $entry_button_name; ?>" id="input-button_name-<?php echo $language['language_id']; ?>" class="form-control" />
                        </div>
                    <?php } ?>
				</div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_show_icons; ?>"><?php echo $entry_show_icons; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($show_icons) { ?>
                    <input type="radio" name="show_icons" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_icons" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$show_icons) { ?>
                    <input type="radio" name="show_icons" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_icons" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-icons_size"><?php echo $entry_icons_size; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="icons_size" value="<?php echo $icons_size; ?>" placeholder="<?php echo $entry_icons_size; ?>" id="input-icons_size" class="form-control"/>
                </div>
              </div>			  
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-css-button"><span data-toggle="tooltip" title="<?php echo $help_css_button; ?>"><?php echo $entry_css_button; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="css_button" value="<?php echo $css_button; ?>" placeholder="<?php echo $entry_css_button; ?>" id="input-css-button" class="form-control"/>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-selector-button"><span data-toggle="tooltip" title="<?php echo $help_selector_button; ?>"><?php echo $entry_selector_button; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="selector_button" value="<?php echo $selector_button; ?>" placeholder="<?php echo $entry_selector_button; ?>. По умолчанию - $('#button-cart')" id="input-selector-button" class="form-control"/>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-selector-block"><span data-toggle="tooltip" title="<?php echo $help_selector_block; ?>"><?php echo $entry_selector_block; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="selector_block" value="<?php echo $selector_block; ?>" placeholder="<?php echo $entry_selector_block; ?>" id="input-selector-block" class="form-control"/>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-css-custom"><span data-toggle="tooltip" title="<?php echo $help_css_custom; ?>"><?php echo $entry_css_custom; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="css_custom" placeholder="<?php echo $entry_css_custom; ?>" rows="5" id="input-css-custom" class="form-control"><?php echo $css_custom; ?></textarea>
                </div>
              </div>
			</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
if ($('input[name=\'pp_markup_type\']:checked').val() == 'fixed') {
	$('#pp_markup_custom').hide();
	$('#input-pp_markup').show();
} else {
	$('#pp_markup_custom').show();
	$('#input-pp_markup').hide();
}
if ($('input[name=\'pp_merchantType\']:checked').val() == 'PB') {
	$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', true);
}
$('input[name=\'pp_merchantType\']').change(function() {
	if ($('input[name=\'pp_merchantType\']:checked').val() == 'PB') {
		$('#pp_markup_custom').hide();
		$('input[name=\'pp_markup_type\'][value="fixed"]').trigger('click');
		$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', true);
	} else {
		$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', false);
	}
});
$('input[name=\'pp_markup_type\']').change(function() {
	if ($('input[name=\'pp_markup_type\']:checked').val() == 'fixed') {
		$('#pp_markup_custom').hide();
		$('#input-pp_markup').show();
	} else {
		$('#pp_markup_custom').show();
		$('input[name=\'pp_markup\']').val(1);
		$('#input-pp_markup').hide();
	}
});

if ($('input[name=\'ii_markup_type\']:checked').val() == 'fixed') {
	$('#ii_markup_custom').hide();
	$('#input-ii_markup').show();
} else {
	$('#ii_markup_custom').show();
	$('#input-ii_markup').hide();
}
if ($('input[name=\'ii_merchantType\']:checked').val() == 'II') {
	$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', true);
}
$('input[name=\'ii_merchantType\']').change(function() {
	if ($('input[name=\'ii_merchantType\']:checked').val() == 'II') {
		$('#ii_markup_custom').hide();
		$('input[name=\'ii_markup_type\'][value="fixed"]').trigger('click');
		$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', true);
	} else {
		$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', false);
	}
});
$('input[name=\'ii_markup_type\']').change(function() {
	if ($('input[name=\'ii_markup_type\']:checked').val() == 'fixed') {
		$('#ii_markup_custom').hide();
		$('#input-ii_markup').show();
	} else {
		$('#ii_markup_custom').show();
		$('input[name=\'ii_markup\']').val(1);
		$('#input-ii_markup').hide();
	}
});

if ($('input[name=\'mb_markup_type\']:checked').val() == 'fixed') {
	$('#mb_markup_custom').hide();
	$('#input-mb_markup').show();
} else {
	$('#mb_markup_custom').show();
	$('#input-mb_markup').hide();
}
$('input[name=\'mb_markup_type\']').change(function() {
	if ($('input[name=\'mb_markup_type\']:checked').val() == 'fixed') {
		$('#mb_markup_custom').hide();
		$('#input-mb_markup').show();
	} else {
		$('#mb_markup_custom').show();
		$('input[name=\'mb_markup\']').val(1);
		$('#input-mb_markup').hide();
	}
});

if ($('input[name=\'ab_markup_type\']:checked').val() == 'fixed') {
	$('#ab_markup_custom').hide();
} else {
	$('#ab_markup_custom').show();
}
$('input[name=\'ab_markup_type\']').change(function() {
	if ($('input[name=\'ab_markup_type\']:checked').val() == 'fixed') {
		$('#ab_markup_custom').hide();
	} else {
		$('#ab_markup_custom').show();
	}
});

if ($('input[name=\'aa_markup_type\']:checked').val() == 'fixed') {
	$('#aa_markup_custom').hide();
	$('#input-aa_markup').show();
} else {
	$('#aa_markup_custom').show();
	$('#input-aa_markup').hide();
}
$('input[name=\'aa_markup_type\']').change(function() {
	if ($('input[name=\'aa_markup_type\']:checked').val() == 'fixed') {
		$('#aa_markup_custom').hide();
		$('#input-aa_markup').show();
	} else {
		$('#aa_markup_custom').show();
		$('input[name=\'aa_markup\']').val(1);
		$('#input-aa_markup').hide();
	}
});

if ($('input[name=\'pl_markup_type\']:checked').val() == 'fixed') {
	$('#pl_markup_custom').hide();
	$('#input-pl_markup').show();
} else {
	$('#pl_markup_custom').show();
	$('#input-pl_markup').hide();
}
$('input[name=\'pl_markup_type\']').change(function() {
	if ($('input[name=\'pl_markup_type\']:checked').val() == 'fixed') {
		$('#pl_markup_custom').hide();
		$('#input-pl_markup').show();
	} else {
		$('#pl_markup_custom').show();
		$('input[name=\'pl_markup\']').val(1);
		$('#input-pl_markup').hide();
	}
});

if ($('input[name=\'pu_markup_type\']:checked').val() == 'fixed') {
	$('#pu_markup_custom').hide();
	$('#input-pu_markup').show();
} else {
	$('#pu_markup_custom').show();
	$('#input-pu_markup').hide();
}
$('input[name=\'pu_markup_type\']').change(function() {
	if ($('input[name=\'pu_markup_type\']:checked').val() == 'fixed') {
		$('#pu_markup_custom').hide();
		$('#input-pu_markup').show();
	} else {
		$('#pu_markup_custom').show();
		$('input[name=\'pu_markup\']').val(1);
		$('#input-pu_markup').hide();
	}
});

</script>
<style>
.nav-tabs > li > a {
    height: 48px;
    vertical-align: middle;
    display: table-cell;
}
</style>
<script>
$('input[name=\'category_allowed_pp\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_pp' + item.product_id).remove();
            $('#product-allowed_pp').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_pp').prop('disabled',true);
			$('#enabled_all_pp').attr('checked', 'checked');
			$('#enabled_all_pp').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_pp\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_pp\']').val('');
		$('#product-allowed_pp' + item['value']).remove();
		$('#product-allowed_pp').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="pp_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_pp').prop('disabled',true);
		$('#enabled_all_pp').attr('checked', 'checked');
		$('#enabled_all_pp').parent().trigger('click');
	}
});
$('#product-allowed_pp').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_pp').html().trim() === '') {
		$('#enabled_selected_pp').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_ii\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_ii' + item.product_id).remove();
            $('#product-allowed_ii').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="ii_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_ii').prop('disabled',true);
			$('#enabled_all_ii').attr('checked', 'checked');
			$('#enabled_all_ii').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_ii\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_ii\']').val('');
		$('#product-allowed_ii' + item['value']).remove();
		$('#product-allowed_ii').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ii_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_ii').prop('disabled',true);
		$('#enabled_all_ii').attr('checked', 'checked');
		$('#enabled_all_ii').parent().trigger('click');
	}
});
$('#product-allowed_ii').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_ii').html().trim() === '') {
		$('#enabled_selected_ii').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_mb\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_mb' + item.product_id).remove();
            $('#product-allowed_mb').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="mb_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_mb').prop('disabled',true);
			$('#enabled_all_mb').attr('checked', 'checked');
			$('#enabled_all_mb').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_mb\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_mb\']').val('');
		$('#product-allowed_mb' + item['value']).remove();
		$('#product-allowed_mb').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="mb_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_mb').prop('disabled',true);
		$('#enabled_all_mb').attr('checked', 'checked');
		$('#enabled_all_mb').parent().trigger('click');
	}
});
$('#product-allowed_mb').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_mb').html().trim() === '') {
		$('#enabled_selected_mb').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_ab\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_ab' + item.product_id).remove();
            $('#product-allowed_ab').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="ab_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_ab').prop('disabled',true);
			$('#enabled_all_ab').attr('checked', 'checked');
			$('#enabled_all_ab').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_ab\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_ab\']').val('');
		$('#product-allowed_ab' + item['value']).remove();
		$('#product-allowed_ab').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ab_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_ab').prop('disabled',true);
		$('#enabled_all_ab').attr('checked', 'checked');
		$('#enabled_all_ab').parent().trigger('click');
	}
});
$('#product-allowed_ab').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_ab').html().trim() === '') {
		$('#enabled_selected_ab').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_aa\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_aa' + item.product_id).remove();
            $('#product-allowed_aa').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="aa_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_aa').prop('disabled',true);
			$('#enabled_all_aa').attr('checked', 'checked');
			$('#enabled_all_aa').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_aa\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_aa\']').val('');
		$('#product-allowed_aa' + item['value']).remove();
		$('#product-allowed_aa').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="aa_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_aa').prop('disabled',true);
		$('#enabled_all_aa').attr('checked', 'checked');
		$('#enabled_all_aa').parent().trigger('click');
	}
});
$('#product-allowed_aa').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_aa').html().trim() === '') {
		$('#enabled_selected_aa').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_pl\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_pl' + item.product_id).remove();
            $('#product-allowed_pl').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="pl_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_pl').prop('disabled',true);
			$('#enabled_all_pl').attr('checked', 'checked');
			$('#enabled_all_pl').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_pl\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_pl\']').val('');
		$('#product-allowed_pl' + item['value']).remove();
		$('#product-allowed_pl').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="pl_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_pl').prop('disabled',true);
		$('#enabled_all_pl').attr('checked', 'checked');
		$('#enabled_all_pl').parent().trigger('click');
	}
});
$('#product-allowed_pl').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_pl').html().trim() === '') {
		$('#enabled_selected_pl').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_pu\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_pu' + item.product_id).remove();
            $('#product-allowed_pu').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="pu_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_pu').prop('disabled',true);
			$('#enabled_all_pu').attr('checked', 'checked');
			$('#enabled_all_pu').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_pu\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_pu\']').val('');
		$('#product-allowed_pu' + item['value']).remove();
		$('#product-allowed_pu').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="pu_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_pu').prop('disabled',true);
		$('#enabled_all_pu').attr('checked', 'checked');
		$('#enabled_all_pu').parent().trigger('click');
	}
});
$('#product-allowed_pu').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_pu').html().trim() === '') {
		$('#enabled_selected_pu').prop('disabled',false);
	}
});
$('body').on('click', '#button-pl-getdata', function(){
	var shopid = $('#input-shop-id-pl').val();
	$.ajax({
		url: 'index.php?route=payment/ukrcredits/asktokenPLget&<?php echo $text_token; ?>=<?php echo $token; ?>',
		type: 'GET',
		dataType: 'json',
		data: 'shopid=' + shopid,
		beforeSend: function() {
			$('#tab-pl .text-danger').remove();
			$('#tab-pl .alert-warning').remove();
		},
		success: function(json) {
			console.log(json);
			if (json['success']) {
				if (json.success.status == 2) {
					$.ajax({
						url: 'index.php?route=payment/ukrcredits/askPacketsPLget&<?php echo $text_token; ?>=<?php echo $token; ?>',
						type: 'GET',
						dataType: 'json',
						data: 'tokenpl=' + json.success.token,
						success: function(data) {
							console.log(data);
							if (data.status == 6) {
								$.ajax({
									url: 'index.php?route=payment/ukrcredits/savepldata&<?php echo $text_token; ?>=<?php echo $token; ?>',
									type: 'post',
									dataType: 'json',
									data: {packets:data},
									success: function(json) {
										console.log(json);
										if (json['success']) {
											$('#tab-pl .alert-success').remove();
											$('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $text_pl_saved; ?><button type="button" class="close" data-dismiss="alert">×</button></div>').insertBefore($('#button-pl-getdata'));
											
											$('#input-pl_pq option').remove();
											html  = '';
											$.each(json['data'], function(index,value) {
												html += '<option value="' + index + '">' + index + '</option>';
											});
											$('#input-pl_pq').append(html);
											
											$('#pl_markup_custom .col-sm-10 .row .pl_markup_custom > div').remove();
											html  = '';
											$.each(json['data'], function(index,value) {
												html += '<div class="col-sm-3">';
												html += '	<div class="input-group">';
												html += '		<span class="input-group-addon" style="width:70px">' + index + ' мес</span>';
												html += '		<input type="text" name="pl_markup_custom_PL[' + index + ']" value="' + Math.round((1-value)*100) + '" placeholder="%" id="input-pl_markup_custom-' + index + '" class="form-control text-center">';
												html += '		<span class="input-group-addon">%</span>';
												html += '	</div> ';
												html += '</div>';
											});
											$('#pl_markup_custom .col-sm-10 .row .pl_markup_custom').append(html);										 
											 
										}
										if (json['error']) {
											$('<div class="alert alert-warning alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $error_pl_save; ?> <button type="button" class="close" data-dismiss="alert">×</button></div>').insertBefore($('#button-pl-getdata'));
										}
									}
								});
							} else {
								$('<div class="alert alert-warning alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $error_pl_packets; ?> ' + data.data + '<button type="button" class="close" data-dismiss="alert">×</button></div>').insertBefore($('#button-pl-getdata'));
							}
						}
					});					
				} else {
					$('<div class="alert alert-warning alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $error_pl_token; ?> ' + json.success.data + '<button type="button" class="close" data-dismiss="alert">×</button></div>').insertBefore($('#button-pl-getdata'));
				}
			}

			if (json['error']) {
				$('<div class="text-danger"><?php echo $error_pl_connect; ?> ' + json.error.http_code + ', ip:' + json.error.local_ip + '</div>').insertBefore($('#button-pl-getdata'));
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	
});
</script>

<?php echo $footer; ?>
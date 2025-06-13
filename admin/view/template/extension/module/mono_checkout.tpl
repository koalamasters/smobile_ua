<?= $header ?><?= $column_left ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-module" data-toggle="tooltip" title="<?= $button_save ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?= $cancel ?>" data-toggle="tooltip" title="<?= $button_cancel ?>" class="btn btn-default"><i
                            class="fa fa-reply"></i></a></div>

            <h1>
               <?= $heading_title ?>
            </h1>
            <ul class="breadcrumb">
                <?php foreach($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?= $breadcrumb['href'] ?>"><?= $breadcrumb['text'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible"><i
                    class="fa fa-exclamation-circle"></i> <?= $error_warning ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i><?= $text_edit ?>  <img
                            src="view/image/mono_checkout/monocheckout_logo_black.svg"
                            alt="monocheckout_logo_black">
                </h3>
            </div>
            <div class="panel-body">
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="form-module"
                      class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-model"><?= $entry_api ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="module_mono_checkout_token"
                                   value="<?= $module_mono_checkout_token ?>" placeholder="<?= $entry_api ?>"
                                   id="input-model" class="form-control"/>
                            <?php if($error_api) { ?>
                            <div class="text-danger"><?= $error_api ?></div>
                            <?php } ?>
                            <p><?= $text_apikey ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span data-toggle="tooltip"
                                                                    title="<?= $help_payment ?>"><?= $entry_delivery ?></span></label>
                        <div class="col-sm-10">
                            <div class="well well-sm" style="overflow: auto;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_delivery[]"
                                               value="pickup" <?php if(in_array("pickup", $deliveries)) { ?> checked="checked" <?php } ?>/>
                                        <?= $delivery_pickup ?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_delivery[]"
                                               value="courier" <?php if(in_array("courier", $deliveries)) { ?> checked="checked" <?php } ?>/>
                                        <?= $delivery_courier ?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_delivery[]"
                                               value="np_brnm" <?php if(in_array("np_brnm", $deliveries)) { ?> checked="checked" <?php } ?>/>
                                        <?= $delivery_np_brnm ?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_delivery[]"
                                               value="np_box" <?php if(in_array("np_box", $deliveries)) { ?> checked="checked" <?php } ?>/>
                                        <?= $delivery_np_box ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label"><span data-toggle="tooltip"
                                                                    title="<?= $help_payment ?>"><?= $entry_payment ?></span></label>
                        <div class="col-sm-10">
                            <div class="well well-sm" style="overflow: auto;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_payment[]"
                                               value="card" <?php if(in_array("card", $payments)) { ?> checked="checked" <?php } ?>/>
                                        <?= $payment_card ?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_payment[]"
                                               value="payment_on_delivery" <?php if(in_array("payment_on_delivery", $payments)) { ?> checked="checked" <?php } ?>/>
                                        <?= $payment_on_delivery ?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="module_mono_checkout_payment[]"
                                               value="part_purchase" <?php if(in_array("part_purchase", $payments)) { ?> checked="checked" <?php } ?>/>
                                        <?= $payment_part_purchase ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cart_elem">
                            <span data-toggle="tooltip" title="<?php echo $help_payments_number; ?>"><?php echo $entry_payments_number; ?></span>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="number" min="3" max="25" name="module_mono_checkout_payments_number" value="<?php echo $module_mono_checkout_payments_number; ?>" placeholder="<?php echo $entry_payments_number; ?>" id="input-payments_number" class="form-control"/>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_statuses; ?></label>
                        <div class="col-sm-10">
                            <label class="radio">
                                <p><?php echo $text_status_success; ?></p>
                                <select name="module_mono_checkout_status_success" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"
                                    <?php if ($module_mono_checkout_status_success == $order_status['order_status_id']) { echo 'selected'; } ?>>
                                    <?php echo $order_status['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="radio">
                                <p><?php echo $text_status_payment_on_delivery; ?></p>
                                <select name="module_mono_checkout_status_payment_on_delivery" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"
                                    <?php if ($module_mono_checkout_status_payment_on_delivery == $order_status['order_status_id']) { echo 'selected'; } ?>>
                                    <?php echo $order_status['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="radio">
                                <p><?php echo $text_status_not_confirmed; ?></p>
                                <select name="module_mono_checkout_status_not_confirmed" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"
                                    <?php if ($module_mono_checkout_status_not_confirmed == $order_status['order_status_id']) { echo 'selected'; } ?>>
                                    <?php echo $order_status['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="radio">
                                <p><?php echo $text_status_not_authorized; ?></p>
                                <select name="module_mono_checkout_status_not_authorized" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"
                                    <?php if ($module_mono_checkout_status_not_authorized == $order_status['order_status_id']) { echo 'selected'; } ?>>
                                    <?php echo $order_status['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </label>
                            <label class="radio">
                                <p><?php echo $text_status_fail; ?></p>
                                <select name="module_mono_checkout_status_fail" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"
                                    <?php if ($module_mono_checkout_status_fail == $order_status['order_status_id']) { echo 'selected'; } ?>>
                                    <?php echo $order_status['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?= $entry_faq ?></label>
                        <div class="col-sm-10">
                            <?= $text_faq ?>
                        </div>
                    </div>
                    <!--<div class="form-group">
										                        <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip"
										                                                                                    title="<?= $help_merchant ?>"><?= $entry_merchant ?></span></label>
										                        <div class="col-sm-10">
										                            <div class="checkbox">
										                                <label>
										                                    <?php if($module_mono_checkout_merchant_user) { ?>
										                                        <input type="checkbox" name="module_mono_checkout_merchant_user" value="1"
										                                               checked="checked"
										                                               id="input-module_mono_merchant"/>
										                                    <?php } else { ?>
										                                        <input type="checkbox" name="module_mono_checkout_merchant_user" value="1"
										                                               id="input-module_mono_merchant"/>
										                                    <?php } ?>
										                                </label>
										                            </div>
										                        </div>
										                    </div> -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-module_mono_cart_show">
							<span data-toggle="tooltip" title="<?= $help_cart_show ?>"><?= $entry_cart_show ?></span>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<?php if($module_mono_checkout_cart_show) { ?>
										<input type="checkbox" name="module_mono_checkout_cart_show" value="1" checked="checked" id="input-module_mono_cart_show"/>
									<?php } else { ?>
										<input type="checkbox" name="module_mono_checkout_cart_show" value="1" id="input-module_mono_cart_show"/>
									<?php } ?>
								</label>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cart_elem">
                            <span data-toggle="tooltip" title="<?= $help_elem ?>"><?= $entry_cart_elem ?></span>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="text" name="module_mono_checkout_cart_elem" value="<?= $module_mono_checkout_cart_elem ?>" placeholder="<?= $entry_cart_elem ?>" id="input-cart_elem" class="form-control"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cart_popup_elem">
                            <span data-toggle="tooltip" title="<?= $help_elem ?>"><?= $entry_cart_popup_elem ?></span>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="text" name="module_mono_checkout_cart_popup_elem" value="<?= $module_mono_checkout_cart_popup_elem ?>" placeholder="<?= $entry_cart_popup_elem ?>" id="input-cart_popup_elem" class="form-control"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <?= $text_popup_faq ?>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-cart_show_size_w">
							<?= $entry_cart_show_size_w ?>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="number" name="module_mono_checkout_cart_show_size_w" value="<?= $module_mono_checkout_cart_show_size_w ?>" placeholder="<?= $entry_cart_show_size_w ?>" id="input-cart_show_size_w" class="form-control"/>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-cart_show_size_h">
							<?= $entry_cart_show_size_h ?>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="number" name="module_mono_checkout_cart_show_size_h" value="<?= $module_mono_checkout_cart_show_size_h ?>" placeholder="<?= $entry_cart_show_size_h ?>" id="input-cart_show_size_h" class="form-control"/>
								</label>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cart_popup_show_size_w">
                            <?= $entry_cart_popup_show_size_w ?>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="number" name="module_mono_checkout_cart_popup_show_size_w" value="<?= $module_mono_checkout_cart_popup_show_size_w ?>" placeholder="<?= $entry_cart_popup_show_size_w ?>" id="input-cart_popup_show_size_w" class="form-control"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cart_popup_show_size_h">
                            <?= $entry_cart_popup_show_size_h ?>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="number" name="module_mono_checkout_cart_popup_show_size_h" value="<?= $module_mono_checkout_cart_popup_show_size_h ?>" placeholder="<?= $entry_cart_popup_show_size_h ?>" id="input-cart_popup_show_size_h" class="form-control"/>
                                </label>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-module_mono_product_show">
							<span data-toggle="tooltip" title="<?= $help_product_show ?>"><?= $entry_product_show ?></span>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
                                <?php if($module_mono_checkout_product_show ) { ?>
										<input type="checkbox" name="module_mono_checkout_product_show" value="1" checked="checked" id="input-module_mono_product_show"/>
									<?php } else { ?>
										<input type="checkbox" name="module_mono_checkout_product_show" value="1" id="input-module_mono_product_show"/>
									<?php } ?>
								</label>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-product_elem">
                            <span data-toggle="tooltip" title="<?= $help_elem ?>"><?= $entry_product_elem ?></span>
                        </label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="text" name="module_mono_checkout_product_elem" value="<?= $module_mono_checkout_product_elem ?>" placeholder="<?= $entry_product_elem ?>" id="input-product_elem" class="form-control"/>
                                </label>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-product_show_size_w">
							<?= $entry_product_show_size_w ?>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="number" name="module_mono_checkout_product_show_size_w" value="<?= $module_mono_checkout_product_show_size_w ?>" placeholder="<?= $entry_product_show_size_w ?>" id="input-product_show_size_w" class="form-control"/>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-product_show_size_h">
						    <?= $entry_product_show_size_h ?>
						</label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="number" name="module_mono_checkout_product_show_size_h" value="<?= $module_mono_checkout_product_show_size_h ?>" placeholder="<?= $entry_product_show_size_h ?>" id="input-product_show_size_h" class="form-control"/>
								</label>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?= $entry_button ?></label>
                        <div class="col-sm-10">
                            <label class="radio">
                                <input type="radio" name="module_mono_checkout_button" value="black" <?php if($module_mono_checkout_button == 'black' || !$module_mono_checkout_button) { ?> checked="checked" <?php } ?>/>
                                <img src="view/image/mono_checkout/monocheckout_button_black_normal.svg" alt="monocheckout_button_black_normal">
                            </label>
                            <label class="radio">
                                <input type="radio" name="module_mono_checkout_button" value="white" <?php if($module_mono_checkout_button == 'white') { ?> checked="checked" <?php } ?>/>
                                <img src="view/image/mono_checkout/monocheckout_button_white_normal.svg" alt="monocheckout_button_white_normal">
                            </label>
                            <label class="radio">
                                <input type="radio" name="module_mono_checkout_button" value="black_short" <?php if($module_mono_checkout_button == 'black_short') { ?> checked="checked" <?php } ?>/>
                                <img src="view/image/mono_checkout/monocheckout_button_black_short.svg" alt="monocheckout_button_black_short">
                            </label>
                            <label class="radio">
                                <input type="radio" name="module_mono_checkout_button" value="white_short" <?php if($module_mono_checkout_button == 'white_short') { ?> checked="checked" <?php } ?>/>
                                <img src="view/image/mono_checkout/monocheckout_button_white_short.svg" alt="monocheckout_button_white_short">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?= $entry_status ?></label>
                        <div class="col-sm-10">
                            <select name="module_mono_checkout_status" id="input-status" class="form-control">
                                <?php if($module_mono_checkout_status) { ?>
                                <option value="1" selected="selected"><?= $text_enabled ?></option>
                                <option value="0"><?= $text_disabled ?></option>
                                <?php } else { ?>
                                <option value="1"><?= $text_enabled ?></option>
                                <option value="0" selected="selected"><?= $text_disabled ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#input-payments_number').on('change', function () {
            if($(this).val() < 3) $(this).val(3)
            if($(this).val() > 25) $(this).val(25)
        })
    })
</script>
<?= $footer ?>
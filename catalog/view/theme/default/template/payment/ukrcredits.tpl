<div class="pull-right">
<link href="catalog/view/theme/default/stylesheet/calculator.css" rel="stylesheet" type="text/css">
	<div id="prop<?php echo $credit['type']; ?>" class="proposition">
		<div class="prop_calc">
			<span><?php echo $credit['name']; ?>: </span>			
			<div class="prop_paymentsCount">
				<?php echo $credit['partsCount']; ?>
			</div>
			<div class="prop_select">
				<select id="termInput<?php echo $credit['type']; ?>" name="select<?php echo $credit['type']; ?>" class="form-control">
						<?php if (isset($credit['mounth']) && $credit['mounth']) { ?>
							<?php foreach ($credit['mounth'] as $key=>$value) { ?>
							  <?php if ($key <= $credit['partsCount']) { ?>
								<option value="<?php echo $key; ?>"><?php echo $key; ?> <?php echo $text_mounth; ?></option>
							  <?php } ?>
							<?php } ?>
						<?php } else { ?>
							<?php for(($credit['type']=='MB' || $credit['type']=='PU')?$i=2:$i=1;$i<=$credit['partsCount'];$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo $text_mounth; ?></option>
							<?php } ?>
						<?php } ?> 
				</select>
			</div>
			<div class="prop_permounth">
				<?php echo $text_per; ?> <?php echo $currency_left; ?><span><?php echo round($credit['price']); ?></span><?php echo $currency_right; ?>
			</div>
			<div class="prop_price">
				<?php echo $text_total; ?> <?php echo $currency_left; ?><span><?php echo round($credit['price']); ?></span><?php echo $currency_right; ?>
			</div>
		</div>
		<div id="termSlider<?php echo $credit['type']; ?>" <?php echo ($credit['type']=='AB'||$credit['type']=='SB')?'style="display:none"':''; ?>>
			<div class="progress">
				<div id="termProgress<?php echo $credit['type']; ?>" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
			</div>
		</div>			
	</div> 
	<?php if ($credit['type'] == 'AB') { ?>
	<div class="form-group required">
        <label class="control-label" for="input-panEnd"><?php echo $text_panEnd; ?></label>
        <input type="number" name="panEnd" value="<?php echo $panEnd; ?>" placeholder="XXXX" id="input-panEnd" class="form-control">
    </div>
	<?php } ?>
	<?php if ($credit['type'] == 'PL') { ?>
	<div class="form-group required">
        <label class="control-label" for="input-f"><?php echo $text_f; ?></label>
        <input type="text" name="pldata[f]" value="<?php echo $f; ?>" placeholder="<?php echo $text_f; ?>" id="input-f" class="form-control">
    </div>
	<div class="form-group required">
        <label class="control-label" for="input-i"><?php echo $text_i; ?></label>
        <input type="text" name="pldata[i]" value="<?php echo $i; ?>" placeholder="<?php echo $text_i; ?>" id="input-i" class="form-control">
    </div>
	<div class="form-group required">
        <label class="control-label" for="input-o"><?php echo $text_o; ?></label>
        <input type="text" name="pldata[o]" value="<?php echo $o; ?>" placeholder="<?php echo $text_o; ?>" id="input-o" class="form-control">
    </div>
	<div class="form-group required">
        <label class="control-label" for="input-bd"><?php echo $text_bd; ?></label>
        <input type="text" name="pldata[bd]" value="<?php echo $bd; ?>" placeholder="<?php echo $text_bd; ?>" id="input-bd" class="form-control">
    </div>
	<div class="form-group required">
        <label class="control-label" for="input-phone"><?php echo $text_phone; ?></label>
        <input type="text" name="pldata[phone]" value="<?php echo $phone; ?>" placeholder="<?php echo $text_phone; ?>" id="input-phone" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-phoned"><?php echo $text_phoned; ?></label>
        <input type="text" name="pldata[phoned]" value="<?php echo $phoned; ?>" placeholder="<?php echo $text_phoned; ?>" id="input-phoned" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-madr"><?php echo $text_madr; ?></label>
        <input type="text" name="pldata[madr]" value="<?php echo $madr; ?>" placeholder="<?php echo $text_madr; ?>" id="input-madr" class="form-control">
    </div>
	<div class="form-group required">
        <label class="control-label" for="input-inn"><?php echo $text_inn; ?></label>
        <input type="text" name="pldata[inn]" value="<?php echo $inn; ?>" placeholder="<?php echo $text_inn; ?>" id="input-inn" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-sp"><?php echo $text_sp; ?></label>
        <input type="text" name="pldata[sp]" value="<?php echo $sp; ?>" placeholder="<?php echo $text_sp; ?>" id="input-sp" class="form-control">
    </div>	
	<div class="form-group">
        <label class="control-label" for="input-psp"><?php echo $text_psp; ?></label>
        <input type="text" name="pldata[psp]" value="<?php echo $psp; ?>" placeholder="<?php echo $text_psp; ?>" id="input-psp" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-god"><?php echo $text_god; ?></label>
        <input type="text" name="pldata[god]" value="<?php echo $god; ?>" placeholder="<?php echo $text_god; ?>" id="input-god" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-psp_dv"><?php echo $text_psp_dv; ?></label>
        <input type="text" name="pldata[psp_dv]" value="<?php echo $psp_dv; ?>" placeholder="<?php echo $text_psp_dv; ?>" id="input-psp_dv" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-pkv"><?php echo $text_pkv; ?></label>
        <input type="text" name="pldata[pkv]" value="<?php echo $pkv; ?>" placeholder="<?php echo $text_pkv; ?>" id="input-pkv" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-radr"><?php echo $text_radr; ?></label>
        <input type="text" name="pldata[radr]" value="<?php echo $radr; ?>" placeholder="<?php echo $text_radr; ?>" id="input-radr" class="form-control">
    </div>
	<!--
	<div class="form-group">
        <label class="control-label" for="input-ladr"><?php echo $text_ladr; ?></label>
        <input type="text" name="pldata[ladr]" value="<?php echo $ladr; ?>" placeholder="<?php echo $text_ladr; ?>" id="input-ladr" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-ind"><?php echo $text_ind; ?></label>
        <input type="text" name="pldata[ind]" value="<?php echo $ind; ?>" placeholder="<?php echo $text_ind; ?>" id="input-ind" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-obr"><?php echo $text_obr; ?></label>
        <input type="text" name="pldata[obr]" value="<?php echo $obr; ?>" placeholder="<?php echo $text_obr; ?>" id="input-obr" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-vuz"><?php echo $text_vuz; ?></label>
        <input type="text" name="pldata[vuz]" value="<?php echo $vuz; ?>" placeholder="<?php echo $text_vuz; ?>" id="input-vuz" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-rab"><?php echo $text_rab; ?></label>
        <input type="text" name="pldata[rab]" value="<?php echo $rab; ?>" placeholder="<?php echo $text_rab; ?>" id="input-rab" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-rabt"><?php echo $text_rabt; ?></label>
        <input type="text" name="pldata[rabt]" value="<?php echo $rabt; ?>" placeholder="<?php echo $text_rabt; ?>" id="input-rabt" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-raba"><?php echo $text_raba; ?></label>
        <input type="text" name="pldata[raba]" value="<?php echo $raba; ?>" placeholder="<?php echo $text_raba; ?>" id="input-raba" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-char"><?php echo $text_char; ?></label>
        <input type="text" name="pldata[char]" value="<?php echo $char; ?>" placeholder="<?php echo $text_char; ?>" id="input-char" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-spol"><?php echo $text_spol; ?></label>
        <input type="text" name="pldata[spol]" value="<?php echo $spol; ?>" placeholder="<?php echo $text_spol; ?>" id="input-spol" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-det"><?php echo $text_det; ?></label>
        <input type="text" name="pldata[det]" value="<?php echo $det; ?>" placeholder="<?php echo $text_det; ?>" id="input-det" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-soj"><?php echo $text_soj; ?></label>
        <input type="text" name="pldata[soj]" value="<?php echo $soj; ?>" placeholder="<?php echo $text_soj; ?>" id="input-soj" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-comentar"><?php echo $text_comentar; ?></label>
        <input type="text" name="pldata[comentar]" value="<?php echo $comentar; ?>" placeholder="<?php echo $text_comentar; ?>" id="input-comentar" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-o"><?php echo $text_tfio; ?></label>
        <input type="text" name="pldata[tfio]" value="<?php echo $tfio; ?>" placeholder="<?php echo $text_tfio; ?>" id="input-tfio" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-ttel"><?php echo $text_ttel; ?></label>
        <input type="text" name="pldata[ttel]" value="<?php echo $ttel; ?>" placeholder="<?php echo $text_ttel; ?>" id="input-ttel" class="form-control">
    </div>
	<div class="form-group">
        <label class="control-label" for="input-tsot"><?php echo $text_tsot; ?></label>
        <input type="text" name="pldata[tsot]" value="<?php echo $tsot; ?>" placeholder="<?php echo $text_tsot; ?>" id="input-tsot" class="form-control">
    </div>
	-->
	<?php } ?>
	<div class="buttons">
	<?php if ($oc15) { ?>
	  <div class="right">
		<input type="submit" data-id="<?php echo str_replace(array('ia','pb'),array('ii','pp'),mb_strtolower($credit['type'])); ?>" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
	  </div>
	<?php } else { ?>
	  <div class="pull-right">
		<button type="button" data-id="<?php echo str_replace(array('ia','pb'),array('ii','pp'),mb_strtolower($credit['type'])); ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>"><?php echo $button_confirm; ?></button>
	  </div>
	<?php } ?>
	</div>	
</div>
<script>
var UCconstants = {
	'termStep': 1,
	'priceInitial<?php echo $credit['type']; ?>': <?php echo round($credit['price'], 2); ?>,
	'termMax<?php echo $credit['type']; ?>': <?php echo isset($credit['partsCount'])?$credit['partsCount']:24; ?>,
	'termMin<?php echo $credit['type']; ?>': <?php echo ($credit['type']=='MB' || $credit['type']=='PU')?2:(($credit['type']=='AB')?3:((isset($ukrcredits_pl_data)&&$ukrcredits_pl_data)?$ukrcredits_pl_data['pack0']['count']:((($credit['type']=='SB')&&(isset($ukrcredits_sb_data)&&$ukrcredits_sb_data))?key($ukrcredits_sb_data):1))); ?>,
	'termSelected<?php echo $credit['type']; ?>': <?php echo $credit['partsCountSel']?$credit['partsCountSel']:($credit['type']=='MB'?2:(($credit['type']=='AB')?3:((isset($ukrcredits_pl_data)&&$ukrcredits_pl_data)?$ukrcredits_pl_data['pack0']['count']:((($credit['type']=='SB')&&(isset($ukrcredits_sb_data)&&$ukrcredits_sb_data))?key($ukrcredits_sb_data):1)))); ?>,
};
UCinitElements = function () {
	UCinitTermInput<?php echo $credit['type']; ?>();
	UCinitTermSlider<?php echo $credit['type']; ?>();
},
UCinitTermSlider<?php echo $credit['type']; ?> = function () {
	$("#termSlider<?php echo $credit['type']; ?>").slider({
		value: UCconstants.termSelected<?php echo $credit['type']; ?>,
		max: UCconstants.termMax<?php echo $credit['type']; ?>,
		min: UCconstants.termMin<?php echo $credit['type']; ?>,
		step: UCconstants.termStep,
		slide: function (event, ui) {
			UCsliderMoved($(this), $("#termInput<?php echo $credit['type']; ?>"), $("#termProgress<?php echo $credit['type']; ?>"), ui.value);
		}
	});
	var initprogress<?php echo $credit['type']; ?> = (UCconstants.termSelected<?php echo $credit['type']; ?> - UCconstants.termMin<?php echo $credit['type']; ?>) * 100 / ( UCconstants.termMax<?php echo $credit['type']; ?> - UCconstants.termMin<?php echo $credit['type']; ?> );
	$("#termProgress<?php echo $credit['type']; ?>").css('width', initprogress<?php echo $credit['type']; ?> + "%");
},
UCinitTermInput<?php echo $credit['type']; ?> = function () {
	var $inp = $("#termInput<?php echo $credit['type']; ?>");
	$inp.attr("min", UCconstants.termMin<?php echo $credit['type']; ?>);
	$inp.attr("max", UCconstants.termMax<?php echo $credit['type']; ?>);
	$inp.val(UCconstants.termSelected<?php echo $credit['type']; ?>);
	$inp.on('change', function () {
		UCinputChanged($inp, $("#termSlider<?php echo $credit['type']; ?>"), $("#termProgress<?php echo $credit['type']; ?>"));
	});
},
UCsliderMoved = function (slider, inputToChange, progressToChange, newValue) {
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    inputToChange.val(newValue);
    var progress = (newValue - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
	UCcalc();
	savepartscount(inputToChange.attr('id'),newValue);
},
UCinputChanged = function (input, slider, progressToChange) {
    var newVal = input.val();
    slider.slider("value", newVal);
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    var progress = (newVal - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
	UCcalc();
	savepartscount(input.attr('id'),input.val());
},
savepartscount = function(selector,partscount){
	type = selector.substr(-2).toLowerCase().replace('ia','ii').replace('pb','pp');
	$.ajax({
		type: 'POST',
		url: 'index.php?route=payment/ukrcredits_' + type + '/setUkrcreditsType',
		dataType: 'json',
		data: {partsCount: partscount},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}		     
	});
	<?php if ($ukrcredits_setting[str_replace(array('ia','pb'),array('ii','pp'),mb_strtolower($credit['type'])).'_markup_type'] == 'custom') { ?>
	setTimeout(function () {
		$.ajax({
			url: 'index.php?route=checkout/confirm',
			dataType: 'html',
			complete: function() {
				$('#button-payment-method').button('reset');
			},
			success: function(html) {
				$('#collapse-checkout-confirm .panel-body').html(html);
				$('#confirm .checkout-content').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}, 100);
	<?php } ?>
},
payments = [<?php echo $text_payments; ?>],
declOfNum = function(number, titles) {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>7 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
},
UCcalc = function(){
	var resCalc<?php echo $credit['type']; ?> = UC_CALCULATOR.calculatePhys($('#termInput<?php echo $credit['type']; ?>').val()<?php if ($credit['type'] == 'PU') { ?>-1<?php } ?>, UCconstants.priceInitial<?php echo $credit['type']; ?>); 
	if (resCalc<?php echo $credit['type']; ?> != undefined) {
		$('#prop<?php echo $credit['type']; ?> .prop_paymentsCount').html(resCalc<?php echo $credit['type']; ?>.payCount + ' ' + declOfNum(resCalc<?php echo $credit['type']; ?>.payCount,payments));
		$('#paymentsCount<?php echo $credit['type']; ?>').html(resCalc<?php echo $credit['type']; ?>.payCount);
		$('#prop<?php echo $credit['type']; ?> .prop_permounth span').html(resCalc<?php echo $credit['type']; ?>.<?php echo mb_strtolower($credit['type']); ?>Value);
		$('#prop<?php echo $credit['type']; ?> .prop_price span').html(resCalc<?php echo $credit['type']; ?>.<?php echo mb_strtolower($credit['type']); ?>Price);
	}
},
UC_CALCULATOR = (function () {
    var uc = {};
    function privParseInt(num) {
        return parseInt(num, 10)
    }

    uc.calculatePhys = function (paymentsCount, price) {
		<?php if (isset($ukrcredits_pl_data['data']) && $ukrcredits_pl_data['data']) { ?>
		var pl_data = $.parseJSON('<?php echo json_encode($ukrcredits_pl_data['data']); ?>');
		pl_data_markupPL = Number((pl_data[paymentsCount]));	
		<?php } else { ?>	
		pl_data_markupPL = 1;
		<?php } ?>
        if (isNaN(paymentsCount) || isNaN(price)) return;
        paymentsCount = privParseInt(paymentsCount) + 1;
        price = privParseInt(price);
        var ip = price / paymentsCount + price * (1.9 / 100);
        var pp = price / paymentsCount;
		var ab = price / (paymentsCount-1);
        var ia = (price / paymentsCount) + (price * 0.99 / 100);
		var pl = price / pl_data_markupPL / paymentsCount;

		var sb = (price) / 3;
		price_sb = price;
			
		if ((paymentsCount-1) == 3) {
			var sb = (price + 500) / 3;
			price_sb = price + 500;
		}
		if ((paymentsCount-1) == 5) {
			var sb = (price+(price*0.0527+250))/5;
			price_sb = price+(price*0.0527+250);
		}		
		if ((paymentsCount-1) == 10) {
			var sb = (price+(price*0.111+500))/10;
			price_sb = price+(price*0.111+500);
		}	
		if ((paymentsCount-1) == 12) {
			var sb = (price+(price*0.1364+600))/12;
			price_sb = price+(price*0.1364+600);
		}
		
        return ({
            payCount: paymentsCount,
            ppValue: pp.toFixed(2),
			pbValue: pp.toFixed(2),
            iiValue: ip.toFixed(2),
            iaValue: ia.toFixed(2),
			mbValue: pp.toFixed(2),
			abValue: ab.toFixed(2),
			aaValue: pp.toFixed(2),
			plValue: pl.toFixed(2),
			puValue: pp.toFixed(2),
			sbValue: sb.toFixed(2),
			iiPrice: (price + (price * (1.9 / 100) * paymentsCount)).toFixed(2),
			iaPrice: (price + (price * (0.99 / 100) * paymentsCount)).toFixed(2),
			plPrice: (price/pl_data_markupPL).toFixed(2),
			sbPrice: price_sb.toFixed(2),
        });
    };
    return uc;
}());
$(document).ready(function() {
    UCinitElements();
    UCcalc();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	if (window.location.href.indexOf("simple") > -1) { 
		<?php if ($oc15) { ?>
		$('#simplecheckout_payment_form').hide();
		<?php } else { ?>
		$('.proposition').hide();
		<?php } ?>
	}
	$('.proposition').parent().parent().removeClass('d-none');
    $('.proposition').parent().find('<?php echo $oc15?"input":"button" ?>').click(function(){
        var error = false;
        partsCounArr = {
			partsCount: parseInt($('#termInput<?php echo $credit['type']; ?>').val())+1,
			panEnd: $('#input-panEnd').val(),
			pldata: {
				f: $('#input-f').val(),
				i: $('#input-i').val(),
				o: $('#input-o').val(),
				bd: $('#input-bd').val(),
				phone: $('#input-phone').val(),
				phoned: $('#input-phoned').val(),
				madr: $('#input-madr').val(),
				inn: $('#input-inn').val(),
				sp: $('#input-sp').val(),
				psp: $('#input-psp').val(),
				god: $('#input-god').val(),
				psp_dv: $('#input-psp_dv').val(),
				pkv: $('#input-pkv').val(),
				radr: $('#input-radr').val(),
				ladr: $('#input-ladr').val(),
				ind: $('#input-ind').val(),
				obr: $('#input-obr').val(),
				vuz: $('#input-vuz').val(),
				rab: $('#input-rab').val(),
				rabt: $('#input-rabt').val(),
				raba: $('#input-raba').val(),
				char: $('#input-char').val(),
				spol: $('#input-spol').val(),
				det: $('#input-det').val(),
				vdet: $('#input-vdet').val(),
				soj: $('#input-soj').val(),
				comentar: $('#input-comentar').val(),
				tfio: $('#input-tfio').val(),
				ttel: $('#input-ttel').val(),
				tsot: $('#input-tsot').val(),	
			}
		};       

        $.ajax({
            type: 'POST',
            url: '<?php echo $action; ?>',
            dataType: 'json',
            data: partsCounArr,
			beforeSend: function() {
			  $('#button-confirm').button('loading');
			  $('.alert').remove();
			  $('.text-danger').remove();
			  $('.form-group').removeClass('has-error');
			},
			complete: function() {
			  $('#button-confirm').button('reset');
			},	
               success: function(data){ // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
               console.log(data);
<?php if ($credit['type'] == 'MB') { ?>
				   $('.proposition').parent().parent().find('.alert').remove();
				   $('.simplecheckout-button-block').find('.alert').remove();
				   
				   if (data['message']) {
						$('.proposition').parent().before('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				   }
			   
				   if (data['order_id']) {
						$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						setTimeout(function () {
							window.location = '<?php echo $success; ?>';
						}, 5000);
				   
					}

<?php } else if ($credit['type'] == 'AB') { ?>
				   if (data['statusCode'] != 'IN_PROCESSING') {
						$('.proposition').parent().before('<div class="alert alert-warning">' + (typeof(data['statusText']) != 'undefined' ? data['statusText'] : data['errorMessage']) + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('#button-confirm').button('reset');
				   } else {
						$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('.proposition').parent().find('.buttons').hide();
						$('.simplecheckout-proceed-payment').hide();
						$('.simplecheckout-proceed-payment').next().hide();
						setTimeout(function () {
							window.location = '<?php echo $success; ?>';
						}, 5000);
				   }
<?php } else if ($credit['type'] == 'AA') { ?>
				   $('.proposition').parent().parent().find('.alert').remove();
				   $('.simplecheckout-button-block').find('.alert').remove();
				   
				   if (data['message']) {
						$('.proposition').parent().before('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				   }
			   
				   if (data['order_id']) {
						$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						setTimeout(function () {
							window.location = '<?php echo $success; ?>';
						}, 5000);
				   
					}				   
<?php } else if ($credit['type'] == 'PL') { ?>
					if (!data['error']) {
					   if (typeof(data['status']) != 'undefined' && data['status'] != '2') {
							$('.proposition').parent().before('<div class="alert alert-warning">' + (typeof(data['data']) != 'undefined' ? data['data'] : data['data']) + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#button-confirm').button('reset');
					   } else {
					   
							$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('.proposition').parent().find('.buttons').hide();
							$('.simplecheckout-proceed-payment').hide();
							$('.simplecheckout-proceed-payment').next().hide();
							setTimeout(function () {
								window.location = '<?php echo $success; ?>';
							}, 100);
						
					   }
					} else {
						console.log(data['error']);
						
						if (data['error']['token']) {
							$('.proposition').parent().before('<div class="alert alert-warning">' + data['error']['token'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#button-confirm').parent().parent().prepend('<div class="text-danger">' + data['error']['token'] + '</div>');
						} else {
							if (data['error']['f']) {
								$('#input-f').parent().addClass('has-error');
								$('#input-f').parent().append('<div class="text-danger">' + data['error']['f'] + '</div>');
							}
							if (data['error']['i']) {
								$('#input-i').parent().addClass('has-error');
								$('#input-i').parent().append('<div class="text-danger">' + data['error']['i'] + '</div>');
							}
							if (data['error']['o']) {
								$('#input-o').parent().addClass('has-error');
								$('#input-o').parent().append('<div class="text-danger">' + data['error']['o'] + '</div>');
							}
							if (data['error']['inn']) {
								$('#input-inn').parent().addClass('has-error');
								$('#input-inn').parent().append('<div class="text-danger">' + data['error']['inn'] + '</div>');
							}
							if (data['error']['sp']) {
								$('#input-sp').parent().addClass('has-error');
								$('#input-sp').parent().append('<div class="text-danger">' + data['error']['sp'] + '</div>');
							}
							if (data['error']['phone']) {
								$('#input-phone').parent().addClass('has-error');
								$('#input-phone').parent().append('<div class="text-danger">' + data['error']['phone'] + '</div>');
							}
							$('#button-confirm').parent().parent().prepend('<div class="text-danger">' + data['error']['all'] + '</div>');
						}
					}
<?php } else if ($credit['type'] == 'PU') { ?>
                    switch(data['state']){
                        case 'SUCCESS':
							$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							setTimeout(function () {
								window.location = '<?php echo $success; ?>';
							}, 5000);
							break;
                        case 'FAIL':
                            $('.proposition').parent().before('<div class="alert alert-warning 111">' + data['errorMessage'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#button-confirm').button('reset');
                          break;
                        case 'sys_error':
                            $('.proposition').parent().before('<div class="alert alert-warning 222">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');                                          
							$('#button-confirm').button('reset');
                        break;
                    }
<?php } else if ($credit['type'] == 'PP' || $credit['type'] == 'PB' || $credit['type'] == 'II'){ ?>
                    switch(data['state']){
                        case 'SUCCESS':
                            window.location = 'https://payparts2.privatbank.ua/ipp/v2/payment?token='+data['token'];
                            break;
                        case 'FAIL':
                            $('.proposition').parent().before('<div class="alert alert-warning">' + data['errorMessage'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#button-confirm').button('reset');
                          break;
                        case 'sys_error':
                            $('.proposition').parent().before('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');                                          
							$('#button-confirm').button('reset');
                        break;
                    }
<?php } else { ?>
                    switch(data['state']){
                        case 'SUCCESS':
							$('.proposition').parent().before('<div class="alert alert-warning"><?php echo $text_success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            setTimeout(function () {
							window.location = '<?php echo $success; ?>';
							}, 3000);
                            break;
						break;
                    }
<?php } ?>
               },
			error: function(jqXHR, exception) {
			$('.proposition').parent().before('<div class="alert alert-warning">' + jqXHR.responseText + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			} // error
        });
        
        return false;    
    });    
});
</script>

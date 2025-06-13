<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label">UTM Source</label>
                <select name="filter_utm_source" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($utm_source as $utm) { ?>
                  <?php if ($utm === $filter_utm_source) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">UTM Campaign</label>
                <select name="filter_utm_campaign" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($utm_campaign as $utm) { ?>
                  <?php if ($utm === $filter_utm_campaign) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">UTM Medium</label>
                <select name="filter_utm_medium" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($utm_medium as $utm) { ?>
                  <?php if ($utm === $filter_utm_medium) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label">UTM Term</label>
                <select name="filter_utm_term" class="form-control">
			  	  <option value="0">All</option>
                  <?php foreach ($utm_term as $utm) { ?>
                  <?php if ($utm === $filter_utm_term) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">UTM Content</label>
                <select name="filter_utm_content" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($utm_content as $utm) { ?>
                  <?php if ($utm === $filter_utm_content) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select> 
              </div>
              <div class="form-group">
                <label class="control-label">UTM Referrer</label>
                <select name="filter_utm_referrer" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($utm_content as $utm) { ?>
                  <?php if ($utm === $filter_utm_referrer) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label">First Referrer</label>
                <select name="filter_first_referrer" class="form-control">
			  	  <option value="0">All</option>
                  <?php foreach ($first_referrer as $utm) { ?>
                  <?php if ($utm === $filter_first_referrer) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Last Referrer</label>
                <select name="filter_last_referrer" class="form-control">
				  <option value="0">All</option>
                  <?php foreach ($last_referrer as $utm) { ?>
                  <?php if ($utm === $filter_last_referrer) { ?>
                  <option value="<?php echo $utm; ?>" selected="selected"><?php echo $utm; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $utm; ?>"><?php echo $utm; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-group"><?php echo $entry_group; ?></label>
                <select name="filter_group" id="input-group" class="form-control">
                  <?php foreach ($groups as $group) { ?>
                  <?php if ($group['value'] == $filter_group) { ?>
                  <option value="<?php echo $group['value']; ?>" selected="selected"><?php echo $group['text']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $group['value']; ?>"><?php echo $group['text']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_order_status_id" id="input-status" class="form-control">
                  <option value="0"><?php echo $text_all_status; ?></option>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_date_start; ?></td>
                <td class="text-left"><?php echo $column_date_end; ?></td>
                <td class="text-right"><?php echo $column_orders; ?></td>
                <td class="text-right"><?php echo $column_products; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>
                <td class="text-right">Details</td>
              </tr>
            </thead>
            <tbody>
              <?php if ($orders) { ?>
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td class="text-left"><?php echo $order['date_start']; ?></td>
                <td class="text-left"><?php echo $order['date_end']; ?></td>
                <td class="text-right"><?php echo $order['orders']; ?></td>
                <td class="text-right"><?php echo $order['products']; ?></td>
                <td class="text-right"><?php echo $order['total']; ?></td>
                <td class="text-right"><a href="<?php echo $order['details']; ?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Details"><i class="fa fa-eye"></i></a></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div> 
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=report/remarketing_report&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_group = $('select[name=\'filter_group\']').val();
	
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	var filter_utm_source = $('select[name=\'filter_utm_source\']').val();
	
	if (filter_utm_source != 0) {
		url += '&filter_utm_source=' + encodeURIComponent(filter_utm_source);
	}	

	var filter_utm_campaign = $('select[name=\'filter_utm_campaign\']').val();
	
	if (filter_utm_campaign != 0) {
		url += '&filter_utm_campaign=' + encodeURIComponent(filter_utm_campaign);
	}	

	var filter_utm_medium = $('select[name=\'filter_utm_medium\']').val();
	
	if (filter_utm_medium != 0) {
		url += '&filter_utm_medium=' + encodeURIComponent(filter_utm_medium);
	}	

	var filter_utm_term = $('select[name=\'filter_utm_term\']').val();
	
	if (filter_utm_term != 0) {
		url += '&filter_utm_term=' + encodeURIComponent(filter_utm_term);
	}	

	var filter_utm_content = $('select[name=\'filter_utm_content\']').val();
	
	if (filter_utm_content != 0) {
		url += '&filter_utm_content=' + encodeURIComponent(filter_utm_content);
	}	

	var filter_utm_referrer = $('select[name=\'filter_utm_referrer\']').val();
	
	if (filter_utm_referrer != 0) {
		url += '&filter_utm_referrer=' + encodeURIComponent(filter_utm_referrer);
	}	

	var filter_first_referrer = $('select[name=\'filter_first_referrer\']').val();
	
	if (filter_first_referrer != 0) {
		url += '&filter_first_referrer=' + encodeURIComponent(filter_first_referrer);
	}	

	var filter_last_referrer = $('select[name=\'filter_last_referrer\']').val();
	
	if (filter_last_referrer != 0) {
		url += '&filter_last_referrer=' + encodeURIComponent(filter_last_referrer);
	}	

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>
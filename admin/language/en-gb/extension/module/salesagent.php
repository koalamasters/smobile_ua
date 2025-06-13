<?php

$_['main_word']             = 'Person';
$_['main_word_small']               = 'person';

// Heading
$_['heading_title']         = 'Marketing Partner Pro : Commission, Tracking & Reports';

$_['heading_title_list']         = 'Sales '.$_['main_word'].' List';
$_['heading_title_form']         = 'Sales '.$_['main_word'].' Form';
$_['heading_title_catalogform']         = 'Catalog Form Page';
$_['heading_title_catalog']         = 'Catalogs - For Specific Products Commission';
$_['heading_title_orderreport']         = $_['main_word'].' Transaction Report';
$_['heading_title_customerreport']         = $_['main_word'].' Customer Report';


// Settings
$_['tab_agent_selection']   = "Person Selection";
$_['tab_backend_display']   = "Backend Display";
$_['tab_commission_calculation']   = "Commission Calculation";
$_['tab_agent_multistore']   = "Multi Store";
$_['tab_agent_permission']   = "Permissions Control";
$_['tab_transaction_styling']   = "Transaction Page Styling";

$_['tab_agent_selection_note'] = "Below 3 options are necessary if you want to display sales ".$_['main_word_small']." on the front end and then customers can select them. You can ignore below if you are using unique sales ".$_['main_word_small']." link. Via link the selection on the front end is not necessary.";

$_['text_success']          = 'Success: You have modified Sales '.$_['main_word'].'!';
$_['text_list']             = 'Sales '.$_['main_word'].' List';
$_['text_payout_list']             = 'Sales '.$_['main_word'].' Payout List';
$_['text_clist']             = 'Catalog List';
$_['text_add']              = 'Add Sales '.$_['main_word'];
$_['text_edit']             = 'Edit Sales '.$_['main_word'];
$_['text_default']          = 'Default';
$_['text_pleaseselect']     = 'No Sales '.$_['main_word'];
$_['text_balance']          = 'Balance';
$_['text_settings']         = "Settings";
$_['text_salesagent_register']          = 'Display On Account Registeration Page';
$_['text_salesagent_checkout']          = 'Display On Checkout Page';
$_['text_salesagent_backend_checkout']      = 'Display On Order List Page';
$_['text_salesagent_orderhistory']          = 'Display On Order History Page';
$_['text_salesagent_orderformedit']         = 'Display On Order Edit Backend';
$_['text_salesagent_customershow']          = 'Display On Customer Form Edit Page';

$_['text_salesagent_deleteorder']           = 'Allow Delete Order?';
$_['text_salesagent_addorderhistory']           = 'Allow Order Status Change?';
$_['text_salesagent_autostore']             = 'Auto Select sales '.$_['main_word_small'].' Based On Store';
$_['text_orderstatus_display']              = 'Order Status That Marks A Successfully Delivered Order';
$_['help_orderstatus_display']              = 'Select the order status that means order was successful completed or delivered. These orders would be shown on the transaction page for payouts';


$_['entry_selectstates']  = "Regions Covered";
$_['help_selectstates'] = "Enter states for which you want to assign these sales agent";

$_['text_usergrouprestrictions']  = "User Group Additional Restrictions";
$_['help_usergrouprestrictions'] = "If you forgot to connect the user to the agent, it can show the user all the orders and customers. To avoid that, please mark the user groups on which restrictions will apply.";

$_['text_salesagent_commissiontotal']    = "Calculate Commission On";

$_['text_salesagent_coupondiscount']    = "Remove Coupon Discount From Sub Total";
$_['help_salesagent_coupondiscount']    = "If you want to remove coupon discount from the calculation use this option. Will work if you have commission set up on entire order. If commission is set up on catalog this option cannot work.";

$_['text_salesagent_storecredit']       = "Remove Store Credit From Sub Total";

$_['help_salesagent_storecredit']    = "If you want to remove store creidt discount from the calculation use this option. Will work if you have commission set up on entire order. If commission is set up on catalog this option cannot work.";


$_['text_salesagent_recurrsive']            = "Recursive Future Commission";

$_['text_subtotal']  = "Sub total";
$_['text_total']    = "Total";
$_['text_salesagent_clist'] = 'Sales '.$_['main_word_small'].' catalog commission';
$_['help_orderstatuspermission']     = "You can restrict sales ".$_['main_word_small']." for updating orders, if they already have certain order status which you can mark here";
$_['text_orderstatuspermission']     = "Select Order Status Not Allowed To Edit";

$_['text_unpaid_color']  = "Select background color for unpaid commissions";
$_['text_paid_color']    = "Select background color for paid commissions";
$_['text_cancelled_color']   = "Select background color for cancelled orders";

$_['text_unpaid_commission'] = 'Unpaid Commission';
$_['text_paid_commission'] = 'Paid Commission';


$_['entry_clist'] = "Enter Catalog Name";
$_['text_salesagent_selecttype'] = "sales ".$_['main_word_small']." Box Selection Type";
$_['help_salesagent_selecttype'] = "If you are displaying sales ".$_['main_word_small']." selection on the front end. Then the customers can either select via select box or via input box. Input box allows hiding other sales ".$_['main_word_small']."s name. And customer must search via unique code in the input box.";
$_['text_yes']              = "Yes";
$_['text_no']               = "No";
$_['text_salesagentname']   = $_['main_word']." Name";

$_['text_salesagent']       = 'Select Your Sales '.$_['main_word'].' Name';

// Column
$_['column_name']           = $_['main_word'].' Name';
$_['column_email']          = 'E-Mail';
$_['column_status']         = 'Status';
$_['column_date_added']     = 'Date Added';
$_['column_image']          = 'Image Proof';
$_['column_comment']        = 'Comment';
$_['column_description']    = 'Description';
$_['column_amount']         = 'Amount';
$_['column_total']          = 'Total';
$_['column_action']         = 'Action';

$_['text_image_not_added']  = "Not Uploaded";

// Entry
$_['entry_firstname']       = 'First Name';
$_['entry_lastname']        = 'Last Name';
$_['entry_email']           = 'E-Mail';
$_['entry_telephone']       = 'Telephone';
$_['entry_user']            = "Connect With User";
$_['entry_fax']             = 'Fax';
$_['entry_status']          = 'Status';
$_['entry_address']          = 'Address';
$_['entry_city']            = 'City';
$_['entry_date_added']      = 'Date Added';
$_['entry_alertemail']      = 'Alert Email';
$_['entry_commission']      = 'Enter Commission';
$_['entry_customergroup_commission']   = "Customer Group Based Commission";
$_['entry_uniqueid']      = 'Enter Unique Id';
$_['entry_store']       = "Select Store";

$_['uniqueid_help']      = 'The unique id can be added at end of links when sales '.$_['main_word_small'].' shares any link from your store. So it can be used for tracking purpose.';
$_['uniqueid_exist']      = ' Add below code at end of link you wish to share:<br><br><b>';


$_['entry_parent']          = 'Enter Direct Parent';
$_['entry_parent_commission']     = 'Direct Parent commission';
$_['text_second_parent']     = 'Master Parent Name';
$_['entry_second_parent_commission']     = 'Master Parent commission';

$_['entry_salesagent']      = 'Enter Sales '.$_['main_word'];
$_['entry_expiry_date']      = "Commission expiry date";

// Help

// Error
$_['error_warning']         = 'Warning: Please check the form carefully for errors!';
$_['error_permission']      = 'Warning: You do not have permission to modify Sales '.$_['main_word'].'!';
$_['error_permission_payouts']      = 'Warning: You do not have permission to modify payouts';
$_['error_exists']          = 'Warning: E-Mail Address is already registered!';
$_['error_uniqueid_exists'] = "Warning: Unique id is already used. Please add new one";
$_['error_firstname']       = 'First Name must be between 1 and 32 characters!';
$_['error_lastname']        = 'Last Name must be between 1 and 32 characters!';
$_['error_email']           = 'E-Mail Address does not appear to be valid!';
$_['error_telephone']       = 'Telephone must be between 3 and 32 characters!';
$_['error_password']        = 'Password must be between 4 and 20 characters!';
$_['error_confirm']         = 'Password and password confirmation do not match!';
$_['error_address_1']       = 'Address 1 must be between 3 and 128 characters!';
$_['error_city']            = 'City must be between 2 and 128 characters!';
$_['error_postcode']        = 'Postcode must be between 2 and 10 characters for this country!';
$_['error_country']         = 'Please select a country!';
$_['error_zone']            = 'Please select a region / state!';
$_['error_custom_field']    = '%s required!';
$_['error_same_parent']     = 'Warning: You cannot make parent same as current sales '.$_['main_word_small'];
$_['error_clist'] = "Warning: You can add same catalog multiple times. Please add only once";

$_['column_catalog_name']            = 'Catalog Name';

$_['text_filter_name']       = 'Enter Catalog Name';
$_['button_filter']          = "Filter";

$_['entry_name']             = 'Catalog Name';
$_['entry_products']         = "Enter Product Names";
$_['entry_categories']       = "Enter Category Name";

$_['text_subject'] = "New Signup Received: %s";
$_['text_congrats'] = "Congratulations %s !! A new customer has signed up on %s with your reference.";
$_['text_firstname']      = 'First Name:';
$_['text_lastname']       = 'Last Name:';
$_['text_email']          = 'E-Mail:';
$_['text_telephone']      = 'Telephone:';

//reports

$_['heading_title_report']     = 'Sales '.$_['main_word'].' Order Report';
$_['heading_title_customer']     = 'Sales '.$_['main_word'].' Customer Report';
$_['heading_title_payouts']     = 'Sales '.$_['main_word'].' Payout Report';
$_['heading_title_payout_details'] = 'Sales '.$_['main_word'].' Payout Details';
$_['text_make_payout'] = "Make payout for <b>%s orders</b> below: ";
$_['help_only_successfully']    = "- Please note only order that have <b>selected order status</b> would show up here.<br>- You can control the order status from the <b>settings page</b>.<br>- Orders outside those status are considered pending / failed orders and hence it won't show for Payouts.";
$_['help_make_payouts']         = "There are 2 ways to make payout for the agent.<br>
1) For making <b>Full Payout</b>. Select the <b>Unpaid Status</b> filter from top. And Click Filter. Then click link in the Success Page. <br>
    2) For making <b>Partial Payout</b> to specific orders, select the orders from below and click filter button above. Then click link in the Success Page.";
$_['help_selectagent_transactionpage']         = "If you want to make a payout to the sales ".$_['main_word_small'].". Please select the sales ".$_['main_word_small']." name from the dropdown below and then click filter.";
$_['text_proof_1'] = 'View Proof 1';
$_['text_proof_2'] = 'View Proof 2';


// Text

// Text
$_['text_orderreport']     = 'Order Report';
$_['text_reportlist']         = 'Transaction List';
$_['text_all_status']   = 'All Statuses';
$_['text_subtotal']  = "Sub total";
$_['text_total']    = "Total";


// Column
$_['column_name']       = $_['main_word'].' Name';
$_['column_customerid']   = 'Customer Id';
$_['column_customertelephone']   = 'Telephone';
$_['column_customername']   = 'Customer Name';
$_['column_customeremail']   = 'Customer Email';
$_['column_orders']     = 'Order Id';
$_['column_products']   = 'No. Products';
$_['column_commission']        = 'Percentage';
$_['column_calculationtext']        = 'Calculation Summary';
$_['column_amount']        = 'Commission Amount';
$_['column_orderamount']   = "Order Amount";
$_['column_dateadded']   = "Date Added";

// Text

$_['text_orderamount']   = 'Total Order Amount: ';
$_['text_commission']   = 'Total Commission Amount: ';
$_['text_customercreated'] = "Total Customers Created : ";


// Entry
$_['entry_date_start']  = 'Date Start';
$_['entry_date_end']    = 'Date End';
$_['entry_salesagent']       = 'Select Sales '.$_['main_word'];
$_['entry_display_front_end']      = 'Display On Front End';
$_['entry_status']      = 'Order Status';
$_['entry_amount']      = 'Amount';
$_['entry_transactionid']      = 'Transaction ID';
$_['entry_totalorders']      = 'Total Orders';
$_['entry_paidout']     = "PaidOut Status";

$_['entry_transaction_id'] = "Enter Transaction No / UTR No ( Reference purpose )";
$_['entry_amountpaid'] = "Amount Paid";
$_['entry_paymentdetails'] = "Payment Details";
$_['entry_image_1'] = "Image proof 1";
$_['entry_image_2'] = "Image proof 2";
$_['entry_notes'] = "Additional Notes";

$_['text_payouttext'] = "Note: The above payment must be done <b>Offline</b>. You can use your own payment modes. Once you make the payment.<br>Kindly add the details below and save the Payout Details.";
$_['text_salesagentname'] = 'Sales '.$_['main_word'].' Name';
$_['text_totalorders'] = "Total Orders In This Payout";
$_['text_amounttopay'] = "Commission Amount To Pay:";
$_['text_payoutsubject'] = "Commission Payout Transaction Id %s";


//Payout Email

$_['text_greetings']  = "Hello %s,";
$_['text_payout']  = "A Payout was made to your by %s, kindly find the details below:";
$_['text_totalorders'] = 'Total Orders:';
$_['text_totalpayment'] = 'Total Amount Paid:';
$_['text_paymentdetails'] = 'Payment Details:';
$_['text_transactionid'] = "Transaction / Reference no:";


//Payout Delete

$_['text_success_delete'] = "Successfully Deleted";


$_['error_transaction_id']  = "Error please enter transaction no for reference";
$_['error_paymentdetails']  = "Error please enter payment details for reference";

$_['text_howitworks']   = "About this page";
$_['text_howitworks_content']   = '1) This page controls settings settings for each sales '.$_['main_word_small'].'.</br>
2) Fields like firstname, lastname, email, fax, telephone, city, address are for <b>normal reference fields</b>.</br>
3) <b>Connect with user:</b> If you want your sales '.$_['main_word_small'].' to see their own orders / customers in admin panel you need to connect them with admin user. For this first create an admin user through system - users.</br>
4) <b>Commission:</b> The percentage commission to calculate on orders.</br>
5) <b>Send Email Alert: </b> If you want to send email alert to the sales '.$_['main_word_small'].' on new customer registration / order, you need to enable this.</br>
6) <b>Status: </b> If you want to enable / disable the sales '.$_['main_word_small'].', use this field.</br>
7) <b>Direct parent & commission: </b> This is first level parent of this sales '.$_['main_word_small'].' i.e Father/Mother.</br>
8) <b>Master parent & commission: </b> This is second level parent of this sales '.$_['main_word_small'].' i.e Grand father / mother.</br>
9) <b>Unique String: </b>If you want to auto assign sales '.$_['main_word_small'].' to order, you can provide unique string to each sales '.$_['main_word_small'].'. So when sales '.$_['main_word_small'].' do marketing they must add this extra string at end of url while sharing.<br>
10 <b>Catalog Based Commission: </b> It is possible to provide different commission to different categories / products. You can assign commission based on catalogs.';

$_['text_howitworks_list_content']  = '1) This page is used to check and manage different sales '.$_['main_word_small'].'<br>
2) You can click plus icon to create a new sales '.$_['main_word_small'].'<br>
3) You can use filters to check and search for sales '.$_['main_word_small'].'<br>
4) Click edit button to check specific sales '.$_['main_word_small'].' settings.<br>
5) Using top right settings icon, you can enable-disable different sales '.$_['main_word_small'].' features.';

$_['text_howitworks_clist_content'] = '1) Using catalogs you can assign different commission to product / categories for any '.$_['main_word_small'].'</br>
2) Each catalog can have different category / products.<br>
3) For creating a catalog click on <b>Add catalog</b> button.<br>
4) Once catalog(s) is created you can then assign via sales '.$_['main_word_small'].' form page.';

$_['text_howitworks_orderreport_content']   = '1) Check all order transactions from this page.<br>
2) You can filter transactions using order start and order end date.<br>
3) You can also filter using order status.<br>
4) Total amount and commission can be seen just below filters.';

$_['text_howitworks_customerreport_content']    = '1) Check all customer transactions from this page.<br>
2) You can check how many customers are assigned to '.$_['main_word_small'].' from this page.';


$_['regerror_email'] = 'Email Address Error';
$_['regerror_orderid']  = 'Order ID Error';
$_['regerror_noreferer']  = 'Please Contact Support';
$_['regerror_localhost']  = 'This extension can not be used on a localhost server!';
$_['regerror_licensedupe']  = 'This extension is already licensed to a different domain!';
$_['regerror_quote_msg'] = '<p>Please quote the error message below when contacting support.</p>';

$_['license_purchase_thanks'] = '<p>Thanks for purchasing our OpenCart Extension.</p>
    <p>Please complete the form below to register this extension on our licensing server.</p>
    <p>If you experience any problems installing this extension or registering your license, please email support at %s</p>';


$_['license_registration'] = 'Register License';
$_['license_opencart_email'] = 'Email Address Of Purchase';
$_['license_opencart_orderid'] = 'Order Id';

$_['check_email'] = 'Please check and correct your email address. The address you entered does not match our records. It could be that when you purchased the extension, you used a different email address to the one you have entered here.';
$_['check_orderid'] = 'Please check and correct your order id. The order id you have entered does not match our records. Please check this in your account.';

$_['server_error_curl'] = '<h2>Server Error - Curl Required</h2>
    <p>Your server does not appear to have the \'curl\' PHP module installed. The \'curl\' PHP module is required for OpenCart to function correctly. Please contact your web host to ask them to install the \'curl\' PHP module for you.</p>';

$_['text_free_support_remaining'] = 'You have <strong><span style="color:red;">%s</span></strong> days of free support remaining - <a href="https://support.cartbinder.com/" target="_blank">Visit Support Now</a>';
$_['text_free_support_expired'] = '<span style="color:red;">Your 12 months of free support has expired</span> - <a href="https://www.cartbinder.com/store/free-support.php?path=%d&ssl=%d&domain=%s&ext=%s&user_token=%s">Extend Now</a>';

$_['text_deregister'] = 'De-Register License';
$_['help_deregister'] = 'Are you sure you want to de-register the license for this domain?\n\nDe-registering will free up this license for use on another OpenCart Installation / Domain Name.\n\nWARNING - You will no longer be able to access the settings on this domain until a license is registered!';


$_['entry_customer'] = 'Choose customer account';
$_['text_select'] = 'Choose account';


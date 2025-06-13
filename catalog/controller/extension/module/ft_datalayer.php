<?php
class ControllerExtensionModuleFtDatalayer extends Controller 
{
	public function setup() {
        $data = [];

        if (empty($this->session->data['ft_datalayer'])) {
            $data['error'] = 'No datalayer found in session, put in contact with FlowyTracking support team.';
        } else {
            $data = $this->session->data['ft_datalayer'];

            $data['general_data']['clientId'] = $this->FTMaster->get_client_id();
            $data['general_data']['gclDc'] = $this->FTMaster->get_gcl_dc();

            $customer_info = $this->FTMaster->get_customer_info();
            $email = '';
            
            if (!empty($customer_info['email'])) {
                $email = $customer_info['email'];
            } elseif (!empty($this->session->data['ft_customer_email'])) {
                $email = $this->session->data['ft_customer_email'];
            }

            $data['general_data']['email'] = $email;
        }
        /*header("X-Robots-Tag: noindex, nofollow", true);
        echo json_encode($data); die;*/
        $this->response->addHeader('X-Robots-Tag: noindex, nofollow', true);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
    }
}
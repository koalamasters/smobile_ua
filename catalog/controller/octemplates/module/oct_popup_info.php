<?php

class ControllerOCTemplatesModuleOctPopupInfo extends Controller
{

    function cryptopay()
    {
        $this->load->language('product/product');
        $data['heading_title'] = $this->language->get('cryptopay');
        $data['heading_title'] = strip_tags($data['heading_title']);
        $data['detail_text'] = $this->language->get('cryptopay_info');
        $this->response->setOutput($this->load->view('modal/popup', $data));
    }

    function deliveryservice()
    {
        $this->load->language('product/product');
        $data['heading_title'] = $this->language->get('delivery_service');
        $data['heading_title'] = strip_tags($data['heading_title']);
        $data['detail_text'] = $this->language->get('delivery_service_info');
        $this->response->setOutput($this->load->view('modal/popup', $data));
    }

    function payment()
    {
        $this->load->language('product/product');
        $data['heading_title'] = $this->language->get('paument_methods');
        $data['heading_title'] = strip_tags($data['heading_title']);
        $data['detail_text'] = $this->language->get('payment_methods_info');
        $this->response->setOutput($this->load->view('modal/popup', $data));
    }

    function freedelivery()
    {
        $this->load->language('product/product');
        $data['heading_title'] = $this->language->get('FreeDelivery');
        $data['heading_title'] = strip_tags($data['heading_title']);
        $data['detail_text'] = $this->language->get('free_delivery_info');
        $this->response->setOutput($this->load->view('modal/popup', $data));
    }

    function offdist()
    {
        $this->load->language('product/product');
        $data['heading_title'] = $this->language->get('FreeDelivery');
        $data['heading_title'] = strip_tags($data['heading_title']);
        $data['detail_text'] = $this->language->get('off_dist_info');
        $this->response->setOutput($this->load->view('modal/popup', $data));
    }


}
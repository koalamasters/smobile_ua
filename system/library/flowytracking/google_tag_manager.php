<?php
	namespace flowytracking;
	class google_tag_manager extends master
    {
		public function get_code_head() {
		    $gtm_ids = $this->get_gtm_id();

		    $code = $this->get_generic_js_variables();

		    foreach ($gtm_ids as $gtm) {
		        $code .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','$gtm');</script>";
		    }

			return $code;
		}

		public function get_code_body() {
		    $code = '';
		    $gtm_ids = $this->get_gtm_id();

		    foreach ($gtm_ids as $gtm) {
		        $code = "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id=$gtm\"
					height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>";
		    }

			return $code;
		}

		public function get_generic_js_variables() {
            $link = ($this->config->get("config_ssl") != '' ? $this->config->get("config_ssl") : HTTPS_SERVER).'index.php?route=extension/module/ft_datalayer/setup&v='.$this->generate_uuid();

		    $code = "<script>
                            //Flowy Tracking https://flowytracking.com/ - Declare basic variables 
                            var dataLayer = [];
					        var dataLayer_setup_link = '".$link."';
					        var flowy_tracking_language = '".$this->FTMaster->get_language_code()."';
                     </script>";

            /*
             var eeMultiChanelVisitProductPageStep = ".(int)$this->get_ee_multichannel_step('visit_product_page').";
                            var eeMultiChanelAddToCartStep = ".(int)$this->get_ee_multichannel_step('add_to_cart').";
                            var eeMultiChanelVisitCartPageStep = ".(int)$this->get_ee_multichannel_step('visit_cart_page').";
                            var eeMultiChanelVisitCheckoutStep = ".(int)$this->get_ee_multichannel_step('visit_checkout_page').";
                            var eeMultiChanelFinishOrderStep = ".(int)$this->get_ee_multichannel_step('finish_order').";
             * */

		    return $code;
        }

        public function get_products_listed() {
		    $product_hrefs = array();

            if (!empty($this->session->data['ft_data']['products_listed'])) {
                foreach ($this->session->data['ft_data']['products_listed'] as $key => $prod) {
                    $prod_id = $prod['product']['product_id'];
                    $href = $prod['product']['url'];

                    if (!empty($href) && !array_key_exists($href, $product_hrefs)) {
                        $product_hrefs[$href] = $prod_id;
                    }
                }
            }

            return $product_hrefs;
        }

        public function get_promotions_listed() {
		    $promotions_hrefs = array();

            if (!empty($this->session->data['ft_data']['promotions_listed'])) {
                foreach ($this->session->data['ft_data']['promotions_listed'] as $key => $prom) {
                    $prom_id = $prom['id'];
                    $href = $prom['url'];

                    if (!empty($href) && !array_key_exists($href, $promotions_hrefs)) {
                        $promotions_hrefs[$href] = $prom_id;
                    }
                }
            }

            return $promotions_hrefs;
        }
	}
?>
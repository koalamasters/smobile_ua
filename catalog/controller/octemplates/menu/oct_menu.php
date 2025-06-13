<?php
/**
 * @copyright    OCTemplates
 * @support      https://octemplates.net/
 * @license      LICENSE.txt
 */

class ControllerOCTemplatesMenuOCTMenu extends Controller {
    public function index() {
        $this->load->language('octemplates/menu/oct_menu');
        $this->load->language('octemplates/module/oct_popup_login');

        $this->load->model('tool/image');
        $this->load->model('localisation/language');

        $data['language_id'] = (int)$this->config->get('config_language_id');

        $data['oct_showcase_data'] = $oct_showcase_data = $this->config->get('theme_oct_showcase_data');

        if ((isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && (isset($this->request->post['mobile']) && $this->request->post['mobile'])) {
            $data['isLogged'] = !$this->customer->isLogged() ? false : true;

            $data['wishlist_link'] = $this->url->link('account/wishlist','', true);
            $data['account_url'] = $this->url->link('account/account', '', true);

			if ($this->customer->isLogged()) {
				$this->load->model('account/wishlist');
                $this->load->language('extension/module/account');

				$data['wishlist_total'] = $this->model_account_wishlist->getTotalWishlist();

                $data['logout'] = $this->url->link('account/logout', '', true);
        		$data['account'] = $this->url->link('account/account', '', true);
        		$data['edit'] = $this->url->link('account/edit', '', true);
        		$data['password'] = $this->url->link('account/password', '', true);
        		$data['address'] = $this->url->link('account/address', '', true);
        		$data['wishlist'] = $this->url->link('account/wishlist');
        		$data['order'] = $this->url->link('account/order', '', true);
        		$data['download'] = $this->url->link('account/download', '', true);
        		$data['reward'] = $this->url->link('account/reward', '', true);
        		$data['return'] = $this->url->link('account/return', '', true);
        		$data['transaction'] = $this->url->link('account/transaction', '', true);
        		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
        		$data['recurring'] = $this->url->link('account/recurring', '', true);
				$data['oct_stock_notifier'] = $this->url->link('account/oct_stock_notifier', '', true);

                $this->load->model('account/customer');

				$affiliate_info = $this->model_account_customer->getAffiliate($this->customer->getId());

				if (!$affiliate_info) {
					$data['affiliate'] = $this->url->link('account/affiliate/add', '', true);
					$data['tracking'] = '';
				} else {
					$data['affiliate'] = $this->url->link('account/affiliate/edit', '', true);
					$data['tracking'] = $this->url->link('account/tracking', '', true);
				}

                $data['download_view'] = $this->config->get('module_account_download_view');
    			$data['recurring_view'] = $this->config->get('module_account_recurring_view');
    			$data['reward_view'] = $this->config->get('module_account_reward_view');
    			$data['return_view'] = $this->config->get('module_account_return_view');
    			$data['transaction_view'] = $this->config->get('module_account_transaction_view');
    			$data['newsletter_view'] = $this->config->get('module_account_newsletter_view');
    			$data['affiliate_view'] = $this->config->get('module_account_affiliate_view');
				$data['oct_stock_notifier_status'] = $this->config->get('oct_stock_notifier_status');
			} else {
				$data['wishlist_total'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);

                $data['forgotten_url'] = $this->url->link('account/forgotten', '', true);
                $data['register_url'] = $this->url->link('account/register', '', true);
			}
			
			$data['compare_link'] = $this->url->link('product/compare','', true);
			$data['compare_total'] = (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0);

			$product_views = [];

			if (isset($this->request->cookie['oct_product_views'])) {
	            $product_views = explode(',', $this->request->cookie['oct_product_views']);
	        } elseif (isset($this->session->data['oct_product_views'])) {
	            $product_views = $this->session->data['oct_product_views'];
	        }

	        if (isset($this->request->cookie['viewed'])) {
	            $product_views = array_merge($product_views, explode(',', $this->request->cookie['viewed']));
	        } elseif (isset($this->session->data['viewed'])) {
	            $product_views = array_merge($product_views, $this->session->data['viewed']);
	        }

			$data['product_views_count'] = count($product_views);

            $data['oct_menu_title'] = (isset($oct_showcase_data['mobile_menu']['title'][(int)$this->config->get('config_language_id')]) && !empty($oct_showcase_data['mobile_menu']['title'][(int)$this->config->get('config_language_id')])) ? $oct_showcase_data['mobile_menu']['title'][(int)$this->config->get('config_language_id')] : $this->language->get('oct_menu_catalog');

            $this->load->model('catalog/information');

			if (isset($oct_showcase_data['mobile_links']) && !empty($oct_showcase_data['mobile_links'])) {
                foreach ($oct_showcase_data['mobile_links'] as $mobile_link) {
					$data['mobile_informations'][] = array(
						'title' => html_entity_decode($mobile_link[(int)$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8'),
						'href'  => $mobile_link[(int)$this->config->get('config_language_id')]['link']
					);
				}
			}

			if (isset($oct_showcase_data['mobile_menu']['languages']) && $oct_showcase_data['mobile_menu']['languages']) {
				$data['language'] = true;
			}

			if (isset($oct_showcase_data['mobile_menu']['currency']) && $oct_showcase_data['mobile_menu']['currency']) {
				$data['currency'] = true;
			}

			if (isset($oct_showcase_data['mobile_menu']['time']) && $oct_showcase_data['mobile_menu']['time']) {
                if (isset($oct_showcase_data['contact_open'][(int)$this->config->get('config_language_id')])){
                    $oct_contact_opens = explode(PHP_EOL, $oct_showcase_data['contact_open'][(int)$this->config->get('config_language_id')]);

                    foreach ($oct_contact_opens as $oct_contact_open) {
                        if (!empty($oct_contact_open)) {
							$data['oct_contact_opens'][] = html_entity_decode($oct_contact_open, ENT_QUOTES, 'UTF-8');
                        }
                    }
                }
            }

			$data['languages'] = $this->model_localisation_language->getLanguages();

			$data['socials'] = (isset($oct_showcase_data['socials']) && !empty($oct_showcase_data['socials'])) ? $oct_showcase_data['socials'] : false;
			$data['contact'] = $this->url->link('information/contact', '', true);

            if (isset($oct_showcase_data['mobile_menu']['phones']) && $oct_showcase_data['mobile_menu']['phones']) {
                $oct_contact_telephones = explode(PHP_EOL, $oct_showcase_data['contact_telephone']);

                foreach ($oct_contact_telephones as $oct_contact_telephone) {
                    if (!empty($oct_contact_telephone)) {
                        $data['oct_contact_telephones'][] = trim($oct_contact_telephone);
                    }
                }
            }
        }

        if (isset($oct_showcase_data['megamenu']['status']) && $oct_showcase_data['megamenu']['status']) {

			if (isset($oct_showcase_data['megamenu']['dcategories']) && $oct_showcase_data['megamenu']['dcategories']) {
				$oct_categories = $this->getStandartCategories($data);
			} else {
				$oct_categories = [];
			}

            $oct_menu = $this->getOCTMegaMenu($data);

            if ($oct_showcase_data['megamenu']['sort'] == 3) {
                $data['oct_menu'] = array_merge($oct_menu, $oct_categories);

                $sort_order = [];

                foreach ($data['oct_menu'] as $key => $value) {
                    $sort_order[$key] = $value['sort'];
                }

                array_multisort($sort_order, SORT_ASC, $data['oct_menu']);
            } else {
                $data['oct_menu'] = $oct_showcase_data['megamenu']['sort'] == 1 ? array_merge($oct_menu, $oct_categories) : array_merge($oct_categories, $oct_menu);
            }

            $desktop_template = 'octemplates/menu/oct_menu';
            $mobile_template = 'octemplates/menu/oct_menu_mobile';
            
            //if(isset($_GET['new_mega_menu'])){
                //if($_GET['new_mega_menu'] == '1') {
                    $data['oct_menu'] = $this->load->controller('km/menueditor/index');
                //}
                $desktop_template = 'octemplates/menu/oct_menu_custom';
                $mobile_template = 'octemplates/menu/oct_menu_mobile_custom';

            //}

            if ((isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && (isset($this->request->post['mobile']) && $this->request->post['mobile'])) {
                $this->response->setOutput($this->load->view($mobile_template, $data));
            } else {
                return $this->load->view($desktop_template, $data);
            }
        } elseif ((isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && (isset($this->request->post['mobile']) && $this->request->post['mobile'])) {
            $data['oct_menu'] = $this->load->controller('common/menu', $data);

            $this->response->setOutput($this->load->view('octemplates/menu/oct_menu_mobile', $data));
        }
    }

    private function getOCTMegaMenu($data = []) {
        if(isset($this->request->server['HTTP_ACCEPT']) && strpos($this->request->server['HTTP_ACCEPT'], 'webp')) {
			$oct_webP = 1 . '-' . $this->session->data['currency'];
		} else {
			$oct_webP = 0 . '-' . $this->session->data['currency'];
		}

        $menu_items = $this->cache->get('octemplates.menuItems.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . $oct_webP);

        if (!$menu_items) {
            $menu_items = [];

            $this->load->model('octemplates/menu/oct_menu');

            $types = [
                'category' => 1,
                'manufacturer' => 1,
                'oct_blogcategory' => 1,
                'link' => 1
            ];

            $menu_items = $this->model_octemplates_menu_oct_menu->getOCTMenuItems($types);

            $this->cache->set('octemplates.menuItems.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . $oct_webP, $menu_items);
        }

        return $menu_items;
    }

    private function getStandartCategories($data = []) {
        $oct_showcase_data = $this->config->get('theme_oct_showcase_data');

        $categories_icon = (isset($oct_showcase_data['mobile_menu']['icon']) || isset($oct_showcase_data['megamenu']['icon'])) ? true : false;

        $this->load->model('catalog/category');

        if ($categories_icon) {
            $this->load->model('tool/image');
        }

        if ($this->config->get('config_product_count')) {
    		$this->load->model('catalog/product');
        }

        if(isset($this->request->server['HTTP_ACCEPT']) && strpos($this->request->server['HTTP_ACCEPT'], 'webp')) {
			$oct_webP = 1 . '-' . $this->session->data['currency'];
		} else {
			$oct_webP = 0 . '-' . $this->session->data['currency'];
		}

        $menu_categories = $this->cache->get('octemplates.categoryItems.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . $oct_webP);

        $oct_cats_limit = $oct_showcase_data['megamenu']['limit'] ? $oct_showcase_data['megamenu']['limit'] : 0;

        if (!$menu_categories) {
    		$categories = $this->model_catalog_category->getOCTCategories(0, '');
            $menu_categories = [];

    		foreach ($categories as $category) {
				// Level 2
				$children_data = [];

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = [
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					];

                    // Level 3
        			$children_data_2 = [];
        			$children_2 = $this->model_catalog_category->getOCTCategories($child['category_id'], $oct_cats_limit);

        			foreach ($children_2 as $child_2) {
        				$filter_data2 = [
        					'filter_category_id'  => $child_2['category_id'],
        					'filter_sub_category' => true
        				];

        				$children_3 = $this->model_catalog_category->getCategories($child_2['category_id']);

        				$children_data_3 = [];

        				foreach ($children_3 as $child_3) {
        					$filter_data3 = [
        						'filter_category_id'  => $child_3['category_id'],
        						'filter_sub_category' => true
        					];

        					$children_data_3[] = [
        						'name'  => $child_3['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data3) . ')' : ''),
        						'oct_pages' => isset($oct_showcase_data['megamenu']['page']) ? unserialize($child_3['page_group_links']) : [],
        						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child_2['category_id'] . '_' . $child_3['category_id'])
        					];
        				}

        				$children_data_2[] = [
        					'name'  => $child_2['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data2) . ')' : ''),
                            'children' => $children_data_3,
        					'oct_pages' => isset($oct_showcase_data['megamenu']['page']) ? unserialize($child_2['page_group_links']) : [],
        					'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child_2['category_id'])
        				];
        			}

					$children_data[] = [
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                        'children' => $children_data_2,
        				'oct_pages' => isset($oct_showcase_data['megamenu']['page']) ? unserialize($child['page_group_links']) : [],
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					];
				}

				// Level 1
				$menu_categories[] = [
					'name'     => $category['name'],
                    'sort'     => $category['sort_order'],
                    'type'     => 'standard',
                    'view'     => $data['oct_showcase_data']['megamenu']['view'],
					'children' => $children_data,
					'column'   => 1,
                    'target'   => '',
                    'oct_image'=> $categories_icon ? $this->model_tool_image->resize($category['oct_image'], 32, 32) : false,
                    'width'    => 32,
                    'height'   => 32,
                    'oct_pages' => isset($oct_showcase_data['megamenu']['page']) ? unserialize($category['page_group_links']) : false,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				];
    		}

            $this->cache->set('octemplates.categoryItems.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . $oct_webP, $menu_categories);
        }

        return $menu_categories;
    }
}

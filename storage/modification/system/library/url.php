<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* URL class
*/
class Url {
	private $url;
	private $ssl;

	// SEO langmark vars
	private $langmark_registry = Array();
	// End of SEO langmark vars
    

	// SEO CMS vars
	private $sc_registry = Array();
	// End of SEO CMS vars
    
	private $rewrite = array();
	
	/**
	 * Constructor
	 *
	 * @param	string	$url
	 * @param	string	$ssl
	 *
 	*/
	public function __construct($url, $ssl = '') {
		// SEO langmark code
		if (is_callable(array($this->langmark_registry, 'get')) && $this->langmark_registry->get('controller_record_langmark')) {
			$url = $this->langmark_registry->get('controller_record_langmark')->after($url);
		}
		// End SEO langmark code
		$this->url = $url;
		$this->ssl = $ssl;
	}

	/**
	 *
	 *
	 * @param	object	$rewrite
 	*/	

 	// SEO CMS function
 	public function seocms_setRegistry($registry) {
		$this->sc_registry = $registry;
	}
	// End of SEO CMS function
    

 	// SEO langmark function
 	public function langmark_setRegistry($registry) {
		$this->langmark_registry = $registry;
	}
	// End of SEO langmark function
    
	public function addRewrite($rewrite) {
		// SEO CMS code
		if (is_callable(array($this->sc_registry, 'get'))) {
			$this->sc_registry->get('controller_record_url')->before($rewrite);
		}
		// End of SEO CMS code
		$this->rewrite[] = $rewrite;
	}

	/**
	 * 
	 *
	 * @param	string		$route
	 * @param	mixed		$args
	 * @param	bool		$secure
	 *
	 * @return	string
 	*/
	public function link($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
			$url = $this->ssl . 'index.php?route=' . $route;
		} else {
			$url = $this->url . 'index.php?route=' . $route;
		}
		
		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}

		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
		

		// SEO CMS code
		if (is_callable(array($this->sc_registry, 'get'))) {
			$url = $this->sc_registry->get('controller_record_url')->after($url);
		}
		//End of SEO CMS code
    

		// SEO langmark code
		if (is_callable(array($this->langmark_registry, 'get')) && $this->langmark_registry->get('controller_record_langmark')) {
			$url = $this->langmark_registry->get('controller_record_langmark')->after($url, $route);
		}
		//End of SEO langmark code
    
		return $url; 
	}
}
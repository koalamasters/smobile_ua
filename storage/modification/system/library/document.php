<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Document class
*/
class Document {

	private $robots;
	private $title;

	// SEO CMS vars
	private $sc_og_image;
	private $sc_og_description;
	private $sc_og_title;
	private $sc_og_type;
	private $sc_og_url;
	private $sc_robots;
	private $sc_hreflang = array();
	private $sc_removelinks = array();
	//End of SEO CMS vars

	private $description;
	private $keywords;
	private $links = array();
	private $styles = array();
	private $scripts = array();

			private $oct_files = [];
			private $octOpenGraph = [];
			private $octStyles = [];
			private $octScripts = [];

			public function setOCTPreload($oct_file) {
				$this->oct_files[$oct_file] = $oct_file;
			}

			public function getOCTPreload() {
				return $this->oct_files;
			}

            public function setOCTOpenGraph($property, $content) {
        		$this->octOpenGraph[$property] = [
                    'property' => $property,
                    'content' => $content
                ];
        	}

            public function getOCTOpenGraph() {
                return $this->octOpenGraph;
            }

			public function addOctStyle($href, $rel = 'stylesheet', $media = 'screen', $position = 'header') {
				$href = $this->removeVersion($href);

				$this->octStyles[$position][$href] = [
					'href'  => $href,
					'rel'   => $rel,
					'media' => $media
				];
			}

			public function getOctStyles($position = 'header') {
				if (isset($this->octStyles[$position])) {
					$styles = isset($this->styles) ? isset($this->styles[$position]) ? $this->styles[$position] : $this->styles : [];
					$this->styles = [];
					$this->styles[$position] = [];

					foreach ($styles as $style) {
						$href = $this->removeVersion($style['href']);

						$this->styles[$position][$href] = [
							'href'  => $href,
							'rel'   => $style['rel'],
							'media' => $style['media']
						];
					}

					return array_merge($this->octStyles[$position], $this->styles[$position]);
				} else {
					return [];
				}
			}

			public function addOctScript($href, $position = 'header') {
				$href = $this->removeVersion($href);

				$this->octScripts[$position][$href] = $href;
			}

			public function getOctScripts($position = 'header') {
				if (isset($this->octScripts[$position])) {
					$scripts = isset($this->scripts[$position]) ? $this->scripts[$position] : [];
					$this->scripts[$position] = [];

					foreach ($scripts as $script) {
						$href = $this->removeVersion($script);

						$this->scripts[$position][$href] = $href;
					}

					return array_merge($this->octScripts[$position], $this->scripts[$position]);
				} else {
					return array();
				}
			}

			private function removeVersion($link) {
				$href = explode('?', $link);

				if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($href[0]))) {
			       $link = $href[0];
		        }

		        return $link;
		    }
			

	/**
     * 
     *
     * @param	string	$title
     */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
     * 
	 * 
	 * @return	string
     */
	public function getTitle() {
		return $this->title;
	}

	/**
     * 
     *
     * @param	string	$description
     */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
     * 
     *
     * @param	string	$description
	 * 
	 * @return	string
     */
	public function getDescription() {
		return $this->description;
	}

	/**
     * 
     *
     * @param	string	$keywords
     */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
     *
	 * 
	 * @return	string
     */
	public function getKeywords() {
		return $this->keywords;
	}
	
	/**
     * 
     *
     * @param	string	$href
	 * @param	string	$rel
     */
	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}

	/**
     * 
	 * 
	 * @return	array
     */

  // OCFilter start
  public function ocfDeleteLink($rel) {
    foreach ($this->links as $href => $link) {
      if ($link['rel'] == $rel) {
        unset($this->links[$href]);
      }
    }
  }
  // OCFilter end
      

    // SEO CMS functions
	public function setSCRobots($str) {
		$this->sc_robots = $str;
	}
	public function getSCRobots() {
		return $this->sc_robots;
	}
	public function setSCHreflang($hreflang = array()) {
		$this->sc_hreflang = $hreflang;
	}
	public function getSCHreflang() {
		return $this->sc_hreflang;
	}
	public function setSCOgImage($image) {
		$this->sc_og_image = $image;
	}
	public function getSCOgImage() {
		return $this->sc_og_image;
	}
	public function setSCOgType($og_type) {
		$this->sc_og_type = $og_type;
	}
	public function getSCOgType() {
		return $this->sc_og_type;
	}
	public function setSCOgTitle($title) {
		$this->sc_og_title = $title;
	}
	public function getSCOgTitle() {
		return $this->sc_og_title;
	}
	public function setSCOgDescription($description) {
		$this->sc_og_description = $description;
	}
	public function getSCOgDescription() {
		return $this->sc_og_description;
	}
	public function setSCOgUrl($url) {
		$this->sc_og_url = $url;
	}
	public function getSCOgUrl() {
		return $this->sc_og_url;
	}
	public function removeSCLink($href) {
		$this->sc_removelinks[$href] = $href;
	}
	//End of SEO CMS functions

	public function getLinks() {
		
		// SEO CMS code
		if (is_array($this->links) && !empty($this->links)) {
			foreach ($this->links as $links => $linksarray) {
				if (isset($this->sc_removelinks) && !empty($this->sc_removelinks) && isset($this->sc_removelinks[$links])) {
					unset($this->links[$links]);
				}
			}
		}
		//End of SEO CMS code
		return $this->links;

	}

	/**
     * 
     *
     * @param	string	$href
	 * @param	string	$rel
	 * @param	string	$media
     */
	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	/**
     * 
	 * 
	 * @return	array
     */
	public function getStyles() {
		return $this->styles;
	}

	/**
     * 
     *
     * @param	string	$href
	 * @param	string	$postion
     */
	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	/**
     * 
     *
     * @param	string	$postion
	 * 
	 * @return	array
     */
	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}



	public function setRobots($robots) {
		$this->robots = $robots;
	}
	public function getRobots() {
		return $this->robots;
	}
}
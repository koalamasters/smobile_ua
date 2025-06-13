<?php
class ControllerStartupMaintenance extends Controller {
	public function index() {

	 	$file = DIR_SYSTEM.'../catalog/controller/record/front.php';
	 	if (file_exists($file)) {
			if (function_exists('modification')) {
				require_once(modification($file));
			} else {
				require_once($file);
			}
		 	new ControllerRecordFront($this->registry);
	 	}
    
		if ($this->config->get('config_maintenance')) {
			// Route
			if (isset($this->request->get['route']) && $this->request->get['route'] != 'startup/router') {
				$route = $this->request->get['route'];
			} else {
				$route = $this->config->get('action_default');
			}			
			
			$ignore = array(
				'common/language/language',
				'common/currency/currency'
			);
			
			// Show site if logged in as admin
			$this->user = new Cart\User($this->registry);

			if ((substr($route, 0, 17) != 'extension/payment' && substr($route, 0, 3) != 'api') && !in_array($route, $ignore) && !$this->user->isLogged()) {
				return new Action('common/maintenance');
			}
		}
	}
}

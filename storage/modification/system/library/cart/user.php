<?php
namespace Cart;
class User {
	private $user_id;
	private $user_group_id;
	private $username;

        private $config;
        
	private $permission = array();

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

        $this->config = $registry->get('config');
        

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->user_group_id = $user_query->row['user_group_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = json_decode($user_group_query->row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = json_decode($user_group_query->row['permission'], true);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}


       public function getSalesAgentId() {
       if(!$this->config->get("salesagent_installed")) {
        return 0;
       }
    if(isset($this->session->data['suser_id']) && $this->session->data['suser_id']) {
        $salesagent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE user_id = '" . (int)$this->session->data['suser_id'] . "'");
       } else {
      $salesagent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE user_id = '" . (int)$this->user_id . "'");
    }
    if($salesagent_query->num_rows) {
      foreach($salesagent_query->rows as $key => $value) {
        $salesagentarray[] = $value['salesagent_id'];
         $salesagent_parent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE parent_id = '" . $value['salesagent_id'] . "'");
         if($salesagent_parent_query->num_rows) {
            foreach($salesagent_parent_query->rows as $key1 => $value1) {
              $salesagentarray[] = $value1['salesagent_id'];
              $salesagent_parent_query1 = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE parent_id = '" . $value1['salesagent_id'] . "'");
              if($salesagent_parent_query1->num_rows) {
                foreach($salesagent_parent_query1->rows as $key2 => $value2) {
                  $salesagentarray[] = $value2['salesagent_id'];
                }  
             }
            }  
         }
      }
      $salesagentarray = array_unique($salesagentarray);
      $salesagentsting = implode(",", $salesagentarray);
      return $salesagentsting;
    } else {
      $usergrouprestrictions = $this->config->get('salesagent_usergrouprestrictions');
      if(empty($usergrouprestrictions)) {
        return 0;
      } else {
        $user_group_id = $this->user_group_id;
        if(in_array($user_group_id,$usergrouprestrictions)) {
          return 99999999999;
        } else {
          return 0;
        }
      }
    }
  }

  public function getSalesAgentId2() {
       if(!$this->config->get("salesagent_installed")) {
        return 0;
       }
    if(isset($this->session->data['suser_id']) && $this->session->data['suser_id']) {
        $salesagent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE user_id = '" . (int)$this->session->data['suser_id'] . "'");
    }
    if(isset($salesagent_query) && $salesagent_query->num_rows) {
      foreach($salesagent_query->rows as $key => $value) {
        $salesagentarray[] = $value['salesagent_id'];
         $salesagent_parent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE parent_id = '" . $value['salesagent_id'] . "'");
         if($salesagent_parent_query->num_rows) {
            foreach($salesagent_parent_query->rows as $key1 => $value1) {
              $salesagentarray[] = $value1['salesagent_id'];
              $salesagent_parent_query1 = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE parent_id = '" . $value1['salesagent_id'] . "'");
              if($salesagent_parent_query1->num_rows) {
                foreach($salesagent_parent_query1->rows as $key2 => $value2) {
                  $salesagentarray[] = $value2['salesagent_id'];
                }  
             }
            }  
         }
      }
      $salesagentarray = array_unique($salesagentarray);
      $salesagentsting = implode(",", $salesagentarray);
      return $salesagentsting;
    } else {
      $usergrouprestrictions = $this->config->get('salesagent_usergrouprestrictions');
      if(empty($usergrouprestrictions)) {
        return 0;
      } else {
        $user_group_id = $this->user_group_id;
        if(in_array($user_group_id,$usergrouprestrictions)) {
          return 99999999999;
        } else {
          return 0;
        }
      }
    }
  }
        
	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}
}
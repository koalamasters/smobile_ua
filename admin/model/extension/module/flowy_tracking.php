<?php
    class ModelExtensionModuleFlowyTracking extends Model {
        public function _lang($lang_key) {
            return $this->language->get($lang_key);
        }

        public function validate_permiss() {
            if (!$this->user->hasPermission('modify', $this->real_extension_type.'/'.$this->extension_name)) {
                if(!empty($this->request->post['no_exit']))
                {
                    $array_return = array(
                        'error' => true,
                        'message' => $this->language->get('error_permission')
                    );
                    echo json_encode($array_return); die;
                }
                else
                    throw new Exception($this->language->get('error_permission'));

                return false;
            }
            return true;
        }
        public function exception($message) {
            throw new Exception($message);
        }
    }
?>
<?php
    if(!defined('HTTP_CATALOG')) {
        if (version_compare(VERSION, '2.1.0.3', '>')) {
            $this->registry->set('FTMaster', new flowytracking\master($this->registry));
            $this->registry->set('GoogleTagManager', new flowytracking\google_tag_manager($this->registry));
            $this->registry->set('DataLayer', new flowytracking\data_layer($this->registry));
            $this->registry->set('FacebookApiConversions', new flowytracking\facebook_api_conversions($this->registry));
        } elseif (version_compare(VERSION, '2', '>=')) {
            $registry->set('FTMaster', new flowytracking\master($registry));
            $registry->set('GoogleTagManager', new flowytracking\google_tag_manager($registry));
            $registry->set('DataLayer', new flowytracking\data_layer($registry));
            $registry->set('FacebookApiConversions', new flowytracking\facebook_api_conversions($registry));
        } else {
            require_once(VQMod::modCheck(DIR_SYSTEM . 'library/user.php'));
            $registry->set('user', new User($registry));

            include_once(DIR_SYSTEM . 'library/flowytracking/master.php');
            $registry->set('FTMaster', new flowytracking\master($registry));

            include_once(DIR_SYSTEM . 'library/flowytracking/google_tag_manager.php');
            $registry->set('GoogleTagManager', new flowytracking\google_tag_manager($registry));

            include_once(DIR_SYSTEM . 'library/flowytracking/data_layer.php');
            $registry->set('DataLayer', new flowytracking\data_layer($registry));

            include_once(DIR_SYSTEM . 'library/flowytracking/facebook_api_conversions.php');
            $registry->set('FacebookApiConversions', new flowytracking\facebook_api_conversions($registry));
        }
    }
?>
<?php

if($this->FTMaster && $this->FTMaster->ft_is_enabled()) {
    //Set data in session to recover it after make ajax call
    $ft_data = $this->DataLayer->get_datalayer_data();
    $ft_data['fb_api_track_info'] = $this->FacebookApiConversions->set_track_info_api($ft_data);

    if(!empty($ft_data['order_data']))
        $this->FTMaster->send_order_to_flowytracking($ft_data);

    $this->session->data['ft_datalayer'] = $ft_data;

    //Get Google tag manager code
    $head_ft = $this->GoogleTagManager->get_code_head();

    //$head_ft .= "\n".'<script type="text/javascript" nitro-exclude="" src="https://gateway.flowytracking.com/library"></script>';
    $head_ft .= "\n".'<script type="text/javascript" nitro-exclude="" src="'.HTTPS_SERVER.'catalog/view/javascript/flowytracking/data_layer_events.js"></script>'."\n";

    $head_ft .= '<script type="text/javascript" nitro-exclude="">
                    var scriptElement = document.createElement("script");
                    scriptElement.src = "https://gateway.flowytracking.com/library";
                    scriptElement.setAttribute("nitro-exclude", "");

                    var _FlowyTracking;

                    scriptElement.onload = function() {
                        if (typeof FlowyTracking === "undefined") {
                            console.error("FlowyTracking error: JS Library FlowyTracking not loaded.");
                        } else {
                            var flowy_tracking_settings = {
                                "lang" : flowy_tracking_language,
                                "system" : "opencart",
                                "version" : "1.0.0"
                            };
                        
                            _FlowyTracking = new FlowyTracking(flowy_tracking_settings);
                                    
                            var xhr = new XMLHttpRequest();
                            
                            xhr.open("POST", dataLayer_setup_link);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=UTF-8");
                            xhr.responseType = "json";
                            
                            xhr.onload = function() {
                                if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                                    var result = xhr.response;
                                    flowyTracking_Start(result);
                                }
                            };

                            xhr.send();
                        }
                    };
                
                    document.head.appendChild(scriptElement);
                </script>';

    $head_ft .= "<script type=\"text/javascript\" nitro-exclude=\"\">
                    function ft_facebook_api_track(data) {
                        var xhr = new XMLHttpRequest();
                        xhr.open(\"POST\", 'index.php?route=extension/module/ft_facebook/track');
                        xhr.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded;charset=UTF-8\");
                        xhr.responseType = 'json';
                        xhr.onload = function() {
                            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                            }
                        };
                        
                        xhr.send(JSON.stringify(data));
                    }
                </script>";

    $data_to_view['head_ft'] = $head_ft;

    $data_to_view['body_ft'] = $this->GoogleTagManager->get_code_body();

    //JooCart compatibility
    if(defined( '_JEXEC' )) {
        $document = JFactory::getDocument();
        foreach ($data_to_view as $data_name => $value) {
            if($data_name == 'head_ft') {
                $document->addCustomTag($value);

                unset($data_to_view[$data_name]);
            }
        }
    }

    //Send data to view
    foreach ($data_to_view as $data_name => $value) {
        if(version_compare(VERSION, '2.0.0.0', '>='))
            $data[$data_name] = $value;
        else
            $this->data[$data_name] = $value;
    }
}
?>
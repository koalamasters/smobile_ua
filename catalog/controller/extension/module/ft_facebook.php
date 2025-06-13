<?php
class ControllerExtensionModuleFtFacebook extends Controller 
{
    public function __construct($registry) {
        parent::__construct($registry);
    }

    public function track() {
        $post_data = file_get_contents('php://input');
        $this->request->post = json_decode($post_data, true);
        $event_name = !empty($this->request->post['event_name']) ? $this->request->post['event_name'] : '';
        
        if (!empty($event_name)) {
            if ($event_name == 'addToCart') {
                $response = $this->FacebookApiConversions->track_add_to_cart($this->request->post);
            } elseif ($event_name == 'removeFromCart') {
                $response = $this->FacebookApiConversions->track_remove_from_cart($this->request->post);
            } elseif ($event_name == 'addToWishlist') {
                $response = $this->FacebookApiConversions->track_add_to_wishlist($this->request->post);
            } elseif ($event_name == 'trackView') {
                $response = $this->FacebookApiConversions->track_view($this->request->post);
            } else {
                $response = "No action was found for track: ".$event_name;
            }
        } else {
            $response = "No action was found for track: ".$event_name;
        }

        die($response);
    }
}
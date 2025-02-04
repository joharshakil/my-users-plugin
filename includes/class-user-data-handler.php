<?php
class UserDataHandler {
    private $api_base = 'https://jsonplaceholder.typicode.com/';

    public function fetch_users() {
        $response = wp_remote_get($this->api_base . 'users');
        if (is_wp_error($response)) {
            return [];
        }
        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function fetch_user_details($user_id) {
        $response = wp_remote_get($this->api_base . 'users/' . $user_id);
        if (is_wp_error($response)) {
            return [];
        }
        return json_decode(wp_remote_retrieve_body($response), true);
    }
}

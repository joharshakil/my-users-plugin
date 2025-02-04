<?php
class UserTableRenderer {
    public function render() {
        $handler = new UserDataHandler();
        $users = $handler->fetch_users();

        if (empty($users)) {
            return '<p>No users found.</p>';
        }

        $output = '<table>';
        $output .= '<thead><tr><th>ID</th><th>Name</th><th>Username</th></tr></thead><tbody>';

        foreach ($users as $user) {
            $output .= '<tr>';
            $output .= '<td><a href="#" class="user-link" data-id="' . esc_attr($user['id']) . '">' . esc_html($user['id']) . '</a></td>';
            $output .= '<td>' . esc_html($user['name']) . '</td>';
            $output .= '<td>' . esc_html($user['username']) . '</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody></table>';
        $output .= '<div id="user-details"></div>';

        return $output;
    }
}

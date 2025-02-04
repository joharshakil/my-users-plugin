<?php
use PHPUnit\Framework\TestCase;
use MyUsersPlugin\UserDataHandler;

class UserDataHandlerTest extends TestCase {
    public function test_fetch_users_returns_array() {
        $handler = new UserDataHandler();
        $users = $handler->fetch_users();
        $this->assertIsArray($users);
    }

    public function test_fetch_user_details_returns_array() {
        $handler = new UserDataHandler();
        $details = $handler->fetch_user_details(1);
        $this->assertIsArray($details);
    }
}

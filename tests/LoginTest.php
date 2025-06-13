<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private function resetSession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        $_SESSION = [];
        $_GET = [];
        $_POST = [];
    }

    public function testIsUserLoggedInReturnsTrueWhenStatusIsSet()
    {
        $this->resetSession();
        $login = new Login();
        $_SESSION['user_login_status'] = 1;
        $this->assertTrue($login->isUserLoggedIn());
    }

    public function testIsUserLoggedInReturnsFalseByDefault()
    {
        $this->resetSession();
        $login = new Login();
        $this->assertFalse($login->isUserLoggedIn());
    }

    public function testDoLogoutClearsSessionAndAddsMessage()
    {
        $this->resetSession();
        $login = new Login();
        $_SESSION['user_login_status'] = 1;
        $login->doLogout();
        $this->assertArrayNotHasKey('user_login_status', $_SESSION);
        $this->assertContains('Has sido desconectado.', $login->messages);
    }

    public function testLoginMissingUsernameAddsError()
    {
        $this->resetSession();
        $_POST = ['login' => 1, 'user_password' => '123'];
        $login = new Login();
        $this->assertContains('Username field was empty.', $login->errors);
    }
}

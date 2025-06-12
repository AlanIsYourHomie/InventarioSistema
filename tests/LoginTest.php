<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        // Limpiar sesiones y formularios antes de cada prueba
        $_POST = [];
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        // Limpiar variables globales después de cada prueba
        $_POST = [];
        $_SESSION = [];
    }

    public function testLoginCorrecto()
    {
        $_POST['user_name'] = 'admin'; // Nombre del usuario real
        $_POST['user_password'] = 'admin'; // Contraseña real del usuario (en texto plano)
        $_POST['login'] = true;

        require_once __DIR__ . '/../config/db.php';
        require_once __DIR__ . '/../config/conexion.php';
        require_once __DIR__ . '/../classes/Login.php';

        $login = new Login();

        $this->assertEmpty(
            $login->errors,
            "Errores encontrados en login: " . implode(", ", $login->errors)
        );

        $this->assertNotEmpty(
            $_SESSION['user_id'] ?? null,
            "La sesión no fue iniciada correctamente."
        );
    }

    public function testLoginIncorrecto()
    {
        $_POST['user_name'] = 'admin'; // Usuario real
        $_POST['user_password'] = 'clave_incorrecta'; // Contraseña incorrecta
        $_POST['login'] = true;

        require_once __DIR__ . '/../config/db.php';
        require_once __DIR__ . '/../config/conexion.php';
        require_once __DIR__ . '/../classes/Login.php';

        $login = new Login();

        $this->assertNotEmpty(
            $login->errors,
            "Se esperaba error de login pero no ocurrió."
        );

        $this->assertEmpty(
            $_SESSION['user_id'] ?? null,
            "No se esperaba que se inicie sesión."
        );

        var_dump($_SESSION);

    }
}

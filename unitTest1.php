<?php
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testRedirectsToLoginWhenUsernameIsNotSet()
    {
        // Arrange
        $_SESSION = []; // Reset the session
        require 'form.php';

        // Act
        ob_start();
        $_POST['submit'] = true;
        $_POST['text1'] = 'some text';
        $_POST['text2'] = 'another text';
        $_FILES['files']['name'] = ['file1.txt', 'file2.txt'];
        $_FILES['files']['tmp_name'] = ['path/to/tmp/file1.txt', 'path/to/tmp/file2.txt'];
        $_FILES['files']['type'] = ['text/plain', 'text/plain'];
        $_FILES['files']['size'] = [100, 200];
        $_FILES['files']['error'] = [UPLOAD_ERR_OK, UPLOAD_ERR_OK];
        require 'form.php';
        $output = ob_get_clean();

        // Assert
        $this->assertStringContainsString('Location: login.php', xdebug_get_headers()[0]);
        $this->assertEquals('', $output);
    }

    public function testFormSubmission()
    {
        // Arrange
        $_SESSION['username'] = 'user';
        require 'form.php';

        // Act
        ob_start();
        $_POST['submit'] = true;
        $_POST['text1'] = 'some text';
        $_POST['text2'] = 'another text';
        $_FILES['files']['name'] = ['file1.txt', 'file2.txt'];
        $_FILES['files']['tmp_name'] = ['path/to/tmp/file1.txt', 'path/to/tmp/file2.txt'];
        $_FILES['files']['type'] = ['text/plain', 'text/plain'];
        $_FILES['files']['size'] = [100, 200];
        $_FILES['files']['error'] = [UPLOAD_ERR_OK, UPLOAD_ERR_OK];
        require 'form.php';
        $output = ob_get_clean();

        // Assert
        $this->assertStringContainsString('submitted successfully!', $output);
    }

}


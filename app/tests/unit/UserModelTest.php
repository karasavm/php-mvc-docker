<?php 
use \App\Models\User;
use PDO;

class UserModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $user;

    protected function _before()
    {
        $this->user = new User('Michael Karasavvas', 'mkarasavvas@test.com', 'pass', 'pass_conf');
    }

    protected function _after()
    {
    }

    
    public function testConstructor()
    {
        

        $this->assertEquals('Michael Karasavvas', $this->user->name, 'wrong name--------------');
        $this->assertEquals('mkarasavvas@test.com', $this->user->email, 'wrhons emaiiill');
        $this->assertEquals('pass', $this->user->password);
        $this->assertEquals('pass_conf', $this->user->password_confirm);    
    }

    public function testValidate() {

        $this->user->name = '';

        $this->user->validate();
        $this->assertContains('Name is required', $this->user->errors);

    }
}
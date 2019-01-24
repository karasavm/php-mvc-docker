<?php namespace App\Models;

use \App\Models\User;
use \App\Config;

//require '../app/vendor/autoload.php';


class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $user;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $config = new \App\Config();
        $config->load();
        codecept_debug(__NAMESPACE__);
    }

    protected function _before()
    {

    }

    protected function _after()
    {
    }

    // tests

    public function testConstructorWhenParametersProvided()
    {
        $user = new User('Michael Karasavvas', 'mkarasavvas@test.com', 'pass', 'pass_conf');
        $this->assertEquals('Michael Karasavvas', $user->name);
        $this->assertEquals('mkarasavvas@test.com', $user->email);
        $this->assertEquals('pass', $user->password);
        $this->assertEquals('pass_conf', $user->password_confirm);
    }

    public function testConstructorWhenNoParametersProvided()
    {
        $user = new User();
        $this->assertEquals(null, $user->name);
        $this->assertEquals(null, $user->email);
        $this->assertEquals(null, $user->password);
        $this->assertEquals(null, $user->password_confirm);
    }

    // ----------------- validate()

    //  name validation
    public function testValidateNameCheck() {


        $user = $this->construct(User::class, [], [
            'emailExists' => true
        ]);

        // not set name
        $user->errors = [];
        $user->validate();

        $this->assertContains('Name is required', $user->errors);

        // empty string name
        $user->name = '';
        $user->errors = [];
        $user->validate();

        $this->assertContains('Name is required', $user->errors);

        // null name
        $user->name = null;
        $user->errors = [];
        $user->validate();

        $this->assertContains('Name is required', $user->errors);

        // dummy string name
        $user->name = 'mpla mpla';
        $user->errors = [];
        $user->validate();

        $this->assertNotContains('Name is required', $user->errors);

    }

    // email validation
    public function testValidateEmailCheck() {

        $user = $this->construct( User::class, [], [
            'emailExists' => true
        ]);

        // not set email
        $user->errors = [];
        $user->validate();

        $this->assertContains('Invalid email', $user->errors);

        // empty string email
        $user->email = '';
        $user->errors = [];
        $user->validate();

        $this->assertContains('Invalid email', $user->errors);

        // null email
        $user->email = null;
        $user->errors = [];
        $user->validate();

        $this->assertContains('Invalid email', $user->errors);

        // wrong email format
        $user->email = 'mpla mpla';
        $user->errors = [];
        $user->validate();

        $this->assertContains('Invalid email', $user->errors, 'wrong email format');

        // dummy string email
        $user->email = 'dummy@email.test';
        $user->errors = [];
        $user->validate();

        $this->assertNotContains('Invalid email', $user->errors);


    }

    public function testValidatePasswordCheck() {
        $user = $this->construct( User::class, [], [
            'emailExists' => true
        ]);

        // password and password_confirm not set
        $user->errors = [];
        $user->validate();

        $this->assertNotContains('Password must match confirmation', $user->errors);
        $this->assertNotContains('Please enter at least 6 characters for the password', $user->errors);

        // password = null
        $user->errors = [];
        $user->password = null;
        $user->validate();

        $this->assertNotContains('Password must match confirmation', $user->errors);
        $this->assertNotContains('Please enter at least 6 characters for the password', $user->errors);

        // password = ''
        $user->errors = [];
        $user->password = '';
        $user->validate();

        $this->assertNotContains('Password must match confirmation', $user->errors);
        $this->assertNotContains('Please enter at least 6 characters for the password', $user->errors);


        // password set and password < 6
        $user->errors = [];
        $user->password = '12345';
        $user->validate();

        $this->assertContains('Please enter at least 6 characters for the password', $user->errors);

        // password set and password >= 6
        $user->errors = [];
        $user->password = '123454';
        $user->validate();

        $this->assertNotContains('Please enter at least 6 characters for the password', $user->errors);


        // password and password_conf set and equal
        $user->errors = [];
        $user->password = '123454';
        $user->password_confirm = '123454';
        $user->validate();

        $this->assertNotContains('Password must match confirmation', $user->errors);

        // password and password_conf set and not equal
        $user->errors = [];
        $user->password = '123454';
        $user->password_confirm = '1234543';
        $user->validate();

        $this->assertContains('Password must match confirmation', $user->errors);

        // password set and password_conf not set
        $user->errors = [];
        $user->password = '123454';
        $user->validate();

        $this->assertContains('Password must match confirmation', $user->errors);





        // empty string email
//        $user->email = '';
//        $user->errors = [];
//        $user->validate();
    }


    public function testDokimastiko() {
        $user = $this->construct(User::class, [
            'custom email ree',
            'custom email ree',
        ], [
            'emailExists' => true
        ]);

//        codecept_debug($user);
//        $user->validate();

    }

    // ------------------------------  save()   ----------------------
    public function testSaveSuccessfulInsertToDb() {

        $name = 'Test Name 1';
        $email = 'test@yahoo.gr';
        $password = 'password';
        $password_confirm = $password;

        $user = new User($name, $email, $password, $password_confirm);
        $result = $user->save();

        $this->tester->seeInDatabase('users', [
            'email' => $email,
            'name' => $name,
            'password_hash' => $user->password_hash
        ]);

        $this->assertTrue($result);
    }
}
















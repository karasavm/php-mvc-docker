<?php namespace App\Models;

use \App\Models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $user;

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
}
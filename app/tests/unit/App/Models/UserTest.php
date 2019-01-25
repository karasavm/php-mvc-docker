<?php namespace App\Models;

use AcmePack\UnitTester;
use \App\Models\User;
use \App\Config;
use \Helper\Utils;
use mysql_xdevapi\Exception;

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
//            'emailExists' => true
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

        $this->assertContains('Invalid email', $user->errors);

        // dummy string email
        $user->email = 'dummy@email.test';
        $user->errors = [];
        $user->validate();

        $this->assertNotContains('Invalid email', $user->errors);

        // email exists
        $email = 'testValidateEmailCheck@email.com';
        $this->tester->haveInDatabase('users', [
            'email' => $email,
            'name' => 'testValidateEmailCheck',
            'password_hash' => 'testValidateEmailCheck'
        ]);

        $user->email = $email;
        $user->errors = [];
        $user->validate();

        $this->assertContains('Email already taken', $user->errors);


    }

    public function testValidatePasswordCheck() {
        $user = $this->construct( User::class, [], [
//            'emailExists' => true
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
//            'emailExists' => true
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
//        $result = $user->save();
//
//        $this->tester->seeInDatabase('users', [
//            'email' => $email,
//            'name' => $name,
//            'password_hash' => $user->password_hash
//        ]);
//
//        $this->assertTrue($result);
    }


    public function testDoSaveSuccessfulInsertToDB() {

        $name = 'Test Name 1';
        $email = 'test@yahoo.gr';
        $password_hash = 'hashed password';

        $user = $this->make(
            User::class, [
                'name' => $name,
                'email' => $email,
                'password_hash' => $password_hash
            ]
        );

        Utils::invokeMethod($user, 'doSave', []);

        $this->tester->seeInDatabase('users', [
            'email' => $email,
            'name' => $name,
            'password_hash' => $user->password_hash
        ]);

    }


    public function badUserValues()
    {
        return [
            ['Test Name 1', 'test@yahoo.gr1', null],
            [ null, 'test@yahoo.gr2', 'hash_password'],
            ['Test Name 1', null, 'hash_password']
        ];
    }

    /**
     * @dataProvider badUserValues
     * @expectedException \PDOException
     */
    public function testDoSaveNotNullValuesCheck( $name, $email, $hash_password ) {

        $user = $this->make(User::class, [
                'name' => $name,
                'email' => $email,
                'password_hash' => $hash_password
            ]
        );

        $this->expectException(\PDOException::class);
        Utils::invokeMethod($user, 'doSave', []);
    }

    // ------------------------------ save()
    public function testSaveWhenInvalidData() {

        $user = $this->make(User::class, [
            'errors' => [ 'test message'],
            'validate' => function () {}
        ]);

        $this->assertFalse($user->save());
    }

    public function testSaveWhenValidData() {

        $user = new User(
            'Mike',
            'testSaveWhenValidData@email.com',
            'password',
            'password'
        );



        $result = $user->save();
        $this->assertTrue($result);

    }

    // ----------------------------- setHashedPassword()
    public function testHashedPassword() {

        $user = $this->make(User::class, [
            'password' => 'test'
        ]);

        $user->setHashedPassword();

        $this->assertNotEmpty($user->password_hash);
        $this->assertNotNull($user->password_hash);

    }

    // ---------------------------- authenticate()

    public function testAuthenticationSuccess() {

        $email = 'testAuthenticationSuccess@gmail.com';
        $password = 'password';

        $user = new User('Test Name', $email, $password, $password);

        if (!$user->save()) throw new \Exception('Unable to save user');

        // should return true
        $result = User::authenticate($email, $password);
        $this->assertFalse($result === false);

        // should return false when wrong email string
        $result = User::authenticate('ddfd', $password);
        $this->assertTrue($result === false);

        // should return false when null email
        $result = User::authenticate(null, $password);
        $this->assertTrue($result === false);

        // should return false when empty string email
        $result = User::authenticate('', $password);
        $this->assertTrue($result === false);

        // should return false when wrong password string
        $result = User::authenticate($email, 'ddfd');
        $this->assertTrue($result === false);

        // should return false when null password
        $result = User::authenticate($email, null);
        $this->assertTrue($result === false);

        // should return false when empty string password
        $result = User::authenticate($password, '');
        $this->assertTrue($result === false);
    }


    // --------------------------------- findById()
    public function  testFindById() {
        $email = 'testFindById@email.com';
        $this->tester->haveInDatabase('users', [
           'email' => $email,
           'name' => 'testFindById',
            'password_hash' => 'passs'
        ]);

        $id = $this->tester->grabColumnFromDatabase('users', 'id', [
            'email' => $email
        ]);


        // success
        $result = User::findById($id[0]);
        $this->assertNotNull($result);

        // fail, id not exists
        $result = User::findById('-10');
        $this->assertFalse($result);

    }


    // --------------------------------- emailExists()
    public function  testEmailExists() {
        $email = 'testEmailExists@email.com';
        $this->tester->haveInDatabase('users', [
            'email' => $email,
            'name' => 'testEmailExists',
            'password_hash' => 'passs'
        ]);

        $id = $this->tester->grabColumnFromDatabase('users', 'id', [
            'email' => $email
        ]);


        // success
        $result = \App\Models\User::emailExists($email);
        $this->assertTrue($result);

        // success with ignore_id what is different to users
        $result = \App\Models\User::emailExists($email, $id[0] . '4'); // change the id
        $this->assertTrue($result);

        // fail with same ignore id
        $result = \App\Models\User::emailExists($email, $id[0]); // change the id
        $this->assertFalse($result);


        // fail, id not exists
//        $result = User::findById('-10');
//        $this->assertFalse($result);
    }

    // -------------------------------- update()
    //todo: emeina edw

    public function testUpdateWithSuccessNameAndEmail() {

        // init save user object
        $name = 'testUpdate';
        $email = 'testUpdate@email.com';
        $password = '';
        $password_confirm = '';

        $user = new User($name, $email, $password, $password_confirm);
        $user->save();

        $user = User::findByEmail($email);

        // [name, email, password, password_confirm]
        $params = [
            ['testUpdate2', 'testUpdate@email.com', '', ''],
            ['testUpdate22', 'testUpdate@email1.com', '', '']
        ];
        // update with success name and email

        foreach ( $params as $values) {
            $data = [];
            $data['name'] = $values[0];
            $data['email'] = $values[1];
            $data['password'] = $values[2];
            $data['password_confirm'] = $values[3];

            $result = $user->update($data);
            $this->assertTrue($result !== false);

            $this->tester->seeInDatabase('users', [
                    'email' => $data['email'],
                    'name' => $data['name']
                ]
            );
        }


    }


    public function testUpdateWithSuccessNameAndEmail__() {

        // init save user object
        $name = 'testUpdate';
        $email = 'testUpdate@email.com';
        $password = 'testUpdate';
        $password_confirm = $password;

        $user = new User($name, $email, $password, $password_confirm);
        $user->save();

        $user = User::findByEmail($email);

        // [name, email, password, password_confirm]
        $params = [
            ['testUpdate2', 'testUpdate@email.com', '', ''],
            ['testUpdate22', 'testUpdate@email1.com', '', '']
        ];
        // update with success name and email

        foreach ( $params as $values) {
            $data = [];
            $data['name'] = $values[0];
            $data['email'] = $values[1];
            $data['password'] = $values[2];
            $data['password_confirm'] = $values[3];

            $result = $user->update($data);
            $this->assertTrue($result !== false);

            $this->tester->seeInDatabase('users', [
                    'email' => $data['email'],
                    'name' => $data['name']
                ]
            );
        }


    }


}
















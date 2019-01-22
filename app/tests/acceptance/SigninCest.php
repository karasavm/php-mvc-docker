<?php 

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function loginSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email','averelgr@yahoo.gr');
        $I->fillField('password','1');
        $I->click('submit');
        $I->wait(5);
        $I->see('Hello michael karas !');
    }
}

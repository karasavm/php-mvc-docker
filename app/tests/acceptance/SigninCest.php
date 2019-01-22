<?php 

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function signInSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Email','averelge@yahoo.gr');
        $I->fillField('Password','qwerty');
        $I->click('Submit');
        $I->see('Hello michael karas !');
    }
}

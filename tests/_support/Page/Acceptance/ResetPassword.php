<?php
namespace Page\Acceptance;

class ResetPassword
{
    // include url of current page
    public static $URL = '';


    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    // Inputs
    public $resetPasswordCodeInput = 'input[name="code"]';
    public $passwordInput = 'input[name="password"]';

    // Buttons
    public $changePasswordButton = 'input[value="Change password"][type="submit"]';

    // Text
    public $alertInfo = 'div.alert.alert-info';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function checkResetPasswordElements()
    {
        $I = $this->acceptanceTester;

        $I->seeElement($this->resetPasswordCodeInput);
        $I->seeElement($this->passwordInput);
        $I->seeElement($this->resetPasswordCodeInput);
        $I->seeElement($this->changePasswordButton);
        $I->seeElement($this->alertInfo);
    }

}

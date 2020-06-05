<?php
namespace Page\Acceptance;

class Registration
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //text elements
    public $registrationH1 = '#registration-h1';
    public $privateRegistrationHeading = 'h1.registration-heading';

    //widgets
    public $registrationForm = 'form[name="registrationForm"]';
    public $privateAccount = 'li[data-ng-class*="private"] a';
    public $businessAccount = 'li[data-ng-class*="business"] a';

    //icons and logo
    public $androidPlayStoreIcon = 'img[src*="img/addons/store/google-store.png"]';
    public $iosAppStoreIcon = 'img[src*="img/addons/store/app-store.png"]';

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

    public function registrationElementCheck()
    {
        $I = $this->acceptanceTester;
        $I->seeElement($this->registrationH1);
        $I->seeElement($this->registrationForm);
        $I->seeElement($this->privateAccount);
        $I->seeElement($this->businessAccount);
        $I->seeElement($this->privateRegistrationHeading);
        $I->seeElement($this->androidPlayStoreIcon);
        $I->seeElement($this->iosAppStoreIcon);
    }

}

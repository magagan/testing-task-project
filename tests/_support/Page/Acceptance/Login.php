<?php
namespace Page\Acceptance;

class Login
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //inputs
    public $usernameEmailInput = 'input[name="userIdentifier"]';
    public $passwordInput = '#password';

    //widgets
    public $passwordTabSection = '#login-methods-heading-user_credentials';
    public $loginContainer = 'div.authentication-login-form-container';
    public $mobileLoginWidget = '#login-methods-body-app_credentials';
    public $mobileAppLoginTab = '#login-methods-heading-app_credentials';
    public $loadingSpinner = 'div.spinner';

    //buttons
    public $loginButton = 'button[type="submit"]';
    public $mobileAppLoginButton = 'div[class="Loader"] div > button[type="button"]';
    public $mobileLoginCancelButton = '#login-methods-body-app_credentials > div > button.btn.btn-danger';

    //alert element
    public $alertInfo = 'div.alert.alert-info';
    public $alertDanger = 'div.alert.alert-danger';
    public $notHaveApplicationH4 = 'div[class="Loader"] span.h4.text-uppercase';

    //text link
    public $forgotPassword = '//*[text()="Forgot password?"]';
    public $registerTextLink = 'a[href*="/registration"]';
    public $noMobileAppYetTexLink = '//*[text()="I do not have the mobile app yet"]';
    public $loginMethods = '#login-methods div > a';

    //icon or logo
    public $iosMobileLoginIcon = 'div[class="Loader"] a[href*="itunes.apple.com/app/"]';
    public $androidMobileLoginIcon = 'div[class="Loader"] a[href*="play.google.com/store/apps/details"]';


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

    public function login($email, $password)
    {
        $I = $this->acceptanceTester;
        $I->waitForElement($this->usernameEmailInput);
        $I->fillField($this->usernameEmailInput, $email);
        $I->click($this->loginButton);
        $this->loadingSpinnerChecking();
        $I->click($this->passwordTabSection);
        $I->waitForElementVisible($this->passwordInput, 30);
        $I->fillField($this->passwordInput, $password);
        $I->click($this->loginButton);

    }

    public function loadingSpinnerChecking()
    {
        $I = $this->acceptanceTester;
        $I->waitForElementVisible($this->loadingSpinner,30);
        $I->waitForElementNotVisible($this->loadingSpinner,30);
        $I->waitForElementVisible($this->passwordTabSection, 10);
        $I->waitForElementVisible($this->loadingSpinner,30);
        $I->waitForElementNotVisible($this->loadingSpinner,30);
    }

}

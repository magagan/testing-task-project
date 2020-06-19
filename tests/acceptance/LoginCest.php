<?php
use Yandex\Allure\Adapter\Annotation\Title;

class LoginCest
{
    public function _before(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->amOnPage('/');
        $I->waitForElement($loginPage->usernameEmailInput);
    }

    /**
     * @Title("Verify account not exists notification")
     */
    public function accountNotExistsTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $faker = Faker\Factory::create();
        $I->fillField($loginPage->usernameEmailInput, $faker->safeEmail);
        $I->click($loginPage->loginButton);
        $I->waitForElementVisible($loginPage->alertDanger, 30);
        $I->see('The specified user could not be found', $loginPage->alertDanger);
    }

    /**
     * @Title("Verify user is able to login and logout to account")
     */
    public function loginLogoutToAccountTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage, \Page\Acceptance\Account $accountPage)
    {
        $loginPage->login($I->getConfig('login_username'), $I->getConfig('login_password'));
        $I->waitForElement($loginPage->alertInfo);
        $I->see('Connecting to the system, please wait.', $loginPage->alertInfo);
        $I->waitForElement($accountPage->accoutOverviewContainer);
        $I->seeInCurrentUrl('/account-overview');
        $I->click($accountPage->logoutButton);
        $I->waitForElement($loginPage->loginContainer);
        $I->seeInCurrentUrl('en/login');
    }

    /**
     * @Title("Verify user is redirected to forgot password page")
     */
    public function forgotPasswordLinkRedirectTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage, \Page\Acceptance\ResetPassword $resetPwdPage)
    {
        $I->fillField($loginPage->usernameEmailInput, $I->getConfig('login_username'));
        $I->click($loginPage->loginButton);

        $I->waitForText($loginPage->responseTxt, 30);

        $I->click($loginPage->passwordTabSection);
        $I->waitForElementClickable($loginPage->forgotPassword);
        $I->click($loginPage->forgotPassword);
        $I->waitForElement($resetPwdPage->resetPasswordCodeInput, 30);
        $I->seeInCurrentUrl('reset-password/reset/');
        $resetPwdPage->checkResetPasswordElements();
    }

    /**
     * @Title("Verify notification for invalid password input")
     */
    public function invalidPasswordTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $faker = Faker\Factory::create();
        $loginPage->login($I->getConfig('login_username'), $faker->password(6, 20));
        $I->waitForElementVisible($loginPage->alertDanger, 30);
        $I->see('Incorrect password. Please try again.', $loginPage->alertDanger);
    }

    /**
     * @Title("Verify user is redirected to account registration")
     */
    public function accountRegistrationRedirectTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage, \Page\Acceptance\Registration $registrationPage)
    {
        $I->click($loginPage->registerTextLink);
        $I->waitForElement($registrationPage->registrationForm, 30);
        $I->seeInCurrentUrl('/registration');
        $registrationPage->registrationElementCheck();
    }

    /**
     * @Title("Verify mobile login widget functionality")
     */
    public function mobileAppLoginTabTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->fillField($loginPage->usernameEmailInput, $I->getConfig('login_username'));
        $I->click($loginPage->loginButton);
        $I->waitForText($loginPage->responseTxt, 30);
        $I->seeElement($loginPage->mobileLoginWidget);
        $I->click($loginPage->mobileAppLoginTab);

        $expandedValue = $I->grabAttributeFrom($loginPage->loginMethods, 'aria-expanded');
        \PHPUnit\Framework\Assert::assertEquals('false', $expandedValue, 'Mobile Login Tab Expanded');

        $I->click($loginPage->mobileAppLoginTab);
        $I->waitForElementClickable($loginPage->noMobileAppYetTexLink, 30);

        $expandedValue = $I->grabAttributeFrom($loginPage->loginMethods, 'aria-expanded');
        \PHPUnit\Framework\Assert::assertEquals('true', $expandedValue, 'Mobile Login Tab Expanded');

        $I->seeElement($loginPage->mobileAppLoginButton);
        $I->click($loginPage->noMobileAppYetTexLink);
        $I->see('DO NOT HAVE THE APPLICATION?', $loginPage->notHaveApplicationH4);
        $I->seeElement($loginPage->iosMobileLoginIcon);
        $I->seeElement($loginPage->androidMobileLoginIcon);
    }

    /**
     * @Title("Verify messaging when user click CANCEL in mobile login widget")
     */
    public function mobileAppLoginCancelTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->fillField($loginPage->usernameEmailInput, $I->getConfig('login_username'));
        $I->click($loginPage->loginButton);
        $I->waitForText($loginPage->responseTxt, 30);
        $I->see('Cancel', $loginPage->mobileAppCancelButton, 30);
        $I->click($loginPage->mobileAppCancelButton);
        $I->waitForElement($loginPage->alertInfo, 30);
        $I->see('Login cancelled. Please retry or select another login mode.', $loginPage->alertInfo);
    }

    /**
     * @Title("Verify expired mobile login authentication")
     */
    public function mobileAppLoginVerificationExpiredRepeatTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->fillField($loginPage->usernameEmailInput, $I->getConfig('login_username'));
        $I->click($loginPage->loginButton);
        $I->waitForText($loginPage->responseTxt, 30);

        $mobileLoginAuthCode = $I->grabTextFrom($loginPage->mobileAppCode);
        \PHPUnit\Framework\Assert::assertNotEmpty($mobileLoginAuthCode, 'Mobile login authentication code');

        $I->waitForElement($loginPage->alertDanger, 140);
        $I->see('Verification time expired', $loginPage->alertDanger);
        $I->see('Repeat', $loginPage->mobileAppLoginButton);
        $I->click($loginPage->mobileAppLoginButton);
        $I->waitForText($loginPage->responseTxt, 30);
        $I->seeElement($loginPage->mobileAppCode);

        $mobileLoginAuthCode = $I->grabTextFrom($loginPage->mobileAppCode);
        \PHPUnit\Framework\Assert::assertNotEmpty($mobileLoginAuthCode, 'Mobile login authentication code');
    }

    /**
     * @Title("Verify messaging when user not receiving code within 60 seconds")
     */
    public function mobileAppLoginNotReceivingCodeTest(AcceptanceTester $I, \Page\Acceptance\Login $loginPage)
    {
        $I->fillField($loginPage->usernameEmailInput, $I->getConfig('login_username'));
        $I->click($loginPage->loginButton);
        $I->waitForText($loginPage->responseTxt, 30);
        $I->waitForElement($loginPage->notReceivingCode, 60);
        $I->see('Haven\'t received a code?', $loginPage->notReceivingCode);
    }

}


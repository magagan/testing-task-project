<?php

use Yandex\Allure\Adapter\Annotation\Title;

include __DIR__ . '/../../vendor/autoload.php';

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
        $I->waitForElementVisible($loginPage->alertDanger);
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

        $loginPage->loadingSpinnerChecking();

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
        $loginPage->loadingSpinnerChecking();
        $I->waitForElement($loginPage->mobileLoginCancelButton);
        $I->seeElement($loginPage->mobileLoginCancelButton);
        $I->click($loginPage->mobileAppLoginTab);

        $expandedValue = $I->grabAttributeFrom($loginPage->loginMethods, 'aria-expanded');
        \PHPUnit\Framework\Assert::assertEquals('false' , $expandedValue, 'Mobile Login Tab Expanded' );

        $I->click($loginPage->mobileAppLoginTab);
        $I->waitForElementClickable($loginPage->noMobileAppYetTexLink, 30);

        $expandedValue = $I->grabAttributeFrom($loginPage->loginMethods, 'aria-expanded');
        \PHPUnit\Framework\Assert::assertEquals('true' , $expandedValue, 'Mobile Login Tab Expanded' );

        $I->seeElement($loginPage->mobileAppLoginButton);
        $I->click($loginPage->noMobileAppYetTexLink);
        $I->see('DO NOT HAVE THE APPLICATION?', $loginPage->notHaveApplicationH4);
        $I->seeElement($loginPage->iosMobileLoginIcon);
        $I->seeElement($loginPage->androidMobileLoginIcon);
    }

}


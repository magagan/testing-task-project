# Login Page Testing Project

Login Page automated test using codeception framework.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Setup](#setup)
- [Running The Test](#running-test)
- [Test Cases](#test-cases)
- [Reporting](#reporting)

#### Prerequisites
- <a href="https://www.php.net/" target="_blank">Installed PHP 7.3 or higher</a>
- <a href="https://getcomposer.org/" target="_blank">Installed PHP Composer</a>
- <a href="https://www.google.com/chrome/" target="_blank">Installed Google Chrome browser</a>
- <a href="https://www.npmjs.com/package/allure-commandline" target="_blank">Installed NPM Allure Commandline</a>

#### Setup
- Download or clone this project
- Go to project root directory using terminal
- Run composer install command
    ```
    composer install
    ```
- Run selenium server hub in new terminal window
    ```
    java -jar ./selenium/selenium-server-standalone-*.jar -role hub
    ```
- Run selenium server node in new terminal window
    ```
    java -jar -Dwebdriver.chrome.driver=./selenium/chromedriver ./selenium/selenium-server-standalone-*.jar -role node
    ```
- Update values of `acceptance.suite.yml` under `tests` directory
   ```
   url: <Url mentioned in Gist Task - QA.md>
   ```
   ```
   login_username: <Your registered email or phone number>
   login_password: <Your Password>
   ```

#### Running Test
- Running all the test available with steps
    ```
    php vendor/bin/codecept run acceptance --steps --html
    ```
- Running Specific test with steps
    
    _Format:_
    ```
    php vendor/bin/codecept run acceptance <class name>:<function name> --steps --html
    ```
    _Example:_
    ```
    php vendor/bin/codecept run acceptance LoginCest:accountNotExistsTest --steps --html
    ```
    _Lists of Test Functions:_
    - LoginCest:accountNotExistsTest
    - LoginCest:loginLogoutToAccountTest
    - LoginCest:forgotPasswordLinkRedirectTest
    - LoginCest:invalidPasswordTest
    - LoginCest:accountRegistrationRedirectTest
    - LoginCest:mobileAppLoginTabTest
    - LoginCest:mobileAppLoginCancelTest
    - LoginCest:mobileAppLoginVerificationExpiredRepeatTest
    - LoginCest:mobileAppLoginNotReceivingCodeTest

#### Test Cases
- Verify account not exists notification
- Verify user is able to login and logout to account
- Verify user is redirected to forgot password page
- Verify notification for invalid password input
- Verify user is redirected to account registration
- Verify mobile login widget functionality
- Verify messaging when user click CANCEL in mobile login widget
- Verify expired mobile login authentication
- Verify messaging when user not receiving code within 60 seconds


#### Reporting
- Execute in terminal at root directory of project
    ```
    allure serve tests/_output/allure-results
    ```
    _Allure Test Report will be displayed in default browser of machine_

----



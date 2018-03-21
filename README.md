## Running the Tests
### Selenium Server
#### Download Selenium Server

```bash
cd resources/selenium-server; ./install_binaries.sh

```

#### Start Selenium Server
The below command when run from the root of this project will spin up a selenium server which is required for running these tests.
```bash
cd resources/selenium-server; ./run_selenium_server.sh

```
### Installing correct packages
```bash
composer install
```
### Behat Command
This will run all the scenarios in the notification.feature file.
```bash
vendor/bin/behat
```

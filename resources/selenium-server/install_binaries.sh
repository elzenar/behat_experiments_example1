#!/bin/sh

set -e

cd binaries

# WARNING: I use Google Chrome 57.0 so I have to use the correct (not the latest) version of chromedriver
# If you need you can change the version of 'chromedriver'.
# See https://sites.google.com/a/chromium.org/chromedriver/downloads for more details.
#

wget https://chromedriver.storage.googleapis.com/2.29/chromedriver_linux64.zip
unzip -o chromedriver_linux64.zip
rm chromedriver_linux64.zip

wget http://selenium-release.storage.googleapis.com/3.11/selenium-server-standalone-3.11.0.jar

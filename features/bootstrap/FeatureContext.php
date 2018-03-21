<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

use Webmozart\Assert\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    protected $returnedHttpResponse = null;
    protected $returnedHttpErrorMessage = null;

    const BASE_URL = 'https://sandbox.payever.de';

    const VALID_AUTHENTICATION_PARAMS = array(
        'client_id' => '30801_44jezpd83a68wc4k8c8wsssco4k0w0gow4owswoc0g0oksc8o8',
        'client_secret' => '9vejpbzp8k08sk0k08cg00ocsgco80ckog8s800kgwcckwss0',
        'grant_type' => 'http://www.payever.de/api/payment',
        'scope' => 'API_CREATE_PAYMENT',
    );

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * TODO Should be deleted
     * @Given test step
     */
    public function testStep()
    {
        throw new PendingException();
    }

    /**
     * @When RESTClient send valid request to \/oauth\/v2\/token
     */
    public function restClientSendValidRequestToOauthV2Token()
    {
        $curl = curl_init();
        $related_path = "/oauth/v2/token";
        $curl_options = array(
            CURLOPT_URL => self::BASE_URL . $related_path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => self::VALID_AUTHENTICATION_PARAMS,
        );
        curl_setopt_array($curl, $curl_options);
        $this->returnedHttpResponse = curl_exec($curl);
        $this->returnedHttpErrorMessage = curl_error($curl);
        curl_close($curl);
    }

    /**
     * @Then HTTP response error message should be empty
     */
    public function httpResponseErrorMessageShouldBeEmpty()
    {
        Assert::isEmpty($this->returnedHttpErrorMessage);
    }

    /**
     * @Then Returned HTTP response should be valid JSON
     */
    public function returnedHttpResponseShouldBeValidJson()
    {
        $json = json_decode($this->returnedHttpResponse);
        $error = json_last_error_msg();
        Assert::notNull($json, "Returned HTTP response can not be decoded as JSON. Error message: ${error}");
        # TODO Is it extra assertion ?
        Assert::isEmpty($error, "Error message has appeared during JSON decoding: ${error}");
    }

    /**
     * @Then Returned HTTP response should contains JSON fields:
     */
    public function returnedHttpResponseShouldContainsJsonFields(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then Specified JSON fields in returned HTTP response should not be empty:
     */
    public function specifiedJsonFieldsInReturnedHttpResponseShouldNotBeEmpty(TableNode $table)
    {
        throw new PendingException();
    }

}

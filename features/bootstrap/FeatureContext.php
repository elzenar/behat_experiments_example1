<?php

use Behat\Behat\Context\Context;
//use Behat\Gherkin\Node\PyStringNode;
//use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

use Webmozart\Assert\Assert;
use Helmich\JsonAssert\JsonAssertions;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    use JsonAssertions;

    protected $returnedHttpResponse = null;
    protected $returnedHttpErrorMessage = null;

    const BASE_URL = 'https://sandbox.payever.de';

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
     * @When /^RESTClient send request to \/oauth\/v2\/token using "([^"]*)" dataset$/
     * @param $datasetName
     */
    public function restClientSendRequestToOauthV2TokenUsingDataset($datasetName)
    {
        $curl = curl_init();
        $related_path = "/oauth/v2/token";
        $curl_options = array(
            CURLOPT_URL => self::BASE_URL . $related_path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $this->getDataset($datasetName),
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
    }


    /**
     * @Given /^Returned HTTP response should match "([^"]*)" JSON schema$/
     */
    public function returnedHTTPResponseShouldMatchJSONSchema($jsonSchemaName)
    {
        $this->assertJsonDocumentMatchesSchema(json_decode($this->returnedHttpResponse), $this->jsonSchemaRepository($jsonSchemaName));
    }

    /**
     * Returns associative array that represents JSON schema for passed $jsonSchemaName
     * TODO Should be moved from FeatureContext class
     *
     * @param $jsonSchema
     * @return array
     * @throws InvalidArgumentException
     */
    protected function jsonSchemaRepository($jsonSchemaName)
    {

        $returnedSchema = null;
        switch ($jsonSchemaName)
        {
            case 'valid_oauth_v2_token_response_json_schema':
                $returnedSchema = [
                    'type' => 'object',
                    'required' => ['access_token', 'expires_in', 'token_type', 'scope', 'refresh_token'],
                    'properties' => [
                        'access_token' => ['type' => 'string'],
                        'expires_in'   => ['type' => 'integer'],
                        'token_type'   => ['type' => 'string'],
                        'scope'   => ['type' => 'string'],
                        'refresh_token'   => ['type' => 'string'],
                    ]
                ];
                break;
            case 'error_oauth_v2_token_response_invalid_client_json_schema':
                $returnedSchema = [
                    'type' => 'object',
                    'required' => ['error', 'error_description'],
                    'properties' => [
                        'error' => ['type' => 'string'],
                        'error_description'   => ['type' => 'string'],
                    ]
                ];
                break;
            default:
               throw new InvalidArgumentException("Unknown jsonSchemaName was passed: $jsonSchemaName");
        }
        return $returnedSchema;
    }

    /**
     * Returns associated array by specified $datasetName
     *
     * @param $datasetName
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getDataset($datasetName)
    {
        $returnedDataset = null;

        switch ($datasetName)
        {
            case 'valid_request_to_oauth_v2_token':
                $returnedDataset = array(
                    'client_id' => '30801_44jezpd83a68wc4k8c8wsssco4k0w0gow4owswoc0g0oksc8o8',
                    'client_secret' => '9vejpbzp8k08sk0k08cg00ocsgco80ckog8s800kgwcckwss0',
                    'grant_type' => 'http://www.payever.de/api/payment',
                    'scope' => 'API_CREATE_PAYMENT',
                );
                break;
            case 'invalid_request_to_oauth_v2_token_with_incorrect_client_secret':
                $returnedDataset = array(
                    'client_id' => '30801_44jezpd83a68wc4k8c8wsssco4k0w0gow4owswoc0g0oksc8o8',
                    'client_secret' => 'incorrect_client_secret',
                    'grant_type' => 'http://www.payever.de/api/payment',
                    'scope' => 'API_CREATE_PAYMENT',
                );

                break;
            case 'invalid_request_to_oauth_v2_token_with_incorrect_client_id':
                $returnedDataset = array(
                    'client_id' => 'incorrect_client_secret',
                    'client_secret' => '9vejpbzp8k08sk0k08cg00ocsgco80ckog8s800kgwcckwss0',
                    'grant_type' => 'http://www.payever.de/api/payment',
                    'scope' => 'API_CREATE_PAYMENT',
                );

                break;


            default:
                throw new InvalidArgumentException("Unknown datasetName was passed: $datasetName");
        }
        return $returnedDataset;
    }

}

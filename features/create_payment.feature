Feature: Create payment

  Scenario: Send valid request to /api/payment and get valid response
    Given RestClient: authorize through /oauth/v2/token
    When  RestClient: send valid request to /api/payment
    Then  HTTP response error message should be empty
    And   Returned HTTP response should be valid JSON
    And   Returned HTTP response should match "valid_api_payment_response_json_schema" JSON schema


  @wip
  Scenario: Finish payment
    Given RestClient: authorize through /oauth/v2/token
    And   RestClient: send valid request to /api/payment
    When  Open 'redirect_url' into web browser
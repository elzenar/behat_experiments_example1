Feature: Authorization

  Scenario: Send valid request to '/oauth/v2/token' and get valid response
#    Given test step
    When RESTClient send valid request to /oauth/v2/token
    Then HTTP response error message should be empty
    And  Returned HTTP response should be valid JSON
    And  Returned HTTP response should match "valid_oauth_v2_token_response_json_schema" JSON schema

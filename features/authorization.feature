Feature: Authorization

  Scenario: Send valid request to '/oauth/v2/token' and get valid response
#    Given test step
    When RESTClient send valid request to /oauth/v2/token
    Then HTTP response error message should be empty
    And  Returned HTTP response should be valid JSON
    And  Returned HTTP response should contains JSON fields:
      | access_token  |
      | expires_in    |
      | token_type    |
      | scope         |
      | refresh_token |
    And  Specified JSON fields in returned HTTP response should not be empty:
      | access_token  |
      | expires_in    |
      | token_type    |
      | scope         |
      | refresh_token |

Feature: Authorization

  Scenario: Send valid request to '/oauth/v2/token' and get valid response
#    Given test step
    When RESTClient send request to /oauth/v2/token using "valid_request_to_oauth_v2_token" dataset
    Then HTTP response error message should be empty
    And  Returned HTTP response should be valid JSON
    And  Returned HTTP response should match "valid_oauth_v2_token_response_json_schema" JSON schema

#  Scenario: Send invalid request to '/oauth/v2/token': incorrect 'client_secret'
#    When RESTClient send request to /oauth/v2/token using "invalid_request_to_oauth_v2_token_with_incorrect_client_secret" dataset
#    Then HTTP response error message should be empty
#    And  Returned HTTP response should be valid JSON
#    And  Returned HTTP response should match "valid_oauth_v2_token_response_json_schema" JSON schema
#
#  Scenario: Send invalid request to '/oauth/v2/token': incorrect 'client_id'
#    When RESTClient send request to /oauth/v2/token using "invalid_request_to_oauth_v2_token_with_incorrect_client_id" dataset
#    Then HTTP response error message should be empty
#    And  Returned HTTP response should be valid JSON
#    And  Returned HTTP response should match "valid_oauth_v2_token_response_json_schema" JSON schema


  Scenario Outline: Send invalid request to '/oauth/v2/token': incorrect credentials
    When RESTClient send request to /oauth/v2/token using "<credentials_dataset>" dataset
    Then HTTP response error message should be empty
    And  Returned HTTP response should be valid JSON
    And  Returned HTTP response should match "<matching_json_schema>" JSON schema
  Examples:
    | credentials_dataset                                            | matching_json_schema                      |
    | invalid_request_to_oauth_v2_token_with_incorrect_client_id     | error_oauth_v2_token_response_invalid_client_json_schema |
    | invalid_request_to_oauth_v2_token_with_incorrect_client_secret | error_oauth_v2_token_response_invalid_client_json_schema |



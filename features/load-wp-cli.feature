Feature: Components of the WP-CLI commands

  Scenario: WP-CLI loads for your tests
    Given a WP install

    When I run `wp eval 'echo "Hello world.";'`
    Then STDOUT should contain:
      """
      Hello world.
      """

  Scenario: Get a list of plugins for specific author.
    Given a WP install

    When I run `wp plugins-api author miyauchi`
    Then STDOUT should contain:
      """
      WP Total Hacks
      """

    When I try `wp plugins-api author xxxxxxxxxxxxxxx`
    Then the return code should be 1
    And STDERR should be:
      """
      Error: The xxxxxxxxxxxxxxx's plugins could not be found.
      """

    When I run `wp plugins-api browse popular`
    Then STDOUT should contain:
      """
      akismet
      """

    When I try `wp plugins-api browse hoge`
    Then the return code should be 1
    And STDERR should be:
      """
      Error: The possible values are popular/new/updated/top-rated.
      """

    When I run `wp plugins-api info wp-total-hacks`
    Then STDOUT should contain:
      """
      wp-total-hacks
      """

    When I try `wp plugins-api info xxxxxxxxxxxxxxx`
    Then the return code should be 1
    And STDERR should be:
      """
      Error: The "xxxxxxxxxxxxxxx" could not be found.
      """

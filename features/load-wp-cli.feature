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
    When I run `wp plugins-api browse popular`
    Then STDOUT should contain:
      """
      Contact Form 7
      """

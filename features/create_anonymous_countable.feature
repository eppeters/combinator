Feature: Anonymous user can create a countable
				In order to start counting something
								As an anonymous API consumer
								I need to create a countable
	Scenario: I post a countable name to the countable creation endpoint
		Given I have a name for a quantity I want to count, a countable
		When I post the countable name
		Then I should be able to get that countable
			And I should see that the value is 0

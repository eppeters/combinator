Feature: Anonymous user can create a countable
				In order to start counting something
								As an anonymous API consumer
								I need to create a countable
	Scenario: I send a unique countable name to the countable creation endpoint
		Given I have a unique name for a quantity I want to count, a countable
		When I create the countable
		Then I should be able to get that countable
			And I should see that the value is 0

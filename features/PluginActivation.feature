Feature: Plugin Activation
	In order to plublicise the concert
	As an orchestra manager
	I need to be able to create a new concert
	
Scenario: The Plugin should be listed on the plugins page

Given the plugin is installed
When I visit the plugins admin page
Then the plugin should be listed

Scenario: The Plugin can be actived

Given the plugin is listed
And the plugin is not activated
When I press the activation link
Then the plugin is actived

Scenario: The Plugin can be dectivated

Given the plugin is listed
And the plugin is activated
When I press the deactivation link
Then the plugin is deactivated
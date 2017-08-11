Feature: Administration
	In order that the displayed concerts are accurate
	As a website administrator
	I need to be able to see the concert post button on the menu

@ignore
Scenario: Menu item is displayed

Given I visit the administration page
When I look at the menu
Then I can see the Concert menu item


Scenario: Logging in
Given I visit the login page
When I submit valid credentials
Then I should be taken to the dashboard page

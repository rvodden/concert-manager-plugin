Feature: Administration
	In order that the displayed concerts are accurate
	As a website administrator
	I need to be able to see the concert post button on the menu

Background:
	Given there are users:
     | user_login | user_pass |  user_email        | role          |
     | admin      | admin     |  admin@example.com | administrator |

Scenario: Logging in
Given I visit the login page
When I submit valid credentials
Then I should be taken to the dashboard page

Scenario: Menu item is displayed
Given I am logged in as an admin
When I go to the dashboard
Then I can see the Concert menu item


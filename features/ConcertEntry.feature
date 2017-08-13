@ignore
Feature: Concert Entry
	In order to plublicise the concert
	As an orchestra manager
	I need to be able to create a new concert

Scenario: Conert title has a sensible default.

Given the orchestra manager visits the concert entry page
When the date is set between January and April 2016
And no title has been specified
Then the title "2016-17: Spring Concert" is suggested.


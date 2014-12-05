@codedill_core
Feature: Store tasks page
  As a visitor
  I want to be able to see the tasks list

  Scenario: Viewing the tasks list
    Given I am on "/tasks"
    Then  I should see "Game"
    And   I should see "Crossword"

@codedill_core
Feature: Store homepage
  In order to access and browse the homepage
  As a visitor
  I want to be able to see the homepage

  Scenario: Viewing the homepage at website root
    Given I am on the homepage
    Then  I should be on the homepage
    And   I should see "Homepage"
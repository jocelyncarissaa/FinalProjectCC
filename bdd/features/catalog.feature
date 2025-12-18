Feature: User Catalog Browsing and Search
    As an authenticated user
    I want to browse and search items in the catalog
    So that I can find products easily

  Background:
    Given the application base url is set

  Scenario: User can view the catalog list
    Given there are items named "Paracetamol" and "Amoxicillin"
    When the user searches catalog at "/bdd/products" with keyword "Paracetamol"
    Then the search results should include "Paracetamol"

  Scenario: Search by name is case-insensitive
    Given there are items named "Paracetamol" and "Amoxicillin"
    When the user searches catalog at "/bdd/products" with keyword "paracetamol"
    Then the search results should include "Paracetamol"
    And the search results should not include "Amoxicillin"

  Scenario: Filter by category shows only items in that category
    Given there is an item named "Vitamin C" with category "Antiviral"
    And there is an item named "Ibuprofen" with category "Analgesic"
    When the user searches catalog at "/bdd/products" with keyword "Vitamin"
    And the user filters catalog at "/bdd/products" by category "Antiviral"
    Then the search results should include "Vitamin C"
    And the search results should not include "Ibuprofen"

  Scenario: Search returns empty message when no match
    Given there are items named "Paracetamol" and "Amoxicillin"
    When the user searches catalog at "/bdd/products" with keyword "zzzz"
    Then the search results should be empty
    And the catalog page should show "No products found matching your criteria."

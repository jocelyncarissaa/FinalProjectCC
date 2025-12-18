Feature: User Cart Management
  As an authenticated user
  I want to add and update items in my cart
  So that I can manage my shopping cart properly

  Background:
    Given the application base url is set

  Scenario: User can add a product to the cart
    Given there is an item named "Acetocillin" with category "Test"
    When the user adds "Acetocillin" to the cart with quantity 2
    Then the cart should contain "Acetocillin" with quantity 2

  Scenario: User can increase product quantity in the cart
    Given there is an item named "Acetocillin" with category "Test"
    And the cart contains "Acetocillin" with quantity 1
    When the user increases quantity of "Acetocillin" by 1
    Then the cart should contain "Acetocillin" with quantity 2

  Scenario: User can decrease product quantity in the cart
    Given there is an item named "Acetocillin" with category "Test"
    And the cart contains "Acetocillin" with quantity 2
    When the user decreases quantity of "Acetocillin" by 1
    Then the cart should contain "Acetocillin" with quantity 1

  Scenario: Product is removed when quantity becomes zero
    Given there is an item named "Acetocillin" with category "Test"
    And the cart contains "Acetocillin" with quantity 1
    When the user decreases quantity of "Acetocillin" by 1
    Then the cart should not contain "Acetocillin"

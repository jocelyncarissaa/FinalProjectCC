Feature: Authentication (Login & Logout)
    As a user of PharmaPlus
    I want to login and logout
    So that I can access protected pages based on my role

  Scenario: Admin can login and is redirected to admin dashboard
    Given I open the login page
    When I login with email "admin@pharmaplus.com" and password "password"
    Then I should be redirected to "/admin/dashboard"

  Scenario: Customer can login and is redirected to home
    Given I open the login page
    When I login with email "customer@gmail.com" and password "password"
    Then I should be redirected to "/home"

  Scenario: Login fails with wrong password
    Given I open the login page
    When I login with email "customer@gmail.com" and password "wrong-password"
    Then I should not be authenticated

  Scenario: User can logout and protected page becomes inaccessible
    Given I open the login page
    When I login with email "customer@gmail.com" and password "password"
    And I logout
    Then accessing "/home" should redirect to "/login"

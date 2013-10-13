@users
Feature: User groups management
    In order to manage customers
    As a store owner
    I want to be able to group them

    Background:
        Given I am logged in as administrator
          And there are following users:
            | email          | enabled | address                                                |
            | beth@foo.com   | no      | Klaus Schmitt, Heine-Straße 12, 99734, Berlin, Germany |
            | martha@foo.com | yes     | Lars Meine, Fun-Straße 1, 90032, Vienna, Austria       |
            | rick@foo.com   | no      | Klaus Schmitt, Heine-Straße 12, 99734, Berlin, Germany |
            | dale @foo.com  | yes     | Lars Meine, Fun-Straße 1, 90032, Vienna, Austria       |
          And there are following groups:
            | name                | roles          |
            | Wholesale Customers | ROLE_WHOLESALE |
            | Retail Customers    | ROLE_RETAIL    |
          And the following zones are defined:
            | name   | type    | members |
            | Poland | country | Poland  |

    Scenario: Seeing index of all groups
        Given I am on the dashboard page
         When I follow "Groups"
         Then I should be on the group index page
          And I should see 2 groups in the list

    Scenario: Accessing the group creation form
        Given I am on the group index page
          And I follow "Create group"
         Then I should be on the group creation page

    Scenario: Submitting empty form
        Given I am on the group creation page
         When I press "Create"
         Then I should still be on the group creation page
          And I should see "Please enter group name."

    Scenario: Creating group
        Given I am on the group creation page
         When I fill in the following:
            | Name  | Dealers                    |
            | Roles | ROLE_DEALERS, ROLE_MANAGER |
          And I press "Create"
         Then I should be on the group index page
          And I should see group "Dealers" in the list

    Scenario: Accessing the editing form from the list
        Given I am on the group index page
         When I click "edit" near "Retail Customers"
         Then I should be editing group with name "Retail Customers"

    Scenario: Updating the group
        Given I am editing group with name "Wholesale Customers"
         When I fill in "Name" with "Premium Customers"
          And I press "Save changes"
         Then I should be on group index page
          And "Group has been successfully updated." should appear on the page
          And "Premium Customers" should appear on the page
          But I should not see "Wholesale Customers"

    Scenario: Deleting group
        Given I am on the group index page
         When I click "delete" near "Wholesale Customers"
         Then I should still be on the group index page
          And I should see "Group has been successfully deleted."
          And I should not see group with name "Wholesale Customers" in that list

    Scenario: Deleting group from the list
        Given I am on the group index page
         When I click "delete" near "rick@foo.com"
         Then I should still be on the group index page
          And "group has been successfully deleted." should appear on the page
          But I should not see group with groupname "rick@foo.com" in that list

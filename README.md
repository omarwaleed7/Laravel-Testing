# Training Project for Testing

This project is a hands-on training initiative for applying best practices in automated testing and Test-Driven Development (TDD). It covers several aspects of testing in a Laravel application.

## Key Testing Aspects

-   **PHPUnit Setup:**  
    Tests are configured using [phpunit.xml](phpunit.xml).

-   **Test-Driven Development (TDD):**  
    This project follows TDD principles to drive application development.

-   **Laravel Testing:**  
    Feature tests extend the Laravel base class ([Tests\TestCase](tests/TestCase.php)) and utilize built-in testing helpers.

-   **Database Testing:**  
    Uses the `RefreshDatabase` trait to reset database state after each test.

-   **Factories and Models:**  
    Leverages model factories (e.g., for [`User`](app/Models/User.php) and [`Task`](app/Models/Task.php)) to quickly generate test data.

-   **Environment Configuration:**  
    Testing environment settings are defined in [phpunit.xml](phpunit.xml) and [`.env.testing`](.env.testing).

## Learning Outcomes

-   Practical experience in setting up and using PHPUnit.
-   Solid understanding of Laravel testing features including HTTP testing and database migrations.
-   Familiarity with factory-based model testing.

This project consolidates what was learned in testing and serves as a foundation for writing robust, automated tests in Laravel.

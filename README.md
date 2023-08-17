# Laravel-API-Dice-Game

Welcome to the Laravel API: Dice Game project! This project was undertaken as part of my training at IT Academy, where I had the opportunity to create a complete API with access control configured using tokens. The project involves creating a dice game API that enables users to play the game and manage player information.

## Project Overview

The Laravel API: Dice Game project includes the following features and tasks:

### Level 1

- **Dice Game Rules:** The dice game is played with two dice. If the sum of the results from both dice is 7, the player wins; otherwise, the player loses.
- **User Registration:** Players must be registered as users in the application with a unique email and an optional non-repeating nickname (defaulting to "Anónimo" if not provided).
- **Player Information:** Each player is assigned a unique identifier and a registration date upon registration.
- **Game History:** Players can view a list of all their dice rolls, along with the dice values and whether they won or lost the game.
- **Success Percentage:** Players can determine their success percentage based on all the dice rolls they've made.
- **Data Deletion:** Players can delete their entire game history.

### Administrator Access

- **Admin Dashboard:** The application's admin can view all players in the system and their success percentages.
- **Average Success Percentage:** The admin can also see the average success percentage of all players.
- **Role-Based Access:** The system implements role-based access control, allowing different levels of access to different routes.

### Testing

- **Test-Driven Development (TDD):** Unit and integration tests are created using TDD principles to thoroughly test each route.

## How to Use

To utilize the Dice Game API:

1. Clone or download this repository to your local machine.
2. Set up a local development environment with Laravel, PHP, and a web server.
3. Configure your database connection settings in the `.env` file.
4. Run migrations to create the necessary database structure: `php artisan migrate`.
5. Install and configure Laravel Passport for authentication: `php artisan passport:install`.
6. Run the API: `php artisan serve`.
7. Access the API endpoints using tools like Postman or a web browser.

Follow the API documentation to understand the available routes, request methods, and expected responses.

## Technologies Used

- Laravel: Backend framework used to create the API.
- Laravel Passport: Used for API authentication and token-based access control.
- PHPUnit: Utilized for writing and running tests.
- Other Laravel Ecosystem Packages: Leveraged for database interactions and role-based access control.

## Acknowledgements

This project was completed as part of the IT Academy training program, providing hands-on experience in building a robust API, implementing authentication, and role-based access control.

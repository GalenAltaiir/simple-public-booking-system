# Online Booking System

This repository is a simple public online booking system. It consists of a simple API with 2 routes (retrieve available appointments and booking an appointment). 

## Project Design

As it wasn't specified whether the system would require a login to book a meeting, I opted in for a simple and flexible approach that allows for public booking, but a user schema could be easily implemented if needed.

All data is stored within a MySQL database and the frontend is a simple blade replica that mirrors the MVC architecture. This was done so virtually any front-end can be adopted, including raw HTML. 

Security was very much omitted for this task. API keys are visible from the frontend, once again for flexibility reasons. In production a node server with a frontend framework, or a Laravel backend could provide security and a more robust system. 

Appointments are selectable per day, with each slot lasting 30 minutes. Slots can be booked between 8am and 5pm. The system includes a both a frontend and backend validation to ensure data integrity and consistency. Meetings can be booked up to 2 months in advance, with one booking per day. Bookings cannot be made retroactively or on weekends.

Note:* A further improvement can be made to allow only one booking per user UNTIL that meeting passes. But this would depend on client requirements.

## Requirements

The project uses AJAX for data exchange, with HTTP as the transport protocol and JSON as the data type. The database is MySQL compatible. The code is written in vanilla PHP, and it's compatible with PHP version 8.2+ and MySQL 8+.

## Setup

1. Clone the repository or extract the archive
2. Run `composer install` to install the dependencies
3. Copy `.env.example` to `.env` and fill in your database credentials
4. Run the SQL commands in the provided `.sql` file to set up the database

## API Endpoints

- `GET /api/available-times`: Retrieves all booked slots. Returns a JSON object with a record containing time and date (no other information is technically required at this point, but could be easily added it needed.)
- `POST /api/create-appointment`: Books an appointment, requires all form fields in order to be processed.
## Testing

Only basic QA using Postman was done to ensure the API was working as expected. Further testing could be done using PHPUnit or another testing framework to ensure the system is robust and reliable.

## Future Improvements

- Create user schema (depending on client requirements)
- Middleware to check if user is logged in*
- Middleware to check if the API key is valid
- (Dev only) "pose as" feature allowing to test multiple users while booking
- (Dev only) "reset" feature to clear the appointments table
- Improved validation and error handling in the API similar to how the frontend handles it with regex, but cleaner.

## Final Thoughts
Overall this was a fun project, having worked with Laravel for the past 2 years it's hard to think outside of MVC and Eloquent. I definitely wanted to be very ambitious with the project and I'm sure there are many improvements that could be made, but I'm happy with the result given the time constraints. I hope you enjoy it as much as I did creating it. Below I've included some basic documention on expanding the project.

## Expanding the Project

The index.php file handles all the setup from providing vendor packages to boostrapping the project. A few packages were used to make the project easier to work with, including:
FastRoutes - A simple and fast routing package, to add new routes simply add routes to web.php for web routes and api.php for API routes.

For example: $r->addRoute('GET', '/about', [AboutController::class, 'show']); 
Then create relevant controller and view files.

DotEnv: A simple package to handle serverside environment variables. To add new environment variables, add them to the .env file and access them using $_ENV('VARIABLE_NAME').
### Methods

#### Helpers.php

Helpers::View($view, $data = []) - Renders a view with data, usage identical to Laravel's view() method.
Helpers::response->json() - Returns a JSON response with the provided data.

#### Database.php

Very simple implementation of PDO to handle database connections. Queries can be added here to perform specific actions on the databse, but I would recommend creating a model for each table to handle the queries if this project were to be an ongoing one.

#### Appointments.php

Handles all the logic for the appointments, including validation and error handling. This could be expanded to include more complex logic, for example if Users were involved. The all() method will return all appointments, while currentBookings() will return all bookings.

#### Controllers
While perhaps unnecessary due to the simplicity of the overall project, staying in the theme of MVC they are set there to  handle requests and very basic logic - Although, with more time I would have migrated some of that logic towards it's own dedicated class such as a service class.


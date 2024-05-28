# Online Booking System

This project is a simple online booking system consisting of three (only two are used) API routines. The first one retrieves available slots for a selected date, and the second one books an appointment. The redundant routine lists all appointments but wasn't needed.

## Project Design

The project is designed with backend in focus, and should be implementable with any full-stack site that uses PHP. The frontend is a hacky blade engine that was created to replicate MVC architecture (displaying views, handling requests, and routing). The databse is very basic with only one table for appointments* but follows a normalized structure.

Appointments are selectable per day, with each slot lasting 30 minutes. Slots can be booked between 8am and 5pm. The system includes a number of frontend and backend checks to ensure data integrity and consistency. Meetings can be booked up to 2 months in advance, with one booking per day (again, probably shouldn't let users book another one prior to their next one, but I realised that way too late). Bookings cannot be made retroactively or on weekends.

Note:* The appointments table was built under the assumption it wouldn't be logged users but rather a public booking system. In hindsight, it would be better to have a user table and link the appointments to the user but due to time constraints I decided to stick with the initial decision. This could be easily amended by creating a user schema and linking the appointments to the user instead of email and phone.

## Requirements

The project uses modern AJAX for data exchange, with HTTP as the transport protocol and JSON as the data type. The database is MySQL compatible. The code is written in vanilla PHP, and it's compatible with PHP version 8.2+ and MySQL 8+.

## Setup

1. Clone the repository
2. Run `composer install` to install the dependencies
3. Copy `.env.example` to `.env` and fill in your database credentials
4. Run the SQL commands in the provided `.sql` file to set up the database

## API Endpoints

- `GET /api/available-times`: Retrieves all booked slots. Returns a JSON object with a record containing time and date (no other information is technically required at this point, but could be easily added it needed.)
- `POST /api/create-appointment`: Books an appointment, requires all form fields in order to be processed.
## Testing

Testing was not a requirement, and due to my lack of experience with PHP testing, I didn't have time to implement it.

## Future Improvements

- Create user schema
- Middleware to check if user is logged in
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

DotEnv: A simple package to handle environment variables. To add new environment variables, add them to the .env file and access them using $_ENV('VARIABLE_NAME').

DIY Blade: A very hacky and simple implementation of blade to handle views, with a few directives that never ended up being used (like @if, @foreach, etc). All views are located in public/views directory.

### Methods

#### Helpers.php

Helpers::View($view, $data = []) - Renders a view with data, usage identical to Laravel's view() method.
Helpers::response->json() - Returns a JSON response with the provided data, saves a bit of realestate when returning data.

#### Database.php

Very simple implementation of PDO to handle database connections. Queries can be added here to perform specific actions on the databse, but I would recommend creating a model for each table to handle the queries if this project were to be an ongoing one.

#### Appointments.php

Handles all the logic for the appointments, including validation and error handling. This could be expanded to include more complex logic, for example if Users were involved. The all() method will return all appointments, while currentBookings() will return all bookings.

#### Controllers
While perhaps unnecessary due to the simplicity of the overall project, staying in the theme of MVC they are set there to  handle requests and very basic logic - Although, with more time I would have migrated some of that logic towards it's own dedicated class such as a service class.


# Project Build and Setup Instructions
* Laravel Sail
* Laravel Livewire
* MySQL Database

## Getting Started
To set up the project, follow these steps:

1. Install Laravel Sail `composer require laravel/sail`.
2. `php artisan sail:install` - I selected MySQL as my preferred preference.
2. Once you've installed Sail, you can start the Sail environment with the following command in your terminal at your project's root directory:

`./vendor/bin/sail up`

3. Install Laravel Livewire `composer require livewire/livewire`.

# Database Setup

I personally have used MySQL for this build. Once setup and configured run the following:

`sail artisan migrate:fresh --seed`

This will migrate all files as if it were a clean database and then trigger the DatabaseSeeder accordingly.

I amended the intial Seeder to run via `$this->call` and moved the User creation logic into its own seeder.

## Testing

You can typically run all the tests by the following:

`sail artisan test` or `php artisan test`.

You can filter these tests down with the use of `--filter TestFileName` in this instance `--filter SalesCalculationsTest`

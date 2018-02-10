# Laravel auth-email

[![Latest Stable Version](https://poser.pugx.org/ntavelis/auth-email/v/stable)](https://packagist.org/packages/ntavelis/auth-email)
[![License](https://poser.pugx.org/ntavelis/auth-email/license)](https://packagist.org/packages/ntavelis/auth-email)


Auth-email provides out of the box email authentication for your Laravel >=5.4 application. It leverages the Laravel's functionality provided by the `make:auth` command, which runs for you and then proceeds to configure email authentication.
Which means that every user that registers to your application, will receive an email with an activate account button. He will have to click the activate account, in order to prove that he is the owner of the email and therefore activate his account.


## Installation

Via Composer

``` bash
$ composer require ntavelis/auth-email
```
Then add the service provider in `config/app.php`:

Note: Starting with Laravel 5.5 this package gets auto discovered so you can skip this step!
```php
'providers' => [
    Ntavelis\AuthEmail\AuthEmailServiceProvider::class,
];
```

Run your new command:

``` bash
$ php artisan auth:email
```
Finally run your migrations. Now you have email Authentication. Visit `/register` to register a new user via email.

Note: Make sure you configured your email settings properly.

## Options/Parameters

Auth-email provides the following options:

If you have already bootstrapped your application with `make:auth` before you discovered this package, then you can pass the `-o`, `--only` flag, to make auth-email skip running `make:auth` command.

``` bash
$ php artisan auth:email -o
```

Auth-email can run your migrations after setup, to keep installation process as minimum as possible. Pass it the `-m`, `--migrate` flag.

``` bash
$ php artisan auth:email -m
```
Note: Make sure you configured your database settings properly before running the command.

Auth-email can make your generated `app/mail/ActivateAccount.php` implement the ShouldQueue interface. Pass it the `-s`, `--queue` flag.

``` bash
$ php artisan auth:email -s
```
Note: Make sure you configured your queue driver properly.

You can also run the command with any number of flags.

``` bash
$ php artisan auth:email -o -m -s
```
## Migrations
After the initial installation, you need to run your migrations, auth-email added 2 migration files on your `database/migrations/` path.
Which provide 1 new table to store activation tokens and 1 new column in the user table, create_users_table migration is provided by default in laravel, we just add 1 column with the new migration to track the authenticated(Via email) users.

Alternatively as mentioned above pass it the `-m` flag to instantly run the migrations for you after setup.
``` bash
$ php artisan auth:email -m
```

## Email markup
To change the look of the activation email you send to the user, you have to modify the `resources/views/emails/auth.blade.php` blade file.

This file uses Laravel's 5.4 new feature markdown mailables, please refer to the Laravel documentation for details.
https://laravel.com/docs/5.4/mail#markdown-mailables

The mailable that is responsible for the markup (subject,sender etc) of the activation mail, is located in the `app/Mail/ActivateAccount.php`.

## Flash messages
Auth-email provides 2 flash messages out of the box.

The `authEmail.mailSend` message informs the user after registration to check their inbox and activate their account.

The `authEmail.confirm` message informs the user, who just tried to login without being authenticated, that they have to click the activate button on the email we sent them.

If you need to change these messages, you can do so from this file `resources/lang/en/authEmail.php`.

## Queue

The default behavior is not to implement the ShouldQueue interface, for simplicity on setup. But I strongly encourage you to use queues.

If you want your email to implement ShouldQueue interface, therefore to be queueable. You can pass it the `-s`, `--queue` flag.
Then your generated email in the `app/mail/ActivateAccount.php` would implement the ShouldQueue interface.

Alternatively you can manually make it implement ShouldQueue interface.

You can read more about queues on Laravel's documentation https://laravel.com/docs/5.4/queues.

## Validation

This package adds one more validation rule called `alpha_spaces`. It considers valid alphanumeric characters and spaces, and is used to validate the `name`, on the registration form.

You can find the displayed message in, `resources/lang/en/validation.php`, and if you are interested the validation logic is located in this package's ServiceProvider on the register method.

## Generated Files
List of all the generated files from the `auth:email` command:

| File                                            | Location                            | Functionality                                   |
| :---------------------------------------------: |-------------------------------------| ------------------------------------------------|
| LoginController.php                             | /app/Http/Controllers/Auth/         | Adds authenticated method                       |
| RegisterController.php                          | /app/Http/Controllers/Auth/         | Adds 4 new methods for email authentication     |
| login.blade.php                                 | /resources/views/auth/              | Adds flash message logic, to display alerts     |
| auth.blade.php                                  | /resources/views/emails/            | Activation email, with activation link          |
| Y_m_d_His_create_user_activations_table.php     | /database/migrations/               | Migration that creates table user_activations   |
| Y_m_d_His_add_boolean_column_to_users_table.php | /database/migrations/               | Adds column activated to users table            |
| authEmail.php                                   | /resources/lang/en/                 | The messages text exists in this file           |
| ActivateAccount.php                             | /app/Mail/                          | Mailable, sends the activation mail.            |

Also one more line is appended into your routes file `web.php`, which creates the activation route of your application.
The activation route looks like this `/user/activation/{token}`.

## Requirements

Requires PHP >= 5.6.*

Laravel Framework to be installed, with version >= 5.4

## Supported Laravel versions

This package supports all Laravel version from 5.4 onwards.

- From version 1.4.0, support has been added for Laravel 5.6.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email davelis89@gmail.com instead of using the issue tracker.

## Credits

- [Athanasios Ntavelis][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ntavelis/auth-email.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ntavelis/auth-email.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ntavelis/auth-email
[link-downloads]: https://packagist.org/packages/ntavelis/auth-email
[link-author]: https://github.com/ntavelis
[link-contributors]: ../../contributors

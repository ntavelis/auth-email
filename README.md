# Laravel 5.4 email-auth

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]


Auth-email provides out of the box email authentication for your Laravel 5.4 application. It leverages the Laravel's functionality provided by the make:auth command, which runs for you and then proceeds to configure email authentication.

## Install

Via Composer

``` bash
$ composer require ntavelis/auth-email
```
Then add the service provider in `config/app.php`:

```php
Ntavelis\AuthEmail\AuthEmailServiceProvider::class,
```

Run your new command:

``` bash
$ php artisan auth:email
```

## Options/Parameters

Auth-email provides the following options:

If you have already bootstrapped your application with `make:auth` before you discover this package, then you can pass the `-o`, `--only` flag, to make auth-email skip rerunning this command.

``` bash
$ php artisan auth:email -o
```

Auth-email can run your migrations after setup, to keep installation process as minimum as possible. Pass it the `-m`, `--migrate` flag.

``` bash
$ php artisan auth:email -m
```
Note: make sure you configured your database settings properly before running the command.

You can also run command with both flags.

``` bash
$ php artisan auth:email -o -m
```
## Email markup
To change the look of the activation email you sent to the user, you have to modify the `resources/views/emails/auth.blade.php` blade file.

This file uses Laravel's 5.4 new feature markdown mailables, please refer to the Laravel's documentation for details.
https://laravel.com/docs/5.4/mail#markdown-mailables

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
| authEmail.php                                   | /resources/lang/en/                 | The displays messages exist in this file        |

Also on more line is appended into you routes file `web.php`, which creates the activation route of your application.
The activation route looks like this `/user/activation/{token}`.


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

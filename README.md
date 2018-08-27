# SocialPlaces Server

Symfony 4 Contacts example app with RESTFUL API

## Features

1. User can add new contacts
2. Users can view contact list
3. API accepts new contact

## Getting Started

  1. `git clone https://github.com/adeadedoja/dami-social-places-server.git`
  2. `cd dami-social-places-server`
  3. `composer install`
  4. `php bin/console doctrine:migrations:migrate`
  5. `create a new database`
  5. `set up env variables`
  6. `php bin/console server:run`
  7. `npm install to install dependencies`
  8. `run 'gulp default'`

The above will get you a copy of the project up and running on your local machine for development and testing purposes.

## Dependencies

  1. [MYSQL]
  2. [PHP]
  3. [Gulp]

## API Endpoints


| EndPoint                                |   Functionality                      |
| --------------------------------------- | ------------------------------------:|
| POST /api/contact/store                 | Store a new contact                  |

## Responses

The API responds with JSON data by default.

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://opensource.org/licenses/MIT) file for details

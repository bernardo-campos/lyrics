# Lyrics App

I made this project because I wanted to make a website where I can store and show all the data (artists, albums and lyrics) scraped from another website.

<!--
## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Features](#features)
- [Contributing](#contributing)
- [Testing](#testing)
- [License](#license)
- [Authors and Acknowledgments](#authors-and-acknowledgments)
- [Contact Information](#contact-information)
- [Badges](#badges)
- [Changelog](#changelog)
- [FAQ](#faq)
-->

## Installation

You must have PHP >= 8.1 already installed

1. Clone the repository `git clone https://github.com/bernardo-campos/lyrics.git`
1. Copy the `.env.example` file to `.env`
1. Install dependencies `php composer.phar install`
1. Generate a key `php artisan key:generate`
1. Create a database and set the corresponding settings in the .env file
1. Run the migrations `php artisan migrate`
1. Run the app `php artisan serve`

(Optional):

* Create a link to storage path `php artisan storage:link`
* Insert dummy data `php artisan db:seed --class=MigrationSeeder`

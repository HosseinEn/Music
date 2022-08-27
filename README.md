<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Laravel Musics Website

Explore in musics website written in PHP using Laravel framework. Find artists, songs and albums you
like in this application which created by admins in admin panel. Admin panel with variaty of accessibility
on content produced. 

## Requirements

- PHP 7.3+
- Composer
- Git
- MYSQL 5.7+.
(Easy way) You may install XAMPP, AMPPS, WAMP or whatever you prefer in order to set up a MySQL database
which gives you access to phpmyadmin on windows and running this application. For Linux users, Install mysql-server database. (Godspeed!)

## Installation

1. Clone the repo and `cd` into it. (`git clone https://github.com/HosseinEn/Musics.git`)
4. `composer install` (you have to install and add composer to you system env path before running this command
5. Rename or copy `.env.example` file to `.env`
6. `php artisan key:generate`
7.  `php artisan storage:link` (Make sure you have storage directory in public folder or image and files won't show up!)
8. Set your database credentials in your `.env` file.
9. `php artisan migrate:fresh --seed`
10. `php artisan serve`
11. Visit `127.0.0.1:8000` in your browser.
12. Log in to admin panel using following credentials:
	<br/>`email: testing@admin.com`
	<br/>`password: 12345678`
13. (Optional) Set your mail service credentials in your `.env` file if you want to use application email sending services. (Recommended for local testing: https://mailtrap.io/)
14. (Optional) Change `QUEUE_CONNECTION=sync` in `.env` file to `database` if you want to use queueable mail service and run `php artisan migrate` to create jobs table.
15. (Optional) Change your `CACHE_DRIVER=file` to redis or other caching systems if you are into using other caching systems rather than your filesystem.


<br/>
<br/>

If you are interested in checking the auto publish scheduling system run:
<br/>
`php artisan schedule:work`
<br/>
https://laravel.com/docs/9.x/scheduling#running-the-scheduler-locally

<br/>
<br/>

And for using queue system run:
<br/>
`php artisan queue:work`
<br/>
https://laravel.com/docs/9.x/queues#running-the-queue-worker

## Features


- Private disk for unpublished song files for security purposes.

- Services for transferring between private and public disks by changing song status.

- Admin Panel with songs, artists, users, albums and tags management system with strong validation on forms, image and audio files and searchable tables.

- Using Caching method to enhance performance on Front page.

- Sending logs to admin email on changes if enabled in panel using Laravel Mailable, queue, event and listeners system.

- Automatic songs publishing on a specific date using Laravel job scheduling system.

- Using area chart for count of records in admin panel.

- Providing SEO-friendly, human-readable automatic name slugging  for  routing throughout the application (Persian and English supported).

- Sending emails as suggestions for admins by visitors.

- Providing user's favorite page for registered users to add or remove songs, albums, and artists.

- Using Laravel Eloquent relations (including polymorphics), observers and model events to handle related models on creating, updating and deleting.

- Providing songs download in 128 and 320 kbps.

- Recaptcha for login, register and contact us to prevent malicious activites. (Throttle middleware is used for login by default, I added this for song downloading too) 

## Demo Video (1.84MB)
https://user-images.githubusercontent.com/83599557/187021466-24046ce9-18e9-4efa-b3a7-a3b35c8117f5.mp4




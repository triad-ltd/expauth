[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/triad-ltd/expauth/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/triad-ltd/expauth/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/triad-ltd/expauth/badges/build.png?b=master)](https://scrutinizer-ci.com/g/triad-ltd/expauth/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/triad-ltd/expauth/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/triad-ltd/expauth/?branch=master) [![Packagist](https://img.shields.io/packagist/dt/triad-ltd/expauth.svg)](https://packagist.org/packages/triad-ltd/expauth) [![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](http://www.opensource.org/licenses/MIT)

#Laravel 5 Expression Engine User Authentication

Allows you to switch your Expression Engine website to Laravel, by handling the authentication of Expression Engine members. This package allows you to easily build a front end in Laravel for Expression Engine websites, without worrying about how existing members logins and registrations will work.

**For Laravel 5.2 support, please checkout the 5.2 branch.**

## What it does

Expression Engine uses a number of different hashing algorithms, such as SHA512, SHA256, SHA1 and even MD5 (*shudder*), whilst Laravel 5 uses the much more secure bcrypt.

This package will allow your existing Expression Engine members to log in with their existing login credentials, and new users can benefit from having their data hashed with the latest bcrypt algorithm.

Furthermore, once an Expression Engine user has logged in, it's very easy to switch them over to bcrypt encryption as the ```needsRehash()``` method will always return true for Expression Engine members.

## Installation

In your composer.json file, add:

```
    "require": {
       "triad-ltd/expauth": "1.1.*"
    }
```

Then, in config/app.php add

```
    'TriadLtd\ExpAuth\ExpressionEngineUserServiceProvider',
    'TriadLtd\ExpAuth\ExpressionEngineHasherServiceProvider',
```

and (optionally) comment out

```
    //'Illuminate\Hashing\HashServiceProvider',
```

In config/auth.php, change

```
    'driver' => 'eloquent',
```

to

```
    'driver' => 'ExpressionEngineAuth',
```

In your User model, make sure that you set the table and primary key fields as per the Expression Engine schema:

```
    protected $table = 'exp_members';
	protected $primaryKey = 'member_id';
```

and that's it!

## Usage

Authentication works in exactly the same way as Laravel's regular auth methods.

## Licence and credit

This package is open-sourced software licensed under the MIT license. Many thanks to the original package (pixelfusion/ExpAuth) upon which this was based, by PixelFusion.

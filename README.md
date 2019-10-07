# Fetchable behavior for CakePHP

[![Build Status](https://img.shields.io/travis/riesenia/cakephp-fetchable/master.svg?style=flat-square)](https://travis-ci.org/riesenia/cakephp-fetchable)
[![Latest Version](https://img.shields.io/packagist/v/riesenia/cakephp-fetchable.svg?style=flat-square)](https://packagist.org/packages/riesenia/cakephp-fetchable)
[![Total Downloads](https://img.shields.io/packagist/dt/riesenia/cakephp-fetchable.svg?style=flat-square)](https://packagist.org/packages/riesenia/cakephp-fetchable)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This plugin is for CakePHP 3.x and contains behavior that handles fetching entities
from cache / memory storage. Relevant for tables that contain moderate number of rows
and are used commonly in many parts of application.

## Installation

Using composer

```
composer require riesenia/cakephp-fetchable
```

## Usage

This behavior is suitable for tables that contain moderate number of rows
and are used commonly in many parts of application. Fetchable checks if they are
already cached and also stores them in memory using `Configure` class. This lowers
the number of database queries for them.

```php
class StatusesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Fetchable.Fetchable', [
            // can use custom finder
            'finder' => 'active',
            // cache config
            'cache' => 'statuses_cache',
            // can contain another data
            'contain' => ['StatusProperties'],
            // if i.e. status name is translatable
            'key' => function ($name) {
                return $name . '-' . I18n::getLocale();
            }
        ]);
    }
}

// fetch all active statuses
$this->Statuses->fetch();
```

## Configuration options:

* *finder* - finder to use to get entities. Defaults to "all".
* *cache* - cache config to use. Defaults to "default".
* *contain* - set related entities that will be fetched.
* *key* - key used for *Cache* and *Configure* calls. Can be set to callable (i.e. for *I18n* dependend data).

# Doctrine tools

[![Author](https://img.shields.io/badge/author-@RemiSan-blue.svg?style=flat-square)](https://twitter.com/RemiSan)
[![Build Status](https://img.shields.io/travis/remi-san/doctrine-tools/master.svg?style=flat-square)](https://travis-ci.org/remi-san/doctrine-tools)
[![Quality Score](https://img.shields.io/scrutinizer/g/remi-san/doctrine-tools.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/doctrine-tools)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/remi-san/doctrine-tools.svg?style=flat-square)](https://packagist.org/packages/remi-san/doctrine-tools)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/remi-san/doctrine-tools.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/doctrine-tools/code-structure)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/569d91a5-bd6e-4ee7-b47e-ed619406c35c/small.png)](https://insight.sensiolabs.com/projects/569d91a5-bd6e-4ee7-b47e-ed619406c35c)


Providing easy-to-use tools for doctrine.

Content
-------

This lib provides the following util classes:
 - `EntityManagerBuilder` an entity manager builder providing an easy way to add **Doctrine** types
   to the `EntityManager`, you can also call methods on the type using a callable formatted array.
   It has been designed to be compatible with **Symfony DI** config files.
 - `Psr3SqlLogger` is a **Doctrine** logger encapsulating a **PSR3** logger.


Usage example
------------

**EntityManagerBuilder**

```php
$builder = new EntityManagerBuilder($connection, $config);
$builder->addType('customName', CustomType::class, [ [ 'callTypeMethod', []] ]);
$entityManager = $builder->buildEntityManager();
```

**Psr3SqlLogger**

```php
$logger = new Psr3SqlLogger($psr3Logger, LogLevel::INFO);
```

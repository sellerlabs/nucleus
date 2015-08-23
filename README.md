# Nucleus [![Build Status](https://travis-ci.org/etcinit/nucleus.svg?branch=master)](https://travis-ci.org/etcinit/nucleus) ![](https://img.shields.io/packagist/v/chromabits/nucleus.svg) [![](https://img.shields.io/badge/ApiGen-reference-blue.svg)](http://etcinit.github.io/nucleus)

A standalone PHP utility library. Inspired heavily by similar projects like libphutil. Currently used in personal and work projects. Designed to make working wth PHP a little bit nicer and predictable.

Requires HHVM 3.6 or PHP 5.6

## Core pieces

While Nucleus has a bunch of random crap in it, there are some useful classes worth mentioning:

- **Spec**: Strict and extensible validation. A multi-purpose validation framework that can be easily extended.
- **Impersonator**: A constructor dependency automocker. Useful for testing classes that have many external dependencies and projects that heavily use container dependency injection.
- **View**: An set of classes and utilities for generating clean and safe HTML/Text. It sort of looks like XHP without the XML or de-sugarized React.js code.
- **Std, Arr, and others**: We all know the PHP standard library is a mess. I've created a few classes with a bunch of static aliases that attempt to improve upon it. Yes, there is a performance penalty (validation + at least one more function call), but it makes many operations more predictable and safer.

## Contributing

Pull Request are accepted on GitHub.
Code Standard: PSR-2 with some additions. See https://github.com/etcinit/php-coding-standard for more details

## License

This code is licensed under the MIT license. See LICENCE for more information.

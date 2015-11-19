# PHP Custom end-of-line CSV class

[![Travis Build Status](https://travis-ci.org/chrismou/php-eol-csv.svg)](https://travis-ci.org/chrismou/php-eol-csv)
[![Test Coverage](https://codeclimate.com/github/chrismou/php-eol-csv/badges/coverage.svg)](https://codeclimate.com/github/chrismou/php-eol-csv/coverage)
[![Code Climate](https://codeclimate.com/github/chrismou/php-eol-csv/badges/gpa.svg)](https://codeclimate.com/github/chrismou/php-eol-csv)

# About

This exists for one specific purpose - to provide a class for creating CSV files in PHP, while also allowing you to set a custom end-of-line character.

fputcsv allows you to specify a field delimiter, but strangely doesn't let you set the EOL character - which, when it insists on \n,
isn't always helpful when the files are destined for Windows based systems.

## Install

To install via [Composer](http://getcomposer.org/):

```
composer require chrismou/php-eol-csv
```

## Usage

Instantiate the class:

```
$csv = new \Chrismou\PhpEolCsv\Csv;
```

Open a CSV file for editing:

```
$csv->open($fileName, $savePath, $eol, $delimiter, $enclosure);
```

- **$filename** (required) - the filename to use.
- **$savePath** - The path to save the file. Leaving this blank will save directly to the output buffer for a direct download.
- **$eol** - The EOL character/string to use. Defaults to \n.
- **$delimiter** - The character/string to use as a separator between fields.
- **enclosure** - The character to use to enclose multi-word strings, or strings that include the delimiter character.

Write a row to the CSV:

```
$csv->write(array("Field1", "Field2", "Field3"));
```

Finish editing and close the file:

```
$csv->close();
```

## Supported versions

PHP 5.3 upwards, including HHVM.

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

A [DUnit](https://github.com/Vectorface/dunit) config file is also included, allowing you to easily run tests on all supported PHP versions.

First, you need to have docker installed. This is fairly simple on Linux - on OSX, take a look at [docker machine](https://docs.docker.com/machine/).

Assuming you have composer setup (see above), run the tests with the following command:

```
./vendor/bin/dunit
```

## License

Released under the MIT License. See [LICENSE.md](LICENSE.md).
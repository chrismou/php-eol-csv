## Archived
When I wrote this it did exactly what I needed it to do, but with the number of great 3rd party packages available now it's not really needed anymore. If you want full control of your CSVs, check out the excellent [phpleague/csv](https://csv.thephpleague.com/)

# PHP Custom end-of-line CSV class

[![Travis Build Status](https://travis-ci.org/chrismou/php-eol-csv.svg)](https://travis-ci.org/chrismou/php-eol-csv)
[![Test Coverage](https://codeclimate.com/github/chrismou/php-eol-csv/badges/coverage.svg)](https://codeclimate.com/github/chrismou/php-eol-csv/coverage)
[![Code Climate](https://codeclimate.com/github/chrismou/php-eol-csv/badges/gpa.svg)](https://codeclimate.com/github/chrismou/php-eol-csv)
[![Buy me a beer](https://img.shields.io/badge/donate-PayPal-019CDE.svg)](https://www.paypal.me/chrismou)

## About

This class provides the flexibility of creating CSV files in PHP with a custom end-of-line character.

PHP's `fputcsv` function allows you to specify a field delimiter, but strangely doesn't let you set the EOL character - which, when it insists on `\n`,
isn't always helpful when the files are destined for people to view/edit on a Windows based systems.

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
$csv->open($fileName, $savePath, $eol, $fileExtension, $delimiter, $enclosure);
```

- **$fileName** (required) - the filename to use. Don't include the file extension, this can be set seperately.
- **$savePath** - The path to save the file. Leaving this blank will save directly to the output buffer for a direct download.
- **$eol** - The EOL character/string to use. Defaults to `\n`.
- **$fileExtension** - The file extension to use. Defaults to `csv`.
- **$delimiter** - The character/string to use as a separator between fields. Defaults to `,`.
- **enclosure** - The character to use to enclose multi-word strings, or strings that include the delimiter character. Defaults to `"`.

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

First, you need to have docker installed. This is fairly simple on Linux - on OSX and Windows, take a look at [docker machine](https://docs.docker.com/machine/).

Assuming you have composer setup (see above), run the tests with the following command:

```
./vendor/bin/dunit
```

## License

Released under the MIT License. See [LICENSE.md](LICENSE.md).

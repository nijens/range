# Range

[![Latest version on Packagist][ico-version]][link-version]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![SensioLabsInsight][ico-insight]][link-insight]
[![StyleCI][ico-code-style]][link-code-style]

Ruby range syntax parser for PHP.

## Installation using Composer
Run the following command to add the package to the composer.json of your project:

``` bash
$ composer require nijens/range
```

## Usage
Parsing a range in Ruby syntax:
``` php
<?php

use Nijens\Range\Range;

$range = Range::parse('0..1');

echo $range->getFrom(); // Output: 0
echo $range->getTo(); // Output: 1
```

Converting a Range instance to Ruby range syntax:
``` php
<?php

use Nijens\Range\Range;

$range = new Range(0, 1, false);

echo $range; // Output: 0..1
```


[ico-version]: https://img.shields.io/packagist/v/nijens/range.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-build]: https://travis-ci.org/nijens/range.svg?branch=master
[ico-coverage]: https://coveralls.io/repos/nijens/range/badge.svg?branch=master
[ico-insight]: https://img.shields.io/sensiolabs/i/9bf0a15d-ecbb-4e1f-b70e-46fa79ade72c.svg
[ico-code-style]: https://styleci.io/repos/68444850/shield?style=flat

[link-version]: https://packagist.org/packages/nijens/range
[link-build]: https://travis-ci.org/nijens/range
[link-coverage]: https://coveralls.io/r/nijens/range?branch=master
[link-insight]: https://insight.sensiolabs.com/projects/9bf0a15d-ecbb-4e1f-b70e-46fa79ade72c
[link-code-style]: https://styleci.io/repos/68444850

[![Build Status](https://travis-ci.org/77web/Japanese.Holiday.svg?branch=master)](https://travis-ci.org/77web/Japanese.Holiday)

# Japanese.Holiday

calculates holidays in Japan.

## Installation

```bash
composer install japanese-holiday/japanese-holiday
```

## Usage

### Get list of holidays for a year

```php
<?php
use Japanese\Holiday\Repository as HolidayRepository;

$holidayRepository = new HolidayRepository();
$holidays = $holidayRepository->getHolidaysForYear(2017);
$holidays['2017-01-01']->getDate(); // equals new \DateTime('2016-01-01')
$holidays['2017-01-01']->getName(); // "元旦"

```

### Check whether a date is a holiday or not

```php
<?php
use Japanese\Holiday\Repository as HolidayRepository;

$holidayRepository = new HolidayRepository();
$holidayRepository->isHoliday('2017-01-01'); // true
$holidayRepository->isHoliday('2017-01-04'); // false
```


## Build new yml for a specific year

```bash
php scripts/newyear.php XXXX
```

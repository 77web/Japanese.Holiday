<?php

use Japanese\Holiday\Repository as HolidayRepository;
use Japanese\Holiday\Entity\Holiday;
use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

if (empty($argv[1])) {
    die('"year" is required.');
}

$year = $argv[1];
$configPath = sprintf(__DIR__.'/../src/Resources/config/%s.yml', $year);

if (file_exists($configPath)) {
    die('yml file already exists!');
}

$repository = new HolidayRepository();
$holidays = $repository->getHolidaysForYear($year);

$yaml = Yaml::dump(array_map(function (Holiday $holiday) {
    return [
        'caption' => $holiday->getName(),
        'month' => $holiday->getDate()->format('n'),
        'date' => $holiday->getDate()->format('j'),
    ];
}, $holidays));

file_put_contents($configPath, $yaml);

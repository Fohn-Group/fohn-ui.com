<?php

declare(strict_types=1);

// to use MySQL database:
// Simply call Data::setDb() with an Sql persistence.
// Data::setDb(new Sql('mysql:dbname=fohn;host=mysql;charset=utf8', 'root', 'root'));

use Atk4\Data\Persistence\Sql;

return [
    'env' => \Fohn\Ui\Service\Ui::PROD_ENV,
    'css' => '/public/fohn-ui.com.min.css',
    'timezone' => 'America/Toronto',
    'csfrSecret' => 'my csfr secret',
    'locale' => 'en_CA',
    'format' => [
        'currency_code' => 'CAD',
        'currency' => '$',
        'date' => 'M d, Y',
        'time' => 'H:i',
        'datetime' => 'M d, Y H:i:s',
    ],
];

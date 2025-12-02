<?php
/**
 * This file is part of riesenia/cakephp-fetchable package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */
declare(strict_types=1);

namespace Fetchable\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class StatusesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];

    public $records = [
        ['id' => 1, 'name' => 'First status'],
        ['id' => 2, 'name' => 'Second status']
    ];
}

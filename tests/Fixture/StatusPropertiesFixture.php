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

class StatusPropertiesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'status_id' => ['type' => 'integer', 'null' => true],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];

    public $records = [
        ['id' => 1, 'status_id' => 1, 'name' => 'First property'],
        ['id' => 2, 'status_id' => 1, 'name' => 'Second property']
    ];
}

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
    public $records = [
        [
            'id' => 1,
            'name' => 'First status'
        ],
        [
            'id' => 2,
            'name' => 'Second status'
        ]
    ];

    public function getTableSchema()
    {
        $schema = new \Cake\Database\Schema\TableSchema('statuses');
        $schema->addColumn('id', [
            'type' => 'integer',
            'null' => false,
        ])
        ->addColumn('name', [
            'type' => 'string',
            'length' => 255,
            'null' => true,
        ])
        ->addConstraint('primary', [
            'type' => 'primary',
            'columns' => ['id']
        ]);

        return $schema;
    }
}

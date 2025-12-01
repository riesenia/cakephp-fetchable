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
    public $records = [
        [
            'id' => 1,
            'status_id' => 1,
            'name' => 'First property'
        ],
        [
            'id' => 2,
            'status_id' => 1,
            'name' => 'Second property'
        ]
    ];

    public function getTableSchema()
    {
        $schema = new \Cake\Database\Schema\TableSchema('status_properties');
        $schema->addColumn('id', [
            'type' => 'integer',
            'null' => false,
        ])
        ->addColumn('status_id', [
            'type' => 'integer',
            'null' => true,
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

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
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'First status'
            ],
            [
                'id' => 2,
                'name' => 'Second status'
            ]
        ];
        parent::init();
    }

    protected function _buildSchema($schema)
    {
        return $schema->addColumn('id', [
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
    }
}

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

/**
 * I18nFixture.
 */
class I18nFixture extends TestFixture
{
    /**
     * Table name.
     *
     * @var string
     */
    public $table = 'i18n';

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'locale' => 'sk_SK',
                'model' => 'Statuses',
                'foreign_key' => 1,
                'field' => 'name',
                'content' => 'First status - sk'
            ],
            [
                'id' => 2,
                'locale' => 'sk_SK',
                'model' => 'StatusProperties',
                'foreign_key' => 1,
                'field' => 'name',
                'content' => 'Property 1 - sk'
            ],
        ];
        parent::init();
    }

    protected function _buildSchema($schema)
    {
        return $schema->addColumn('id', [
            'type' => 'integer',
            'null' => false,
            'autoIncrement' => true,
        ])
        ->addColumn('locale', [
            'type' => 'string',
            'length' => 6,
            'null' => false,
        ])
        ->addColumn('model', [
            'type' => 'string',
            'length' => 255,
            'null' => false,
        ])
        ->addColumn('foreign_key', [
            'type' => 'integer',
            'null' => false,
        ])
        ->addColumn('field', [
            'type' => 'string',
            'length' => 255,
            'null' => false,
        ])
        ->addColumn('content', [
            'type' => 'text',
            'null' => true,
        ])
        ->addConstraint('primary', [
            'type' => 'primary',
            'columns' => ['id']
        ])
        ->addConstraint('locale', [
            'type' => 'unique',
            'columns' => ['locale', 'model', 'foreign_key', 'field']
        ])
        ->addIndex('model', [
            'type' => 'index',
            'columns' => ['model', 'foreign_key', 'field']
        ]);
    }
}

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

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'autoIncrement' => true],
        'locale' => ['type' => 'string', 'length' => 6, 'null' => false],
        'model' => ['type' => 'string', 'length' => 255, 'null' => false],
        'foreign_key' => ['type' => 'integer', 'null' => false],
        'field' => ['type' => 'string', 'length' => 255, 'null' => false],
        'content' => ['type' => 'text', 'null' => true],
        '_indexes' => [
            'model' => ['type' => 'index', 'columns' => ['model', 'foreign_key', 'field']]
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'locale' => ['type' => 'unique', 'columns' => ['locale', 'model', 'foreign_key', 'field']]
        ]
    ];

    public $records = [
        ['id' => 1, 'locale' => 'sk_SK', 'model' => 'Statuses', 'foreign_key' => 1, 'field' => 'name', 'content' => 'First status - sk'],
        ['id' => 2, 'locale' => 'sk_SK', 'model' => 'StatusProperties', 'foreign_key' => 1, 'field' => 'name', 'content' => 'Property 1 - sk']
    ];
}

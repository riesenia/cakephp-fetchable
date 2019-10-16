<?php
/**
 * This file is part of riesenia/cakephp-fetchable package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace TestApp\Model\Table;

use Cake\I18n\I18n;
use Cake\ORM\Table;

class StatusesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Translate', ['fields' => ['name']]);
        $this->addBehavior('Fetchable.Fetchable', [
            'fields' => ['name'],
            'contain' => ['StatusProperties'],
            'key' => function ($name) {
                return $name . '-' . I18n::getLocale();
            }
        ]);

        $this->hasMany('StatusProperties', [
            'className' => 'TestApp\Model\Table\StatusPropertiesTable'
        ]);
    }
}

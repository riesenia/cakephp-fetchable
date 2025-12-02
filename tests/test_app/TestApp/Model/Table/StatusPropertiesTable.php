<?php
/**
 * This file is part of riesenia/cakephp-fetchable package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */
declare(strict_types=1);

namespace TestApp\Model\Table;

use Cake\ORM\Table;

class StatusPropertiesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('Translate', [
            'fields' => ['name']
        ]);
    }
}

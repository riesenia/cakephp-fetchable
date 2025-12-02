<?php
/**
 * This file is part of riesenia/cakephp-fetchable package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */
declare(strict_types=1);

namespace Fetchable\Model\Behavior;

use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Behavior;

class FetchableBehavior extends Behavior
{
    /**
     * @var array<string,mixed>
     */
    protected $_defaultConfig = [
        'finder' => 'all',
        'cache' => 'default',
        'contain' => [],
        'key' => null
    ];

    /**
     * @var array<string,array<int|string,mixed>>
     */
    private $_cache;

    public function initialize(array $config): void
    {
        // key is set automatically
        if (!isset($config['key'])) {
            $config['key'] = 'Fetchable.' . $this->_table->getAlias();
        }

        $this->setConfig('key', $config['key']);
    }

    /**
     * Fetch data.
     *
     * @return array<int|string,mixed>
     */
    public function fetch(): array
    {
        $key = $this->getConfig('key');

        if (\is_callable($key)) {
            $key = $key($this->_table->getAlias());
        }

        if (isset($this->_cache[$key])) {
            return $this->_cache[$key];
        }

        if (!($data = Cache::read($key, $this->getConfig('cache')))) {
            $data = [];

            $find = $this->_table->find($this->getConfig('finder'));

            if ($this->getConfig('contain')) {
                $find->contain($this->getConfig('contain'));
            }

            foreach ($find as $entity) {
                $data[$this->_getPrimaryValue($entity)] = $entity->toArray();
            }

            Cache::write($key, $data, $this->getConfig('cache'));
        }

        $this->_cache[$key] = $data;

        return $data;
    }

    /**
     * Fetch entity.
     *
     * @param int|string $id
     */
    public function fetchEntity($id): EntityInterface
    {
        $record = $this->fetch()[$id] ?? null;

        if ($record === null) {
            throw new RecordNotFoundException('Record not found');
        }

        return $this->_table->newEntity($record, ['validate' => false]);
    }

    /**
     * Get primary key value for entity.
     *
     * @return int|string
     */
    protected function _getPrimaryValue(EntityInterface $entity)
    {
        if (\is_array($this->_table->getPrimaryKey())) {
            return \implode('-', \array_map(function ($f) use ($entity) {
                return (string) $entity->get($f);
            }, $this->_table->getPrimaryKey()));
        }

        $primary = $entity->get($this->_table->getPrimaryKey());

        if (!is_int($primary) && !is_string($primary)) {
            throw new \RuntimeException('Primary key value is not a string or integer');
        }

        return $primary;
    }
}

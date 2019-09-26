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
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Behavior;

class FetchableBehavior extends Behavior
{
    /** @var array */
    protected $_defaultConfig = [
        'finder' => 'all',
        'cache' => 'default',
        'contain' => [],
        'key' => null
    ];

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        // key is set automatically
        if (!isset($config['key'])) {
            $config['key'] = 'Fetchable.' . $this->_table->getAlias();
        }

        // key can be callable
        if (\is_callable($config['key'])) {
            $config['key'] = $config['key']($this->_table->getAlias());
        }

        $this->setConfig('key', $config['key']);
    }

    /**
     * Fetch data.
     *
     * @return array
     */
    public function fetch(): array
    {
        if (Configure::check($this->getConfig('key'))) {
            return Configure::read($this->getConfig('key'));
        }

        if (($data = Cache::read($this->getConfig('key'), $this->getConfig('cache'))) === false) {
            $data = [];

            $find = $this->_table->find($this->getConfig('finder'));

            if ($this->getConfig('contain')) {
                $find->contain($this->getConfig('contain'));
            }

            foreach ($find as $entity) {
                $data[$this->_getPrimaryValue($entity)] = $entity->toArray();
            }

            Cache::write($this->getConfig('key'), $data, $this->getConfig('cache'));
        }

        Configure::write($this->getConfig('key'), $data);

        return $data;
    }

    /**
     * Fetch entity.
     *
     * @param int|string $id
     *
     * @return EntityInterface
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
     * @param EntityInterface $entity
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

        return $entity->get($this->_table->getPrimaryKey());
    }
}

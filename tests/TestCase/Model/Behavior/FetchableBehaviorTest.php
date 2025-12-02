<?php
/**
 * This file is part of riesenia/cakephp-fetchable package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */
declare(strict_types=1);

namespace Fetchable\Test\TestCase\Model\Behavior;

use Cake\Cache\Cache;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * FetchableBehavior Test Case.
 */
class FetchableBehaviorTest extends TestCase
{
    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Fetchable.Statuses',
        'plugin.Fetchable.StatusProperties',
        'plugin.Fetchable.I18n'
    ];

    /**
     * @var \TestApp\Model\Table\StatusesTable
     */
    protected $Statuses;

    /**
     * Test fetch.
     */
    public function testFetch()
    {
        $statuses = $this->Statuses->fetch();

        $this->assertEquals(2, \count($statuses));
        $this->assertEquals('First status', $statuses[1]['name']);
        $this->assertEquals('Second status', $statuses[2]['name']);

        // assert no additional queries are executed
        $this->Statuses->deleteAll(['id >' => 0]);

        $statuses = $this->Statuses->fetch();

        $this->assertEquals(2, \count($statuses));

        // assert no other cache hits are executed
        Cache::clearAll();

        $statuses = $this->Statuses->fetch();

        $this->assertEquals(2, \count($statuses));
    }

    /**
     * Test entity fetch.
     */
    public function testEntityFetch()
    {
        $status = $this->Statuses->fetchEntity(1);

        $this->assertEquals('First status', $status->get('name'));
        $this->assertEquals('First property', $status->status_properties[0]->get('name'));
    }

    /**
     * Test i18n dependent fetch calls.
     */
    public function testI18nFetch()
    {
        $statuses = $this->Statuses->fetch();

        $this->assertEquals('First status', $statuses[1]['name']);
        $this->assertEquals('First property', $statuses[1]['status_properties'][0]['name']);

        I18n::setLocale('sk_SK');

        $statuses = $this->Statuses->fetch();

        $this->assertEquals('First status - sk', $statuses[1]['name']);
        $this->assertEquals('Property 1 - sk', $statuses[1]['status_properties'][0]['name']);
    }

    /**
     * setUpBeforeClass method - Create fixture tables.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $connection = \Cake\Datasource\ConnectionManager::get('test');

        // Create fixture tables
        $fixtures = [
            new \Fetchable\Test\Fixture\StatusesFixture(),
            new \Fetchable\Test\Fixture\StatusPropertiesFixture(),
            new \Fetchable\Test\Fixture\I18nFixture()
        ];

        foreach ($fixtures as $fixture) {
            $fixture->create($connection);
        }
    }

    /**
     * setUp method.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Statuses = TableRegistry::getTableLocator()->get('Statuses', [
            'className' => 'TestApp\Model\Table\StatusesTable'
        ]);
    }

    /**
     * tearDown method.
     */
    public function tearDown(): void
    {
        unset($this->Statuses);

        parent::tearDown();
    }
}

<?php

namespace Hyn\MultiTenant\Tests;

use Hyn\Framework\Testing\TestCase;
use Hyn\MultiTenant\Models\Hostname;
use Hyn\MultiTenant\Models\Tenant;
use Hyn\MultiTenant\Models\Website;

/**
 * Class TenantModeltest.
 *
 * @coversDefaultClass \Hyn\MultiTenant\Models\Tenant
 */
class TenantModelTest extends TestCase
{
    /**
     * @return Tenant
     * @coversNothing
     */
    public function testCreate()
    {
        $tenant = new Tenant();
        $tenant->name = 'example';
        $tenant->email = 'foo@baz.com';

        return $tenant;
    }

    /**
     * Tests hostnames.
     *
     * @param Tenant $tenant
     * @depends testCreate
     * @covers ::hostnames
     */
    public function testHostnames($tenant)
    {
        $this->assertEquals(0, $tenant->hostnames->count());

        $this->assertEquals(new Hostname(), $tenant->hostnames()->getRelated()->newInstance([]));
    }

    /**
     * Tests websites.
     *
     * @param Tenant $tenant
     * @depends testCreate
     * @covers ::websites
     */
    public function testWebsites($tenant)
    {
        $this->assertEquals(0, $tenant->websites->count());

        $this->assertEquals(new Website(), $tenant->websites()->getRelated()->newInstance([]));
    }

    /**
     * @param Tenant $tenant
     * @depends testCreate
     * @covers ::reseller
     * @covers ::referer
     * @covers ::refered
     * @covers ::reselled
     */
    public function testRelatedTenants($tenant)
    {
        $this->assertEquals(0, $tenant->reselled->count());
        $this->assertNull($tenant->reseller);

        $this->assertEquals(0, $tenant->refered->count());
        $this->assertNull($tenant->referer);
    }

    /**
     * @param Tenant $tenant
     * @depends testCreate
     * @covers \Hyn\MultiTenant\Presenters\TenantPresenter
     */
    public function testPresenter($tenant)
    {
        $this->assertEquals($tenant->name, $tenant->present()->name);
        $this->assertNotNull($tenant->present()->icon);
    }
}

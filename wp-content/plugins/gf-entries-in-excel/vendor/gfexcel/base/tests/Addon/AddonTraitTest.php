<?php

namespace GFExcel\Tests\Addon;

use GFExcel\Addon\AddonInterface;
use GFExcel\Addon\AddonTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test case for {@see AddonTrait}.
 * @since $ver$
 */
class AddonTraitTest extends TestCase
{
    /**
     * Test case for {@see AddonTrait::set_instance()} and {@see AddonTrait::get_instance()}.
     * @since $ver$
     */
    public function testSetInstance(): void
    {
        $addon = new ConcreteAddon();
        ConcreteAddon::set_instance($addon);

        self::assertSame($addon, $addon::get_instance());
    }

    /**
     * Test case for {@see AddonTrait::set_instance()} with the wrong instance type.
     * @since $ver$
     */
    public function testSetInstanceWithException(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException(sprintf(
            'Add-on instance must be of type "%s"',
            ConcreteAddon::class
        )));

        ConcreteAddon::set_instance($this->createMock(AddonInterface::class));
    }
}

// Helper class to test the trait.
class ConcreteAddon implements AddonInterface
{
    use AddonTrait;
}
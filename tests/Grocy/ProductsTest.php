<?php
/**
 * Tests for Products class
 */

namespace Tests\Grocy;

use \App\Grocy\Products;

/**
 * Products test
 */
class ProductsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \App\Grocy\Products
     */
    protected $products;

    /**
     * Set the test up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->products = new Products(['grocyToken' => null]);
    }
    /**
     * Test nothing
     *
     * @return void
     */
    public function testNothing(): void
    {
        self::assertInstanceOf(
            \Jshannon63\JsonCollect\JsonCollect::class,
            $this->products->getItems()
        );
    }
}

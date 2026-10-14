<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\AbTestService;
use PHPUnit\Framework\TestCase;

class AbTestServiceTest extends TestCase
{
    protected function setUp(): void
    {
        // Limpa cookies antes de cada teste
        $_COOKIE = [];
    }

    public function testGetTitleForVariantA(): void
    {
        $service = new AbTestService();
        $title = $service->getTitleForVariant('A');
        $this->assertStringContainsString('organizados', $title);
        $this->assertNotEmpty($title);
    }

    public function testGetTitleForVariantB(): void
    {
        $service = new AbTestService();
        $title = $service->getTitleForVariant('B');
        $this->assertStringContainsString('perdidas', $title);
        $this->assertNotEmpty($title);
    }

    public function testVariantATitleDiffersFromVariantB(): void
    {
        $service  = new AbTestService();
        $titleA   = $service->getTitleForVariant('A');
        $titleB   = $service->getTitleForVariant('B');
        $this->assertNotEquals($titleA, $titleB);
    }

    public function testUnknownVariantFallsBackToA(): void
    {
        $service  = new AbTestService();
        $titleA   = $service->getTitleForVariant('A');
        $titleUnk = $service->getTitleForVariant('X');
        $this->assertEquals($titleA, $titleUnk);
    }

    public function testGetVariantReturnsCookieVariantA(): void
    {
        $_COOKIE['devflow_ab'] = 'A';
        $service  = new AbTestService();
        $variant  = $service->getVariant();
        $this->assertEquals('A', $variant);
    }

    public function testGetVariantReturnsCookieVariantB(): void
    {
        $_COOKIE['devflow_ab'] = 'B';
        $service  = new AbTestService();
        $variant  = $service->getVariant();
        $this->assertEquals('B', $variant);
    }

    public function testGetVariantIgnoresInvalidCookie(): void
    {
        $_COOKIE['devflow_ab'] = 'Z';
        $service = new AbTestService();
        $variant = $service->getVariant();
        $this->assertContains($variant, ['A', 'B']);
    }

    public function testGetVariantWithoutCookieReturnsAorB(): void
    {
        $service = new AbTestService();
        $variant = $service->getVariant();
        $this->assertContains($variant, ['A', 'B']);
    }
}

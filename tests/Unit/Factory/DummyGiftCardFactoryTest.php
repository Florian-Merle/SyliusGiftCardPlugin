<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusGiftCardPlugin\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusGiftCardPlugin\Factory\DummyGiftCardFactory;
use Setono\SyliusGiftCardPlugin\Factory\GiftCardFactoryInterface;
use Setono\SyliusGiftCardPlugin\Model\GiftCard;
use Sylius\Component\Currency\Context\CurrencyContextInterface;

final class DummyGiftCardFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_creates_dummy_gift_card(): void
    {
        $decoratedFactory = $this->prophesize(GiftCardFactoryInterface::class);
        $currencyContext = $this->prophesize(CurrencyContextInterface::class);

        $giftCard = new GiftCard();
        $decoratedFactory->createNew()->willReturn($giftCard);
        $currencyContext->getCurrencyCode()->willReturn('USD');

        $factory = new DummyGiftCardFactory($decoratedFactory->reveal(), $currencyContext->reveal());
        $returnedGiftCard = $factory->createNew();
        $this->assertEquals(1500, $returnedGiftCard->getAmount());
        $this->assertEquals('USD', $returnedGiftCard->getCurrencyCode());
    }
}

<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Components\CounterComponent;
use App\Core\Component\ComponentSigner;

final class ComponentTest extends TestCase
{
    public function testCounterComponentIncrementAction(): void
    {
        $component = new CounterComponent();
        $component->mount(['start' => 2]);
        $component->call('increment', []);
        self::assertSame(3, $component->state()['count']);
    }

    public function testComponentSignerVerification(): void
    {
        $signer = new ComponentSigner('secret');
        $payload = '{"state":{"count":1}}';
        $sig = $signer->sign($payload);
        self::assertTrue($signer->verify($payload, $sig));
        self::assertFalse($signer->verify($payload, 'bad-signature'));
    }
}

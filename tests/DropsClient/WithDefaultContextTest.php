<?php declare(strict_types=1);

namespace Vantoozz\Drops\UnitTests\DropsClient;

use PHPUnit\Framework\TestCase;
use Vantoozz\Drops\Drop;
use Vantoozz\Drops\DropsClient\DropsClientInterface;
use Vantoozz\Drops\DropsClient\WithDefaultContext;

/**
 * Class WithDefaultContextTest
 * @package Vantoozz\Drops\UnitTests\DropsClient
 */
final class WithDefaultContextTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_adds_context()
    {
        $drop = new Drop('some_tag', ['a' => 1], new \DateTimeImmutable);

        $dropsClient = $this->makeDummyDropsClient();

        (new WithDefaultContext($dropsClient, ['b' => 2]))->drop($drop);

        /** @var Drop $dropped */
        $dropped = $dropsClient->dropped;
        $context = $dropped->printWith(function (string $tag, array $context, \DateTimeImmutable $date) {
            return json_encode($context);
        });

        $this->assertSame($context, json_encode(['a'=>1, 'b'=>2]));
    }

    /**
     * @return DropsClientInterface
     */
    private function makeDummyDropsClient(): DropsClientInterface
    {

        return new class implements DropsClientInterface
        {

            /**
             * @var Drop
             */
            public $dropped;

            /**
             * @param Drop $drop
             */
            public function drop(Drop $drop): void
            {
                $this->dropped = $drop;
            }
        };
    }
}
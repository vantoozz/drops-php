<?php declare(strict_types=1);

namespace Vantoozz\Drops\DropsClient;

use Vantoozz\Drops\Drop;

/**
 * Class DefaultContext
 * @package Vantoozz\Drops\DropsClient
 */
final class WithDefaultContext implements DropsClientInterface
{
    /**
     * @var DropsClientInterface
     */
    private $dropsClient;

    /**
     * @var array
     */
    private $defaultContext;

    /**
     * DefaultContext constructor.
     * @param DropsClientInterface $dropsClient
     * @param array $defaultContext
     */
    public function __construct(DropsClientInterface $dropsClient, array $defaultContext)
    {
        $this->dropsClient = $dropsClient;
        $this->defaultContext = $defaultContext;
    }

    /**
     * @param Drop $drop
     * @throws \Vantoozz\Drops\Exceptions\ContextTransformException
     */
    public function drop(Drop $drop): void
    {
        $drop->transformContextWith(function (array $context) {
            return $context + $this->defaultContext;
        });

        $this->dropsClient->drop($drop);
    }
}

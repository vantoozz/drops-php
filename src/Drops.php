<?php declare(strict_types=1);

namespace Vantoozz\Drops;

use Vantoozz\Drops\DropsClient\DropsClientInterface;

/**
 * Class Drops
 * @package Vantoozz\Drops
 */
final class Drops
{
    /**
     * @var DropsClientInterface
     */
    private static $dropsClient;

    /**
     * @param Drop $drop
     */
    public static function drop(Drop $drop): void
    {
        if (!static::$dropsClient instanceof DropsClientInterface) {
            return;
        }

        static::$dropsClient->drop($drop);
    }

    /**
     * @param DropsClientInterface $dropsClient
     */
    public static function setDropsClient(DropsClientInterface $dropsClient): void
    {
        static::$dropsClient = $dropsClient;
    }
}

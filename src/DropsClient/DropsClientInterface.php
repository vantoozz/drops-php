<?php declare(strict_types = 1);

namespace Vantoozz\Drops\DropsClient;

use Vantoozz\Drops\Drop;

/**
 * Interface DropsClientInterface
 * @package Vantoozz\Drops\DropsClient
 */
interface DropsClientInterface
{
    /**
     * @param Drop $drop
     */
    public function drop(Drop $drop): void;
}

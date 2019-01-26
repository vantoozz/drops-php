<?php declare(strict_types=1);

namespace Vantoozz\Drops\DropsClient;

use Vantoozz\Drops\Drop;

/**
 * Class PrinterDropsClient
 * @package Vantoozz\Drops\DropsClient
 */
final class PrinterDropsClient implements DropsClientInterface
{

    /**
     * @var callable
     */
    private $printer;

    /**
     * PrinterDropsClient constructor.
     * @param callable $printer
     */
    public function __construct(callable $printer)
    {
        $this->printer = $printer;
    }

    /**
     * @param Drop $drop
     */
    public function drop(Drop $drop): void
    {
        $drop->printWith($this->printer);
    }
}

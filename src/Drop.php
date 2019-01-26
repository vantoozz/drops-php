<?php declare(strict_types=1);

namespace Vantoozz\Drops;

/**
 * Class Drop
 * @package Vantoozz\Drops
 */
final class Drop
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var array
     */
    private $context;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * Drop constructor.
     * @param string $tag
     * @param array $context
     * @param \DateTimeImmutable $date
     */
    public function __construct(string $tag, array $context, \DateTimeImmutable $date)
    {
        $this->tag = $tag;
        $this->context = $context;
        $this->date = $date;
    }

    /**
     * @param callable $printer
     * @return string
     */
    public function printWith(callable $printer): string
    {
        return (string)$printer($this->tag, $this->context, $this->date);
    }

    /**
     * @param array $context
     */
    public function mergeContextWith(array $context): void
    {
        $this->context += $context;
    }
}

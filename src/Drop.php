<?php declare(strict_types=1);

namespace Vantoozz\Drops;

use Vantoozz\Drops\Exceptions\ContextTransformException;

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
     * @param callable $callback
     * @throws ContextTransformException
     */
    public function transformContextWith(callable $callback): void
    {
        $transformed = $callback($this->context);

        if (!is_array($transformed)) {
            throw new ContextTransformException('Context transformation result is not array');
        }

        $this->context = $transformed;
    }
}

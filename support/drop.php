<?php declare(strict_types=1);

namespace Vantoozz\Drops;

/**
 * @param string $tag
 * @param array ...$arguments
 * @return void
 */
function drop(string $tag, ...$arguments): void
{
    try {
        $date = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    } catch (\Exception $e) {
        return;
    }

    foreach ($arguments as $argument) {

        if (is_array($argument)) {
            $context = $argument;
        }

        if ($argument instanceof \DateTime) {
            $date = \DateTimeImmutable::createFromMutable($argument);
        }

        if ($argument instanceof \DateTimeImmutable) {
            $date = $argument;
        }
    }

    Drops::drop(new Drop($tag, $context ?? [], $date));
}
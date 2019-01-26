<?php declare(strict_types=1);

namespace Vantoozz\Drops\DropsClient;

use Vantoozz\Drops\Drop;

/**
 * Class UdpDropsClient
 * @package Vantoozz\Drops\DropsClient
 */
final class UdpDropsClient implements DropsClientInterface
{
    /**
     * @var string
     */
    private $socketPath;

    /**
     * UdpDropsClient constructor.
     * @param string $socketPath
     */
    public function __construct(string $socketPath)
    {
        $this->socketPath = $socketPath;
    }

    /**
     * @param Drop $drop
     */
    public function drop(Drop $drop): void
    {
        try {
            $socket = stream_socket_client($this->socketPath);
        } catch (\Throwable $e) {
            return;
        }
        if (!$socket) {
            return;
        }

        fwrite($socket, $drop->printWith(function (string $tag, array $context, \DateTimeImmutable $date) {
            $data = ['tag' => $tag, 'date' => $date->format(\DateTime::ATOM)];
            if (!empty($context)) {
                $data['context'] = $context;
            }
            return json_encode($data);
        }));

        fclose($socket);
    }
}

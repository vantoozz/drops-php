<?php declare(strict_types=1);

namespace Vantoozz\Drops\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Vantoozz\Drops\Drops;
use Vantoozz\Drops\DropsClient\DropsClientInterface;
use Vantoozz\Drops\DropsClient\PrinterDropsClient;
use Vantoozz\Drops\DropsClient\UdpDropsClient;
use Vantoozz\Drops\DropsClient\WithDefaultContext;

/**
 * Class LaravelServiceProvider
 * @package Vantoozz\Drops\ServiceProviders
 * @property \Illuminate\Foundation\Application $app
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->app->singleton(DropsClientInterface::class, function () {

            $dropsClient = $this->makeDropsClient();

            $dropsClient = new WithDefaultContext($dropsClient, $this->makeDefaultContext());

            return $dropsClient;
        });


        Drops::setDropsClient($this->app->make(DropsClientInterface::class));
    }

    /**
     * @return array
     */
    private function makeDefaultContext(): array
    {
        $defaultContext = json_decode(env('DROPS_DEFAULT_CONTEXT', '[]'), true);

        return $defaultContext + [
                'host' => gethostname(),
            ];
    }

    /**
     * @return DropsClientInterface
     */
    private function makeDropsClient(): DropsClientInterface
    {
        if ('udp' === env('DROPS_TRANSPORT')) {
            return new UdpDropsClient(env('DROPS_UDP_SOCKET', ''));
        }

        /** @var OutputInterface $output */
        $output = $this->app->make(OutputInterface::class);
        return new PrinterDropsClient(
            function (string $tag, array $context, \DateTimeImmutable $date) use ($output) {
                $output->writeln(
                    $tag . ' -> ' .
                    json_encode($context) . '-> ' .
                    $date->format('Y-m-d H:i:s')
                );
            }
        );
    }
}

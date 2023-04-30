<?php

namespace NotificationChannels;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\Channels\MessengerChannel;
use NotificationChannels\Channels\NotifyChannel;
use NotificationChannels\Channels\SmartSenderChannel;
use NotificationChannels\Http\Client;
use NotificationChannels\Models\NotifyService\Notice;
use NotificationChannels\Services\NotifyService;

class NotificationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * All the container singletons that should be registered.
     */
    public array $singletons = [
        'messenger' => MessengerChannel::class,
        'smart-sender' => SmartSenderChannel::class,
        'notify' => NotifyChannel::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/notification-channels.php', 'notification-channels');

        $this->publishes([
            __DIR__.'/../config/notification-channels.php' => config_path('notification-channels.php'),
        ]);

        Notification::resolved(function (ChannelManager $service) {
            foreach (array_keys($this->singletons) as $driver) {
                $service->extend($driver, function (Application $app) use ($driver) {
                    $config = $app['config']['notification-channels'][$driver];

                    return $app->make($driver, [
                        'client' => $app->make(Client::class, compact('config')),
                    ]);
                });
            }
        });

        $this->app->bind('notify.client', function (Application $app) {
            $config = $app['config']['notification-channels']['notify'];

            return $app->make(Client::class, compact('config'));
        });

        $this->app->bind(NotifyService::class, function (Application $app) {
            return new NotifyService($app->make('notify.client'), new Collection);
        });

        $this->app->when(Notice::class)
            ->needs('$profileUuid')
            ->giveConfig('notification-channels.notify.profileUuid');
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [ChannelManager::class];
    }
}

Notification channels
=============================
![PHP 8.x](https://img.shields.io/badge/PHP-%5E8.0-blue)
[![Laravel 8.x](https://img.shields.io/badge/Laravel-8.x-orange.svg)](http://laravel.com)
[![Yii 2.x](https://img.shields.io/badge/Yii-2.x-orange)](https://www.yiiframework.com/doc/guide/2.0/ru)
![Latest Stable Version](https://poser.pugx.org/businessprocess/notify-service/v/stable)
![Release date](https://img.shields.io/github/release-date/businessprocess/notify-service)
![Release Version](https://img.shields.io/github/v/release/businessprocess/notify-service)
![Total Downloads](https://poser.pugx.org/businessprocess/notify-service/downloads)
![Pull requests](https://img.shields.io/bitbucket/pr/businessprocess/notify-service)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=plastic-square)](LICENSE)
![Stars](https://img.shields.io/github/stars/businessprocess/notify-service?style=social)

Notification messenger channel to Laravel FrameWork v6.0 and above.

## Installation
The recommended way to install channel is through
[Composer](http://getcomposer.org).

```bash
composer require businessprocess/notify-service
```


## Usage <a name="usege-channels"></a>

```php
    Notify::getDeliveryProfiles() - Get all delivery profiles
    Notify::notifications() - get all notification
```

```php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MyNotification extends Notification implements ShouldQueue
{    
   public function via($notifiable): array
    {
        return ['notify'];
    }

    public function toNotify($notifiable)
    {    
        $notice = \NotificationChannels\Models\NotifyService\Notice::create('profileUuid');
        
        $notice->setLangCode(app()->getLocale())
            ->setTimeToDelivery(now()->addHour())
            ->setText('Welcome to hell')
            ->options()
            ->email(
            'Hello email',
            'From admin'
        );
            
        $notice->destination()
            ->email($notifiable->email)
            ->viber($notifiable->phone);    
            
        $notice->responseCallback(function (?array $response){
            // can be processed response from notify service
            if(! is_null($response)){
                echo data_get($response, 'id');
            }
        })
        
        return $notice;     
    }
}
```

```php

    // Notice object can be obtained from the container with the addition of the profileUuid from the configuration
    
    public function toNotify($notifiable, \NotificationChannels\Models\NotifyService\Notice $notice)
    {
        return $notice->fill('ArrayOfParams');
    }
}
```

```php
    //call
    $user->notify(new MyNotification());
    
    //or multiply users
    
    Notification::send($users, new MyNotification());

```

#### Available Options

| Option         | Description               | Default value | 
|----------------|---------------------------|---------------|
| url            | API url (required)        | null          |
| login          | Login (required)          | null          |
| password       | Password (required)       | null          |
| profileUuid    | Uuid of delivery profile  | null          |

#### Params Heroku/BptPaymentsBot/SmartSender
- [Swagger](https://dev.mail-service.me/api-docs/#/Delivery%20profile/DeliveryProfileCreateDeliveryProfile)

| Option         | Description                          | Default value | 
|----------------|--------------------------------------|---------------|
| profileUuid    | Uuid of delivery profile (required)  | null          |
| langCode       | Notify template locale (required)    | null          |
| emitter        | Group by string key                  | null          |
| destination    | Recipient channel keys (required)    | null,object   |
| data           | Template data (required if no text)  | null,object   |
| text           | Message text (required if no data)   | null          |
| options        | Options                              | null,object   |
| key            | Group by key                         | null          |
| timeToDelivery | Time to delivery                     | null          |


```php
   public function via($notifiable): array
    {
        return ['messenger'];
    }

    public function toMessenger($notifiable): string
    {
        return 'Text of body';
    }
```

#### Available Options

| Option         | Description                             | Default value                           | 
|----------------|-----------------------------------------|-----------------------------------------|
| authentication | Your API key (required)                 | null                                    |
| url            | API url (required)                      | null                                    |
| project_id     | Project iD (required)                   | null                                    |
| messenger      | List of messengers (required)           | viber                                   |
| sendAll        | Send to all messenger in list           | false                                   |
| callback_url   | Callback url to response from messenger | null                                    |
| user_phone     | User phone                              | null                                    |


```php
   public function via($notifiable): array
    {
        return ['smart-sender'];
    }

    public function toSmartSender($notifiable): AbstractSender
    {
        return new BptPaymentsBot::task(         
            'ArrayOfParams'       
        );
    }
```

#### Available Options

| Option | Description        | Default value    | 
|--------|--------------------|------------------|
| url    | API url (required) | null             |

#### Params Heroku/BptPaymentsBot/SmartSender
- [Swagger](https://bpt-payments-dev-bot.ooo.ua/swagger-route#/refill-task/RefillTaskController_create)  

| Option     | Description                             | Default value       | 
|------------|-----------------------------------------|---------------------|
| requestID  | Your request ID (required)              | null                |
| date       | Date by format Y-m-d H:i:s (required)   | null                |
| type       | Request type (required)                 | null                |
| notes      | Comment (required)                      | null                |
| user       | User name (required)                    | null                |
| author     | Author name (required)                  | null                |
| amount     | Amount (required)                       | null                |
| applyUrl   | Callback approve url  (required)        | null                |
| declineUrl | Callback cancel url  (required)         | null                |

## Usage Laravel <a name="laravel"></a>

```php
    $user = User::find(1);
    Notification::send($user, new EmailNotification)
```

## Usage YII2 <a name="yii2"></a>
 ```php
[
    'modules' => [
        'notifications' => [
            'class' => 'NotificationChannels\yii\Module',
                'channels' => [
                    'notify' => [
                        'class' => 'NotificationChannels\yii\Channels\NotifyChannel',
                        'url' => $params['notifyService']['url'],
                        'login' => $params['notifyService']['login'],
                        'password' => $params['notifyService']['password'],
                    ],            
                ],
            ],
        ],
    ],
]
 ```

 ```php
namespace app\notifications;

use NotificationChannels\yii\Notification;
use NotificationChannels\Models\NotifyService\Notice;

class EmailNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['notify'];
    } 
    
    public function toNotify($notifiable)
    {
        return Notice::create(
         'ArrayOfParams' 
        );
    }
}
 ```

 ```php
    $user = User::findOne(1);
    
    EmailNotification::create()->sendTo($user);
    // (new EmailNotification())->sendTo($user);
 ```
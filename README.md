Notification channels
=============================

![Latest Stable Version](https://poser.pugx.org/businessprocess/notify-service/v/stable)
![Total Downloads](https://poser.pugx.org/businessprocess/notify-service/downloads)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Notification messenger channel to Laravel FrameWork v6.0 and above.

## Installation
The recommended way to install channel is through
[Composer](http://getcomposer.org).

```bash
composer require businessprocess/notify-service
```


## Usage <a name="usege-channels"></a>

```php

   public function via($notifiable): array
    {
        return ['notify'];
    }

    public function toNotify($notifiable, \NotificationChannels\Models\NotifyService\Notice $notice)
    {
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
        
        return $notice;
        //return \NotificationChannels\Models\NotifyService\Notice::create('ArrayOfParams');
    }
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
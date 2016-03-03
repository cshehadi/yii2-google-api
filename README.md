# Google Api Component for Yii2
--------------------------------

[![Latest Stable Version](https://poser.pugx.org/gillbeits/yii2-google-api/v/stable.svg)](https://packagist.org/packages/gillbeits/yii2-google-api) 
[![Total Downloads](https://poser.pugx.org/gillbeits/yii2-google-api/downloads.svg)](https://packagist.org/packages/gillbeits/yii2-google-api) 
[![Latest Unstable Version](https://poser.pugx.org/gillbeits/yii2-google-api/v/unstable.svg)](https://packagist.org/packages/gillbeits/yii2-google-api) 
[![License](https://poser.pugx.org/gillbeits/yii2-google-api/license.svg)](https://packagist.org/packages/gillbeits/yii2-google-api)

Installation
-------------

The preferred way to install this component is through [composer](http://getcomposer.org/download/).

```
php composer.phar require --prefer-dist gillbeits/yii2-google-api
```

###Configuration
----------------

in your app and/or console configuration file, add

```php
'components' => [
    // Google Api Configuration
    'google-api'   => [
        'class'             => 'gillbeits\Yii2GoogleApi\GoogleApi',
        'credentials' => '@common/config/google-api-server-key.json',
        'services' => [
            'analytics' => [
                'class' => '\Google_Service_Analytics',
                'scopes' => ['https://www.googleapis.com/auth/analytics.readonly']
            ],
            ...
        ]
    ],
    ...
],
```

Usage
-----

```php

// Get Sessions by user gender dimension
$data = \Yii::$app->{'google-api'}
        ->analytics
            ->data_ga
                ->get(
                    "ga:<AnalyticsViewID>", 
                    "2015-01-01", 
                    "today", 
                    "ga:sessions", 
                    [
                       "dimensions" => "ga:userGender"
                    ]
                )
;

```

Widgets
-------

For usage widgets in Yii2 install yiisoft/yii2-bootstrap library:

```php
php composer.phar require yiisoft/yii2-bootstrap
```

* Google Analytics widget usage

    ```php
    <?= gillbeits\Yii2GoogleApi\Widgets\AnalyticsGAData::widget([
        'viewId' => <AnalyticsViewID>,
        'startDate' => '2015-01-01',
        'endDate' => 'today',
        'metrics' => 'ga:sessions',
        'dimensions' => 'ga:userGender',
        'templateFile' => '//analytics/widgets/AnalyticsGenderGA'
    ])?>
    ```
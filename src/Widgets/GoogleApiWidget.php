<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 16.02.16
 * Time: 14:03
 */

namespace gillbeits\Yii2GoogleApi\Widgets;


use gillbeits\Yii2GoogleApi\GoogleApi;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;

class GoogleApiWidget extends Widget
{
    protected $widgetId;

    public function __construct(array $config = [])
    {
        $this->widgetId = "wid-id-" . crc32(serialize($config));
        parent::__construct($config);
    }

    /**
     * @return GoogleApi
     */
    public function getGoogleApi()
    {
        return \Yii::$app->{'google-api'};
    }

    /**
     * @param $serviceClass
     * @return \Google_Service|mixed|null
     * @throws InvalidConfigException
     */
    protected function getService($serviceClass)
    {
        $serviceInstance = null;

        foreach ($this->getGoogleApi()->services as $serviceName => $service) {
            if ($service["class"] === $serviceClass) {
                $serviceInstance = $this->getGoogleApi()->{$serviceName};
            }
        }

        if (empty($analytics) || !is_subclass_of($analytics, $serviceClass)) {
            throw new InvalidConfigException("No config for {$serviceClass} service");
        }

        return $serviceInstance;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 16.02.16
 * Time: 14:03
 */

namespace Yii2GoogleApi\Widgets;


use Yii2GoogleApi\GoogleApi;
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
}

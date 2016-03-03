<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 16.02.16
 * Time: 14:02
 */

namespace gillbeits\Yii2GoogleApi\Widgets;


class AnalyticsGAData extends GoogleApiWidget
{
    /** @var  integer */
    public $viewId;
    /** @var  string */
    public $metrics;
    /** @var  string */
    public $dimensions;
    /** @var  string|\DateTime */
    public $startDate;
    /** @var  string|\DateTime */
    public $endDate;
    /** @var  string */
    public $templateFile;

    public function init()
    {
        parent::init();
        $this->startDate = $this->startDate instanceof \DateTime ? $this->startDate : date_create($this->startDate);
        $this->endDate = $this->endDate instanceof \DateTime ? $this->endDate : date_create($this->endDate);
    }

    public function run()
    {
        try {
            $ga_data = $this->getGoogleApi()->analytics->data_ga->get("ga:" . $this->viewId, $this->startDate->format("Y-m-d"), $this->endDate->format("Y-m-d"), $this->metrics, [
                'dimensions' => $this->dimensions
            ]);
            echo $this->render($this->templateFile, [
                'ga_data' => $ga_data,
                'widgetId' => $this->widgetId
            ]);
        } catch (\Exception $e) {
            \Yii::$app->getSession()->setFlash('error', $e->getMessage());
        }
    }
}

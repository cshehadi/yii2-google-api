<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 19.02.16
 * Time: 16:54
 */

namespace Yii2GoogleApi;


use yii\base\Component;
use yii\base\InvalidConfigException;

class GoogleApi extends Component
{
    /** @var string  */
    public $name = 'Google Api Application';
    /** @var  string */
    public $credentials;
    /** @var array  */
    public $services = [];

    /** @var \Google_Client  */
    protected $client;
    /** @var  array|\Google_Service[] */
    protected $serviceInstances;


    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!isset($this->credentials)) {
            throw new InvalidConfigException("Не указан файл с данными для авторизации");
        }

        $this->credentials = \Yii::getAlias($this->credentials);
        if (!file_exists($this->credentials)) {
            throw new InvalidConfigException("Файл {$this->credentials} не найден");
        }
    }

    protected function getClient()
    {
        if (null === $this->client) {

            $this->client = new \Google_Client();
            $this->client->setAuthConfig($this->credentials);
            $this->client->setApplicationName($this->name);

            foreach ($this->services as $serviceName => $service) {
                if (!isset($service['class'])) {
                    throw new InvalidConfigException("Не указан класс сервиса {$serviceName}");
                }

                $service['scopes'] = (array)$service['scopes'];
                if (empty($service['scopes'])) {
                    throw new InvalidConfigException("Не указан область доступа сервиса {$serviceName}");
                }

                $this->client->addScope($service["scopes"]);
            }

            $scopes = $this->client->getScopes();

            if (empty($scopes)) {
                throw new InvalidConfigException("Не указаны области доступа для приложения {$this->name}");
            }
        }

        return $this->client;
    }

    /**
     * @param $name
     * @return \Google_Service|mixed
     */
    function __get($name)
    {
        if (!isset($this->services[$name])) {
            return parent::__get($name);
        }

        if (null === $this->serviceInstances[$name]) {
            /** @var \Google_Service $serviceClass */
            $serviceClass = $this->services[$name]["class"];
            $this->serviceInstances[$name] = new $serviceClass($this->getClient());
        }

        return $this->serviceInstances[$name];
    }
}

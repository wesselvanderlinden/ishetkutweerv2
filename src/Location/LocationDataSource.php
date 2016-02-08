<?php

namespace Location;

use Interfaces\DataFactory;
use Interfaces\DataSource;
use Interfaces\HttpClient;

class LocationDataSource implements DataSource
{
    private $dataFactory;
    private $httpClient;
    private $baseUrl;

    public function __construct(DataFactory $dataFactory, HttpClient $httpClient, $baseUrl)
    {
        $this->dataFactory = $dataFactory;
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    public function getData($ip = null)
    {
        if (is_null($ip)) {
            throw new \LogicException('No ip provided for LocationDataSource');
        }
        $query = http_build_query(['ip' => $ip]);
        $url = $this->baseUrl . '?' . $query;

        $data = unserialize($this->httpClient->getData($url));

        return $this->dataFactory->createDataBlock($data);
    }
}
 
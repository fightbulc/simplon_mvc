<?php

namespace Simplon\Mvc\App\Views\Rest;

use Simplon\Mvc\App\Data\SampleData;
use Simplon\Mvc\Core\Views\RestView;

/**
 * Class SampleRestView
 * @package Simplon\Mvc\App\Views\Rest
 */
class SampleRestView extends RestView
{
    /**
     * @return SampleData
     */
    public function getDataResponse()
    {
        return $this->data;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function build(array $params = [])
    {
        $result = [
            'raw'   => $this->getDataResponse()->toArray(),
            'model' => $this->getDataResponse()->getModel()->toArray(),
            'time'  => time(), // the reason why we have a RestView
        ];

        $this->setResult($result);

        return $this;
    }
}
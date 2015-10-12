<?php

namespace Simplon\Mvc\App\Controllers\Api;

use Simplon\Mvc\App\Views\Client\Rest\SampleRestView;
use Simplon\Mvc\App\Data\SampleData;
use Simplon\Mvc\Core\Controllers\RestController;
use Simplon\Mvc\Core\Responses\RestResponse;

/**
 * Class SampleRestController
 * @package Simplon\Mvc\App\Controllers\Api
 */
class SampleRestController extends RestController
{
    /**
     * @return RestResponse
     */
    public function index()
    {
        $model = $this->getAuthUsersStorage()->readOne(['id' => 1]);

        $dataResponse = (new SampleData())->fromArray(['model' => $model, 'type' => 'foo']);

        return $this->respond(
            new SampleRestView($dataResponse)
        );
    }
}
<?php

namespace SoftWorksPy\AppConfig\Api;

use Response;
use Illuminate\Routing\Controller;
use SoftWorksPy\AppConfig\Models\Application;

class Applications extends Controller
{
    public function getConfig()
    {
        $clientCode = $this->_getClientDatas()[0];
        $client = Application::findByCode($clientCode);

        if (!$client) return SimpleResponse::create('Not found', 404);

        return Response::json($client);
    }

    public function checkVersion()
    {
        list($clientCode, $version) = $this->_getClientDatas();
        $client = Application::findByCode($clientCode);

        if (!$client) {
            return SimpleResponse::create('La aplicación no existe', 404);
        }

        return $client->checkVersion($version);
    }

    private function _getClientDatas()
    {
        $userAgent = request()->header('User-Agent');
        return explode('/', $userAgent);
    }
}

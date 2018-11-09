<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class CameraImageManagementController extends Controller
{  
    public function index()
    {
        $client = new \Guzzle\Service\Client(env('NODE_SERVER', '10.208.16.160').':3000');
        $response = $client->post("getCollection",null,['collectionName'=>'camera'])->send();
        $response=json_decode($response->getBody(), true);
        return view('CameraImageManagement.Index',compact('response'));

    }

    public function manageMasking($camId) {
        $client = new \Guzzle\Service\Client(env('NODE_SERVER', 'http://10.208.16.160').':3000');
        $response = $client->post('getCollection',null,['collectionName'=>'camera'])->send();
        $response=json_decode($response->getBody(), true);

        foreach($response as $object)
        {
            if($object['cameraID'] === $camId)
            {
                try {
                    list($width, $height) = getimagesize($object['cameraImageUrl']);
                    $width /= 2;
                    $height /= 2;

                } catch (\Exception $exception) {
                    abort(404);
                }
                $drawables = $this->getPolygonsToDraw($object);
                return view('CameraImageManagement.Show',compact('object', 'width', 'height', 'drawables'));
            }

        }
    }

    /**
     * @param $item
     * @return array|null
     * There is /2 because to fit in screen, I have divided the dimension by 2
     */
    private function getPolygonsToDraw($item) {
        if (!isset($item['maskData'])) {
            return [];
        }

        $maskData = $item['maskData'];
        $masks = [];

        foreach ($maskData as $key => $maskDatum) {
            $masks[$key]['colors'] = $this->getColorByType($key);
            $masks[$key]['points'] = array_map(function($point) {
                return [$point['x']/2, $point['y']/2];
            }, $maskDatum);
        }

        return $masks;
    }

    public function updatePoints(Request $request) {
        //We require objects like many items..
    }

    private function getColorByType($key) {
        $colors = [
            'roadPixels' => [
                'rgba(255,0,0, 1)',
                'rgba(255,0,0, 0.4)',
            ]
        ];

        return isset($colors[$key]) ? $colors[$key] : ['rgba(0,0,0, 1)', 'rgba(0,0,0, 0.4)'];
    }
}

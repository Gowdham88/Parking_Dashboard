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
                return view('CameraImageManagement.Show',compact('object', 'width', 'height'));
            }

        }
    }
}

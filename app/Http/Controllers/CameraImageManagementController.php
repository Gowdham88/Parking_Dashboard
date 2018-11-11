<?php

namespace App\Http\Controllers;

use App\Http\Workers\FireStore;
use Illuminate\Http\Request;

class CameraImageManagementController extends Controller
{

    private $fireStore;

    public function __construct()
    {
        $this->fireStore = new FireStore();
    }

    public function index()
    {

        $data = $this->fireStore->getCollection();
        return view('CameraImageManagement.Index',compact('data'));

    }

    public function manageMasking($camId)
    {
        $camera = $this->fireStore->get($camId);

        if (!$camera) {
            abort(404);
        }

        try {
            list($width, $height) = getimagesize($camera['cameraImageUrl']);
            $width /= 2;
            $height /= 2;

        } catch (\Exception $exception) {
            abort(404);
        }

        $drawables = $this->getPolygonsToDraw($camera['maskData']);

        return view('CameraImageManagement.Show',compact('camera', 'width', 'height', 'drawables'));
    }

    /**
     * @param $maskData
     * @return array|null
     * There is /2 because to fit in screen, I have divided the dimension by 2
     */
    private function getPolygonsToDraw($maskData) {
        if (!count($maskData)) {
            return [];
        }

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

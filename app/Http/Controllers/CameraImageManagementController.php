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
        } catch (\Exception $exception) {
            abort(404);
        }

        $drawables = $this->getPolygonsToDraw(isset($camera['maskData']) ? $camera['maskData'] : []);

        return view('CameraImageManagement.Show',compact('camera', 'width', 'height', 'drawables'));
    }

    /**
     * @param $maskData
     * @return array|null
     * There is /2 because to fit in screen, I have divided the dimension by 2
     */
    private function getPolygonsToDraw($maskData) {

        if (!$maskData) {
            return [];
        }

        $maskData = json_decode($maskData);

        if (!count($maskData)) {
            return [];
        }

        $masks = [];

        foreach ($maskData as $key => $maskDatum) {
            $masks[$key]['type'] = $maskDatum->type;
            $masks[$key]['color'] = $maskDatum->color;
            $masks[$key]['points'] = array_map(function($point) {
                return [$point[0], $point[1]];
            }, $maskDatum->points);
        }

        return $masks;
    }

    public function updatePoints($id, Request $request) {
        $camera = $this->fireStore->getForUpdate($id);

        $data = json_encode($request->get('polygons'));

        $camera->update([
           ['path' => 'maskData', 'value' => $data ]
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function showPreview(Request $request) {
        $camera = $this->fireStore->get($request->get('cid'));

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

        $drawables = $this->getPolygonsToDraw(isset($camera['maskData']) ? $camera['maskData'] : []);

        return view('CameraImageManagement.preview',compact('camera', 'width', 'height', 'drawables'));

    }
}

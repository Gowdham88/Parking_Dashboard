<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Http\Workers\FireStore;

class CameradetailsController extends Controller
{
    private $fireStore;

    public function __construct()
    {

        $this->fireStore = new FireStore();
    }

    public function index()
    {
        
        $data = $this->fireStore->getCollection();

        return view('Cameralist.Index',compact('data'));

    }

    public function show($cameraID)
    {

        $camera = $this->fireStore->get($cameraID);

        if (!$camera) {
            abort(404);
        }

        return view('Cameralist.Show',compact('camera'));
         
        
    }

    public function edit($cameraID)
    {

        $camera = $this->fireStore->get($cameraID);

        if (!$camera) {
            abort(404);
        }

        return view('Cameralist.Edit',compact('camera'));
    }

    public function create()
    {
        return view('Cameralist.Create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'location' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);
        
        $data = [
            'cameraLat' => $request->get('lat'),
            'cameraLong' => $request->get('lng'),
            'cameraLocationName' => $request->get('location'),
            'focalLength' => $request->get('flen'),
            'cameraImageUrl' => $request->get('url'),
            'directionAngle' => $request->get('directionAngle'),

            'parkingRules' => (object) $request->get('parkingRules')
        ];

        $camera = $this->fireStore->save($data);

        if (!$camera) {
            return redirect()->back()->with('message', 'Camera did not add successfully!');
        }

        $cameraId = $camera->id();

        $camera->update([
            ['path' => 'cameraID', 'value' => $cameraId]
        ]);

        return redirect()->back()->with('message', 'Camera added successfully!');

    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'location' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        $camera = $this->fireStore->getForUpdate($id);

        if (!$camera) {
            abort(404);
        }

        $camera->update([
            ['path' => 'cameraLat', 'value' => $request->get('lat')],
            ['path' => 'cameraLong', 'value' => $request->get('lng')],
            ['path' => 'cameraLocationName', 'value' => $request->get('location')],
            ['path' => 'focalLength', 'value' => $request->get('flen')],
            ['path' => 'cameraImageUrl', 'value' => $request->get('url')],
            ['path' => 'directionAngle', 'value' => $request->get('directionAngle')]
        ]);

        return redirect()->back()->with('message', 'Camera update successful!');

    }

    public function destroy($id) {
        $this->fireStore->getForUpdate($id)->delete();

        return redirect()->back()->with('message', 'Camera deleted successfully!');
    }
}

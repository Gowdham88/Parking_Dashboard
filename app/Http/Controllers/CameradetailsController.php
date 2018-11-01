<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class CameradetailsController extends Controller
{  
    public function index()
    {
        // $response = Curl::to('http://10.208.1.229:3000/getCollection')
        //         ->post();
        // dd($response);
        $username = 'abcd';
        // $client = new \Guzzle\Service\Client('http://10.208.1.229:3000');
        $client = new \Guzzle\Service\Client('http://10.208.16.160:3000');
        // dd(config("camera"));
        $response = $client->post("getCollection",null,['collectionName'=>'camera'])->send();
        // $response=json_decode($response->getBody(), true);
        $response=json_decode($response->getBody(), true);
        return View('Cameralist.Index',compact('response'));



        // foreach($response as $object)
        //     {
        //         $data[] = $object['cameraID'];
        //         $data[] = $object['cameraLat'];
        //     }
        // // foreach ($data as $value) 
        // //     {
        // //          $cameraid[] = $value['cameraID'];
        // //          $camlat[]   = $value['cameraLat'];
        // //     }
        // dd($data);

            // dd($cameraid, $camlat);
        // return View('Cameralist.Index');
    }
    public function show($cameraID)
    {
        $client = new \Guzzle\Service\Client('http://10.208.16.160:3000');
        $response = $client->post("getCollection",null,['collectionName'=>'camera'])->send();
        $response=json_decode($response->getBody(), true);
        // dd($response);
        // return View('Cameralist.Show',compact('response'));
        foreach($response as $object)
        {
            if($object['cameraID'] == $cameraID)
            {
               return View('Cameralist.Show',compact('object'));
               break;
            }
               
        }
         
        
    }
    public function edit($cameraID)
    {
        $client = new \Guzzle\Service\Client('http://10.208.16.160:3000');
        $response = $client->post("getCollection",null,['collectionName'=>'camera'])->send();
        $response=json_decode($response->getBody(), true);
        foreach($response as $object)
        {
            if($object['cameraID'] == $cameraID)
            {
               return View('Cameralist.Edit',compact('object'));
               break;
            }
               
        }
    }
    public function create()
    {
        return View('Cameralist.Create');
    }
}

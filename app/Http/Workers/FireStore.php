<?php

namespace App\Http\Workers;

use Google\Cloud\Firestore\FirestoreClient;


class FireStore {

    public $fireStore;

    public function __construct()
    {
        $this->fireStore = new FirestoreClient();
    }

    public function getCollection($collectionName = 'camera') {
        return $this->fireStore->collection($collectionName)->documents()->rows();
    }

    public function get($id, $collectionName = 'camera') {

        $cRef = $this->fireStore->collection($collectionName);
        $dRef = $cRef->document($id);

        if ($dRef) {
            return $dRef->snapshot();
        }

        return null;

    }

    public function getForUpdate($id, $collectionName = 'camera') {

        $cRef = $this->fireStore->collection($collectionName);
        $dRef = $cRef->document($id);

        if ($dRef) {
            return $dRef;
        }

        return null;

    }

    public function save($data, $collectionName = 'camera') {
        return $this->fireStore->collection($collectionName)->add($data);
    }

    public function update() {

    }

    public function delete() {

    }
}
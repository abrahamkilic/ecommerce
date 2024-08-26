<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/Firebase.json')
            ->withDatabaseUri('https://laravel-firebase-a43d2-default-rtdb.firebaseio.com/');
        
        $this->database = $firebase->createDatabase();
    }

    public function getDatabase()
    {
        return $this->database;
    }
}
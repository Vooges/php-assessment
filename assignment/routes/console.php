<?php

use Illuminate\Support\Facades\Schedule;
use App\Services\ColleaguesAPIService;

Schedule::call(function (){
    (new ColleaguesAPIService())->updateColleagues();
})->everyFiveMinutes();
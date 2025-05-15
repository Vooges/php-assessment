<?php

use Illuminate\Support\Facades\Schedule;
use App\Services\ColleaguesAPIService;

if (App::environment('production')){
    Schedule::call(function (){
        (new ColleaguesAPIService())->updateColleagues();
    })->everyFiveMinutes();
} else {
    Schedule::call(function (){
        (new ColleaguesAPIService())->updateColleagues();
    });
}
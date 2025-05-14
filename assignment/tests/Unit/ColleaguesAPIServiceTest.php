<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ColleaguesAPIService;
use App\Models\Recipient;
use Illuminate\Support\Facades\Http;

class ColleaguesAPIServiceTest extends TestCase
{
    private $colleaguesAPIService;

    private static $mockedResponseBody = '[
        {
            "name": "Niek Hoek",
            "email": "niekhoek@mailinator.com"
        },
        {
            "name": "Dennes Slagmolen",
            "email": "dennes@mailinator.com"
        },
        {
            "name": "Renee Henstra",
            "email": "renee.henstra@mailinator.com"
        },
        {
            "name": "Jurren Buitink",
            "email": "renee.henstra@mailinator.com"
        }
    ]';

    public function setUp() : void
    {
        parent::setUp();

        Http::fake(['*' => Http::response(self::$mockedResponseBody, 200)]);

        $this->colleaguesAPIService = new ColleaguesAPIService();
    }

    public function tearDown() : void
    {
        Recipient::query()->delete();
        
        parent::tearDown();
    }

    public function test_colleagues_api_service_adds_new_colleages() : void
    {
        $beforeCount = Recipient::count();

        $this->colleaguesAPIService->updateColleagues();

        $afterCount = Recipient::count();

        $this->assertTrue($afterCount > $beforeCount);
    }

    public function test_colleagues_api_service_updates_colleagues() : void
    {
        $emailAddress = 'niekhoek@mailinator.com';

        $old = Recipient::create([
            'name' => 'Old Name',
            'email_address' => $emailAddress
        ]);

        $this->colleaguesAPIService->updateColleagues();

        $new = Recipient::where('email_address', $emailAddress)->first();

        $this->assertFalse($old->name === $new->name);
    }
}
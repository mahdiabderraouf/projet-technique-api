<?php

namespace Tests\Unit;

use App\Models\Adress;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_a_path() {
        $campaign = Campaign::factory()->create();
        $this->assertEquals('/campaigns/' . $campaign->slug, $campaign->path());
    }

    /** @test */
    public function it_has_an_adress() {
        $this->withoutExceptionHandling();
        $campaign = Campaign::factory()->create();
        $adress = Adress::create([
            'label' => 'Example adress',
            'name' => 'example',
            'postcode' => 83000,
            'city' => 'Toulon',
            'street' => '1 rue Example',
            'importance' => 0.7,
            'x' => 100,
            'y' => 100,
        ]);
        $campaign->adress()->associate($adress);
        $this->assertInstanceOf('App\Models\Adress', $campaign->adress);
    }
}

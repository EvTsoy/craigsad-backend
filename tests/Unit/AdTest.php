<?php

namespace Tests\Unit;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class AdTest
 * @package Tests\Unit
 */
class AdTest extends TestCase
{
    use RefreshDatabase;

    protected $user1;
    protected $user2;

    public function testUsersCanFetchAds(): void
    {
        $this->signIn($this->user1);
        Ad::factory()->count(5)->create(['user_id' => $this->user1->id ?? 1]);
        $this->signIn($this->user2);
        Ad::factory()->count(5)->create(['user_id' => $this->user2->id ?? 2]);
        $response = $this->get('/api/ads');
        $response->assertJsonCount(10, 'data');
    }

    protected function signIn($user = null)
    {
        Sanctum::actingAs($user, ['*']);
        return $user;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::factory()->create([
            'email'    => 'user_1@example.com',
            'password' => Hash::make('password_1')
        ]);

        $this->user2 = User::factory()->create([
            'email'    => 'user_2@example.com',
            'password' => Hash::make('password_2')
        ]);
    }

}

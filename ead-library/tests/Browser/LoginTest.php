<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function testLoginBerhasil(): void
    {
        $user = User::factory()->create([
            'email' => 'member@ead.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'member@ead.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertPathIs('/books')
                    ->assertSee('Login berhasil.')
                    ->assertSee('Daftar Buku');
        });
    }

    public function testLogoutBerhasil(): void
    {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/books')
                    ->click('.user-icon-btn') 
                    ->press('Logout')
                    ->assertPathIs('/login')
                    ->assertSee('Logout berhasil.');
        });
    }
}
<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Book;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookTest extends DuskTestCase
{
        use DatabaseMigrations;

        public function testBookBerhasil(): void
        {
                $this->artisan('db:seed');
                $user = User::factory()->create();
                $this->browse(function (Browser $browser) use ($user) {
                        $browser->loginAs($user)
                                ->visit('/books/create')
                                ->type('title', 'Laskar Pelangi')
                                ->type('author', 'Andrea Hirata')
                                ->select('category', 'Novel')
                                ->type('published_year', '2005')
                                ->type('stock', '10')
                                ->type('summary', 'Kisah perjuangan anak-anak Belitong.')
                                ->press('Simpan Buku')
                                ->waitForText('Buku berhasil ditambahkan.')
                                ->assertSee('Laskar Pelangi');
                        $browser->clickLink('Edit Buku')
                                ->waitForText('Ubah Data Buku')
                                ->type('author', 'Andrea 123')
                                ->press('Perbarui Buku')
                                ->waitForText('Penulis tidak boleh mengandung angka.')
                                ->assertSee('Penulis tidak boleh mengandung angka.');
                        $browser->visit('/books')
                                ->waitForText('Laskar Pelangi')
                                ->clickLink('Detail')
                                ->waitForText('Laskar Pelangi')
                                ->press('Hapus Buku')
                                ->acceptDialog()
                                ->waitForText('Buku berhasil dihapus.')
                                ->assertDontSee('Laskar Pelangi');
                });
        }
}
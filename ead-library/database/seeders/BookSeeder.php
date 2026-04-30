<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Laravel Testing Handbook',
                'author' => 'Dimas Pratama',
                'category' => 'Teknologi',
                'published_year' => 2024,
                'stock' => 12,
                'summary' => 'Panduan praktis untuk mempelajari unit test, feature test, dan browser test di Laravel.',
            ],
            [
                'title' => 'Sistem Informasi Praktikum',
                'author' => 'Ayu Lestari',
                'category' => 'Referensi',
                'published_year' => 2023,
                'stock' => 7,
                'summary' => 'Catatan ringkas untuk membantu mahasiswa memahami alur kerja aplikasi praktikum.',
            ],
            [
                'title' => 'Algoritma untuk Pemula',
                'author' => 'Rizky Maulana',
                'category' => 'Sains',
                'published_year' => 2022,
                'stock' => 4,
                'summary' => 'Buku pengantar mengenai konsep dasar algoritma dan logika pemrograman.',
            ],
            [
                'title' => 'Cerita di Balik Kode',
                'author' => 'Nadia Putri',
                'category' => 'Novel',
                'published_year' => 2021,
                'stock' => 9,
                'summary' => 'Kumpulan cerita pendek tentang tim kecil yang membangun produk digital dari nol.',
            ],
            [
                'title' => 'Manajemen Produk Digital',
                'author' => 'Fajar Hidayat',
                'category' => 'Bisnis',
                'published_year' => 2025,
                'stock' => 3,
                'summary' => 'Membahas cara menyusun roadmap, backlog, dan pengambilan keputusan produk.',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['title' => $book['title']],
                $book
            );
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '9780743273565',
                'category_id' => null,
                'sinopsis' => 'A classic novel about the American Dream',
                'tahun_terbit' => '1925',
                'penerbit' => 'Scribner',
                'price' => 15.99,
                'stock' => 50,
                'image' => null,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '9780451524935',
                'category_id' => null,
                'sinopsis' => 'A dystopian social science fiction novel',
                'tahun_terbit' => '1949',
                'penerbit' => 'Secker & Warburg',
                'price' => 12.99,
                'stock' => 30,
                'image' => null,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
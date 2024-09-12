<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('categories')->insert([
            'name' => 'fiksi',
        ]);
        DB::table('categories')->insert([
            'name' => 'non-fiksi',
        ]);

        DB::table('books')->insert([
            'title' => 'Judul Buku Fiksi',
            'code' => 'AF123',
            'author' => 'Jono',
            'publisher' => 'Gramedia',
            'description' => 'Ini deskripsi penting dari buku dengan judul (Judul Buku)...',
            'category_id' => 1,
            'stock' => 5,
            'pages' => 250,
            'language' => 'Indonesia',
            'isbn_issn' => '978-3-16-148410-0',
            'content_type' => 'Teks',
            'media_type' => 'Buku Cetak',
            'carrier_type' => 'Volume',
            'edition' => 'Edisi Pertama',
            'subject' => 'Sastra',
            'created_at' => '2023-12-12 01:24:14'
        ]);

        DB::table('books')->insert([
            'title' => 'Judul Buku Non Fiksi',
            'code' => 'AF456',
            'author' => 'Jono',
            'publisher' => 'Gramedia',
            'description' => 'Ini deskripsi penting dari buku dengan judul (Judul Buku)...',
            'category_id' => 2,
            'stock' => 5,
            'pages' => 300,
            'language' => 'Indonesia',
            'isbn_issn' => '978-1-23-456789-7',
            'content_type' => 'Teks',
            'media_type' => 'Buku Cetak',
            'carrier_type' => 'Volume',
            'edition' => 'Edisi Kedua',
            'subject' => 'Sejarah',
            'created_at' => '2023-12-13 01:24:14'
        ]);


        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'nis_nip' => '123456789098765',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('12345'),
            'photo' => null,
        ]);

        DB::table('users')->insert([
            'name' => 'dzul fauzi',
            'username' => 'dzulaji',
            'nis_nip' => '2011522001',
            'email' => 'dzulaji@gmail.com',
            'role' => 'user',
            'password' => bcrypt('12345'),
            'photo' => null,
        ]);

        DB::table('users')->insert([
            'name' => 'librarian',
            'username' => 'librarian',
            'nis_nip' => '123456789092765',
            'email' => 'librarian@gmail.com',
            'role' => 'librarian',
            'password' => bcrypt('12345'),
            'photo' => null,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat kategori jika belum ada
        $category = Category::firstOrCreate(
            ['slug' => 'berita'],
            [
                'name' => 'Berita',
                'description' => 'Berita dan update terbaru dari Unceasing Cantica Bandung',
            ]
        );

        // Buat tag jika belum ada
        $tag1 = Tag::firstOrCreate(
            ['slug' => 'kegiatan'],
            ['name' => 'Kegiatan']
        );

        $tag2 = Tag::firstOrCreate(
            ['slug' => 'pelayanan'],
            ['name' => 'Pelayanan']
        );

        $tag3 = Tag::firstOrCreate(
            ['slug' => 'konser'],
            ['name' => 'Konser']
        );

        // Buat artikel contoh
        $article = Article::firstOrCreate(
            ['slug' => 'selamat-datang-di-unceasing-cantica-bandung'],
            [
                'title' => 'Selamat Datang di Unceasing Cantica Bandung',
                'slug' => 'selamat-datang-di-unceasing-cantica-bandung',
                'excerpt' => 'Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar. Kami berkomitmen untuk melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni.',
                'content' => '<h2>Tentang Unceasing Cantica Bandung</h2>

<p>Unceasing Cantica Bandung (UCB) adalah paduan suara yang didirikan pada <strong>22 Maret 2001</strong> oleh <strong>Sir Dante Oblimar</strong>, seorang musisi asal Filipina, di kampus Universitas Advent Indonesia (UNAI) di Bandung.</p>

<h3>Visi dan Misi</h3>

<p>Nama "Unceasing Cantica" berasal dari kata "Unceasing" yang berarti "tak berkesudahan" dan "Cantica" yang berarti "pujian", sehingga secara keseluruhan berarti <strong>"Pujian yang tak berkesudahan"</strong>.</p>

<p>UCB terdiri dari orang-orang muda yang berkomitmen untuk:</p>

<ul>
<li>Melayani Allah dan menyebarkan Injil melalui musik</li>
<li>Membangun komunitas yang solid dan saling mendukung</li>
<li>Mengembangkan talenta musik dan vokal anggota</li>
<li>Memberkati banyak orang melalui pertunjukan musik koor</li>
</ul>

<h3>Kegiatan dan Pelayanan</h3>

<p>Seiring waktu, UCB telah berkembang dan membentuk beberapa cabang di berbagai lokasi, termasuk Jakarta, Manila, AUP, Bangkok, Balikpapan, dan Australia. Kami aktif dalam berbagai kegiatan:</p>

<ul>
<li><strong>Pelayanan Gereja</strong> - Melayani dalam ibadah dan acara gereja</li>
<li><strong>Konser Musik</strong> - Mengadakan konser dan pertunjukan musik rohani</li>
<li><strong>Latihan Rutin</strong> - Latihan setiap Senin malam, Jumat malam, dan Sabtu siang</li>
<li><strong>Kegiatan Komunitas</strong> - Membangun persaudaraan dan kerohanian</li>
</ul>

<h3>Bergabung dengan Kami</h3>

<p>Apakah Anda memiliki passion untuk musik dan ingin melayani Tuhan melalui paduan suara? Mari bergabung dengan Unceasing Cantica Bandung! Kami terbuka untuk semua orang yang ingin melayani melalui musik.</p>

<p>Untuk informasi lebih lanjut, silakan hubungi kami atau kunjungi halaman <a href="/join">Bergabung</a> di website ini.</p>

<p><em>Mari bersama-sama memuji Tuhan dengan pujian yang tak berkesudahan!</em></p>',
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now(),
                'meta_title' => 'Selamat Datang di Unceasing Cantica Bandung - Paduan Suara Bandung',
                'meta_description' => 'Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001. Kami melayani Tuhan melalui musik koor yang penuh harmoni.',
            ]
        );

        // Attach tags to article
        if (!$article->tags()->where('tag_id', $tag1->id)->exists()) {
            $article->tags()->attach($tag1->id);
        }
        if (!$article->tags()->where('tag_id', $tag2->id)->exists()) {
            $article->tags()->attach($tag2->id);
        }
        if (!$article->tags()->where('tag_id', $tag3->id)->exists()) {
            $article->tags()->attach($tag3->id);
        }

        $this->command->info('✅ Artikel berhasil dibuat!');
        $this->command->info('📝 Judul: ' . $article->title);
        $this->command->info('🔗 Slug: ' . $article->slug);
        $this->command->info('📂 Kategori: ' . $category->name);
        $this->command->info('🏷️  Tags: ' . $article->tags->pluck('name')->join(', '));
    }
}


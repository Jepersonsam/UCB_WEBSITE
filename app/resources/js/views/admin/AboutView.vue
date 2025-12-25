<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Tentang Unceasing Cantica</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola konten halaman Tentang</p>
      <p v-if="!hasSavedContent" class="mt-2 text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 inline-block">
        ℹ️ Menampilkan konten default dari website. Simpan untuk menyimpan perubahan ke database.
      </p>
    </div>

    <form @submit.prevent="saveAbout" class="space-y-6">
      <!-- Konten Utama -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Konten Utama</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul</label>
            <input
              v-model="aboutContent.title"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Tentang Unceasing Cantica"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Paragraf 1</label>
            <textarea
              v-model="aboutContent.paragraph1"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Unceasing Cantica Bandung (UCB) adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar..."
            ></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Paragraf 2</label>
            <textarea
              v-model="aboutContent.paragraph2"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Nama 'Unceasing Cantica' berasal dari kata 'Unceasing' yang berarti 'tak berkesudahan'..."
            ></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Paragraf 3</label>
            <textarea
              v-model="aboutContent.paragraph3"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="UCB terdiri dari orang-orang muda yang berkomitmen untuk melayani Allah..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Kartu Fitur -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Kartu Fitur</h3>
        <div class="space-y-4">
          <div
            v-for="(card, index) in aboutContent.cards"
            :key="index"
            class="rounded-xl border border-sky-100 bg-slate-50 p-4"
          >
            <div class="mb-3 flex items-center justify-between">
              <h4 class="font-semibold text-slate-800">Kartu {{ index + 1 }}</h4>
            </div>
            <div class="space-y-3">
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Judul</label>
                <input
                  v-model="card.title"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  :placeholder="`Judul kartu ${index + 1}`"
                />
              </div>
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Deskripsi</label>
                <textarea
                  v-model="card.description"
                  rows="2"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  :placeholder="`Deskripsi kartu ${index + 1}`"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end gap-4 border-t border-sky-100 pt-6">
        <button
          type="submit"
          :disabled="saving"
          class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl disabled:opacity-50"
        >
          <span v-if="saving">Menyimpan...</span>
          <span v-else>Simpan Konten</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

// Konten default yang sama dengan yang ada di website
const defaultContent = {
  title: 'Tentang Unceasing Cantica',
  paragraph1: 'Unceasing Cantica Bandung (UCB) adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar, seorang musisi asal Filipina, di kampus Universitas Advent Indonesia (UNAI) di Bandung.',
  paragraph2: 'Nama "Unceasing Cantica" berasal dari kata "Unceasing" yang berarti "tak berkesudahan" dan "Cantica" yang berarti "pujian", sehingga secara keseluruhan berarti "Pujian yang tak berkesudahan".',
  paragraph3: 'UCB terdiri dari orang-orang muda yang berkomitmen untuk melayani Allah dan menyebarkan Injil melalui musik. Seiring waktu, UCB telah berkembang dan membentuk beberapa cabang di berbagai lokasi, termasuk Jakarta, Manila, AUP, Bangkok, Balikpapan, dan Australia.',
  learnMoreText: 'Pelajari Lebih Lanjut',
  learnMoreUrl: '/about',
  cards: [
    { title: 'Musik Koor', description: 'Berbagai genre musik rohani dengan harmoni yang indah' },
    { title: 'Komunitas', description: 'Komunitas yang solid dan saling mendukung' },
    { title: 'Pelayanan', description: 'Melayani Tuhan dan memberkati banyak orang' },
    { title: 'Konser', description: 'Pertunjukan musik di berbagai acara dan gereja' },
  ],
}

const aboutContent = ref({ ...defaultContent })

const saving = ref(false)
const hasSavedContent = ref(false)

const fetchAbout = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.about_content) {
      try {
        const parsed = typeof data.about_content === 'string' 
          ? JSON.parse(data.about_content) 
          : data.about_content
        // Merge dengan default content, dengan prioritas pada data dari database
        aboutContent.value = { 
          ...defaultContent, 
          ...parsed,
          // Pastikan cards selalu ada 4 item
          cards: parsed.cards && parsed.cards.length === 4 
            ? parsed.cards 
            : [
                ...(parsed.cards || []),
                ...defaultContent.cards.slice(parsed.cards?.length || 0)
              ].slice(0, 4)
        }
        hasSavedContent.value = true
      } catch (e) {
        console.error('Error parsing about_content:', e)
        // Jika parsing gagal, gunakan default content
        aboutContent.value = { ...defaultContent }
        hasSavedContent.value = false
      }
    } else {
      // Jika belum ada data di database, gunakan default content
      aboutContent.value = { ...defaultContent }
      hasSavedContent.value = false
    }
  } catch (error) {
    console.error('Error fetching about content:', error)
    // Jika error, tetap gunakan default content
    aboutContent.value = { ...defaultContent }
  }
}

const saveAbout = async () => {
  saving.value = true
  try {
    await api.put('/v1/settings', {
      settings: {
        about_content: JSON.stringify(aboutContent.value)
      }
    })
    hasSavedContent.value = true
    await swal.success('Konten Tentang berhasil disimpan!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menyimpan konten')
    console.error('Error saving about content:', error)
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchAbout()
})
</script>


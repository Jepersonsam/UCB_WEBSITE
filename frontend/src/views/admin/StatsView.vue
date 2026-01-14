<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Stats Section</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola statistik yang ditampilkan di halaman beranda</p>
    </div>

    <div v-if="!contentLoaded" class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm animate-pulse">
      <div class="h-6 w-1/2 bg-sky-100 rounded mb-4"></div>
      <div class="h-4 w-full bg-sky-50 rounded mb-2"></div>
      <div class="h-4 w-full bg-sky-50 rounded"></div>
    </div>
    <div v-else-if="!contentSaved" class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800 mb-4">
      <p>Konten ini belum pernah disimpan ke database. Ini adalah konten default dari website.</p>
    </div>

    <form @submit.prevent="saveStats" class="space-y-6">
      <!-- Stats Cards -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Kartu Statistik</h3>
        <div class="space-y-4">
          <div
            v-for="(stat, index) in statsContent.stats"
            :key="index"
            class="rounded-xl border border-sky-100 bg-slate-50 p-4"
          >
            <div class="mb-3 flex items-center justify-between">
              <h4 class="font-semibold text-slate-800">Kartu {{ index + 1 }}</h4>
              <button
                v-if="statsContent.stats.length > 1"
                type="button"
                @click="removeStat(index)"
                class="rounded-lg bg-red-50 px-2 py-1 text-xs font-medium text-red-600 transition-colors hover:bg-red-100"
              >
                Hapus
              </button>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Nilai (Angka/Teks)</label>
                <input
                  v-model="stat.value"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  :placeholder="`Contoh: 2001, 100+, 24`"
                />
              </div>
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Judul</label>
                <input
                  v-model="stat.title"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  :placeholder="`Contoh: Tahun Berdiri`"
                />
              </div>
              <div class="sm:col-span-2">
                <label class="mb-1 block text-xs font-medium text-slate-600">Subtitle/Deskripsi</label>
                <input
                  v-model="stat.subtitle"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  :placeholder="`Contoh: 22 Maret 2001`"
                />
              </div>
            </div>
          </div>
          <button
            type="button"
            @click="addStat"
            class="w-full rounded-xl border-2 border-dashed border-sky-300 bg-sky-50 px-4 py-3 text-sm font-medium text-sky-600 transition-colors hover:border-sky-400 hover:bg-sky-100"
          >
            + Tambah Kartu Statistik
          </button>
        </div>
        <p class="mt-4 text-xs text-slate-500">Maksimal 4 kartu statistik. Kartu akan ditampilkan dalam grid responsif.</p>
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

const defaultContent = {
  stats: [
    {
      value: '2001',
      title: 'Tahun Berdiri',
      subtitle: '22 Maret 2001'
    },
    {
      value: '100+',
      title: 'Anggota Aktif',
      subtitle: 'Komunitas yang berkembang'
    },
    {
      value: '24',
      title: 'Tahun Melayani',
      subtitle: 'Dengan dedikasi tinggi'
    }
  ]
}

const statsContent = ref({ ...defaultContent })
const saving = ref(false)
const contentLoaded = ref(false)
const contentSaved = ref(false)

const addStat = async () => {
  if (statsContent.value.stats.length >= 4) {
    await swal.warning('Maksimal 4 kartu statistik')
    return
  }
  statsContent.value.stats.push({
    value: '',
    title: '',
    subtitle: ''
  })
}

const removeStat = async (index: number) => {
  if (statsContent.value.stats.length <= 1) {
    await swal.warning('Minimal harus ada 1 kartu statistik')
    return
  }
  statsContent.value.stats.splice(index, 1)
}

const fetchStats = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.stats_content) {
      try {
        const parsed = typeof data.stats_content === 'string' 
          ? JSON.parse(data.stats_content) 
          : data.stats_content
        
        statsContent.value = { 
          ...defaultContent, 
          ...parsed,
          stats: parsed.stats && parsed.stats.length > 0 
            ? parsed.stats.slice(0, 4) // Maksimal 4 kartu
            : defaultContent.stats
        }
        contentSaved.value = true
      } catch (e) {
        console.error('Error parsing stats_content:', e)
        statsContent.value = { ...defaultContent }
        contentSaved.value = false
      }
    } else {
      statsContent.value = { ...defaultContent }
      contentSaved.value = false
    }
  } catch (error) {
    console.error('Error fetching stats content:', error)
    statsContent.value = { ...defaultContent }
    contentSaved.value = false
  } finally {
    contentLoaded.value = true
  }
}

const saveStats = async () => {
  // Validasi minimal 1 kartu
  if (statsContent.value.stats.length === 0) {
    await swal.warning('Minimal harus ada 1 kartu statistik')
    return
  }

  // Validasi setiap kartu harus memiliki value dan title
  for (let i = 0; i < statsContent.value.stats.length; i++) {
    const stat = statsContent.value.stats[i]
    if (!stat.value || !stat.value.trim()) {
      await swal.warning(`Kartu ${i + 1}: Nilai harus diisi`)
      return
    }
    if (!stat.title || !stat.title.trim()) {
      await swal.warning(`Kartu ${i + 1}: Judul harus diisi`)
      return
    }
  }

  saving.value = true
  try {
    await api.put('/v1/settings', {
      settings: {
        stats_content: JSON.stringify(statsContent.value)
      }
    })
    await swal.success('Konten Stats Section berhasil disimpan!')
    contentSaved.value = true
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menyimpan konten')
    console.error('Error saving stats content:', error)
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchStats()
})
</script>


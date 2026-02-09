<template>
  <div class="space-y-8">
    <!-- Welcome Section -->
    <div class="animate-fade-in-down">
      <h1 class="text-4xl font-bold text-slate-800">Dashboard</h1>
      <p class="mt-2 text-lg text-slate-600">Selamat datang di CMS Unceasing Cantica Bandung 🎵</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <!-- Articles Card -->
      <div class="group animate-fade-in-up stagger-1 card hover-lift overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-500 to-sky-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        <div class="relative p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-600 transition-colors group-hover:text-white">Total Artikel</p>
              <div v-if="loading" class="mt-3 h-10 w-20 skeleton rounded-lg"></div>
              <p v-else class="mt-3 text-4xl font-bold text-slate-800 transition-colors group-hover:text-white">
                {{ stats.articles }}
              </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-sky-600 shadow-lg shadow-sky-500/30 transition-transform group-hover:scale-110">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="flex items-center text-emerald-600 transition-colors group-hover:text-white">
              <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
              </svg>
              Konten
            </span>
          </div>
        </div>
      </div>

      <!-- Photos Card -->
      <div class="group animate-fade-in-up stagger-2 card hover-lift overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        <div class="relative p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-600 transition-colors group-hover:text-white">Total Foto</p>
              <div v-if="loading" class="mt-3 h-10 w-20 skeleton rounded-lg"></div>
              <p v-else class="mt-3 text-4xl font-bold text-slate-800 transition-colors group-hover:text-white">
                {{ stats.photos }}
              </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg shadow-purple-500/30 transition-transform group-hover:scale-110">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="flex items-center text-emerald-600 transition-colors group-hover:text-white">
              <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Galeri
            </span>
          </div>
        </div>
      </div>

      <!-- Videos Card -->
      <div class="group animate-fade-in-up stagger-3 card hover-lift overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-500 to-rose-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        <div class="relative p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-600 transition-colors group-hover:text-white">Total Video</p>
              <div v-if="loading" class="mt-3 h-10 w-20 skeleton rounded-lg"></div>
              <p v-else class="mt-3 text-4xl font-bold text-slate-800 transition-colors group-hover:text-white">
                {{ stats.videos }}
              </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 shadow-lg shadow-rose-500/30 transition-transform group-hover:scale-110">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="flex items-center text-emerald-600 transition-colors group-hover:text-white">
              <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Media
            </span>
          </div>
        </div>
      </div>

      <!-- Events Card -->
      <div class="group animate-fade-in-up stagger-4 card hover-lift overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-amber-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        <div class="relative p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-600 transition-colors group-hover:text-white">Total Event</p>
              <div v-if="loading" class="mt-3 h-10 w-20 skeleton rounded-lg"></div>
              <p v-else class="mt-3 text-4xl font-bold text-slate-800 transition-colors group-hover:text-white">
                {{ stats.events }}
              </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg shadow-amber-500/30 transition-transform group-hover:scale-110">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="flex items-center text-emerald-600 transition-colors group-hover:text-white">
              <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Kegiatan
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="animate-fade-in-up card p-8">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Quick Actions</h2>
          <p class="mt-1 text-sm text-slate-600">Akses cepat ke fitur yang sering digunakan</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-sky-200">
          <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
      </div>
      
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <RouterLink
          :to="{ name: 'admin-article-create' }"
          class="group relative overflow-hidden rounded-xl border-2 border-sky-200 bg-gradient-to-br from-sky-50 to-white p-6 shadow-sm transition-all hover:border-sky-400 hover:shadow-lg hover:-translate-y-1"
        >
          <div class="absolute right-0 top-0 h-20 w-20 translate-x-8 -translate-y-8 rounded-full bg-sky-500 opacity-10 transition-transform group-hover:scale-150"></div>
          <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 shadow-lg shadow-sky-500/30">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-slate-800">Buat Artikel</h3>
            <p class="mt-1 text-sm text-slate-600">Tulis artikel atau berita baru</p>
          </div>
        </RouterLink>

        <RouterLink
          :to="{ name: 'admin-gallery' }"
          class="group relative overflow-hidden rounded-xl border-2 border-purple-200 bg-gradient-to-br from-purple-50 to-white p-6 shadow-sm transition-all hover:border-purple-400 hover:shadow-lg hover:-translate-y-1"
        >
          <div class="absolute right-0 top-0 h-20 w-20 translate-x-8 -translate-y-8 rounded-full bg-purple-500 opacity-10 transition-transform group-hover:scale-150"></div>
          <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg shadow-purple-500/30">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-slate-800">Upload Foto</h3>
            <p class="mt-1 text-sm text-slate-600">Tambahkan foto ke galeri</p>
          </div>
        </RouterLink>

        <RouterLink
          :to="{ name: 'admin-videos' }"
          class="group relative overflow-hidden rounded-xl border-2 border-rose-200 bg-gradient-to-br from-rose-50 to-white p-6 shadow-sm transition-all hover:border-rose-400 hover:shadow-lg hover:-translate-y-1"
        >
          <div class="absolute right-0 top-0 h-20 w-20 translate-x-8 -translate-y-8 rounded-full bg-rose-500 opacity-10 transition-transform group-hover:scale-150"></div>
          <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 shadow-lg shadow-rose-500/30">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-slate-800">Tambah Video</h3>
            <p class="mt-1 text-sm text-slate-600">Upload video baru</p>
          </div>
        </RouterLink>

        <RouterLink
          :to="{ name: 'admin-events' }"
          class="group relative overflow-hidden rounded-xl border-2 border-amber-200 bg-gradient-to-br from-amber-50 to-white p-6 shadow-sm transition-all hover:border-amber-400 hover:shadow-lg hover:-translate-y-1"
        >
          <div class="absolute right-0 top-0 h-20 w-20 translate-x-8 -translate-y-8 rounded-full bg-amber-500 opacity-10 transition-transform group-hover:scale-150"></div>
          <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg shadow-amber-500/30">
              <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-slate-800">Buat Event</h3>
            <p class="mt-1 text-sm text-slate-600">Jadwalkan event baru</p>
          </div>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'

const stats = ref({
  articles: 0,
  photos: 0,
  videos: 0,
  events: 0,
  members: 0
})

const loading = ref(true)

const fetchStats = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/dashboard/stats')
    stats.value = response.data
  } catch (error) {
    console.error('Error fetching stats:', error)
    // Tetap tampilkan 0 jika error
    stats.value = {
      articles: 0,
      photos: 0,
      videos: 0,
      events: 0,
      members: 0
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchStats()
})
</script>


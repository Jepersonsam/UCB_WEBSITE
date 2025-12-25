<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
      <p class="mt-2 text-slate-600">Selamat datang di CMS Unceasing Cantica Bandung</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600">Total Artikel</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ stats.articles }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600">Total Foto</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ stats.photos }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600">Total Video</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ stats.videos }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-600">Total Event</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ stats.events }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
      <h2 class="mb-4 text-xl font-bold text-slate-800">Quick Actions</h2>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <RouterLink
          to="/admin/articles/create"
          class="flex items-center gap-3 rounded-xl border border-sky-200 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100">
            <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </div>
          <span class="text-sm font-medium text-slate-700">Buat Artikel</span>
        </RouterLink>

        <RouterLink
          to="/admin/gallery"
          class="flex items-center gap-3 rounded-xl border border-sky-200 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100">
            <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <span class="text-sm font-medium text-slate-700">Upload Foto</span>
        </RouterLink>

        <RouterLink
          to="/admin/videos"
          class="flex items-center gap-3 rounded-xl border border-sky-200 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100">
            <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
          <span class="text-sm font-medium text-slate-700">Tambah Video</span>
        </RouterLink>

        <RouterLink
          to="/admin/events"
          class="flex items-center gap-3 rounded-xl border border-sky-200 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100">
            <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <span class="text-sm font-medium text-slate-700">Buat Event</span>
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
  events: 0
})

onMounted(async () => {
  // TODO: Fetch stats from API
  // For now, using placeholder data
  stats.value = {
    articles: 12,
    photos: 45,
    videos: 8,
    events: 5
  }
})
</script>


<template>
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div class="animate-fade-in-down">
        <h1 class="text-3xl font-bold text-slate-800">Artikel</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola artikel dan berita</p>
      </div>
      <RouterLink
        :to="{ name: 'admin-article-create' }"
        class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition-all hover:scale-105 hover:shadow-xl hover:shadow-sky-500/40"
      >
        <svg class="h-5 w-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Buat Artikel
      </RouterLink>
    </div>

    <!-- Search Bar -->
    <div class="animate-fade-in-up card p-4">
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
          <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari artikel..."
          class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-slate-800 placeholder-slate-400 transition-all focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20"
        />
      </div>
    </div>

    <!-- Articles Table -->
    <div class="animate-fade-in-up card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Judul</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Kategori</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tanggal</th>
              <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <!-- Loading State -->
            <tr v-if="loading">
              <td colspan="5" class="px-6 py-16 text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                  <div class="h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-sky-500"></div>
                  <p class="text-sm text-slate-500">Memuat data...</p>
                </div>
              </td>
            </tr>

            <!-- Empty State -->
            <tr v-else-if="filteredArticles.length === 0">
              <td colspan="5" class="px-6 py-16 text-center">
                <div class="flex flex-col items-center justify-center gap-4">
                  <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-sky-200">
                    <svg class="h-10 w-10 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div>
                    <p class="text-lg font-semibold text-slate-800">
                      {{ searchQuery ? 'Tidak ada artikel yang ditemukan' : 'Belum ada artikel' }}
                    </p>
                    <p class="mt-1 text-sm text-slate-500">
                      {{ searchQuery ? 'Coba kata kunci lain' : 'Mulai dengan membuat artikel pertama Anda' }}
                    </p>
                  </div>
                  <RouterLink
                    v-if="!searchQuery"
                    :to="{ name: 'admin-article-create' }"
                    class="mt-2 inline-flex items-center gap-2 rounded-lg bg-sky-500 px-5 py-2.5 text-sm font-medium text-white transition-all hover:bg-sky-600"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Artikel Pertama
                  </RouterLink>
                </div>
              </td>
            </tr>

            <!-- Article Rows -->
            <tr
              v-else
              v-for="(article, index) in filteredArticles"
              :key="article.id"
              class="group bg-white transition-all hover:bg-gradient-to-r hover:from-sky-50/50 hover:to-transparent"
              :class="{ 'animate-fade-in-up': true, [`stagger-${Math.min(index + 1, 5)}`]: true }"
            >
              <td class="px-6 py-4">
                <div class="max-w-md">
                  <div class="font-semibold text-slate-900 group-hover:text-sky-600 transition-colors">
                    {{ article.title }}
                  </div>
                  <div class="mt-1 text-xs text-slate-500 truncate">{{ article.slug }}</div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700">
                  <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                  </svg>
                  {{ article.category?.name || '-' }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span
                  :class="{
                    'bg-emerald-100 text-emerald-700': article.status === 'published',
                    'bg-amber-100 text-amber-700': article.status === 'draft',
                    'bg-slate-100 text-slate-700': article.status === 'archived',
                  }"
                  class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium"
                >
                  <span
                    :class="{
                      'bg-emerald-500': article.status === 'published',
                      'bg-amber-500': article.status === 'draft',
                      'bg-slate-500': article.status === 'archived',
                    }"
                    class="h-1.5 w-1.5 rounded-full"
                  ></span>
                  {{ article.status === 'published' ? 'Published' : article.status === 'draft' ? 'Draft' : 'Archived' }}
                </span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                  <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  {{ formatDate(article.created_at) }}
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-end gap-2">
                  <RouterLink
                    :to="{ name: 'admin-article-edit', params: { id: article.id } }"
                    class="group/edit inline-flex items-center gap-1.5 rounded-lg bg-sky-50 px-3 py-2 text-sm font-medium text-sky-600 transition-all hover:bg-sky-100 hover:shadow-md"
                  >
                    <svg class="h-4 w-4 transition-transform group-hover/edit:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </RouterLink>
                  <button
                    @click="handleDelete(article.id)"
                    class="group/delete inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition-all hover:bg-red-100 hover:shadow-md"
                  >
                    <svg class="h-4 w-4 transition-transform group-hover/delete:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const articles = ref<any[]>([])
const loading = ref(true)
const searchQuery = ref('')

const filteredArticles = computed(() => {
  if (!searchQuery.value) return articles.value
  
  const query = searchQuery.value.toLowerCase()
  return articles.value.filter(article => 
    article.title.toLowerCase().includes(query) ||
    article.slug.toLowerCase().includes(query) ||
    article.category?.name.toLowerCase().includes(query)
  )
})

const fetchArticles = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/articles')
    articles.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching articles:', error)
  } finally {
    loading.value = false
  }
}

const handleDelete = async (id: number) => {
  const result = await swal.confirmDelete('artikel ini')
  if (!result.isConfirmed) return

  try {
    await api.delete(`/v1/articles/${id}`)
    articles.value = articles.value.filter(a => a.id !== id)
    await swal.success('Artikel berhasil dihapus!')
  } catch (error) {
    await swal.error('Gagal menghapus artikel')
    console.error('Error deleting article:', error)
  }
}

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

onMounted(() => {
  fetchArticles()
})
</script>

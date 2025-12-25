<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Artikel</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola artikel dan berita</p>
      </div>
      <RouterLink
        to="/articles/create"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl"
      >
        + Buat Artikel
      </RouterLink>
    </div>

    <!-- Articles Table -->
    <div class="rounded-2xl border border-sky-100 bg-slate-50 shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="border-b border-sky-100 bg-white">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Judul</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Kategori</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tanggal</th>
              <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-sky-100">
            <tr v-if="loading" class="bg-white">
              <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                Memuat data...
              </td>
            </tr>
            <tr v-else-if="articles.length === 0" class="bg-white">
              <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                Belum ada artikel. <RouterLink to="/articles/create" class="text-sky-600 hover:underline">Buat artikel pertama</RouterLink>
              </td>
            </tr>
            <tr v-else v-for="article in articles" :key="article.id" class="bg-white transition-colors hover:bg-sky-50/50">
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900">{{ article.title }}</div>
                <div class="mt-1 text-xs text-slate-500">{{ article.slug }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700">
                  {{ article.category?.name || '-' }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span
                  :class="{
                    'bg-green-100 text-green-700': article.status === 'published',
                    'bg-yellow-100 text-yellow-700': article.status === 'draft',
                    'bg-gray-100 text-gray-700': article.status === 'archived',
                  }"
                  class="rounded-full px-3 py-1 text-xs font-medium"
                >
                  {{ article.status === 'published' ? 'Published' : article.status === 'draft' ? 'Draft' : 'Archived' }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-slate-600">
                {{ formatDate(article.created_at) }}
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <RouterLink
                    :to="`/articles/${article.id}/edit`"
                    class="rounded-lg px-3 py-1.5 text-sm text-sky-600 transition-colors hover:bg-sky-50"
                  >
                    Edit
                  </RouterLink>
                  <button
                    @click="handleDelete(article.id)"
                    class="rounded-lg px-3 py-1.5 text-sm text-red-600 transition-colors hover:bg-red-50"
                  >
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
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const articles = ref<any[]>([])
const loading = ref(true)

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

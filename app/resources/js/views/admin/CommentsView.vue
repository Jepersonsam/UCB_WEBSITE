<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Komentar Artikel</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola dan moderasi komentar pada artikel</p>
    </div>

    <!-- Stats Card -->
    <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-slate-600">Total Komentar</p>
          <p class="mt-2 text-3xl font-bold text-slate-800">{{ totalComments }}</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
          <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="animate-pulse rounded-2xl border border-sky-100 bg-slate-50 p-6">
        <div class="h-4 w-1/4 rounded bg-sky-100"></div>
        <div class="mt-3 h-4 w-3/4 rounded bg-sky-50"></div>
        <div class="mt-2 h-4 w-1/2 rounded bg-sky-50"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="comments.length === 0"
      class="rounded-3xl border border-sky-100 bg-gradient-to-br from-slate-50 to-sky-50/30 p-16 text-center shadow-sm"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-sky-100">
        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Tidak Ada Komentar</h3>
      <p class="mt-2 text-slate-600">Belum ada komentar yang diterima</p>
    </div>

    <!-- Comments List -->
    <div v-else class="space-y-4">
      <div
        v-for="comment in comments"
        :key="comment.id"
        class="group relative overflow-hidden rounded-2xl border border-sky-100 bg-white transition-all duration-300"
      >
        <div class="p-6">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 font-semibold">
                  {{ comment.name.charAt(0).toUpperCase() }}
                </div>
                <div class="flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="font-semibold text-slate-800">{{ comment.name }}</h3>
                  </div>
                  <div class="flex items-center gap-3 mt-1 text-sm text-slate-600">
                    <a :href="`mailto:${comment.email}`" class="hover:text-sky-600 transition-colors">{{ comment.email }}</a>
                    <span>•</span>
                    <span>{{ formatDate(comment.created_at) }}</span>
                    <span v-if="comment.article" class="text-sky-600">• {{ comment.article.title }}</span>
                  </div>
                </div>
              </div>
              <div class="ml-14 rounded-xl border border-sky-100 bg-slate-50 p-4">
                <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ comment.comment }}</p>
              </div>
              
              <!-- Reply Indicator -->
              <div v-if="comment.parent_id" class="ml-14 mt-3 text-sm text-slate-500">
                <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                Balasan untuk komentar
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <button
                @click="deleteComment(comment.id)"
                :disabled="deleting"
                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-colors hover:bg-red-100 disabled:opacity-50"
              >
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex items-center justify-center gap-2">
      <button
        @click="loadPage(pagination.current_page - 1)"
        :disabled="pagination.current_page === 1"
        class="rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-sky-50 disabled:opacity-50"
      >
        Sebelumnya
      </button>
      <span class="px-4 py-2 text-sm text-slate-600">
        Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}
      </span>
      <button
        @click="loadPage(pagination.current_page + 1)"
        :disabled="pagination.current_page === pagination.last_page"
        class="rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-sky-50 disabled:opacity-50"
      >
        Selanjutnya
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

interface Article {
  id: number
  title: string
}

interface Comment {
  id: number
  article_id: number
  parent_id: number | null
  name: string
  email: string
  comment: string
  is_approved: boolean
  created_at: string
  updated_at: string
  article?: Article
  parent?: Comment
}

const comments = ref<Comment[]>([])
const loading = ref(true)
const deleting = ref(false)
const pagination = ref<any>(null)

const totalComments = computed(() => comments.value.length)

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}, ${date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`
}

const fetchComments = async (page = 1) => {
  loading.value = true
  try {
    const response = await api.get(`/v1/comments?page=${page}`)
    if (response.data.data) {
      comments.value = response.data.data
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        per_page: response.data.per_page,
        total: response.data.total,
      }
    } else {
      comments.value = response.data
      pagination.value = null
    }
  } catch (error) {
    console.error('Error fetching comments:', error)
    comments.value = []
  } finally {
    loading.value = false
  }
}

const deleteComment = async (id: number) => {
  const confirmed = await swal.confirmDelete('Komentar yang dihapus tidak dapat dikembalikan')
  if (!confirmed) return

  deleting.value = true
  try {
    await api.delete(`/v1/comments/${id}`)
    comments.value = comments.value.filter(c => c.id !== id)
    await swal.success('Komentar berhasil dihapus')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus komentar')
  } finally {
    deleting.value = false
  }
}

const loadPage = (page: number) => {
  fetchComments(page)
}

onMounted(() => {
  fetchComments()
})
</script>


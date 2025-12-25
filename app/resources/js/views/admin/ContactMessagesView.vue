<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Pesan Kontak</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola pesan yang dikirim melalui form kontak</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-4 sm:grid-cols-3">
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-600">Total Pesan</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ messages.length }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-600">Belum Dibaca</p>
            <p class="mt-2 text-3xl font-bold text-sky-600">{{ unreadCount }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </div>
        </div>
      </div>
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-600">Sudah Dibaca</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ readCount }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-2 border-b border-sky-100">
      <button
        @click="filter = 'all'"
        :class="[
          'px-4 py-2 text-sm font-medium transition-colors',
          filter === 'all'
            ? 'border-b-2 border-sky-500 text-sky-600'
            : 'text-slate-600 hover:text-sky-600'
        ]"
      >
        Semua ({{ messages.length }})
      </button>
      <button
        @click="filter = 'unread'"
        :class="[
          'px-4 py-2 text-sm font-medium transition-colors',
          filter === 'unread'
            ? 'border-b-2 border-sky-500 text-sky-600'
            : 'text-slate-600 hover:text-sky-600'
        ]"
      >
        Belum Dibaca ({{ unreadCount }})
      </button>
      <button
        @click="filter = 'read'"
        :class="[
          'px-4 py-2 text-sm font-medium transition-colors',
          filter === 'read'
            ? 'border-b-2 border-sky-500 text-sky-600'
            : 'text-slate-600 hover:text-sky-600'
        ]"
      >
        Sudah Dibaca ({{ readCount }})
      </button>
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
      v-else-if="filteredMessages.length === 0"
      class="rounded-3xl border border-sky-100 bg-gradient-to-br from-slate-50 to-sky-50/30 p-16 text-center shadow-sm"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-sky-100">
        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Tidak Ada Pesan</h3>
      <p class="mt-2 text-slate-600">
        {{ filter === 'unread' ? 'Tidak ada pesan yang belum dibaca' : filter === 'read' ? 'Tidak ada pesan yang sudah dibaca' : 'Belum ada pesan yang diterima' }}
      </p>
    </div>

    <!-- Messages List -->
    <div v-else class="space-y-4">
      <div
        v-for="message in filteredMessages"
        :key="message.id"
        class="group relative overflow-hidden rounded-2xl border transition-all duration-300"
        :class="message.is_read ? 'border-sky-100 bg-white' : 'border-sky-200 bg-sky-50/50'"
      >
        <div class="p-6">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-3">
                <h3 class="text-lg font-bold text-slate-800">{{ message.name }}</h3>
                <span
                  v-if="!message.is_read"
                  class="inline-flex h-2 w-2 rounded-full bg-sky-500"
                ></span>
                <span
                  class="inline-block rounded-full px-3 py-1 text-xs font-semibold"
                  :class="message.is_read ? 'bg-green-100 text-green-700' : 'bg-sky-100 text-sky-700'"
                >
                  {{ message.is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                </span>
              </div>
              <div class="space-y-2 text-sm text-slate-600">
                <div class="flex items-center gap-2">
                  <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <a :href="`mailto:${message.email}`" class="hover:text-sky-600 transition-colors">{{ message.email }}</a>
                </div>
                <div class="flex items-center gap-2">
                  <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                  </svg>
                  <span>{{ message.subject }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{{ formatDate(message.created_at) }}</span>
                </div>
              </div>
              <div class="mt-4 rounded-xl border border-sky-100 bg-slate-50 p-4">
                <p class="text-sm leading-relaxed text-slate-700 whitespace-pre-wrap">{{ message.message }}</p>
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <button
                @click="toggleRead(message)"
                :disabled="updating"
                class="rounded-lg border px-3 py-2 text-xs font-semibold transition-colors disabled:opacity-50"
                :class="message.is_read 
                  ? 'border-sky-200 bg-sky-50 text-sky-600 hover:bg-sky-100' 
                  : 'border-green-200 bg-green-50 text-green-600 hover:bg-green-100'"
              >
                {{ message.is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
              </button>
              <button
                @click="deleteMessage(message.id)"
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

interface ContactMessage {
  id: number
  name: string
  email: string
  subject: string
  message: string
  is_read: boolean
  read_at: string | null
  created_at: string
  updated_at: string
}

const messages = ref<ContactMessage[]>([])
const loading = ref(true)
const updating = ref(false)
const deleting = ref(false)
const filter = ref<'all' | 'unread' | 'read'>('all')
const pagination = ref<any>(null)

const unreadCount = computed(() => {
  return messages.value.filter(m => !m.is_read).length
})

const readCount = computed(() => {
  return messages.value.filter(m => m.is_read).length
})

const filteredMessages = computed(() => {
  if (filter.value === 'unread') {
    return messages.value.filter(m => !m.is_read)
  } else if (filter.value === 'read') {
    return messages.value.filter(m => m.is_read)
  }
  return messages.value
})

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}, ${date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`
}

const fetchMessages = async (page = 1) => {
  loading.value = true
  try {
    const response = await api.get(`/v1/contact-messages?page=${page}`)
    if (response.data.data) {
      messages.value = response.data.data
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        per_page: response.data.per_page,
        total: response.data.total,
      }
    } else {
      messages.value = response.data
      pagination.value = null
    }
  } catch (error) {
    console.error('Error fetching messages:', error)
    messages.value = []
  } finally {
    loading.value = false
  }
}

const toggleRead = async (message: ContactMessage) => {
  updating.value = true
  try {
    await api.put(`/v1/contact-messages/${message.id}`, {
      is_read: !message.is_read,
    })
    message.is_read = !message.is_read
    message.read_at = message.is_read ? new Date().toISOString() : null
    await swal.success(`Pesan ${message.is_read ? 'ditandai sudah dibaca' : 'ditandai belum dibaca'}`)
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal mengupdate status pesan')
  } finally {
    updating.value = false
  }
}

const deleteMessage = async (id: number) => {
  const confirmed = await swal.confirmDelete('Pesan yang dihapus tidak dapat dikembalikan')
  if (!confirmed) return

  deleting.value = true
  try {
    await api.delete(`/v1/contact-messages/${id}`)
    messages.value = messages.value.filter(m => m.id !== id)
    await swal.success('Pesan berhasil dihapus')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus pesan')
  } finally {
    deleting.value = false
  }
}

const loadPage = (page: number) => {
  fetchMessages(page)
}

onMounted(() => {
  fetchMessages()
})
</script>


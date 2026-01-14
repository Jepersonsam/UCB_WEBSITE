<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Aplikasi Bergabung</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola aplikasi bergabung yang masuk</p>
      </div>
      <div class="flex gap-2">
        <button
          @click="exportToPDF"
          :disabled="loading || filteredApplications.length === 0"
          class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition-colors hover:bg-red-100 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          Export PDF
        </button>
        <button
          @click="exportToExcel"
          :disabled="loading || filteredApplications.length === 0"
          class="flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-600 transition-colors hover:bg-green-100 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Export Excel
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-4 sm:grid-cols-3">
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-600">Total Aplikasi</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ totalApplications }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-600">Belum Dibaca</p>
            <p class="mt-2 text-3xl font-bold text-yellow-600">{{ unreadCount }}</p>
          </div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-100">
            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
        Semua ({{ totalApplications }})
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
      v-else-if="filteredApplications.length === 0"
      class="rounded-3xl border border-sky-100 bg-gradient-to-br from-slate-50 to-sky-50/30 p-16 text-center shadow-sm"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-sky-100">
        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Tidak Ada Aplikasi</h3>
      <p class="mt-2 text-slate-600">
        {{ filter === 'unread' ? 'Tidak ada aplikasi yang belum dibaca' : filter === 'read' ? 'Tidak ada aplikasi yang sudah dibaca' : 'Belum ada aplikasi bergabung yang masuk' }}
      </p>
    </div>

    <!-- Applications List -->
    <div v-else class="space-y-4">
      <div
        v-for="application in filteredApplications"
        :key="application.id"
        class="group relative overflow-hidden rounded-2xl border transition-all duration-300"
        :class="application.is_read ? 'border-sky-100 bg-white' : 'border-yellow-200 bg-yellow-50/30'"
      >
        <div class="p-6">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 font-semibold">
                  {{ application.name.charAt(0).toUpperCase() }}
                </div>
                <div class="flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="font-semibold text-slate-800">{{ application.name }}</h3>
                    <span
                      v-if="!application.is_read"
                      class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700"
                    >
                      Baru
                    </span>
                  </div>
                  <div class="flex items-center gap-3 mt-1 text-sm text-slate-600">
                    <a :href="`mailto:${application.email}`" class="hover:text-sky-600 transition-colors">{{ application.email }}</a>
                    <span>•</span>
                    <a :href="`https://wa.me/${formatPhoneForWhatsApp(application.phone)}`" target="_blank" class="hover:text-sky-600 transition-colors">{{ application.phone }}</a>
                    <span>•</span>
                    <span>{{ formatDate(application.created_at) }}</span>
                  </div>
                </div>
              </div>
              
              <div class="ml-14 space-y-3">
                <div v-if="application.voice_part" class="rounded-xl border border-sky-100 bg-slate-50 p-4">
                  <p class="text-sm font-medium text-slate-700 mb-1">Part Suara yang Diinginkan</p>
                  <p class="text-slate-800 font-semibold">{{ application.voice_part }}</p>
                </div>
                <div v-if="application.experience" class="rounded-xl border border-sky-100 bg-slate-50 p-4">
                  <p class="text-sm font-medium text-slate-700 mb-1">Pengalaman Bernyanyi</p>
                  <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ application.experience }}</p>
                </div>
                <div v-if="application.reason" class="rounded-xl border border-sky-100 bg-slate-50 p-4">
                  <p class="text-sm font-medium text-slate-700 mb-1">Alasan Bergabung</p>
                  <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ application.reason }}</p>
                </div>
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <button
                @click="toggleReadStatus(application)"
                :disabled="updating"
                class="rounded-lg border px-3 py-2 text-xs font-semibold transition-colors disabled:opacity-50"
                :class="application.is_read 
                  ? 'border-yellow-200 bg-yellow-50 text-yellow-600 hover:bg-yellow-100' 
                  : 'border-green-200 bg-green-50 text-green-600 hover:bg-green-100'"
              >
                {{ application.is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
              </button>
              <button
                @click="deleteApplication(application.id)"
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

interface JoinApplication {
  id: number
  name: string
  email: string
  phone: string
  voice_part: string | null
  experience: string | null
  reason: string | null
  is_read: boolean
  read_at: string | null
  created_at: string
  updated_at: string
}

const applications = ref<JoinApplication[]>([])
const loading = ref(true)
const updating = ref(false)
const deleting = ref(false)
const filter = ref<'all' | 'unread' | 'read'>('all')
const pagination = ref<any>(null)

const totalApplications = computed(() => applications.value.length)
const unreadCount = computed(() => applications.value.filter(a => !a.is_read).length)
const readCount = computed(() => applications.value.filter(a => a.is_read).length)

const filteredApplications = computed(() => {
  if (filter.value === 'unread') {
    return applications.value.filter(a => !a.is_read)
  } else if (filter.value === 'read') {
    return applications.value.filter(a => a.is_read)
  }
  return applications.value
})

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}, ${date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`
}

const formatPhoneForWhatsApp = (phone: string) => {
  // Remove non-numeric characters
  let cleaned = phone.replace(/\D/g, '')
  // Replace leading '0' with '62' for Indonesia
  if (cleaned.startsWith('0')) {
    cleaned = '62' + cleaned.substring(1)
  }
  return cleaned
}

const fetchApplications = async (page = 1) => {
  loading.value = true
  try {
    const response = await api.get(`/v1/join-applications?page=${page}&filter=${filter.value}`)
    if (response.data.data) {
      applications.value = response.data.data
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        per_page: response.data.per_page,
        total: response.data.total,
      }
    } else {
      applications.value = response.data
      pagination.value = null
    }
  } catch (error) {
    console.error('Error fetching applications:', error)
    applications.value = []
  } finally {
    loading.value = false
  }
}

const toggleReadStatus = async (application: JoinApplication) => {
  updating.value = true
  try {
    await api.put(`/v1/join-applications/${application.id}`, {
      is_read: !application.is_read,
    })
    application.is_read = !application.is_read
    if (application.is_read) {
      application.read_at = new Date().toISOString()
    } else {
      application.read_at = null
    }
    await swal.success(`Aplikasi ${application.is_read ? 'ditandai sudah dibaca' : 'ditandai belum dibaca'}`)
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal mengupdate status aplikasi')
  } finally {
    updating.value = false
  }
}

const deleteApplication = async (id: number) => {
  const confirmed = await swal.confirmDelete('Aplikasi yang dihapus tidak dapat dikembalikan')
  if (!confirmed) return

  deleting.value = true
  try {
    await api.delete(`/v1/join-applications/${id}`)
    applications.value = applications.value.filter(a => a.id !== id)
    await swal.success('Aplikasi berhasil dihapus')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus aplikasi')
  } finally {
    deleting.value = false
  }
}

const loadPage = (page: number) => {
  fetchApplications(page)
}

const exportToPDF = async () => {
  try {
    const filterParam = filter.value !== 'all' ? `&filter=${filter.value}` : ''
    const response = await api.get(`/v1/join-applications/export/pdf${filterParam}`, {
      responseType: 'blob',
    })
    
    // Create blob link to download
    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `aplikasi-bergabung-${new Date().toISOString().split('T')[0]}.pdf`)
    document.body.appendChild(link)
    link.click()
    link.remove()
    window.URL.revokeObjectURL(url)
    
    await swal.success('PDF berhasil diekspor')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal mengekspor PDF')
  }
}

const exportToExcel = async () => {
  try {
    const filterParam = filter.value !== 'all' ? `&filter=${filter.value}` : ''
    const response = await api.get(`/v1/join-applications/export/excel${filterParam}`, {
      responseType: 'blob',
    })
    
    // Create blob link to download
    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', `aplikasi-bergabung-${new Date().toISOString().split('T')[0]}.xlsx`)
    document.body.appendChild(link)
    link.click()
    link.remove()
    window.URL.revokeObjectURL(url)
    
    await swal.success('Excel berhasil diekspor')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal mengekspor Excel')
  }
}

onMounted(() => {
  fetchApplications()
})
</script>


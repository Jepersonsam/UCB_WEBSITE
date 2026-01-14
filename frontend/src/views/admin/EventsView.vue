<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Event</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola jadwal dan event</p>
      </div>
      <button
        @click="showFormModal = true; editingEvent = null"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02]"
      >
        + Buat Event
      </button>
    </div>

    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="h-32 animate-pulse rounded-xl bg-sky-100"></div>
    </div>
    <div v-else-if="events.length === 0" class="rounded-2xl border border-sky-100 bg-white p-12 text-center">
      <p class="text-slate-600">Belum ada event. Buat event pertama Anda!</p>
    </div>
    <div v-else class="space-y-4">
      <div
        v-for="event in events"
        :key="event.id"
        class="rounded-xl border border-sky-100 bg-white p-6 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
      >
        <div class="flex items-start justify-between">
          <div class="flex-1">
            <h3 class="text-lg font-semibold text-slate-900">{{ event.title }}</h3>
            <p class="mt-1 text-sm text-slate-600">{{ event.description || '-' }}</p>
            <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-500">
              <span class="flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ formatDate(event.start_date) }}
              </span>
              <span v-if="event.location" class="flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ event.location }}
              </span>
              <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700">{{ event.event_type }}</span>
            </div>
          </div>
          <div class="ml-4 flex gap-2">
            <button
              @click="editEvent(event)"
              class="rounded-lg px-4 py-2 text-sm text-sky-600 transition-colors hover:bg-sky-50"
            >
              Edit
            </button>
            <button
              @click="deleteEvent(event.id)"
              class="rounded-lg px-4 py-2 text-sm text-red-600 transition-colors hover:bg-red-50"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Modal -->
    <div
      v-if="showFormModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="showFormModal = false"
    >
      <div class="w-full max-w-2xl rounded-2xl border border-sky-100 bg-white p-6 shadow-xl">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">{{ editingEvent ? 'Edit Event' : 'Buat Event' }}</h3>
        <form @submit.prevent="saveEvent" class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul *</label>
            <input v-model="form.title" type="text" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai *</label>
              <input v-model="form.start_date" type="datetime-local" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Selesai</label>
              <input v-model="form.end_date" type="datetime-local" class="w-full rounded-xl border border-sky-200 px-4 py-2" />
            </div>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Tipe Event *</label>
            <input v-model="form.event_type" type="text" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Lokasi</label>
            <input v-model="form.location" type="text" class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea v-model="form.description" rows="4" class="w-full rounded-xl border border-sky-200 px-4 py-2"></textarea>
          </div>
          <div class="flex gap-3">
            <button type="button" @click="showFormModal = false" class="flex-1 rounded-xl border border-sky-200 px-4 py-2 text-sm font-semibold">
              Batal
            </button>
            <button type="submit" :disabled="saving" class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50">
              {{ saving ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const events = ref<any[]>([])
const loading = ref(true)
const showFormModal = ref(false)
const editingEvent = ref<any>(null)
const saving = ref(false)

const form = ref({
  title: '',
  description: '',
  event_type: '',
  start_date: '',
  end_date: '',
  location: '',
  venue: '',
})

const fetchEvents = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/events')
    events.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching events:', error)
  } finally {
    loading.value = false
  }
}

const editEvent = (event: any) => {
  editingEvent.value = event
  form.value = {
    title: event.title,
    description: event.description || '',
    event_type: event.event_type,
    start_date: event.start_date ? new Date(event.start_date).toISOString().slice(0, 16) : '',
    end_date: event.end_date ? new Date(event.end_date).toISOString().slice(0, 16) : '',
    location: event.location || '',
    venue: event.venue || '',
  }
  showFormModal.value = true
}

const saveEvent = async () => {
  saving.value = true
  try {
    if (editingEvent.value) {
      await api.put(`/v1/events/${editingEvent.value.id}`, form.value)
    } else {
      await api.post('/v1/events', form.value)
    }
    showFormModal.value = false
    editingEvent.value = null
    form.value = { title: '', description: '', event_type: '', start_date: '', end_date: '', location: '', venue: '' }
    await fetchEvents()
  } catch (error: any) {
    let errorMessage = 'Gagal menyimpan event'
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      const firstError = Object.values(errors)[0]
      if (Array.isArray(firstError) && firstError.length > 0) {
        errorMessage = firstError[0]
      }
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    }
    await swal.error(errorMessage)
    console.error('Error saving event:', error)
  } finally {
    saving.value = false
  }
}

const deleteEvent = async (id: number) => {
  const result = await swal.confirmDelete('event ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/events/${id}`)
    await fetchEvents()
    await swal.success('Event berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus event')
    console.error('Error deleting event:', error)
  }
}

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(() => {
  fetchEvents()
})
</script>

<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Jadwal Audisi</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola jadwal audisi penerimaan member baru</p>
      </div>
      <button
        @click="openCreateModal"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl"
      >
        + Tambah Jadwal Audisi
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
      v-else-if="schedules.length === 0"
      class="rounded-3xl border border-sky-100 bg-gradient-to-br from-slate-50 to-sky-50/30 p-16 text-center shadow-sm"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-sky-100">
        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Jadwal Audisi</h3>
      <p class="mt-2 text-slate-600">Tambahkan jadwal audisi pertama untuk memulai</p>
    </div>

    <!-- Schedules List -->
    <div v-else class="space-y-4">
      <div
        v-for="schedule in schedules"
        :key="schedule.id"
        class="group relative overflow-hidden rounded-2xl border transition-all duration-300"
        :class="schedule.is_active ? 'border-sky-100 bg-white' : 'border-slate-200 bg-slate-50'"
      >
        <div class="p-6">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-3 mb-3">
                <div class="flex-shrink-0 rounded-xl border-2 border-sky-200 bg-sky-50 p-4 text-center">
                  <p class="text-2xl font-bold text-sky-600">{{ formatDay(schedule.audition_date) }}</p>
                  <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-600">{{ formatMonth(schedule.audition_date) }}</p>
                </div>
                <div class="flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="text-xl font-bold text-slate-800">{{ schedule.title }}</h3>
                    <span
                      class="inline-block rounded-full px-3 py-1 text-xs font-semibold"
                      :class="schedule.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600'"
                    >
                      {{ schedule.is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    <span
                      v-if="isUpcoming(schedule.audition_date)"
                      class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700"
                    >
                      Akan Datang
                    </span>
                  </div>
                  <div class="mt-2 space-y-1 text-sm text-slate-600">
                    <div class="flex items-center gap-2">
                      <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>{{ formatTime(schedule.start_time) }}<span v-if="schedule.end_time"> - {{ formatTime(schedule.end_time) }}</span></span>
                    </div>
                    <div v-if="schedule.location" class="flex items-center gap-2">
                      <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <span>{{ schedule.location }}</span>
                    </div>
                    <div v-if="schedule.max_participants" class="flex items-center gap-2">
                      <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span>Maksimal {{ schedule.max_participants }} peserta</span>
                    </div>
                  </div>
                  <div v-if="schedule.description" class="mt-3 rounded-xl border border-sky-100 bg-slate-50 p-4">
                    <p class="text-sm text-slate-700 leading-relaxed">{{ schedule.description }}</p>
                  </div>
                  <div v-if="schedule.requirements" class="mt-3 rounded-xl border border-sky-100 bg-sky-50/50 p-4">
                    <p class="text-xs font-semibold text-slate-700 mb-2">Persyaratan:</p>
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ schedule.requirements }}</p>
                  </div>
                  <div v-if="schedule.notes" class="mt-3 rounded-xl border border-amber-100 bg-amber-50/50 p-4">
                    <p class="text-xs font-semibold text-amber-700 mb-2">Catatan:</p>
                    <p class="text-sm text-amber-800 leading-relaxed whitespace-pre-wrap">{{ schedule.notes }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <button
                @click="openEditModal(schedule)"
                class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-600 transition-colors hover:bg-sky-100"
              >
                Edit
              </button>
              <button
                @click="toggleActive(schedule)"
                :disabled="updating"
                class="rounded-lg border px-3 py-2 text-xs font-semibold transition-colors disabled:opacity-50"
                :class="schedule.is_active 
                  ? 'border-yellow-200 bg-yellow-50 text-yellow-600 hover:bg-yellow-100' 
                  : 'border-green-200 bg-green-50 text-green-600 hover:bg-green-100'"
              >
                {{ schedule.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
              </button>
              <button
                @click="deleteSchedule(schedule.id)"
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

    <!-- Create/Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="closeModal"
    >
      <div class="w-full max-w-2xl rounded-2xl border border-sky-100 bg-white p-6 shadow-xl lg:p-8 max-h-[90vh] overflow-y-auto">
        <div class="mb-6 flex items-center justify-between">
          <h2 class="text-2xl font-bold text-slate-800">{{ editingSchedule ? 'Edit Jadwal Audisi' : 'Tambah Jadwal Audisi' }}</h2>
          <button
            @click="closeModal"
            class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveSchedule" class="space-y-5">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul *</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Contoh: Audisi Penerimaan Member Baru 2025"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea
              v-model="form.description"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Deskripsi singkat tentang audisi ini"
            ></textarea>
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Audisi *</label>
              <input
                v-model="form.audition_date"
                type="date"
                required
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Lokasi</label>
              <input
                v-model="form.location"
                type="text"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="Contoh: Aula UNAI, Bandung"
              />
            </div>
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Jam Mulai *</label>
              <input
                v-model="form.start_time"
                type="time"
                required
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Jam Selesai</label>
              <input
                v-model="form.end_time"
                type="time"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Maksimal Peserta</label>
              <input
                v-model.number="form.max_participants"
                type="number"
                min="1"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="Kosongkan untuk tidak terbatas"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
              <select
                v-model="form.is_active"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              >
                <option :value="true">Aktif</option>
                <option :value="false">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Persyaratan</label>
            <textarea
              v-model="form.requirements"
              rows="4"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Contoh:&#10;1. Usia 17-30 tahun&#10;2. Memiliki passion untuk musik&#10;3. Siap mengikuti latihan rutin"
            ></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Catatan</label>
            <textarea
              v-model="form.notes"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Catatan tambahan untuk peserta"
            ></textarea>
          </div>
          <div class="flex gap-3 pt-4">
            <button
              type="submit"
              :disabled="saving"
              class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] disabled:opacity-50"
            >
              {{ saving ? 'Menyimpan...' : 'Simpan' }}
            </button>
            <button
              type="button"
              @click="closeModal"
              class="rounded-xl border border-sky-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition-all hover:bg-sky-50"
            >
              Batal
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

interface AuditionSchedule {
  id: number
  title: string
  description: string | null
  audition_date: string
  start_time: string
  end_time: string | null
  location: string | null
  requirements: string | null
  notes: string | null
  is_active: boolean
  max_participants: number | null
  created_at: string
  updated_at: string
}

const schedules = ref<AuditionSchedule[]>([])
const loading = ref(true)
const saving = ref(false)
const updating = ref(false)
const deleting = ref(false)
const showModal = ref(false)
const editingSchedule = ref<AuditionSchedule | null>(null)

const form = ref({
  title: '',
  description: '',
  audition_date: '',
  start_time: '',
  end_time: '',
  location: '',
  requirements: '',
  notes: '',
  is_active: true,
  max_participants: null as number | null,
})

const formatDay = (dateString: string) => {
  const date = new Date(dateString)
  return date.getDate().toString().padStart(2, '0')
}

const formatMonth = (dateString: string) => {
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return months[date.getMonth()]
}

const formatTime = (timeString: string) => {
  if (!timeString) return ''
  const [hours, minutes] = timeString.split(':')
  return `${hours}:${minutes} WIB`
}

const isUpcoming = (dateString: string) => {
  const date = new Date(dateString)
  date.setHours(0, 0, 0, 0)
  const today = new Date()
  today.setHours(0, 0, 0, 0)
  return date >= today
}

const fetchSchedules = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/audition-schedules')
    schedules.value = response.data || []
  } catch (error) {
    console.error('Error fetching schedules:', error)
    schedules.value = []
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  editingSchedule.value = null
  form.value = {
    title: '',
    description: '',
    audition_date: '',
    start_time: '',
    end_time: '',
    location: '',
    requirements: '',
    notes: '',
    is_active: true,
    max_participants: null,
  }
  showModal.value = true
}

const openEditModal = (schedule: AuditionSchedule) => {
  editingSchedule.value = schedule
  form.value = {
    title: schedule.title,
    description: schedule.description || '',
    audition_date: schedule.audition_date,
    start_time: schedule.start_time,
    end_time: schedule.end_time || '',
    location: schedule.location || '',
    requirements: schedule.requirements || '',
    notes: schedule.notes || '',
    is_active: schedule.is_active,
    max_participants: schedule.max_participants,
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingSchedule.value = null
}

const saveSchedule = async () => {
  saving.value = true
  try {
    const data = {
      ...form.value,
      max_participants: form.value.max_participants || null,
    }

    if (editingSchedule.value) {
      await api.put(`/v1/audition-schedules/${editingSchedule.value.id}`, data)
      await swal.success('Jadwal audisi berhasil diperbarui!')
    } else {
      await api.post('/v1/audition-schedules', data)
      await swal.success('Jadwal audisi berhasil ditambahkan!')
    }

    closeModal()
    await fetchSchedules()
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menyimpan jadwal audisi')
  } finally {
    saving.value = false
  }
}

const toggleActive = async (schedule: AuditionSchedule) => {
  updating.value = true
  try {
    await api.put(`/v1/audition-schedules/${schedule.id}`, {
      ...schedule,
      is_active: !schedule.is_active,
    })
    schedule.is_active = !schedule.is_active
    await swal.success(`Jadwal audisi ${schedule.is_active ? 'diaktifkan' : 'dinonaktifkan'}`)
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal mengupdate status jadwal')
  } finally {
    updating.value = false
  }
}

const deleteSchedule = async (id: number) => {
  const confirmed = await swal.confirmDelete('Jadwal audisi yang dihapus tidak dapat dikembalikan')
  if (!confirmed) return

  deleting.value = true
  try {
    await api.delete(`/v1/audition-schedules/${id}`)
    schedules.value = schedules.value.filter(s => s.id !== id)
    await swal.success('Jadwal audisi berhasil dihapus')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus jadwal audisi')
  } finally {
    deleting.value = false
  }
}

onMounted(() => {
  fetchSchedules()
})
</script>


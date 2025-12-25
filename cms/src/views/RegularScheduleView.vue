<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Jadwal Latihan Reguler</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola jadwal latihan reguler UCB</p>
    </div>

    <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm lg:p-8">
      <form @submit.prevent="saveSchedule" class="space-y-6">
        <div>
          <label class="mb-3 block text-sm font-semibold text-slate-700">Jadwal Latihan</label>
          <div class="space-y-4">
            <div
              v-for="(schedule, index) in schedules"
              :key="index"
              class="rounded-xl border border-sky-100 bg-slate-50 p-5"
            >
              <div class="grid gap-4 sm:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-medium text-slate-700">Hari *</label>
                  <select
                    v-model="schedule.day"
                    required
                    class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  >
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                  </select>
                </div>
                <div>
                  <label class="mb-2 block text-sm font-medium text-slate-700">Waktu *</label>
                  <select
                    v-model="schedule.time"
                    required
                    class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  >
                    <option value="">Pilih Waktu</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Sore">Sore</option>
                    <option value="Malam">Malam</option>
                  </select>
                </div>
              </div>
              <div class="grid gap-4 sm:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-medium text-slate-700">Jam Mulai *</label>
                  <input
                    v-model="schedule.start_hour"
                    type="time"
                    required
                    class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  />
                </div>
                <div>
                  <label class="mb-2 block text-sm font-medium text-slate-700">Jam Selesai *</label>
                  <input
                    v-model="schedule.end_hour"
                    type="time"
                    required
                    class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  />
                </div>
              </div>
              <div class="mt-4">
                <label class="mb-2 block text-sm font-medium text-slate-700">Lokasi (Opsional)</label>
                <input
                  v-model="schedule.location"
                  type="text"
                  placeholder="Contoh: Aula UNAI, Bandung"
                  class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                />
              </div>
              <div class="mt-4">
                <label class="mb-2 block text-sm font-medium text-slate-700">Keterangan (Opsional)</label>
                <textarea
                  v-model="schedule.description"
                  rows="2"
                  placeholder="Contoh: Latihan untuk semua part suara"
                  class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                ></textarea>
              </div>
              <button
                v-if="schedules.length > 1"
                type="button"
                @click="removeSchedule(index)"
                class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-100"
              >
                Hapus Jadwal
              </button>
            </div>
          </div>
          <button
            type="button"
            @click="addSchedule"
            class="mt-4 rounded-lg border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-medium text-sky-600 transition-colors hover:bg-sky-100"
          >
            + Tambah Jadwal
          </button>
        </div>

        <div v-if="saveSuccess" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
          Jadwal latihan reguler berhasil disimpan!
        </div>
        <div v-if="saveError" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
          {{ saveError }}
        </div>

        <div class="flex gap-3">
          <button
            type="submit"
            :disabled="saving"
            class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] disabled:opacity-50"
          >
            {{ saving ? 'Menyimpan...' : 'Simpan Jadwal' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'

interface Schedule {
  day: string
  time: string
  start_hour: string
  end_hour: string
  location: string
  description: string
}

const defaultSchedules: Schedule[] = [
  { day: 'Senin', time: 'Malam', start_hour: '19:00', end_hour: '21:00', location: 'UNAI, Bandung', description: '' },
  { day: 'Jumat', time: 'Malam', start_hour: '19:00', end_hour: '21:00', location: 'UNAI, Bandung', description: '' },
  { day: 'Sabtu', time: 'Siang', start_hour: '14:00', end_hour: '16:00', location: 'UNAI, Bandung', description: '' },
]

const schedules = ref<Schedule[]>([...defaultSchedules])
const saving = ref(false)
const saveSuccess = ref(false)
const saveError = ref('')

const addSchedule = () => {
  schedules.value.push({
    day: '',
    time: '',
    start_hour: '',
    end_hour: '',
    location: '',
    description: '',
  })
}

const removeSchedule = (index: number) => {
  if (schedules.value.length > 1) {
    schedules.value.splice(index, 1)
  }
}

const fetchSchedule = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data

    if (data.regular_schedule_content) {
      try {
        const parsed = typeof data.regular_schedule_content === 'string'
          ? JSON.parse(data.regular_schedule_content)
          : data.regular_schedule_content

        if (parsed.schedules && Array.isArray(parsed.schedules) && parsed.schedules.length > 0) {
          schedules.value = parsed.schedules
        }
      } catch (e) {
        console.error('Error parsing regular_schedule_content:', e)
      }
    }
  } catch (error) {
    console.error('Error fetching regular schedule:', error)
  }
}

const saveSchedule = async () => {
  saving.value = true
  saveSuccess.value = false
  saveError.value = ''

  try {
    // Validasi: pastikan semua jadwal memiliki day, time, start_hour, dan end_hour
    for (const schedule of schedules.value) {
      if (!schedule.day || !schedule.time || !schedule.start_hour || !schedule.end_hour) {
        saveError.value = 'Semua jadwal harus memiliki hari, waktu, jam mulai, dan jam selesai'
        saving.value = false
        return
      }
    }

    const scheduleData = {
      schedules: schedules.value,
    }

    await api.put('/v1/settings', {
      settings: {
        regular_schedule_content: JSON.stringify(scheduleData),
      },
    })

    saveSuccess.value = true
    setTimeout(() => {
      saveSuccess.value = false
    }, 3000)
  } catch (error: any) {
    saveError.value = error.response?.data?.message || 'Gagal menyimpan jadwal latihan reguler'
    console.error('Error saving regular schedule:', error)
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchSchedule()
})
</script>


<template>
  <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8 sm:space-y-12">
    <!-- Header Section -->
    <div class="text-center" data-aos="fade-down">
      <h1 class="text-3xl font-bold text-slate-800 sm:text-4xl lg:text-5xl">Jadwal & Event</h1>
      <p class="mt-3 sm:mt-4 text-base sm:text-lg text-slate-600">Pelayanan, konser, dan latihan mendatang Unceasing Cantica Bandung</p>
      <div class="mt-4 sm:mt-6 flex justify-center">
        <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
      </div>
    </div>

    <!-- Audition Schedules Section -->
    <section class="rounded-2xl sm:rounded-3xl border border-amber-100 bg-gradient-to-br from-amber-50/50 to-white p-6 sm:p-8 shadow-lg lg:p-10" data-aos="fade-up" data-aos-duration="800">
      <div class="mb-6 flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100">
          <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Jadwal Audisi Penerimaan Member Baru</h2>
          <p class="text-sm text-slate-600">Jadwal audisi untuk bergabung dengan UCB</p>
        </div>
      </div>
      
      <!-- Empty State -->
      <div
        v-if="auditionSchedules.length === 0"
        class="rounded-2xl border border-amber-100 bg-white p-12 text-center"
      >
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-50">
          <svg
            class="h-8 w-8 text-amber-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            />
          </svg>
        </div>
        <h3 class="mt-4 text-lg font-semibold text-slate-800">Belum Ada Jadwal Audisi</h3>
        <p class="mt-2 text-sm text-slate-600">Tidak ada jadwal audisi yang tersedia saat ini.</p>
      </div>
      
      <!-- Audition Schedules Grid -->
      <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(schedule, index) in auditionSchedules"
          :key="schedule.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-amber-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-amber-300 hover:shadow-xl hover:shadow-amber-100/50 hover:scale-[1.02]"
        >
          <div class="absolute right-0 top-0 h-20 w-20 rounded-bl-full bg-gradient-to-br from-amber-50 to-transparent opacity-60"></div>
          <div class="relative">
            <div class="mb-3 flex items-center gap-2">
              <div class="flex-shrink-0 rounded-xl border-2 border-amber-200 bg-amber-50 p-3 text-center">
                <p class="text-xl font-bold text-amber-600">{{ formatDay(schedule.audition_date) }}</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-600">{{ formatMonth(schedule.audition_date) }}</p>
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-bold text-slate-800 line-clamp-2">{{ schedule.title }}</h3>
                <div class="mt-1 flex items-center gap-2 text-sm text-amber-600">
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{{ formatTimeFromString(schedule.start_time) }}<span v-if="schedule.end_time"> - {{ formatTimeFromString(schedule.end_time) }}</span></span>
                </div>
              </div>
            </div>
            <div v-if="schedule.location" class="mt-3 flex items-start gap-2 text-sm text-slate-600">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="line-clamp-2">{{ schedule.location }}</span>
            </div>
            <p v-if="schedule.description" class="mt-3 text-sm leading-relaxed text-slate-600 line-clamp-2">
              {{ schedule.description }}
            </p>
            <div v-if="schedule.requirements" class="mt-3 rounded-lg border border-amber-100 bg-amber-50/50 p-3">
              <p class="text-xs font-semibold text-amber-700 mb-1">Persyaratan:</p>
              <p class="text-xs text-amber-800 leading-relaxed line-clamp-3 whitespace-pre-wrap">{{ schedule.requirements }}</p>
            </div>
            <div v-if="schedule.max_participants" class="mt-3 flex items-center gap-2 text-xs text-slate-500">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span>Maksimal {{ schedule.max_participants }} peserta</span>
            </div>
            <RouterLink
              to="/join"
              class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition-all hover:bg-amber-100 hover:text-amber-800"
            >
              Daftar Sekarang
              <span>→</span>
            </RouterLink>
          </div>
        </div>
      </div>
    </section>

    <!-- Regular Schedule Section -->
    <section v-if="regularSchedules.length > 0" class="rounded-2xl sm:rounded-3xl border border-indigo-100 bg-gradient-to-br from-indigo-50/50 to-white p-6 sm:p-8 shadow-lg lg:p-10" data-aos="fade-up" data-aos-duration="800">
      <div class="mb-6 flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100">
          <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Jadwal Latihan Reguler</h2>
          <p class="text-sm text-slate-600">Jadwal latihan rutin setiap minggu</p>
        </div>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(schedule, index) in regularSchedules"
          :key="index"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-xl hover:shadow-sky-100/50 hover:scale-[1.02]"
        >
          <div class="absolute right-0 top-0 h-20 w-20 rounded-bl-full bg-gradient-to-br from-indigo-50 to-transparent opacity-60"></div>
          <div class="relative">
            <div class="mb-3 flex items-center gap-2">
              <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100">
                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="flex-1">
                <h3 class="text-lg font-bold text-slate-800">{{ schedule.day }}</h3>
                <div class="mt-1 flex items-center gap-2">
                  <p class="text-sm font-medium text-indigo-600">{{ schedule.time }}</p>
                  <span v-if="schedule.start_hour && schedule.end_hour" class="text-sm font-semibold text-slate-700">
                    • {{ formatHour(schedule.start_hour) }} - {{ formatHour(schedule.end_hour) }}
                  </span>
                  <span v-else-if="schedule.hour" class="text-sm font-semibold text-slate-700">
                    • {{ formatHour(schedule.hour) }}
                  </span>
                </div>
              </div>
            </div>
            <div v-if="schedule.location" class="mt-3 flex items-start gap-2 text-sm text-slate-600">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="line-clamp-2">{{ schedule.location }}</span>
            </div>
            <p v-if="schedule.description" class="mt-3 text-sm leading-relaxed text-slate-600">
              {{ schedule.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Events Section -->
    <section class="rounded-2xl sm:rounded-3xl border border-indigo-100 bg-gradient-to-br from-indigo-50/50 to-white p-6 sm:p-8 shadow-lg lg:p-10" data-aos="fade-up" data-aos-duration="800">
      <div class="mb-6 flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100">
          <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Event Terdekat</h2>
          <p class="text-sm text-slate-600">Pelayanan, konser, dan kegiatan mendatang</p>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="i in 6"
          :key="i"
          class="overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-slate-50 to-indigo-50 p-6 shadow-sm"
        >
          <div class="flex items-start gap-5">
            <div class="h-20 w-20 animate-pulse rounded-xl bg-indigo-100"></div>
            <div class="flex-1 space-y-3">
              <div class="h-4 w-20 animate-pulse rounded bg-indigo-100"></div>
              <div class="h-5 w-3/4 animate-pulse rounded bg-indigo-100"></div>
              <div class="h-4 w-full animate-pulse rounded bg-indigo-50"></div>
              <div class="h-4 w-2/3 animate-pulse rounded bg-indigo-50"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div
        v-else-if="events.length === 0"
        class="rounded-3xl border border-indigo-100 bg-gradient-to-br from-slate-50 to-indigo-50/30 p-16 text-center shadow-sm"
      >
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-indigo-100">
          <svg
            class="h-10 w-10 text-indigo-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            />
          </svg>
        </div>
        <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Event</h3>
        <p class="mt-2 text-slate-600">Tidak ada event yang dijadwalkan saat ini.</p>
      </div>

      <!-- Events List -->
      <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(event, index) in events"
          :key="event.id"
          :data-aos="'fade-up'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-white p-6 shadow-md transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-2xl hover:shadow-sky-200/50 hover:scale-[1.02]"
        >
          <!-- Decorative gradient corner -->
          <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-gradient-to-br from-indigo-50 to-transparent opacity-60"></div>
          
          <div class="relative flex items-start gap-5">
            <!-- Date Badge -->
            <div class="flex-shrink-0 rounded-xl border-2 border-indigo-200 bg-gradient-to-br from-indigo-50 to-white p-4 text-center shadow-sm">
              <p class="text-2xl font-bold text-indigo-600">{{ formatDay(event.start_date) }}</p>
              <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-600">{{ formatMonth(event.start_date) }}</p>
            </div>
            
            <!-- Event Info -->
            <div class="flex-1 min-w-0">
              <div class="mb-3">
                <span
                  class="inline-block rounded-full border border-indigo-300 bg-gradient-to-r from-indigo-50 to-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700 shadow-sm"
                >
                  {{ event.event_type }}
                </span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 leading-tight">{{ event.title }}</h3>
              <p v-if="event.description" class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-600">
                {{ event.description }}
              </p>
              <div class="mt-5 space-y-2.5">
                <div v-if="event.location || event.venue" class="flex items-start gap-2.5 text-sm text-slate-600">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
                  <span class="line-clamp-1">
                    <span v-if="event.venue" class="font-medium">{{ event.venue }}</span>
                    <span v-if="event.venue && event.location">, </span>
                    <span v-if="event.location">{{ event.location }}</span>
                  </span>
                </div>
                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                <svg class="h-4 w-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                  <span class="font-medium">{{ formatTime(event.start_date) }}</span>
                  <span v-if="event.end_date" class="text-slate-400">-</span>
                  <span v-if="event.end_date">{{ formatTime(event.end_date) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'

interface Event {
  id: number
  title: string
  description: string | null
  event_type: string
  start_date: string
  end_date: string | null
  location: string | null
  venue: string | null
}

interface RegularSchedule {
  day: string
  time: string
  start_hour?: string
  end_hour?: string
  hour?: string // Untuk backward compatibility
  location: string
  description: string
}

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

const defaultRegularSchedules: RegularSchedule[] = [
  { day: 'Senin', time: 'Malam', start_hour: '19:00', end_hour: '21:00', location: 'UNAI, Bandung', description: '' },
  { day: 'Jumat', time: 'Malam', start_hour: '19:00', end_hour: '21:00', location: 'UNAI, Bandung', description: '' },
  { day: 'Sabtu', time: 'Siang', start_hour: '14:00', end_hour: '16:00', location: 'UNAI, Bandung', description: '' },
]

const events = ref<Event[]>([])
const regularSchedules = ref<RegularSchedule[]>([])
const auditionSchedules = ref<AuditionSchedule[]>([])
const loading = ref(true)

const formatDay = (dateString: string) => {
  const date = new Date(dateString)
  return date.getDate().toString().padStart(2, '0')
}

const formatMonth = (dateString: string) => {
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return months[date.getMonth()]
}

const formatTime = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
}

const formatTimeFromString = (timeString: string) => {
  if (!timeString) return ''
  const [hours, minutes] = timeString.split(':')
  return `${hours}:${minutes} WIB`
}

const formatHour = (hourString: string) => {
  if (!hourString) return ''
  // Format dari "19:00" menjadi "19:00 WIB"
  return `${hourString} WIB`
}

const fetchRegularSchedule = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data

    if (data.regular_schedule_content) {
      try {
        const parsed = typeof data.regular_schedule_content === 'string'
          ? JSON.parse(data.regular_schedule_content)
          : data.regular_schedule_content

        if (parsed.schedules && Array.isArray(parsed.schedules) && parsed.schedules.length > 0) {
          regularSchedules.value = parsed.schedules
        } else {
          regularSchedules.value = [...defaultRegularSchedules]
        }
      } catch (e) {
        console.error('Error parsing regular_schedule_content:', e)
        regularSchedules.value = [...defaultRegularSchedules]
      }
    } else {
      regularSchedules.value = [...defaultRegularSchedules]
    }
  } catch (error) {
    console.error('Error fetching regular schedule:', error)
    regularSchedules.value = [...defaultRegularSchedules]
  }
}

const fetchAuditionSchedules = async () => {
  try {
    // Fetch jadwal audisi yang aktif dan akan datang
    // Backend sudah otomatis filter is_active untuk public access
    const response = await api.get('/v1/audition-schedules?filter=upcoming')
    
    // Backend mengembalikan langsung array, bukan pagination
    if (Array.isArray(response.data)) {
      auditionSchedules.value = response.data
    } else if (response.data.data && Array.isArray(response.data.data)) {
      auditionSchedules.value = response.data.data
    } else {
      auditionSchedules.value = []
    }
  } catch (error) {
    console.error('Error fetching audition schedules:', error)
    auditionSchedules.value = []
  }
}

onMounted(async () => {
  try {
    loading.value = true
    await fetchRegularSchedule()
    await fetchAuditionSchedules()
    
    const response = await api.get('/v1/events')
    
    if (response.data.data) {
      // Jika menggunakan pagination
      events.value = response.data.data
    } else if (Array.isArray(response.data)) {
      // Jika langsung array
      events.value = response.data
    } else {
      events.value = []
    }
  } catch (error) {
    console.error('Error fetching events:', error)
    events.value = []
  } finally {
    loading.value = false
  }
})
</script>


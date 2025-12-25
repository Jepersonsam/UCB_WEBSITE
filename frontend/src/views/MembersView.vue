<template>
  <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8 sm:space-y-12">
    <div class="text-center" data-aos="fade-down">
      <h1 class="text-3xl font-bold text-slate-800 mb-2 sm:mb-3 sm:text-4xl lg:text-5xl">Member Aktif</h1>
      <p class="text-sm sm:text-base text-slate-600">Para anggota yang aktif melayani dalam Unceasing Cantica Bandung</p>
      <div class="mt-4 sm:mt-6 flex justify-center">
        <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
      </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex flex-wrap justify-center gap-2 sm:gap-3" data-aos="fade-up" data-aos-delay="100">
      <button
        @click="selectedRole = 'Semua'"
        class="rounded-xl px-6 py-3 text-sm font-semibold transition-all"
        :class="selectedRole === 'Semua' 
          ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' 
          : 'bg-white text-slate-700 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-200'"
      >
        Semua
      </button>
      <button
        v-for="role in roles"
        :key="role"
        @click="selectedRole = role"
        class="rounded-xl px-6 py-3 text-sm font-semibold transition-all"
        :class="selectedRole === role 
          ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' 
          : 'bg-white text-slate-700 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-200'"
      >
        {{ role }}
        <span v-if="getMembersByRole(role).length > 0" class="ml-2 rounded-full bg-indigo-100 px-2 py-0.5 text-xs text-indigo-700">
          {{ getMembersByRole(role).length }}
        </span>
      </button>
    </div>

    <div v-if="loading" class="space-y-8">
      <div v-for="i in 5" :key="i" class="h-32 animate-pulse rounded-xl bg-indigo-100"></div>
    </div>

    <!-- Soprano Section -->
    <div v-if="!loading && (selectedRole === 'Semua' || selectedRole === 'Soprano') && getMembersByRole('Soprano').length > 0" class="mb-14" data-aos="fade-up">
      <div class="mb-8 flex items-center gap-4">
        <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-500"></div>
        <h2 class="text-2xl font-bold text-slate-800">Soprano</h2>
        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
          {{ getMembersByRole('Soprano').length }} Member
        </span>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(member, index) in getMembersByRole('Soprano')"
          :key="member.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="relative mx-auto mb-5 h-28 w-28">
            <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-20"></div>
            <img
              :src="getAvatarUrl(member.avatar)"
              :alt="member.name"
              class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
            />
            <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-500 shadow-sm"></div>
          </div>
          <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
          <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
          <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Alto Section -->
    <div v-if="!loading && (selectedRole === 'Semua' || selectedRole === 'Alto') && getMembersByRole('Alto').length > 0" class="mb-14" data-aos="fade-up">
      <div class="mb-8 flex items-center gap-4">
        <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-500"></div>
        <h2 class="text-2xl font-bold text-slate-800">Alto</h2>
        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
          {{ getMembersByRole('Alto').length }} Member
        </span>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(member, index) in getMembersByRole('Alto')"
          :key="member.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="relative mx-auto mb-5 h-28 w-28">
            <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-20"></div>
            <img
              :src="getAvatarUrl(member.avatar)"
              :alt="member.name"
              class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
            />
            <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-500 shadow-sm"></div>
          </div>
          <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
          <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
          <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Tenor Section -->
    <div v-if="!loading && (selectedRole === 'Semua' || selectedRole === 'Tenor') && getMembersByRole('Tenor').length > 0" class="mb-14" data-aos="fade-up">
      <div class="mb-8 flex items-center gap-4">
        <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-500"></div>
        <h2 class="text-2xl font-bold text-slate-800">Tenor</h2>
        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
          {{ getMembersByRole('Tenor').length }} Member
        </span>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(member, index) in getMembersByRole('Tenor')"
          :key="member.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="relative mx-auto mb-5 h-28 w-28">
            <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-20"></div>
            <img
              :src="getAvatarUrl(member.avatar)"
              :alt="member.name"
              class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
            />
            <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-500 shadow-sm"></div>
          </div>
          <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
          <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
          <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bass Section -->
    <div v-if="!loading && (selectedRole === 'Semua' || selectedRole === 'Bass') && getMembersByRole('Bass').length > 0" class="mb-14" data-aos="fade-up">
      <div class="mb-8 flex items-center gap-4">
        <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-500"></div>
        <h2 class="text-2xl font-bold text-slate-800">Bass</h2>
        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
          {{ getMembersByRole('Bass').length }} Member
        </span>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(member, index) in getMembersByRole('Bass')"
          :key="member.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="relative mx-auto mb-5 h-28 w-28">
            <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-20"></div>
            <img
              :src="getAvatarUrl(member.avatar)"
              :alt="member.name"
              class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
            />
            <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-500 shadow-sm"></div>
          </div>
          <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
          <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
          <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Conductor Section -->
    <div v-if="!loading && (selectedRole === 'Semua' || selectedRole === 'Conductor') && getMembersByRole('Conductor').length > 0" class="mb-14" data-aos="fade-up">
      <div class="mb-8 flex items-center gap-4">
        <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
        <h2 class="text-2xl font-bold text-slate-800">Conductor</h2>
        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
          {{ getMembersByRole('Conductor').length }} Member
        </span>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(member, index) in getMembersByRole('Conductor')"
          :key="member.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="relative mx-auto mb-5 h-28 w-28">
            <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-20"></div>
            <img
              :src="getAvatarUrl(member.avatar)"
              :alt="member.name"
              class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
            />
            <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-500 shadow-sm"></div>
          </div>
          <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
          <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
          <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!loading && getFilteredMembers().length === 0" class="rounded-2xl border border-indigo-100/80 bg-white p-12 text-center">
      <p class="text-slate-600">
        {{ selectedRole === 'Semua' 
          ? 'Belum ada member aktif' 
          : `Belum ada member dengan role ${selectedRole}` }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import api from '@/lib/api/client'

interface Member {
  id: number
  name: string
  role: string
  position: string | null
  avatar: string | null
  badges: string[] | null
  is_active: boolean
}

const activeMembers = ref<Member[]>([])
const loading = ref(true)
const selectedRole = ref<string>('Semua')
const roles = ['Soprano', 'Alto', 'Tenor', 'Bass', 'Conductor']

const getAvatarUrl = (avatarPath: string | null) => {
  if (!avatarPath) return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80'
  if (avatarPath.startsWith('http')) return avatarPath
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${avatarPath}`
}

const getMembersByRole = (role: string) => {
  return activeMembers.value.filter(member => member.role === role && member.is_active)
}

const getFilteredMembers = () => {
  if (selectedRole.value === 'Semua') {
    return activeMembers.value
  }
  return getMembersByRole(selectedRole.value)
}

const fetchMembers = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/members')
    const allMembers = response.data.data || response.data || []
    // Filter hanya member yang aktif dan urutkan berdasarkan order
    activeMembers.value = allMembers
      .filter((m: Member) => m.is_active)
      .sort((a: Member, b: Member) => {
        if (a.order !== b.order) return a.order - b.order
        return a.name.localeCompare(b.name)
      })
  } catch (error) {
    console.error('Error fetching members:', error)
    activeMembers.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchMembers()
})
</script>


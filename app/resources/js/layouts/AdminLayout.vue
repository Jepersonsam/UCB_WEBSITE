<template>
  <div class="flex min-h-screen bg-slate-50">
    <!-- Mobile Overlay -->
    <div
      v-if="mobileMenuOpen"
      @click="mobileMenuOpen = false"
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed lg:static inset-y-0 left-0 z-50 w-64 border-r border-sky-100 bg-slate-50 shadow-xl lg:shadow-none transform transition-transform duration-300 ease-in-out lg:transform-none',
        mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
        'lg:block'
      ]"
    >
      <div class="sticky top-0 flex h-screen flex-col">
        <!-- Logo -->
        <div class="border-b border-sky-100 p-6 lg:p-8">
          <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 lg:h-16 lg:w-16 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-sky-50 shadow-sm">
              <img
                v-if="logoExists"
                :src="logoUrl"
                alt="UCB Logo"
                class="h-full w-full object-contain p-2"
                @error="logoExists = false"
              />
              <span v-else class="text-sky-600 text-base lg:text-lg font-semibold">UCB</span>
            </div>
            <div>
              <p class="text-base lg:text-lg font-semibold text-slate-800">CMS Admin</p>
              <p class="text-sm text-slate-500">UCB Website</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 p-4 lg:p-6">
          <RouterLink
            to="/admin/dashboard"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
          </RouterLink>

          <RouterLink
            to="/admin/articles"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Artikel
          </RouterLink>

          <RouterLink
            to="/admin/gallery"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Galeri
          </RouterLink>

          <RouterLink
            to="/admin/videos"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            Video
          </RouterLink>

          <RouterLink
            to="/admin/events"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Event
          </RouterLink>

          <RouterLink
            to="/admin/about"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tentang
          </RouterLink>
          <RouterLink
            to="/admin/join"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Bergabung
          </RouterLink>
          <RouterLink
            to="/admin/join-applications"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Aplikasi Bergabung
          </RouterLink>

          <RouterLink
            to="/admin/hero"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Hero Section
          </RouterLink>

          <RouterLink
            to="/admin/stats"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Stats Section
          </RouterLink>

          <RouterLink
            to="/admin/regular-schedule"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Jadwal Latihan Reguler
          </RouterLink>
          <RouterLink
            to="/admin/audition-schedules"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Jadwal Audisi
          </RouterLink>

          <RouterLink
            to="/admin/promosi"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            Promosi
          </RouterLink>

          <RouterLink
            to="/admin/members"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Member
          </RouterLink>

          <RouterLink
            to="/admin/media"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Media Library
          </RouterLink>

          <RouterLink
            to="/admin/contact-messages"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Pesan Kontak
          </RouterLink>
          <RouterLink
            to="/admin/comments"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Komentar
          </RouterLink>
          <RouterLink
            to="/admin/settings"
            @click="mobileMenuOpen = false"
            class="flex items-center gap-3 rounded-xl px-4 py-3.5 lg:py-4 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5 lg:h-6 lg:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
          </RouterLink>
        </nav>

        <!-- User Info & Logout -->
        <div class="border-t border-sky-100 p-4 lg:p-6">
          <div class="mb-4 flex items-center gap-3 rounded-xl px-4 py-3">
            <div class="flex h-10 w-10 lg:h-12 lg:w-12 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-sm lg:text-base font-semibold">
              {{ userInitials }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm lg:text-base font-medium text-slate-800 truncate">{{ userName }}</p>
              <p class="text-xs lg:text-sm text-slate-500">{{ userRole }}</p>
            </div>
          </div>
          <button
            @click="handleLogout"
            class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-base font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
          >
            Keluar
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1">
      <!-- Top Bar -->
      <header class="sticky top-0 z-10 border-b border-sky-100 bg-slate-50/95 backdrop-blur-sm shadow-sm">
        <div class="flex items-center justify-between px-6 py-5 lg:py-6">
          <div class="flex items-center gap-4">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="lg:hidden rounded-lg p-2 text-slate-700 transition-colors hover:bg-sky-50 hover:text-sky-600"
              aria-label="Toggle menu"
            >
              <svg v-if="!mobileMenuOpen" class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <h2 class="text-xl lg:text-2xl font-semibold text-slate-800">{{ pageTitle }}</h2>
          </div>
          <div class="flex items-center gap-3">
            <a
              href="/"
              target="_blank"
              class="rounded-lg px-4 py-2.5 text-base text-slate-600 transition-all hover:bg-sky-50 hover:text-sky-600"
            >
              Lihat Website
            </a>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const logoExists = ref(false)
const userName = ref('Admin')
const userRole = ref('Administrator')
const userInitials = ref('AD')
const mobileMenuOpen = ref(false)

// Logo URL - file di public folder bisa diakses langsung
const logoUrl = '/UCB.jpg'

const pageTitle = computed(() => {
  const titles: Record<string, string> = {
    '/admin/dashboard': 'Dashboard',
    '/admin/articles': 'Artikel',
    '/admin/gallery': 'Galeri',
    '/admin/videos': 'Video',
    '/admin/events': 'Event',
    '/admin/about': 'Tentang',
    '/admin/join': 'Bergabung',
    '/admin/join-applications': 'Aplikasi Bergabung',
    '/admin/hero': 'Hero Section',
    '/admin/stats': 'Stats Section',
    '/admin/regular-schedule': 'Jadwal Latihan Reguler',
    '/admin/audition-schedules': 'Jadwal Audisi',
    '/admin/promosi': 'Promosi',
    '/admin/members': 'Member',
    '/admin/contact-messages': 'Pesan Kontak',
    '/admin/comments': 'Komentar',
    '/admin/media': 'Media Library',
    '/admin/settings': 'Settings'
  }
  return titles[route.path] || 'Dashboard'
})

onMounted(() => {
  // Check if logo exists
  const img = new Image()
  img.onload = () => {
    logoExists.value = true
  }
  img.onerror = () => {
    logoExists.value = false
  }
  img.src = logoUrl

  const user = localStorage.getItem('user')
  if (user) {
    try {
      const userData = JSON.parse(user)
      userName.value = userData.name || 'Admin'
      userRole.value = userData.role || 'Administrator'
      userInitials.value = userData.name?.split(' ').map((n: string) => n[0]).join('').toUpperCase().slice(0, 2) || 'AD'
    } catch (e) {
      console.error('Error parsing user data:', e)
    }
  }
})

const handleLogout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/admin/login')
}
</script>


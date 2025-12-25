<template>
  <div class="flex min-h-screen bg-slate-50">
    <!-- Sidebar -->
    <aside class="hidden w-64 border-r border-sky-100 bg-slate-50 lg:block">
      <div class="sticky top-0 flex h-screen flex-col">
        <!-- Logo -->
        <div class="border-b border-sky-100 p-6">
          <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 font-semibold shadow-sm">
              UCB
            </div>
            <div>
              <p class="text-sm font-semibold text-slate-800">CMS Admin</p>
              <p class="text-xs text-slate-500">UCB Website</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 p-4">
          <RouterLink
            to="/admin/dashboard"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
          </RouterLink>

          <RouterLink
            to="/admin/articles"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Artikel
          </RouterLink>

          <RouterLink
            to="/admin/gallery"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Galeri
          </RouterLink>

          <RouterLink
            to="/admin/videos"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            Video
          </RouterLink>

          <RouterLink
            to="/admin/events"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Event
          </RouterLink>

          <RouterLink
            to="/admin/media"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Media Library
          </RouterLink>

          <RouterLink
            to="/admin/settings"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
            active-class="bg-sky-100 text-sky-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
          </RouterLink>
        </nav>

        <!-- User Info & Logout -->
        <div class="border-t border-sky-100 p-4">
          <div class="mb-3 flex items-center gap-3 rounded-xl px-4 py-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-xs font-semibold">
              {{ userInitials }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-medium text-slate-800 truncate">{{ userName }}</p>
              <p class="text-xs text-slate-500">{{ userRole }}</p>
            </div>
          </div>
          <button
            @click="handleLogout"
            class="w-full rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-all hover:bg-sky-50 hover:text-sky-600"
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
        <div class="flex items-center justify-between px-6 py-4">
          <div class="flex items-center gap-4">
            <button class="lg:hidden">
              <svg class="h-6 w-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <h2 class="text-lg font-semibold text-slate-800">{{ pageTitle }}</h2>
          </div>
          <div class="flex items-center gap-3">
            <RouterLink
              to="/"
              target="_blank"
              class="rounded-lg px-3 py-2 text-sm text-slate-600 transition-all hover:bg-sky-50 hover:text-sky-600"
            >
              Lihat Website
            </RouterLink>
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

const userName = ref('Admin')
const userRole = ref('Administrator')
const userInitials = ref('AD')

const pageTitle = computed(() => {
  const titles: Record<string, string> = {
    '/admin/dashboard': 'Dashboard',
    '/admin/articles': 'Artikel',
    '/admin/gallery': 'Galeri',
    '/admin/videos': 'Video',
    '/admin/events': 'Event',
    '/admin/media': 'Media Library',
    '/admin/settings': 'Settings'
  }
  return titles[route.path] || 'Dashboard'
})

onMounted(() => {
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


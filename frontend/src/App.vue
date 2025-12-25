<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/20 text-slate-800">
    <header class="border-b border-slate-200/80 bg-white/95 backdrop-blur-xl shadow-sm sticky top-0 z-50 transition-all duration-300">
      <div class="mx-auto flex w-full items-center justify-between px-4 py-4 sm:px-6 sm:py-5 lg:px-8 lg:py-6">
        <RouterLink to="/" class="flex items-center gap-3 sm:gap-4 transition-all duration-300 hover:scale-[1.02] active:scale-95">
          <div class="flex h-12 w-12 sm:h-14 sm:w-14 lg:h-16 lg:w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-indigo-600 shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <img
              v-if="logoExists"
              src="/UCB.jpg"
              alt="UCB Logo"
              class="h-full w-full object-contain p-2"
              @error="logoExists = false"
            />
            <span v-else class="text-white font-bold text-lg sm:text-xl lg:text-2xl">UCB</span>
          </div>
          <div class="hidden sm:block">
            <p class="text-base sm:text-lg lg:text-xl font-bold text-slate-900 tracking-tight">Unceasing Cantica Bandung</p>
            <p class="text-xs sm:text-sm text-slate-500 font-medium">Paduan suara • Bandung</p>
          </div>
        </RouterLink>
        <nav class="hidden items-center gap-1 lg:gap-2 text-sm lg:text-base font-medium text-slate-700 md:flex">
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Beranda</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/gallery"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Galeri</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/videos"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Video</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/schedule"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Jadwal</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/news"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Berita</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/members"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Member</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl px-4 py-2.5 lg:px-5 lg:py-3 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95" 
            to="/contact"
            active-class="text-indigo-600 bg-indigo-50 font-semibold"
          >
            <span class="relative z-10">Kontak</span>
          </RouterLink>
          <RouterLink 
            class="relative rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 px-5 py-2.5 lg:px-6 lg:py-3 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 active:scale-95 font-semibold" 
            to="/join"
            active-class="from-indigo-700 to-indigo-600"
          >
            <span class="relative z-10">Bergabung</span>
          </RouterLink>
        </nav>
        <!-- Mobile Menu Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="flex items-center justify-center rounded-xl p-2.5 text-slate-600 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95 md:hidden"
          aria-label="Toggle menu"
        >
          <svg v-if="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <!-- Mobile Menu -->
      <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div
          v-if="mobileMenuOpen"
          class="border-t border-slate-200/80 bg-white/98 backdrop-blur-xl shadow-sm md:hidden"
        >
          <nav class="flex flex-col px-4 py-4 space-y-1">
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Beranda
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/gallery"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Galeri
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/videos"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Video
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/schedule"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Jadwal
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/news"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Berita
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/members"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Member
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-slate-700 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-600 active:scale-95"
              to="/contact"
              active-class="text-indigo-600 bg-indigo-50 font-semibold"
            >
              Kontak
            </RouterLink>
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 px-4 py-3 text-base font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl active:scale-95"
              to="/join"
            >
              Bergabung
            </RouterLink>
          </nav>
        </div>
      </Transition>
    </header>

    <main class="w-full">
      <RouterView v-slot="{ Component, route }">
        <Transition
          :name="route.meta.transition || 'fade'"
          mode="out-in"
        >
          <component :is="Component" :key="route.path" />
        </Transition>
      </RouterView>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch, onUnmounted } from 'vue'
import { RouterLink, RouterView, useRoute } from 'vue-router'
import AOS from 'aos'

const logoExists = ref(false)
const mobileMenuOpen = ref(false)
const route = useRoute()

let scrollTimeout: ReturnType<typeof setTimeout> | null = null

const handleScroll = () => {
  if (scrollTimeout) {
    clearTimeout(scrollTimeout)
  }
  scrollTimeout = setTimeout(() => {
    AOS.refresh()
  }, 150)
}

onMounted(() => {
  // Check if logo exists
  const img = new Image()
  img.onload = () => {
    logoExists.value = true
  }
  img.onerror = () => {
    logoExists.value = false
  }
  img.src = '/UCB.jpg'

  // Refresh AOS on scroll to ensure animations work when scrolling up
  window.addEventListener('scroll', handleScroll, { passive: true })

  // Initial refresh
  setTimeout(() => {
    AOS.refresh()
  }, 300)
})

onUnmounted(() => {
  // Cleanup scroll event listener
  window.removeEventListener('scroll', handleScroll)
  if (scrollTimeout) {
    clearTimeout(scrollTimeout)
  }
})

// Refresh AOS on route change
watch(() => route.path, () => {
  setTimeout(() => {
    AOS.refresh()
  }, 100)
})
</script>

<template>
  <footer class="relative mt-20 border-t border-slate-200 bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-50 pt-16 pb-8">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden opacity-30">
      <div class="absolute -top-24 right-0 h-96 w-96 rounded-full bg-indigo-200 blur-3xl"></div>
      <div class="absolute -bottom-24 left-0 h-96 w-96 rounded-full bg-indigo-100 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <!-- Main Footer Content -->
      <div class="grid gap-12 lg:grid-cols-4 md:grid-cols-2">
        <!-- About Section -->
        <div class="lg:col-span-2">
          <div class="flex items-center gap-3 mb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg shadow-indigo-500/30">
              <span class="text-white font-bold text-lg">UCB</span>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900">Unceasing Cantica Bandung</h3>
              <p class="text-sm text-slate-600">Pujian yang Tak Berkesudahan</p>
            </div>
          </div>
          <p class="text-slate-600 leading-relaxed mb-6 max-w-md">
            Paduan suara yang didirikan pada 22 Maret 2001, melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni.
          </p>
          <!-- Social Media -->
          <div class="flex gap-3">
            <a
              href="#"
              class="group flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 transition-all hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 hover:scale-110 hover:shadow-md"
              aria-label="Facebook"
            >
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <a
              href="#"
              class="group flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 transition-all hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 hover:scale-110 hover:shadow-md"
              aria-label="Instagram"
            >
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a
              href="#"
              class="group flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 transition-all hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 hover:scale-110 hover:shadow-md"
              aria-label="YouTube"
            >
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
              </svg>
            </a>
            <a
              href="#"
              class="group flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 transition-all hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 hover:scale-110 hover:shadow-md"
              aria-label="Email"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="mb-6 text-sm font-bold uppercase tracking-wider text-slate-900">Navigasi</h4>
          <ul class="space-y-3">
            <li>
              <RouterLink to="/" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Beranda
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/gallery" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Galeri
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/videos" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Video
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/schedule" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Jadwal
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/news" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Berita
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/members" class="group inline-flex items-center text-slate-600 transition-all hover:text-indigo-600 hover:translate-x-1">
                <span class="mr-2 text-indigo-400 opacity-0 transition-opacity group-hover:opacity-100">→</span>
                Member
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="mb-6 text-sm font-bold uppercase tracking-wider text-slate-900">Kontak</h4>
          <ul class="space-y-4">
            <li class="flex items-start gap-3">
              <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-slate-900">Alamat</p>
                <p class="text-sm text-slate-600">Bandung, Indonesia</p>
              </div>
            </li>
            <li class="flex items-start gap-3">
              <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-slate-900">Email</p>
                <a href="mailto:info@ucbandung.com" class="text-sm text-slate-600 hover:text-indigo-600 transition-colors">
                  info@ucbandung.com
                </a>
              </div>
            </li>
            <li>
              <RouterLink
                to="/join"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition-all hover:scale-105 hover:shadow-xl"
              >
                Bergabung dengan Kami
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="mt-12 border-t border-slate-200 pt-8">
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
          <p class="text-sm text-slate-600">
            © {{ currentYear }} Unceasing Cantica Bandung. All rights reserved.
          </p>
          <div class="flex gap-6 text-sm text-slate-600">
            <RouterLink to="/contact" class="transition-colors hover:text-indigo-600">
              Hubungi Kami
            </RouterLink>
            <span class="text-slate-300">•</span>
            <a href="#" class="transition-colors hover:text-indigo-600">
              Privacy Policy
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Back to Top Button -->
    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-4"
    >
      <button
        v-if="showBackToTop"
        @click="scrollToTop"
        class="fixed bottom-8 right-8 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-500/30 transition-all hover:scale-110 hover:shadow-xl active:scale-95"
        aria-label="Back to top"
      >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
      </button>
    </Transition>
  </footer>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink } from 'vue-router'

const currentYear = new Date().getFullYear()
const showBackToTop = ref(false)

const handleScroll = () => {
  showBackToTop.value = window.scrollY > 300
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

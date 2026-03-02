<template>
  <!-- Public Layout (Website) -->
  <div
    v-if="isPublicRoute"
    class="min-h-screen bg-gradient-to-br from-indigo-50/50 via-white to-purple-50/30 text-slate-800"
  >
    <header
      :class="[
        'fixed top-0 left-0 right-0 z-50 w-full transition-all duration-500',
        isScrolled || !isHomePage
          ? 'bg-slate-900/95 backdrop-blur-xl shadow-xl border-b border-white/10'
          : 'bg-transparent',
      ]"
    >
      <div
        class="mx-auto flex w-full items-center justify-between px-4 py-4 sm:px-6 lg:px-8"
      >
        <!-- Logo -->
        <RouterLink
          to="/"
          class="flex items-center gap-3 sm:gap-4 transition-all duration-300 hover:scale-[1.02] active:scale-95"
        >
          <div
            class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm border border-white/25 shadow-md transition-all duration-300 hover:bg-white/25 hover:scale-105"
          >
            <img
              v-if="logoExists"
              :src="logoUrl"
              alt="UCB Logo"
              class="h-full w-full object-contain p-1.5"
              @error="logoExists = false"
            />
            <span v-else class="text-white font-bold text-xl sm:text-2xl"
              >UCB</span
            >
          </div>
          <div class="hidden sm:block">
            <p class="text-base sm:text-lg font-bold text-white tracking-tight">
              Unceasing Cantica Bandung
            </p>
            <p class="text-xs sm:text-sm text-white/60 font-medium">
              Paduan suara • Bandung
            </p>
          </div>
        </RouterLink>

        <!-- Desktop Nav -->
        <nav
          class="hidden items-center gap-1 text-sm font-medium text-white md:flex"
        >
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Beranda</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/gallery"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Galeri</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/videos"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Video</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/schedule"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Jadwal</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/news"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Berita</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/members"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Member</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="group relative rounded-xl px-4 py-2.5 transition-all duration-300 hover:bg-white/10 active:scale-95"
            to="/contact"
            active-class="bg-white/15 font-semibold"
          >
            <span class="relative z-10">Kontak</span>
            <span
              class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-white transition-all duration-300 group-hover:w-3/4"
            ></span>
          </RouterLink>
          <RouterLink
            class="relative ml-2 rounded-xl border-2 border-white/70 px-5 py-2.5 text-sm text-white shadow-lg transition-all duration-300 hover:bg-white hover:text-slate-900 hover:border-white active:scale-95 font-semibold"
            to="/join"
          >
            <span class="relative z-10">Bergabung</span>
          </RouterLink>
        </nav>

        <!-- Mobile Menu Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="flex items-center justify-center rounded-xl p-2.5 text-white transition-all duration-300 hover:bg-white/10 active:scale-95 md:hidden"
          aria-label="Toggle menu"
        >
          <svg
            v-if="!mobileMenuOpen"
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            stroke-width="2.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
          <svg
            v-else
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            stroke-width="2.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
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
          class="border-t border-white/10 bg-slate-900/97 backdrop-blur-xl shadow-xl md:hidden"
        >
          <nav class="flex flex-col px-4 py-4 space-y-1">
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/"
              active-class="bg-white/15 font-semibold"
              >Beranda</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/gallery"
              active-class="bg-white/15 font-semibold"
              >Galeri</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/videos"
              active-class="bg-white/15 font-semibold"
              >Video</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/schedule"
              active-class="bg-white/15 font-semibold"
              >Jadwal</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/news"
              active-class="bg-white/15 font-semibold"
              >Berita</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/members"
              active-class="bg-white/15 font-semibold"
              >Member</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="rounded-xl px-4 py-3 text-base font-medium text-white transition-all duration-300 hover:bg-white/10 active:scale-95"
              to="/contact"
              active-class="bg-white/15 font-semibold"
              >Kontak</RouterLink
            >
            <RouterLink
              @click="mobileMenuOpen = false"
              class="mt-2 rounded-xl border-2 border-white/70 px-4 py-3 text-base font-semibold text-white transition-all duration-300 hover:bg-white hover:text-slate-900 active:scale-95"
              to="/join"
              >Bergabung</RouterLink
            >
          </nav>
        </div>
      </Transition>
    </header>

    <main :class="['w-full', !isHomePage ? 'pt-32' : '']">
      <RouterView v-slot="{ Component, route }">
        <Transition :name="route.meta.transition || 'fade'" mode="out-in">
          <component :is="Component" :key="route.path" />
        </Transition>
      </RouterView>
    </main>

    <!-- Footer -->
    <PublicFooter />
  </div>

  <!-- Admin Layout (CMS) -->
  <RouterView v-else />
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch, onUnmounted } from "vue";
import { RouterLink, RouterView, useRoute } from "vue-router";
import PublicFooter from "@/layouts/PublicFooter.vue";
import AOS from "aos";

const route = useRoute();
const logoExists = ref(false);
const mobileMenuOpen = ref(false);
const isScrolled = ref(false);

const getBackendUrl = () => {
  const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
  let backendUrl = apiUrl.replace("/api", "");
  if (backendUrl === "" && apiUrl !== "/api")
    backendUrl = "http://localhost:8000";
  return backendUrl;
};
const logoUrl = `${getBackendUrl()}/UCB.jpg`;

const isPublicRoute = computed(() => {
  return !route.path.startsWith("/admin");
});

const isHomePage = computed(() => route.path === "/");

let scrollTimeout: ReturnType<typeof setTimeout> | null = null;

const handleScroll = () => {
  if (scrollTimeout) clearTimeout(scrollTimeout);
  isScrolled.value = window.scrollY > 20;
  scrollTimeout = setTimeout(() => {
    AOS.refresh();
  }, 150);
};

onMounted(() => {
  const img = new Image();
  img.onload = () => {
    logoExists.value = true;
  };
  img.onerror = () => {
    logoExists.value = false;
  };
  img.src = logoUrl;

  if (isPublicRoute.value) {
    window.addEventListener("scroll", handleScroll, { passive: true });
    setTimeout(() => {
      AOS.refresh();
    }, 300);
  }
});

onUnmounted(() => {
  if (isPublicRoute.value) {
    window.removeEventListener("scroll", handleScroll);
    if (scrollTimeout) clearTimeout(scrollTimeout);
  }
});

watch(
  () => route.path,
  () => {
    mobileMenuOpen.value = false;
    if (isPublicRoute.value) {
      setTimeout(() => {
        AOS.refresh();
      }, 100);
    }
  },
);
</script>

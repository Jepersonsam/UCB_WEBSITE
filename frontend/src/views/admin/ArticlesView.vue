<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Artikel</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola artikel dan berita</p>
      </div>
      <RouterLink
        to="/admin/articles/create"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl"
      >
        + Buat Artikel
      </RouterLink>
    </div>

    <div class="rounded-2xl border border-sky-100 bg-slate-50 p-6 shadow-sm">
      <p class="text-center text-slate-600">Fitur manajemen artikel akan segera tersedia</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>


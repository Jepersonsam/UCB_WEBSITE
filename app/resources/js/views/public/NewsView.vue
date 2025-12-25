<template>
  <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8 sm:space-y-12">
    <!-- Header Section -->
    <div class="text-center" data-aos="fade-down">
      <h1 class="text-3xl font-bold text-slate-800 sm:text-4xl lg:text-5xl">Berita & Artikel</h1>
      <p class="mt-3 sm:mt-4 text-base sm:text-lg text-slate-600">Update kegiatan, artikel inspiratif, dan berita terbaru dari Unceasing Cantica Bandung</p>
      <div class="mt-4 sm:mt-6 flex justify-center">
        <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="i in 6"
        :key="i"
        class="overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-slate-50 to-indigo-50 shadow-sm"
      >
        <div class="aspect-[4/3] animate-pulse bg-indigo-100"></div>
        <div class="p-6 space-y-3">
          <div class="h-4 w-20 animate-pulse rounded bg-indigo-100"></div>
          <div class="h-6 w-3/4 animate-pulse rounded bg-indigo-100"></div>
          <div class="h-4 w-full animate-pulse rounded bg-indigo-50"></div>
          <div class="h-4 w-2/3 animate-pulse rounded bg-indigo-50"></div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="articles.length === 0"
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
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
          />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Artikel</h3>
      <p class="mt-2 text-slate-600">Tidak ada artikel yang tersedia saat ini.</p>
    </div>

    <!-- Articles Grid -->
    <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <article
        v-for="(article, index) in articles"
        :key="article.id"
        :data-aos="'fade-up'"
        :data-aos-delay="index % 6 * 100"
        class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-2xl hover:shadow-sky-200/50 hover:scale-[1.02]"
      >
        <!-- Featured Image -->
        <div v-if="article.featured_image" class="relative aspect-[4/3] overflow-hidden bg-slate-900">
          <img
            :src="getFeaturedImageUrl(article.featured_image)"
            :alt="article.title"
            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
            @error="handleImageError"
            loading="lazy"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
        </div>
        <div v-else class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-indigo-100 to-slate-100">
          <div class="flex h-full items-center justify-center">
            <svg class="h-16 w-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>

        <!-- Article Content -->
        <div class="p-6">
          <!-- Category & Date -->
          <div class="mb-3 flex items-center justify-between">
            <span
              v-if="article.category"
              class="inline-block rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700"
            >
              {{ article.category.name }}
            </span>
            <span v-else class="text-xs text-slate-400">Artikel</span>
            <span class="text-xs text-slate-500">
              {{ formatDate(article.published_at || article.created_at) }}
            </span>
          </div>

          <!-- Title -->
          <h2 class="text-xl font-bold text-slate-900 line-clamp-2 leading-tight">
            {{ article.title }}
          </h2>

          <!-- Excerpt -->
          <p v-if="article.excerpt" class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">
            {{ article.excerpt }}
          </p>

          <!-- Tags -->
          <div v-if="article.tags && article.tags.length > 0" class="mt-4 flex flex-wrap gap-2">
            <span
              v-for="tag in article.tags.slice(0, 3)"
              :key="tag.id"
              class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1 text-xs font-medium text-slate-600"
            >
              #{{ tag.name }}
            </span>
            <span
              v-if="article.tags.length > 3"
              class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1 text-xs font-medium text-slate-600"
            >
              +{{ article.tags.length - 3 }}
            </span>
          </div>

          <!-- Read More Link -->
          <RouterLink
            :to="`/news/${article.slug || article.id}`"
            class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition-colors hover:text-indigo-700"
          >
            Baca Selengkapnya
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </div>
      </article>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'

interface Category {
  id: number
  name: string
}

interface Tag {
  id: number
  name: string
}

interface Article {
  id: number
  title: string
  slug: string
  excerpt: string | null
  content: string
  featured_image: string | null
  category_id: number | null
  category: Category | null
  tags: Tag[]
  status: string
  published_at: string | null
  created_at: string
  updated_at: string
}

const articles = ref<Article[]>([])
const loading = ref(true)

const getFeaturedImageUrl = (imagePath: string) => {
  if (!imagePath) return ''
  
  // Jika sudah URL lengkap, langsung return
  if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
    return imagePath
  }
  
  // Jika sudah dimulai dengan /storage/, langsung return
  if (imagePath.startsWith('/storage/')) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}${imagePath}`
  }
  
  // Jika dimulai dengan /, langsung return
  if (imagePath.startsWith('/')) {
    return imagePath
  }
  
  // Build URL untuk path relatif (media/images/... atau media/articles/...)
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  
  // Pastikan path tidak mengandung /storage/ di depannya
  const cleanPath = imagePath.replace(/^\/?storage\//, '')
  return `${backendUrl}/storage/${cleanPath}`
}

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300"%3E%3Crect fill="%23e0e7ef" width="400" height="300"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`
}

const fetchArticles = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/articles')
    const allArticles = response.data.data || response.data || []
    
    // Filter hanya artikel yang published
    articles.value = allArticles.filter((article: Article) => 
      article.status === 'published'
    )
  } catch (error) {
    console.error('Error fetching articles:', error)
    articles.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchArticles()
})
</script>


<template>
  <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8 sm:space-y-12">
    <!-- Header Section -->
    <div class="text-center" data-aos="fade-down">
      <h1 class="text-3xl font-bold text-slate-800 sm:text-4xl lg:text-5xl">Galeri Foto</h1>
      <p class="mt-3 sm:mt-4 text-base sm:text-lg text-slate-600">Momen-momen indah dalam pelayanan dan kegiatan Unceasing Cantica Bandung</p>
      <div class="mt-4 sm:mt-6 flex justify-center">
        <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <div
        v-for="i in 8"
        :key="i"
        class="aspect-square animate-pulse rounded-2xl border border-indigo-100 bg-gradient-to-br from-slate-50 to-indigo-50"
      ></div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="galleryImages.length === 0"
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
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Foto</h3>
      <p class="mt-2 text-slate-600">Tidak ada foto yang tersedia saat ini.</p>
    </div>

    <!-- Gallery Grid -->
    <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <div
        v-for="(image, index) in galleryImages"
        :key="image.id"
        :data-aos="'zoom-in'"
        :data-aos-delay="index % 8 * 50"
        class="group relative aspect-square cursor-pointer overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-2xl hover:shadow-sky-200/50 hover:scale-[1.02]"
        @click="openLightbox(image)"
      >
        <img
          :src="getImageUrl(image)"
          :alt="image.alt_text || image.original_filename"
          class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
          @error="handleImageError"
          loading="lazy"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
          <div class="absolute bottom-0 left-0 right-0 p-5">
            <p class="text-sm font-semibold text-white line-clamp-1">{{ image.original_filename }}</p>
            <p v-if="image.caption" class="mt-1.5 text-xs text-slate-200 line-clamp-2">{{ image.caption }}</p>
          </div>
        </div>
        <div class="absolute top-4 right-4 rounded-full bg-white/90 p-2 opacity-0 shadow-lg transition-opacity duration-300 group-hover:opacity-100">
          <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <div
      v-if="selectedImage"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
      @click.self="closeLightbox"
    >
      <button
        @click="closeLightbox"
        class="absolute top-4 right-4 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-colors hover:bg-white/20"
      >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <div class="relative max-h-[90vh] max-w-7xl">
        <img
          :src="getImageUrl(selectedImage)"
          :alt="selectedImage.alt_text || selectedImage.original_filename"
          class="max-h-[90vh] rounded-2xl object-contain shadow-2xl"
        />
        <div v-if="selectedImage.caption || selectedImage.original_filename" class="absolute bottom-0 left-0 right-0 rounded-b-2xl bg-gradient-to-t from-black/80 to-transparent p-6">
          <p class="text-lg font-semibold text-white">{{ selectedImage.original_filename }}</p>
          <p v-if="selectedImage.caption" class="mt-2 text-sm text-slate-200">{{ selectedImage.caption }}</p>
        </div>
      </div>
      <button
        v-if="currentImageIndex > 0"
        @click="previousImage"
        class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-colors hover:bg-white/20"
      >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button
        v-if="currentImageIndex < galleryImages.length - 1"
        @click="nextImage"
        class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-colors hover:bg-white/20"
      >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'

interface GalleryImage {
  id: number
  path: string
  original_filename: string
  alt_text?: string
  caption?: string
}

const galleryImages = ref<GalleryImage[]>([])
const loading = ref(true)
const selectedImage = ref<GalleryImage | null>(null)
const currentImageIndex = ref(0)

const getImageUrl = (image: GalleryImage) => {
  if (image.path) {
    // Gunakan URL backend untuk mengakses gambar
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    
    // Path dari database biasanya: "media/images/filename.jpg"
    // URL yang benar: "http://localhost:8000/storage/media/images/filename.jpg"
    return `${backendUrl}/storage/${image.path}`
  }
  return ''
}

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23e0e7ef" width="200" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const fetchGallery = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/gallery')
    galleryImages.value = response.data.all_media || []
  } catch (error) {
    console.error('Error fetching gallery:', error)
    galleryImages.value = []
  } finally {
    loading.value = false
  }
}

const openLightbox = (image: GalleryImage) => {
  selectedImage.value = image
  currentImageIndex.value = galleryImages.value.findIndex(img => img.id === image.id)
  
  // Prevent body scroll when lightbox is open
  document.body.style.overflow = 'hidden'
  
  // Add keyboard navigation
  document.addEventListener('keydown', handleKeyPress)
}

const closeLightbox = () => {
  selectedImage.value = null
  document.body.style.overflow = ''
  document.removeEventListener('keydown', handleKeyPress)
}

const handleKeyPress = (e: KeyboardEvent) => {
  if (e.key === 'Escape') {
    closeLightbox()
  } else if (e.key === 'ArrowLeft') {
    previousImage()
  } else if (e.key === 'ArrowRight') {
    nextImage()
  }
}

const previousImage = () => {
  if (currentImageIndex.value > 0) {
    currentImageIndex.value--
    selectedImage.value = galleryImages.value[currentImageIndex.value]
  }
}

const nextImage = () => {
  if (currentImageIndex.value < galleryImages.value.length - 1) {
    currentImageIndex.value++
    selectedImage.value = galleryImages.value[currentImageIndex.value]
  }
}

onMounted(() => {
  fetchGallery()
})
</script>


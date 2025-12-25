<template>
  <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8 sm:space-y-12">
    <!-- Header Section -->
    <div class="text-center" data-aos="fade-down">
      <h1 class="text-3xl font-bold text-slate-800 sm:text-4xl lg:text-5xl">Video</h1>
      <p class="mt-3 sm:mt-4 text-base sm:text-lg text-slate-600">Rekaman pelayanan, konser, dan dokumentasi kegiatan Unceasing Cantica Bandung</p>
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
        <div class="aspect-video animate-pulse bg-indigo-100"></div>
        <div class="p-5">
          <div class="h-5 w-3/4 animate-pulse rounded bg-indigo-100"></div>
          <div class="mt-3 h-4 w-full animate-pulse rounded bg-indigo-50"></div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="videos.length === 0"
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
            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
          />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Video</h3>
      <p class="mt-2 text-slate-600">Tidak ada video yang tersedia saat ini.</p>
    </div>

    <!-- Videos Grid -->
    <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="(video, index) in videos"
        :key="video.id"
        :data-aos="'fade-up'"
        :data-aos-delay="index % 6 * 100"
        class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-2xl hover:shadow-sky-200/50 hover:scale-[1.02]"
      >
        <!-- Video Player -->
        <div class="relative aspect-video overflow-hidden bg-slate-900">
          <!-- YouTube/Vimeo Embed -->
          <div v-if="video.video_type === 'url' && isYouTubeOrVimeo(video.video_url)" class="h-full w-full">
            <iframe
              :src="getEmbedUrl(video.video_url)"
              class="h-full w-full"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
          
          <!-- Google Drive Embed -->
          <div v-else-if="video.video_type === 'gdrive' || isGoogleDrive(video.video_url)" class="h-full w-full">
            <iframe
              :src="getGoogleDriveEmbedUrl(video.video_url)"
              class="h-full w-full"
              frameborder="0"
              allow="autoplay"
              allowfullscreen
            ></iframe>
          </div>
          
          <!-- Local Video File with Thumbnail -->
          <div v-else-if="video.video_type === 'file' && video.video_file_path" class="relative h-full w-full">
            <img
              v-if="video.thumbnail"
              :src="getThumbnailUrl(video.thumbnail)"
              :alt="video.title"
              class="h-full w-full object-cover"
            />
            <video
              :src="getVideoFileUrl(video)"
              class="h-full w-full object-cover"
              controls
              preload="metadata"
            >
              Browser Anda tidak mendukung video tag.
            </video>
          </div>
          
          <!-- Fallback with Thumbnail -->
          <div v-else-if="video.thumbnail" class="relative h-full w-full">
            <img
              :src="getThumbnailUrl(video.thumbnail)"
              :alt="video.title"
              class="h-full w-full object-cover"
            />
            <div class="absolute inset-0 flex items-center justify-center bg-black/30">
              <div class="rounded-full bg-white/90 p-4 shadow-lg transition-transform group-hover:scale-110">
                <svg class="h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Fallback -->
          <div v-else class="flex h-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
            <div class="text-center">
              <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/10">
                <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
              </div>
              <p class="mt-3 text-sm font-medium text-slate-300">Video tidak dapat dimuat</p>
            </div>
          </div>
        </div>
        
        <!-- Video Info -->
        <div class="p-6">
          <h3 class="text-xl font-semibold text-slate-900 line-clamp-2">{{ video.title }}</h3>
          <p v-if="video.description" class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-600">
            {{ video.description }}
          </p>
          <div class="mt-4 flex flex-wrap items-center gap-3">
            <span v-if="video.category" class="inline-flex items-center rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
              {{ video.category }}
            </span>
            <span v-if="video.duration" class="text-xs text-slate-500">
              <svg class="mr-1 inline h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ video.duration }}
            </span>
            <span v-if="video.views" class="text-xs text-slate-500">
              <svg class="mr-1 inline h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              {{ video.views }} views
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'

interface Video {
  id: number
  title: string
  description: string | null
  video_url: string
  video_file_path: string | null
  video_type: 'url' | 'gdrive' | 'file'
  thumbnail: string | null
  category: string | null
  duration: string | null
  views: number
}

const videos = ref<Video[]>([])
const loading = ref(true)

const isYouTubeOrVimeo = (url: string) => {
  if (!url) return false
  return url.includes('youtube.com') || url.includes('youtu.be') || url.includes('vimeo.com')
}

const isGoogleDrive = (url: string) => {
  if (!url) return false
  return url.includes('drive.google.com') || url.includes('docs.google.com')
}

const getEmbedUrl = (url: string) => {
  if (!url) return ''
  
  // YouTube
  if (url.includes('youtube.com/watch?v=')) {
    const videoId = url.split('v=')[1]?.split('&')[0]
    return `https://www.youtube.com/embed/${videoId}`
  }
  if (url.includes('youtu.be/')) {
    const videoId = url.split('youtu.be/')[1]?.split('?')[0]
    return `https://www.youtube.com/embed/${videoId}`
  }
  
  // Vimeo
  if (url.includes('vimeo.com/')) {
    const videoId = url.split('vimeo.com/')[1]?.split('?')[0]
    return `https://player.vimeo.com/video/${videoId}`
  }
  
  return url
}

const getGoogleDriveEmbedUrl = (url: string) => {
  if (!url) return ''
  
  // Extract file ID from various Google Drive URL formats
  let fileId = ''
  
  // Format: https://drive.google.com/file/d/FILE_ID/view
  const fileMatch = url.match(/\/file\/d\/([a-zA-Z0-9_-]+)/)
  if (fileMatch) {
    fileId = fileMatch[1]
  }
  
  // Format: https://drive.google.com/open?id=FILE_ID
  const openMatch = url.match(/[?&]id=([a-zA-Z0-9_-]+)/)
  if (openMatch && !fileId) {
    fileId = openMatch[1]
  }
  
  if (fileId) {
    return `https://drive.google.com/file/d/${fileId}/preview`
  }
  
  return url
}

const getVideoFileUrl = (video: Video) => {
  if (video.video_file_path) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}/storage/${video.video_file_path}`
  }
  return ''
}

const getThumbnailUrl = (thumbnail: string) => {
  if (!thumbnail) return ''
  if (thumbnail.startsWith('http://') || thumbnail.startsWith('https://')) {
    return thumbnail
  }
  if (thumbnail.startsWith('/')) {
    return thumbnail
  }
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${thumbnail}`
}

const fetchVideos = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/videos')
    videos.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching videos:', error)
    videos.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchVideos()
})
</script>


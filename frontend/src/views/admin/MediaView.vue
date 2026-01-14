<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Media Library</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola semua media (foto, video, dokumen)</p>
      </div>
      <button
        @click="fileInput?.click()"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02]"
      >
        + Upload Media
      </button>
      <input ref="fileInput" type="file" multiple @change="handleFileSelect" class="hidden" />
    </div>

    <div v-if="loading" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <div v-for="i in 8" :key="i" class="aspect-square animate-pulse rounded-xl bg-sky-100"></div>
    </div>
    <div v-else-if="media.length === 0" class="rounded-2xl border border-sky-100 bg-white p-12 text-center">
      <p class="text-slate-600">Belum ada media. Upload media pertama Anda!</p>
    </div>
    <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <div
        v-for="item in media"
        :key="item.id"
        class="group relative aspect-square overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
      >
        <img
          v-if="item.type === 'image'"
          :src="getMediaUrl(item)"
          :alt="item.alt_text || item.original_filename"
          class="h-full w-full object-cover"
          @error="handleImageError"
        />
        <div v-else class="flex h-full items-center justify-center bg-sky-50">
          <svg class="h-12 w-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
        </div>
        <div class="absolute inset-0 bg-black/60 opacity-0 transition-opacity group-hover:opacity-100">
          <div class="flex h-full items-center justify-center gap-2">
            <button
              @click="copyUrl(item)"
              class="rounded-lg bg-sky-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-sky-600"
            >
              Copy URL
            </button>
            <button
              @click="deleteMedia(item.id)"
              class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-600"
            >
              Hapus
            </button>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-black/70 p-2 text-xs text-white">
          {{ item.original_filename }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const media = ref<any[]>([])
const loading = ref(true)
const fileInput = ref<HTMLInputElement | null>(null)

const getMediaUrl = (item: any) => {
  if (item.path) {
    // Gunakan URL backend untuk mengakses gambar
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    
    // Path dari database biasanya: "media/images/filename.jpg"
    // URL yang benar: "http://localhost:8000/storage/media/images/filename.jpg"
    const imageUrl = `${backendUrl}/storage/${item.path}`
    
    // Debug di development
    if (import.meta.env.DEV) {
      console.log('Media URL:', imageUrl, 'Path:', item.path)
    }
    
    return imageUrl
  }
  return ''
}

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23e0e7ef" width="200" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const fetchMedia = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/gallery')
    media.value = response.data.all_media || []
  } catch (error) {
    console.error('Error fetching media:', error)
  } finally {
    loading.value = false
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const handleFileSelect = async (e: Event) => {
  const target = e.target as HTMLInputElement
  if (!target.files || target.files.length === 0) return

  const maxSize = 50 * 1024 * 1024 // 50MB dalam bytes
  const files = Array.from(target.files)
  
  // Validasi semua file sebelum upload
  for (const file of files) {
    if (file.size > maxSize) {
      await swal.warning(`File "${file.name}" terlalu besar! Ukuran maksimal adalah 50MB. File Anda: ${formatFileSize(file.size)}`)
      target.value = ''
      return
    }
    if (!file.type.startsWith('image/')) {
      await swal.warning(`File "${file.name}" harus berupa gambar (JPEG, PNG, GIF, WebP)`)
      target.value = ''
      return
    }
  }

  // Upload semua file dengan progress indicator
  for (const file of files) {
    const formData = new FormData()
    formData.append('file', file)
    try {
      const uploadConfig = {
        timeout: 300000, // 5 menit
        onUploadProgress: (progressEvent: any) => {
          if (progressEvent.total) {
            const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            console.log(`Upload ${file.name}: ${percentCompleted}%`)
          }
        }
      }
      await api.post('/v1/gallery/upload', formData, uploadConfig)
    } catch (error: any) {
      console.error('Error uploading:', error)
      let errorMessage = `Gagal upload ${file.name}`
      if (error.response?.data?.errors) {
        const errors = error.response.data.errors
        const firstError = Object.values(errors)[0]
        if (Array.isArray(firstError) && firstError.length > 0) {
          errorMessage = `${file.name}: ${firstError[0]}`
        }
      } else if (error.response?.data?.message) {
        errorMessage = `${file.name}: ${error.response.data.message}`
      } else if (error.code === 'ECONNABORTED') {
        errorMessage = `Upload ${file.name} timeout. File terlalu besar atau koneksi lambat.`
      }
      await swal.error(errorMessage)
    }
  }
  target.value = '' // Reset input
  await fetchMedia()
}

const copyUrl = async (item: any) => {
  const backendUrl = import.meta.env.VITE_API_URL?.replace('/api', '') || 'http://localhost:8000'
  const url = item.path.startsWith('storage/') || item.path.startsWith('/storage/')
    ? `${backendUrl}/${item.path.startsWith('/') ? item.path.slice(1) : item.path}`
    : `${backendUrl}/storage/${item.path}`
  navigator.clipboard.writeText(url)
  await swal.success('URL berhasil disalin!')
}

const deleteMedia = async (id: number) => {
  const result = await swal.confirmDelete('media ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/gallery/media/${id}`)
    await fetchMedia()
    await swal.success('Media berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus media')
    console.error('Error deleting media:', error)
  }
}

onMounted(() => {
  fetchMedia()
})
</script>

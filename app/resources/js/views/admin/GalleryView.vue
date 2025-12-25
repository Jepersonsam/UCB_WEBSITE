<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Galeri</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola foto dan album</p>
      </div>
      <div class="flex gap-3">
        <button
          @click="showUploadModal = true"
          class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02]"
        >
          + Upload Foto
        </button>
        <button
          @click="createAlbum"
          class="rounded-xl border border-sky-300 bg-white px-5 py-2.5 text-sm font-semibold text-sky-600 shadow-sm transition-all hover:bg-sky-50"
        >
          + Buat Album
        </button>
      </div>
    </div>

    <!-- Albums -->
    <div v-if="albums.length > 0" class="space-y-4">
      <h2 class="text-lg font-semibold text-slate-800">Album</h2>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="album in albums"
          :key="album.id"
          class="group relative overflow-hidden rounded-2xl border border-sky-100 bg-white shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <div class="aspect-square overflow-hidden bg-sky-50">
            <img
              v-if="album.cover_image"
              :src="album.cover_image"
              :alt="album.name"
              class="h-full w-full object-cover"
            />
            <div v-else class="flex h-full items-center justify-center text-sky-400">
              <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <div class="p-4">
            <h3 class="font-semibold text-slate-900">{{ album.name }}</h3>
            <p class="mt-1 text-sm text-slate-600">{{ album.media?.length || 0 }} foto</p>
            <div class="mt-3 flex gap-2">
              <button
                @click="editAlbum(album)"
                class="flex-1 rounded-lg bg-sky-50 px-3 py-1.5 text-xs font-medium text-sky-600 transition-colors hover:bg-sky-100"
              >
                Edit
              </button>
              <button
                @click="deleteAlbum(album.id)"
                class="flex-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-100"
              >
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- All Media -->
    <div class="space-y-4">
      <h2 class="text-lg font-semibold text-slate-800">Semua Foto</h2>
      <div v-if="loading" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="i in 8" :key="i" class="aspect-square animate-pulse rounded-xl bg-sky-100"></div>
      </div>
      <div v-else-if="allMedia.length === 0" class="rounded-2xl border border-sky-100 bg-white p-12 text-center">
        <p class="text-slate-600">Belum ada foto. Upload foto pertama Anda!</p>
      </div>
      <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="media in allMedia"
          :key="media.id"
          class="group relative aspect-square overflow-hidden rounded-xl border border-sky-100 bg-white shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
        >
          <img
            :src="getMediaUrl(media)"
            :alt="media.alt_text || media.original_filename"
            class="h-full w-full object-cover"
            @error="handleImageError"
          />
          <div class="absolute inset-0 bg-black/60 opacity-0 transition-opacity group-hover:opacity-100">
            <div class="flex h-full items-center justify-center gap-2">
              <button
                @click="deleteMedia(media.id)"
                class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-600"
              >
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Modal -->
    <div
      v-if="showUploadModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 overflow-y-auto"
      @click.self="showUploadModal = false"
    >
      <div class="w-full max-w-4xl rounded-2xl border border-sky-100 bg-white p-6 shadow-xl my-8 max-h-[90vh] overflow-y-auto">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Upload Foto</h3>
        <input
          ref="fileInput"
          type="file"
          accept="image/*"
          multiple
          @change="handleFileSelect"
          class="hidden"
        />
        <div
          v-if="selectedFiles.length === 0"
          @click="fileInput?.click()"
          class="mb-4 cursor-pointer rounded-xl border-2 border-dashed border-sky-300 bg-sky-50 p-8 text-center transition-colors hover:border-sky-400 hover:bg-sky-100"
        >
          <svg class="mx-auto h-12 w-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <p class="mt-2 text-sm font-medium text-slate-700">Klik untuk memilih foto</p>
          <p class="mt-1 text-xs text-slate-500">Anda bisa memilih banyak foto sekaligus</p>
        </div>
        
        <!-- Preview Multiple Files -->
        <div v-if="selectedFiles.length > 0" class="mb-4 space-y-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">{{ selectedFiles.length }} foto dipilih</p>
            <button
              @click="clearSelectedFiles"
              class="text-xs text-red-600 hover:text-red-700"
            >
              Hapus Semua
            </button>
          </div>
          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 max-h-96 overflow-y-auto p-2">
            <div
              v-for="(file, index) in selectedFiles"
              :key="index"
              class="relative group rounded-xl border border-sky-200 overflow-hidden bg-slate-50"
            >
              <img
                :src="file.preview"
            alt="Preview"
                class="w-full h-32 object-cover"
          />
          <button
                @click="removeFile(index)"
                class="absolute top-2 right-2 rounded-full bg-red-500 p-1.5 text-white hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100"
          >
                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
              <div class="p-2">
                <p class="text-xs font-medium text-slate-700 truncate" :title="file.file.name">{{ file.file.name }}</p>
                <p class="text-xs text-slate-500">{{ formatFileSize(file.file.size) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Upload Progress -->
        <div v-if="uploading && uploadQueue.length > 0" class="mb-4 space-y-2">
          <div class="flex items-center justify-between text-xs text-slate-600 mb-2">
            <span>Mengupload {{ currentUploadIndex + 1 }} dari {{ uploadQueue.length }} foto...</span>
            <span>{{ Math.round((currentUploadIndex / uploadQueue.length) * 100) }}%</span>
          </div>
          <div class="h-2 w-full overflow-hidden rounded-full bg-sky-100">
            <div class="h-full bg-gradient-to-r from-sky-500 to-sky-600 transition-all duration-300" :style="{ width: Math.round((currentUploadIndex / uploadQueue.length) * 100) + '%' }"></div>
          </div>
          <div v-if="currentUploadFile" class="text-xs text-slate-500">
            Sedang mengupload: {{ currentUploadFile }}
          </div>
        </div>

        <div class="flex gap-3">
      <button
            @click="closeUploadModal"
        :disabled="uploading"
        class="flex-1 rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 disabled:opacity-50"
      >
        Batal
      </button>
          <button
            v-if="selectedFiles.length > 0"
            @click="fileInput?.click()"
            :disabled="uploading"
            class="rounded-xl border border-sky-300 bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-600 disabled:opacity-50"
          >
            + Tambah Lagi
          </button>
          <button
            @click="uploadFiles"
            :disabled="uploading || selectedFiles.length === 0"
            class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
          >
            {{ uploading ? `Mengupload... (${currentUploadIndex + 1}/${uploadQueue.length})` : `Upload ${selectedFiles.length} Foto` }}
          </button>
        </div>
      </div>
    </div>

    <!-- Album Modal -->
    <div
      v-if="showAlbumModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="showAlbumModal = false"
    >
      <div class="w-full max-w-md rounded-2xl border border-sky-100 bg-white p-6 shadow-xl">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">{{ editingAlbum ? 'Edit Album' : 'Buat Album' }}</h3>
        <form @submit.prevent="saveAlbum" class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Nama Album *</label>
            <input v-model="albumForm.name" type="text" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea v-model="albumForm.description" rows="3" class="w-full rounded-xl border border-sky-200 px-4 py-2"></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Cover Image URL</label>
            <input v-model="albumForm.cover_image" type="text" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="URL gambar cover" />
          </div>
          <div class="flex gap-3">
            <button type="button" @click="showAlbumModal = false" class="flex-1 rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-semibold">
              Batal
            </button>
            <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const fileInput = ref<HTMLInputElement | null>(null)

const albums = ref<any[]>([])
const allMedia = ref<any[]>([])
const loading = ref(true)
const showUploadModal = ref(false)
const showAlbumModal = ref(false)
const selectedFiles = ref<Array<{ file: File; preview: string }>>([])
const uploading = ref(false)
const uploadQueue = ref<File[]>([])
const currentUploadIndex = ref(0)
const currentUploadFile = ref<string>('')
const editingAlbum = ref<any>(null)

const albumForm = ref({
  name: '',
  description: '',
  cover_image: '',
})

const getMediaUrl = (media: any) => {
  if (media.path) {
    // Gunakan URL backend untuk mengakses gambar
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    
    // Path dari database biasanya: "media/images/filename.jpg"
    // URL yang benar: "http://localhost:8000/storage/media/images/filename.jpg"
    const imageUrl = `${backendUrl}/storage/${media.path}`
    
    // Debug di development
    if (import.meta.env.DEV) {
      console.log('Media URL:', imageUrl, 'Path:', media.path)
    }
    
    return imageUrl
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
    albums.value = response.data.albums || []
    allMedia.value = response.data.all_media || []
  } catch (error) {
    console.error('Error fetching gallery:', error)
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
  const validFiles: Array<{ file: File; preview: string }> = []
    
  // Validasi semua file
  for (const file of files) {
    // Validasi ukuran file
    if (file.size > maxSize) {
      await swal.warning(`File "${file.name}" terlalu besar! Ukuran maksimal adalah 50MB. File Anda: ${formatFileSize(file.size)}`)
      continue
    }
    
    // Validasi tipe file
    if (!file.type.startsWith('image/')) {
      await swal.warning(`File "${file.name}" harus berupa gambar (JPEG, PNG, GIF, WebP)`)
      continue
    }
    
    // Cek apakah file sudah dipilih sebelumnya
    const isDuplicate = selectedFiles.value.some(f => f.file.name === file.name && f.file.size === file.size)
    if (isDuplicate) {
      continue
    }
    
    validFiles.push({
      file,
      preview: URL.createObjectURL(file)
    })
  }
  
  // Tambahkan file yang valid ke selectedFiles
  selectedFiles.value.push(...validFiles)
  
  // Reset input untuk memungkinkan memilih file yang sama lagi jika perlu
  target.value = ''
}

const removeFile = (index: number) => {
  if (selectedFiles.value[index].preview) {
    URL.revokeObjectURL(selectedFiles.value[index].preview)
  }
  selectedFiles.value.splice(index, 1)
    }

const clearSelectedFiles = () => {
  selectedFiles.value.forEach(file => {
    if (file.preview) {
      URL.revokeObjectURL(file.preview)
  }
  })
  selectedFiles.value = []
}

const closeUploadModal = () => {
  if (!uploading.value) {
    clearSelectedFiles()
    showUploadModal.value = false
  }
}

const uploadFiles = async () => {
  if (selectedFiles.value.length === 0) return

  uploading.value = true
  uploadQueue.value = selectedFiles.value.map(f => f.file)
  currentUploadIndex.value = 0
  let uploadedCount = 0
  const failedFiles: string[] = []

  try {
    // Upload semua file satu per satu
    for (let i = 0; i < uploadQueue.value.length; i++) {
      const file = uploadQueue.value[i]
      currentUploadIndex.value = i
      currentUploadFile.value = file.name

  try {
    const formData = new FormData()
        formData.append('file', file)

    const uploadConfig = {
          timeout: 300000 // 5 menit
        }

        await api.post('/v1/gallery/upload', formData, uploadConfig)
        uploadedCount++
      } catch (error: any) {
        console.error(`Error uploading ${file.name}:`, error)
        failedFiles.push(file.name)
      }
    }

    // Tampilkan hasil
    if (failedFiles.length === 0) {
      await swal.success(`${uploadedCount} foto berhasil diupload!`)
      closeUploadModal()
      await fetchGallery()
    } else {
      await swal.warning(`${uploadedCount} foto berhasil diupload. ${failedFiles.length} foto gagal: ${failedFiles.join(', ')}`)
      // Hapus file yang berhasil diupload dari selectedFiles
      const failedFileSet = new Set(failedFiles)
      selectedFiles.value = selectedFiles.value.filter((f) => failedFileSet.has(f.file.name))
      await fetchGallery()
    }
  } catch (error: any) {
    console.error('Error uploading files:', error)
    await swal.error('Terjadi kesalahan saat mengupload foto')
  } finally {
    uploading.value = false
    currentUploadIndex.value = 0
    currentUploadFile.value = ''
    uploadQueue.value = []
  }
}

const deleteMedia = async (id: number) => {
  const result = await swal.confirmDelete('foto ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/gallery/media/${id}`)
    await fetchGallery()
    await swal.success('Foto berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus foto')
    console.error('Error deleting media:', error)
  }
}

const editAlbum = (album: any) => {
  editingAlbum.value = album
  albumForm.value = {
    name: album.name,
    description: album.description || '',
    cover_image: album.cover_image || '',
  }
  showAlbumModal.value = true
}

const createAlbum = () => {
  editingAlbum.value = null
  albumForm.value = {
    name: '',
    description: '',
    cover_image: '',
  }
  showAlbumModal.value = true
}

const saveAlbum = async () => {
  try {
    if (editingAlbum.value) {
      await api.put(`/v1/gallery/albums/${editingAlbum.value.id}`, albumForm.value)
    } else {
      await api.post('/v1/gallery/albums', albumForm.value)
    }
    await swal.success('Album berhasil disimpan!')
    showAlbumModal.value = false
    editingAlbum.value = null
    albumForm.value = { name: '', description: '', cover_image: '' }
    await fetchGallery()
  } catch (error: any) {
    let errorMessage = 'Gagal menyimpan album'
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      const firstError = Object.values(errors)[0]
      if (Array.isArray(firstError) && firstError.length > 0) {
        errorMessage = firstError[0]
      }
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    }
    await swal.error(errorMessage)
    console.error('Error saving album:', error)
  }
}

const deleteAlbum = async (id: number) => {
  const result = await swal.confirmDelete('album ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/gallery/albums/${id}`)
    await fetchGallery()
    await swal.success('Album berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus album')
    console.error('Error deleting album:', error)
  }
}

onMounted(() => {
  fetchGallery()
})
</script>

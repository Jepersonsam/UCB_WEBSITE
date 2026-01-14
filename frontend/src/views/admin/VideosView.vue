<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Video</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola video</p>
      </div>
      <button
        @click="showFormModal = true; editingVideo = null"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02]"
      >
        + Tambah Video
      </button>
    </div>

    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="h-24 animate-pulse rounded-xl bg-sky-100"></div>
    </div>
    <div v-else-if="videos.length === 0" class="rounded-2xl border border-sky-100 bg-white p-12 text-center">
      <p class="text-slate-600">Belum ada video. Tambahkan video pertama Anda!</p>
    </div>
    <div v-else class="space-y-4">
      <div
        v-for="video in videos"
        :key="video.id"
        class="flex items-center gap-4 rounded-xl border border-sky-100 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
      >
        <div class="h-20 w-32 flex-shrink-0 overflow-hidden rounded-lg bg-sky-100">
          <img v-if="video.thumbnail" :src="video.thumbnail" :alt="video.title" class="h-full w-full object-cover" />
          <div v-else class="flex h-full items-center justify-center text-sky-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
        <div class="flex-1">
          <div class="flex items-center gap-2">
            <h3 class="font-semibold text-slate-900">{{ video.title }}</h3>
            <span v-if="video.video_type === 'file'" class="rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-700">
              File
            </span>
            <span v-else-if="video.video_type === 'gdrive'" class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
              Google Drive
            </span>
            <span v-else class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">
              URL
            </span>
          </div>
          <p class="mt-1 text-sm text-slate-600">{{ video.description || '-' }}</p>
          <p class="mt-1 text-xs text-slate-500">{{ video.category || '-' }} • {{ video.views || 0 }} views</p>
        </div>
        <div class="flex gap-2">
          <button
            @click="editVideo(video)"
            class="rounded-lg px-4 py-2 text-sm text-sky-600 transition-colors hover:bg-sky-50"
          >
            Edit
          </button>
          <button
            @click="deleteVideo(video.id)"
            class="rounded-lg px-4 py-2 text-sm text-red-600 transition-colors hover:bg-red-50"
          >
            Hapus
          </button>
        </div>
      </div>
    </div>

    <!-- Form Modal -->
    <div
      v-if="showFormModal"
      class="fixed inset-0 z-50 flex items-start justify-center bg-black/50 p-4 overflow-y-auto"
      @click.self="showFormModal = false"
    >
      <div class="w-full max-w-2xl rounded-2xl border border-sky-100 bg-white p-6 shadow-xl my-8 max-h-[90vh] overflow-y-auto">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">{{ editingVideo ? 'Edit Video' : 'Tambah Video' }}</h3>
        <form @submit.prevent="saveVideo" class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul *</label>
            <input v-model="form.title" type="text" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          
          <!-- Video Type Selection -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Tipe Video *</label>
            <div class="grid grid-cols-3 gap-3">
              <label class="flex items-center gap-2 cursor-pointer rounded-lg border border-sky-200 p-3 transition-colors hover:bg-sky-50" :class="{ 'bg-sky-100 border-sky-300': videoType === 'url' }">
                <input type="radio" v-model="videoType" value="url" class="text-sky-600" />
                <span class="text-sm text-slate-700">YouTube/Vimeo</span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer rounded-lg border border-sky-200 p-3 transition-colors hover:bg-sky-50" :class="{ 'bg-sky-100 border-sky-300': videoType === 'gdrive' }">
                <input type="radio" v-model="videoType" value="gdrive" class="text-sky-600" />
                <span class="text-sm text-slate-700">Google Drive</span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer rounded-lg border border-sky-200 p-3 transition-colors hover:bg-sky-50" :class="{ 'bg-sky-100 border-sky-300': videoType === 'file' }">
                <input type="radio" v-model="videoType" value="file" class="text-sky-600" />
                <span class="text-sm text-slate-700">Upload File</span>
              </label>
            </div>
          </div>

          <!-- Video URL Input (YouTube/Vimeo) -->
          <div v-if="videoType === 'url'">
            <label class="mb-2 block text-sm font-medium text-slate-700">Video URL (YouTube/Vimeo) *</label>
            <input v-model="form.video_url" type="url" :required="videoType === 'url'" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="https://youtube.com/watch?v=..." />
            <p class="mt-1 text-xs text-slate-500">Masukkan link YouTube atau Vimeo</p>
          </div>

          <!-- Google Drive Input -->
          <div v-if="videoType === 'gdrive'">
            <label class="mb-2 block text-sm font-medium text-slate-700">Google Drive Link *</label>
            <input v-model="form.video_url" type="url" :required="videoType === 'gdrive'" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="https://drive.google.com/file/d/..." />
            <p class="mt-1 text-xs text-slate-500">
              Masukkan link Google Drive. Pastikan file sudah di-share dengan "Anyone with the link can view"
            </p>
            <div class="mt-2 rounded-lg border border-sky-200 bg-sky-50 p-3">
              <p class="text-xs font-medium text-sky-700 mb-1">Cara mendapatkan link:</p>
              <ol class="text-xs text-slate-600 space-y-1 list-decimal list-inside">
                <li>Buka file video di Google Drive</li>
                <li>Klik kanan → "Get link" atau "Dapatkan tautan"</li>
                <li>Ubah akses menjadi "Anyone with the link"</li>
                <li>Copy link dan paste di sini</li>
              </ol>
            </div>
          </div>

          <!-- Video File Upload -->
          <div v-if="videoType === 'file'">
            <label class="mb-2 block text-sm font-medium text-slate-700">Upload Video File *</label>
            <input
              ref="videoFileInput"
              type="file"
              accept="video/*"
              @change="handleVideoFileSelect"
              :required="videoType === 'file'"
              class="w-full rounded-xl border border-sky-200 px-4 py-2"
            />
            <p v-if="selectedVideoFile" class="mt-2 text-sm text-slate-600">
              File dipilih: {{ selectedVideoFile.name }} ({{ formatFileSize(selectedVideoFile.size) }})
            </p>
            <p class="mt-1 text-xs text-slate-500">Format: MP4, AVI, MOV, WMV, FLV, WebM (Maks. 500MB)</p>
          </div>

          <!-- Thumbnail Section -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Thumbnail</label>
            <div class="space-y-3">
              <div>
                <label class="mb-1 block text-xs text-slate-600">URL Thumbnail</label>
                <input v-model="form.thumbnail" type="url" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="https://..." />
              </div>
              <div class="text-center text-xs text-slate-500">atau</div>
              <div>
                <label class="mb-1 block text-xs text-slate-600">Upload Thumbnail</label>
                <input
                  ref="thumbnailFileInput"
                  type="file"
                  accept="image/*"
                  @change="handleThumbnailFileSelect"
                  class="w-full rounded-xl border border-sky-200 px-4 py-2"
                />
                <p v-if="selectedThumbnailFile" class="mt-2 text-sm text-slate-600">
                  File dipilih: {{ selectedThumbnailFile.name }}
                </p>
                <p class="mt-1 text-xs text-slate-500">Format: JPEG, PNG, GIF, WebP (Maks. 10MB)</p>
              </div>
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea v-model="form.description" rows="3" class="w-full rounded-xl border border-sky-200 px-4 py-2"></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
            <input v-model="form.category" type="text" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="Konser, Pelayanan, dll" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Durasi</label>
            <input v-model="form.duration" type="text" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="00:05:30" />
          </div>
          <div v-if="uploadProgress > 0 && uploadProgress < 100 && videoType === 'file'" class="mb-4">
            <div class="mb-1 flex items-center justify-between text-xs text-slate-600">
              <span>Mengupload video...</span>
              <span>{{ uploadProgress }}%</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-sky-100">
              <div class="h-full bg-gradient-to-r from-sky-500 to-sky-600 transition-all duration-300" :style="{ width: uploadProgress + '%' }"></div>
            </div>
          </div>
          <div class="flex gap-3">
            <button type="button" @click="resetForm" :disabled="saving" class="flex-1 rounded-xl border border-sky-200 px-4 py-2 text-sm font-semibold disabled:opacity-50">
              Batal
            </button>
            <button type="submit" :disabled="saving" class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50">
              {{ saving ? (uploadProgress > 0 ? `Mengupload... ${uploadProgress}%` : 'Menyimpan...') : 'Simpan' }}
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

const videos = ref<any[]>([])
const loading = ref(true)
const showFormModal = ref(false)
const editingVideo = ref<any>(null)
const saving = ref(false)
const uploadProgress = ref(0)
const videoType = ref<'url' | 'gdrive' | 'file'>('url')
const selectedVideoFile = ref<File | null>(null)
const selectedThumbnailFile = ref<File | null>(null)

const form = ref({
  title: '',
  video_url: '',
  thumbnail: '',
  description: '',
  category: '',
  duration: '',
})

const fetchVideos = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/videos')
    videos.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching videos:', error)
  } finally {
    loading.value = false
  }
}

const handleVideoFileSelect = async (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files && target.files[0]) {
    const file = target.files[0]
    const maxSize = 500 * 1024 * 1024 // 500MB dalam bytes
    
    // Validasi ukuran file
    if (file.size > maxSize) {
      await swal.warning(`File terlalu besar! Ukuran maksimal adalah 500MB. File Anda: ${formatFileSize(file.size)}`)
      target.value = '' // Reset input
      selectedVideoFile.value = null
      return
    }
    
    selectedVideoFile.value = file
  }
}

const handleThumbnailFileSelect = (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedThumbnailFile.value = target.files[0]
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const resetForm = () => {
  showFormModal.value = false
  editingVideo.value = null
  videoType.value = 'url'
  selectedVideoFile.value = null
  selectedThumbnailFile.value = null
  uploadProgress.value = 0
  form.value = { title: '', video_url: '', thumbnail: '', description: '', category: '', duration: '' }
}

const editVideo = (video: any) => {
  editingVideo.value = video
  form.value = { ...video }
  // Tentukan tipe video berdasarkan video_type atau URL
  if (video.video_type === 'file') {
    videoType.value = 'file'
  } else if (video.video_type === 'gdrive' || (video.video_url && video.video_url.includes('drive.google.com'))) {
    videoType.value = 'gdrive'
  } else {
    videoType.value = 'url'
  }
  selectedVideoFile.value = null
  selectedThumbnailFile.value = null
  showFormModal.value = true
}

const saveVideo = async () => {
  saving.value = true
  try {
    // Validasi frontend
    if (!form.value.title || !form.value.title.trim()) {
      await swal.warning('Judul video harus diisi')
      saving.value = false
      return
    }

    if (videoType.value === 'url' || videoType.value === 'gdrive') {
      if (!form.value.video_url || !form.value.video_url.trim()) {
        await swal.warning('Video URL harus diisi')
        saving.value = false
        return
      }
    } else if (videoType.value === 'file') {
      if (!selectedVideoFile.value && !editingVideo.value) {
        await swal.warning('File video harus dipilih')
        saving.value = false
        return
      }
    }

    const formData = new FormData()
    
    // Add form fields
    formData.append('title', form.value.title.trim())
    if (form.value.description) formData.append('description', form.value.description.trim())
    if (form.value.category) formData.append('category', form.value.category.trim())
    if (form.value.duration) formData.append('duration', form.value.duration.trim())
    
    // Add video (either URL, Google Drive, or file)
    if (videoType.value === 'url' || videoType.value === 'gdrive') {
      formData.append('video_url', form.value.video_url.trim())
      // Tandai sebagai Google Drive jika tipe adalah gdrive
      if (videoType.value === 'gdrive') {
        formData.append('video_type', 'gdrive')
      }
    } else if (videoType.value === 'file' && selectedVideoFile.value) {
      formData.append('video_file', selectedVideoFile.value)
    }
    // Jika edit dan tidak ada perubahan video, backend akan menggunakan yang lama
    
    // Add thumbnail (either URL or file)
    if (form.value.thumbnail && form.value.thumbnail.trim()) {
      formData.append('thumbnail', form.value.thumbnail.trim())
    }
    if (selectedThumbnailFile.value) {
      formData.append('thumbnail_file', selectedThumbnailFile.value)
    }

    // Konfigurasi timeout khusus untuk upload file besar (10 menit)
    uploadProgress.value = 0
    const uploadConfig = {
      timeout: 600000, // 10 menit dalam milliseconds
      onUploadProgress: (progressEvent: any) => {
        if (progressEvent.total) {
          const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
          uploadProgress.value = percentCompleted
          console.log(`Upload progress: ${percentCompleted}%`)
        }
      }
    }

    if (editingVideo.value) {
      await api.put(`/v1/videos/${editingVideo.value.id}`, formData, uploadConfig)
    } else {
      await api.post('/v1/videos', formData, uploadConfig)
    }
    
    await swal.success('Video berhasil disimpan!')
    resetForm()
    await fetchVideos()
  } catch (error: any) {
    let errorMessage = 'Gagal menyimpan video'
    
    // Handle validation errors
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      const errorMessages: string[] = []
      Object.keys(errors).forEach(key => {
        if (Array.isArray(errors[key])) {
          errorMessages.push(...errors[key])
        } else {
          errorMessages.push(errors[key])
        }
      })
      if (errorMessages.length > 0) {
        errorMessage = errorMessages.join('\n')
      }
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    } else if (error.message) {
      errorMessage = error.message
    } else if (error.code === 'ECONNABORTED') {
      errorMessage = 'Upload timeout. File terlalu besar atau koneksi lambat. Silakan coba lagi.'
    }
    
    console.error('Error saving video:', error)
    console.error('Error response:', error.response?.data)
    await swal.error(errorMessage)
    uploadProgress.value = 0
  } finally {
    saving.value = false
  }
}

const deleteVideo = async (id: number) => {
  const result = await swal.confirmDelete('video ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/videos/${id}`)
    await fetchVideos()
    await swal.success('Video berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus video')
    console.error('Error deleting video:', error)
  }
}

onMounted(() => {
  fetchVideos()
})
</script>

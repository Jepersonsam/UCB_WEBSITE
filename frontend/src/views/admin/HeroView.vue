<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Hero Section</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola konten hero section di halaman beranda</p>
    </div>

    <div v-if="!contentLoaded" class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm animate-pulse">
      <div class="h-6 w-1/2 bg-sky-100 rounded mb-4"></div>
      <div class="h-4 w-full bg-sky-50 rounded mb-2"></div>
      <div class="h-4 w-full bg-sky-50 rounded"></div>
    </div>
    <div v-else-if="!contentSaved" class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800 mb-4">
      <p>Konten ini belum pernah disimpan ke database. Ini adalah konten default dari website.</p>
    </div>

    <form @submit.prevent="saveHero" class="space-y-6">
      <!-- Konten Utama -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Konten Utama</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Tag Text</label>
            <input
              v-model="heroContent.tag"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Harmoni • Pelayanan • Komunitas"
            />
            <p class="mt-1 text-xs text-slate-500">Teks yang muncul di badge/tag di atas heading</p>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Heading Baris 1</label>
            <input
              v-model="heroContent.heading1"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Pujian yang"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Heading Baris 2</label>
            <input
              v-model="heroContent.heading2"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Tak Berkesudahan"
            />
            <p class="mt-1 text-xs text-slate-500">Teks ini akan ditampilkan dengan warna gradient biru</p>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea
              v-model="heroContent.description"
              rows="4"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar di Universitas Advent Indonesia (UNAI), Bandung. Melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Tombol CTA -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Tombol Call-to-Action</h3>
        <div class="grid gap-4 sm:grid-cols-2">
          <div class="rounded-xl border border-sky-100 bg-slate-50 p-4">
            <h4 class="mb-3 font-semibold text-slate-800">Tombol Utama</h4>
            <div class="space-y-3">
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Teks Tombol</label>
                <input
                  v-model="heroContent.button1.text"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="Lihat Jadwal Pelayanan"
                />
              </div>
            </div>
          </div>
          <div class="rounded-xl border border-sky-100 bg-slate-50 p-4">
            <h4 class="mb-3 font-semibold text-slate-800">Tombol Sekunder</h4>
            <div class="space-y-3">
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600">Teks Tombol</label>
                <input
                  v-model="heroContent.button2.text"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="Bergabung dengan Kami"
                />
              </div>
             
            </div>
          </div>
        </div>
      </div>

      <!-- Hero Image -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Gambar Hero</h3>
        <div class="space-y-4">
          <!-- Tab untuk memilih metode -->
          <div class="flex gap-2 border-b border-sky-100">
            <button
              type="button"
              @click="imageMethod = 'url'"
              class="px-4 py-2 text-sm font-medium transition-colors"
              :class="imageMethod === 'url' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-slate-600 hover:text-sky-600'"
            >
              URL / Path
            </button>
            <button
              type="button"
              @click="imageMethod = 'upload'"
              class="px-4 py-2 text-sm font-medium transition-colors"
              :class="imageMethod === 'upload' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-slate-600 hover:text-sky-600'"
            >
              Upload Baru
            </button>
            <button
              type="button"
              @click="imageMethod = 'gallery'; openGalleryModal()"
              class="px-4 py-2 text-sm font-medium transition-colors"
              :class="imageMethod === 'gallery' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-slate-600 hover:text-sky-600'"
            >
              Pilih dari Galeri
            </button>
          </div>

          <!-- URL Input -->
          <div v-if="imageMethod === 'url'">
            <label class="mb-2 block text-sm font-medium text-slate-700">URL Gambar</label>
            <input
              v-model="heroContent.imageUrl"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="/UCB.png atau URL lengkap gambar"
            />
            <p class="mt-1 text-xs text-slate-500">Gunakan path relatif (contoh: /UCB.png) atau URL lengkap (contoh: https://example.com/image.jpg)</p>
          </div>

          <!-- Upload Input -->
          <div v-if="imageMethod === 'upload'">
            <input
              ref="imageUploadInput"
              type="file"
              accept="image/*"
              @change="handleImageUpload"
              class="hidden"
            />
            <div
              @click="imageUploadInput?.click()"
              class="cursor-pointer rounded-xl border-2 border-dashed border-sky-300 bg-sky-50 p-8 text-center transition-colors hover:border-sky-400 hover:bg-sky-100"
            >
              <svg class="mx-auto h-12 w-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <p class="mt-2 text-sm font-medium text-slate-700">Klik untuk upload gambar</p>
              <p class="mt-1 text-xs text-slate-500">Format: JPEG, PNG, GIF, WebP (Maks. 50MB)</p>
            </div>
            <div v-if="uploadingImage" class="mt-4">
              <div class="mb-2 flex items-center justify-between text-xs text-slate-600">
                <span>Mengupload...</span>
                <span>{{ uploadProgress }}%</span>
              </div>
              <div class="h-2 w-full overflow-hidden rounded-full bg-sky-100">
                <div class="h-full bg-gradient-to-r from-sky-500 to-sky-600 transition-all duration-300" :style="{ width: uploadProgress + '%' }"></div>
              </div>
            </div>
          </div>

          <!-- Preview -->
          <div v-if="heroContent.imageUrl" class="rounded-xl border border-sky-200 bg-slate-50 p-4">
            <p class="mb-2 text-xs font-medium text-slate-600">Preview:</p>
            <img
              :src="getImageUrl(heroContent.imageUrl)"
              alt="Hero preview"
              class="max-h-64 w-full rounded-lg object-cover"
              @error="handleImageError"
            />
            <button
              type="button"
              @click="heroContent.imageUrl = ''"
              class="mt-2 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-100"
            >
              Hapus Gambar
            </button>
          </div>
        </div>
      </div>

      <!-- Gallery Modal -->
      <div
        v-if="showGalleryModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        @click.self="showGalleryModal = false"
      >
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl border border-sky-100 bg-white p-6 shadow-xl">
          <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800">Pilih Gambar dari Galeri</h3>
            <button
              @click="showGalleryModal = false"
              class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
            >
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div v-if="loadingGallery" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div v-for="i in 8" :key="i" class="aspect-square animate-pulse rounded-xl bg-sky-100"></div>
          </div>
          <div v-else-if="galleryImages.length === 0" class="rounded-xl border border-sky-100 bg-slate-50 p-12 text-center">
            <p class="text-slate-600">Belum ada gambar di galeri</p>
          </div>
          <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div
              v-for="image in galleryImages"
              :key="image.id"
              class="group relative aspect-square cursor-pointer overflow-hidden rounded-xl border-2 transition-all"
              :class="selectedGalleryImage?.id === image.id ? 'border-sky-500 ring-2 ring-sky-200' : 'border-sky-100 hover:border-sky-300'"
              @click="selectedGalleryImage = image"
            >
              <img
                :src="getMediaUrl(image)"
                :alt="image.alt_text || image.original_filename"
                class="h-full w-full object-cover transition-transform group-hover:scale-110"
              />
              <div v-if="selectedGalleryImage?.id === image.id" class="absolute inset-0 flex items-center justify-center bg-sky-500/20">
                <div class="rounded-full bg-sky-500 p-2">
                  <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div v-if="galleryImages.length > 0" class="mt-6 flex justify-end gap-3">
            <button
              @click="showGalleryModal = false"
              class="rounded-xl border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700"
            >
              Batal
            </button>
            <button
              @click="selectGalleryImage"
              :disabled="!selectedGalleryImage"
              class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
            >
              Pilih Gambar
            </button>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end gap-4 border-t border-sky-100 pt-6">
        <button
          type="submit"
          :disabled="saving"
          class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl disabled:opacity-50"
        >
          <span v-if="saving">Menyimpan...</span>
          <span v-else>Simpan Konten</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const imageUploadInput = ref<HTMLInputElement | null>(null)
const imageMethod = ref<'url' | 'upload' | 'gallery'>('url')
const showGalleryModal = ref(false)
const loadingGallery = ref(false)
const galleryImages = ref<any[]>([])
const selectedGalleryImage = ref<any>(null)
const uploadingImage = ref(false)
const uploadProgress = ref(0)

const defaultContent = {
  tag: 'Harmoni • Pelayanan • Komunitas',
  heading1: 'Pujian yang',
  heading2: 'Tak Berkesudahan',
  description: 'Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar di Universitas Advent Indonesia (UNAI), Bandung. Melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni.',
  button1: {
    text: 'Lihat Jadwal Pelayanan',
    url: '/schedule'
  },
  button2: {
    text: 'Bergabung dengan Kami',
    url: '/join'
  },
  imageUrl: '/UCB.png'
}

const heroContent = ref({ ...defaultContent })
const saving = ref(false)
const contentLoaded = ref(false)
const contentSaved = ref(false)

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23e0e7ef" width="200" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const getImageUrl = (url: string) => {
  if (!url) return ''
  if (url.startsWith('http://') || url.startsWith('https://')) {
    return url
  }
  if (url.startsWith('/')) {
    return url
  }
  // Jika path dari storage (contoh: media/images/filename.jpg)
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${url}`
}

const getMediaUrl = (media: any) => {
  if (media.path) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}/storage/${media.path}`
  }
  return ''
}

const handleImageUpload = async (e: Event) => {
  const target = e.target as HTMLInputElement
  if (!target.files || target.files.length === 0) return

  const file = target.files[0]
  const maxSize = 50 * 1024 * 1024 // 50MB

  if (file.size > maxSize) {
    await swal.warning('File terlalu besar! Ukuran maksimal adalah 50MB.')
    target.value = ''
    return
  }

  if (!file.type.startsWith('image/')) {
    await swal.warning('File harus berupa gambar (JPEG, PNG, GIF, WebP)')
    target.value = ''
    return
  }

  uploadingImage.value = true
  uploadProgress.value = 0

  try {
    const formData = new FormData()
    formData.append('file', file)

    const uploadConfig = {
      timeout: 300000, // 5 menit
      onUploadProgress: (progressEvent: any) => {
        if (progressEvent.total) {
          const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
          uploadProgress.value = percentCompleted
        }
      }
    }

    const response = await api.post('/v1/gallery/upload', formData, uploadConfig)
    const media = response.data.media || response.data
    
    // Set imageUrl ke path dari response
    if (media.path) {
      heroContent.value.imageUrl = media.path
      imageMethod.value = 'url'
      await swal.success('Gambar berhasil diupload!')
    }
  } catch (error: any) {
    console.error('Error uploading image:', error)
    let errorMessage = 'Gagal upload gambar'
    if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    }
    await swal.error(errorMessage)
  } finally {
    uploadingImage.value = false
    uploadProgress.value = 0
    target.value = ''
  }
}

const fetchGallery = async () => {
  loadingGallery.value = true
  try {
    const response = await api.get('/v1/gallery')
    galleryImages.value = response.data.all_media || []
  } catch (error) {
    console.error('Error fetching gallery:', error)
    galleryImages.value = []
  } finally {
    loadingGallery.value = false
  }
}

const selectGalleryImage = () => {
  if (selectedGalleryImage.value) {
    if (selectedGalleryImage.value.path) {
      heroContent.value.imageUrl = selectedGalleryImage.value.path
      imageMethod.value = 'url'
    }
    showGalleryModal.value = false
    selectedGalleryImage.value = null
  }
}

const openGalleryModal = () => {
  showGalleryModal.value = true
  fetchGallery()
}

const fetchHero = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.hero_content) {
      try {
        const parsed = typeof data.hero_content === 'string' 
          ? JSON.parse(data.hero_content) 
          : data.hero_content
        
        heroContent.value = { 
          ...defaultContent, 
          ...parsed,
          button1: { ...defaultContent.button1, ...(parsed.button1 || {}) },
          button2: { ...defaultContent.button2, ...(parsed.button2 || {}) }
        }
        contentSaved.value = true
      } catch (e) {
        console.error('Error parsing hero_content:', e)
        heroContent.value = { ...defaultContent }
        contentSaved.value = false
      }
    } else {
      heroContent.value = { ...defaultContent }
      contentSaved.value = false
    }
  } catch (error) {
    console.error('Error fetching hero content:', error)
    heroContent.value = { ...defaultContent }
    contentSaved.value = false
  } finally {
    contentLoaded.value = true
  }
}

const saveHero = async () => {
  saving.value = true
  try {
    await api.put('/v1/settings', {
      settings: {
        hero_content: JSON.stringify(heroContent.value)
      }
    })
    await swal.success('Konten Hero Section berhasil disimpan!')
    contentSaved.value = true
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menyimpan konten')
    console.error('Error saving hero content:', error)
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchHero()
})
</script>


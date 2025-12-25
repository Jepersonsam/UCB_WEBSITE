<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">{{ isEdit ? 'Edit Artikel' : 'Buat Artikel Baru' }}</h1>
      <p class="mt-1 text-sm text-slate-600">{{ isEdit ? 'Ubah informasi artikel' : 'Tambahkan artikel baru ke website' }}</p>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
          <!-- Title -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul Artikel *</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Masukkan judul artikel"
            />
          </div>

          <!-- Slug -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Slug *</label>
            <input
              v-model="form.slug"
              type="text"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="judul-artikel"
            />
            <p class="mt-1 text-xs text-slate-500">URL-friendly version of the title</p>
          </div>

          <!-- Excerpt -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Ringkasan</label>
            <textarea
              v-model="form.excerpt"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Ringkasan singkat artikel"
            ></textarea>
          </div>

          <!-- Content -->
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Konten *</label>
            <textarea
              v-model="form.content"
              rows="15"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200 font-mono text-sm"
              placeholder="Tulis konten artikel di sini..."
            ></textarea>
          </div>
        </div>

        <div class="space-y-6">
          <!-- Status -->
          <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-slate-800">Publikasi</h3>
            <div class="space-y-3">
              <label class="flex items-center gap-3">
                <input
                  v-model="form.status"
                  type="radio"
                  value="draft"
                  class="h-4 w-4 text-sky-600"
                />
                <span class="text-sm text-slate-700">Draft</span>
              </label>
              <label class="flex items-center gap-3">
                <input
                  v-model="form.status"
                  type="radio"
                  value="published"
                  class="h-4 w-4 text-sky-600"
                />
                <span class="text-sm text-slate-700">Published</span>
              </label>
              <label class="flex items-center gap-3">
                <input
                  v-model="form.status"
                  type="radio"
                  value="archived"
                  class="h-4 w-4 text-sky-600"
                />
                <span class="text-sm text-slate-700">Archived</span>
              </label>
            </div>
          </div>

          <!-- Category -->
          <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
            <label class="mb-2 block text-sm font-semibold text-slate-800">Kategori *</label>
            <select
              v-model="form.category_id"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
            >
              <option value="">Pilih Kategori</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                {{ cat.name }}
              </option>
            </select>
          </div>

          <!-- Tags -->
          <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
            <label class="mb-2 block text-sm font-semibold text-slate-800">Tags</label>
            <div class="space-y-2">
              <label v-for="tag in tags" :key="tag.id" class="flex items-center gap-2">
                <input
                  v-model="form.tags"
                  type="checkbox"
                  :value="tag.id"
                  class="h-4 w-4 rounded border-sky-300 text-sky-600"
                />
                <span class="text-sm text-slate-700">{{ tag.name }}</span>
              </label>
            </div>
          </div>

          <!-- Featured Image -->
          <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
            <label class="mb-4 block text-sm font-semibold text-slate-800">Featured Image</label>
            
            <!-- Image Method Selection -->
            <div class="mb-4 flex gap-2">
              <button
                type="button"
                @click="imageMethod = 'url'"
                :class="[
                  'flex-1 rounded-lg px-4 py-2 text-sm font-medium transition-all',
                  imageMethod === 'url' 
                    ? 'bg-sky-500 text-white' 
                    : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                ]"
              >
                URL
              </button>
              <button
                type="button"
                @click="imageMethod = 'upload'"
                :class="[
                  'flex-1 rounded-lg px-4 py-2 text-sm font-medium transition-all',
                  imageMethod === 'upload' 
                    ? 'bg-sky-500 text-white' 
                    : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                ]"
              >
                Upload
              </button>
              <button
                type="button"
                @click="openGalleryModal"
                :class="[
                  'flex-1 rounded-lg px-4 py-2 text-sm font-medium transition-all',
                  imageMethod === 'gallery' 
                    ? 'bg-sky-500 text-white' 
                    : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                ]"
              >
                Galeri
              </button>
            </div>

            <!-- URL Input -->
            <div v-if="imageMethod === 'url'" class="space-y-3">
              <input
                v-model="form.featured_image"
                type="text"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="https://... atau path seperti media/images/..."
              />
              <div v-if="form.featured_image" class="mt-3">
                <img
                  :src="getImagePreviewUrl(form.featured_image)"
                  alt="Preview"
                  class="h-32 w-full rounded-lg border border-sky-200 object-cover"
                  @error="handleImageError"
                />
              </div>
            </div>

            <!-- Upload Input -->
            <div v-if="imageMethod === 'upload'" class="space-y-3">
              <input
                ref="fileInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="handleFileSelect"
              />
              <button
                type="button"
                @click="fileInput?.click()"
                class="w-full rounded-xl border-2 border-dashed border-sky-300 bg-sky-50 px-4 py-8 text-center transition-all hover:border-sky-400 hover:bg-sky-100"
              >
                <svg class="mx-auto h-12 w-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <p class="mt-2 text-sm font-medium text-sky-600">Klik untuk upload gambar</p>
                <p class="mt-1 text-xs text-slate-500">JPG, PNG, GIF, atau WEBP (max 10MB)</p>
              </button>
              <div v-if="featuredImageFile" class="mt-3 space-y-2">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-slate-700">{{ featuredImageFile.name }}</p>
                  <button
                    type="button"
                    @click="clearUploadedFile"
                    class="text-xs text-red-600 hover:text-red-700"
                  >
                    Hapus
                  </button>
                </div>
                <img
                  :src="form.featured_image"
                  alt="Preview"
                  class="h-32 w-full rounded-lg border border-sky-200 object-cover"
                  @error="handleImageError"
                />
                <p class="text-xs text-slate-500">Gambar akan diupload saat artikel disimpan</p>
              </div>
            </div>

            <!-- Gallery Selection -->
            <div v-if="imageMethod === 'gallery'" class="space-y-3">
              <button
                type="button"
                @click="openGalleryModal"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-sm font-medium text-sky-600 transition-all hover:bg-sky-50"
              >
                Pilih dari Galeri
              </button>
              <div v-if="form.featured_image" class="mt-3">
                <img
                  :src="getImagePreviewUrl(form.featured_image)"
                  alt="Preview"
                  class="h-32 w-full rounded-lg border border-sky-200 object-cover"
                  @error="handleImageError"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Meta -->
      <div class="grid gap-6 sm:grid-cols-2">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Meta Title</label>
          <input
            v-model="form.meta_title"
            type="text"
            class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
          />
        </div>
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Meta Description</label>
          <textarea
            v-model="form.meta_description"
            rows="2"
            class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
          ></textarea>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end gap-4 border-t border-sky-100 pt-6">
        <RouterLink
          to="/articles"
          class="rounded-xl border border-sky-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition-all hover:bg-sky-50"
        >
          Batal
        </RouterLink>
        <button
          type="submit"
          :disabled="loading"
          class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl disabled:opacity-50"
        >
          <span v-if="loading">Menyimpan...</span>
          <span v-else>{{ isEdit ? 'Update Artikel' : 'Simpan Artikel' }}</span>
        </button>
      </div>
    </form>

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
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter, RouterLink } from 'vue-router'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const route = useRoute()
const router = useRouter()

const isEdit = computed(() => route.name === 'article-edit')
const articleId = computed(() => route.params.id as string)

const form = ref({
  title: '',
  slug: '',
  excerpt: '',
  content: '',
  category_id: '',
  status: 'draft',
  tags: [] as number[],
  featured_image: '',
  meta_title: '',
  meta_description: '',
})

const categories = ref<any[]>([])
const tags = ref<any[]>([])
const loading = ref(false)

// Featured Image Upload
const fileInput = ref<HTMLInputElement | null>(null)
const imageMethod = ref<'url' | 'upload' | 'gallery'>('url')
const showGalleryModal = ref(false)
const loadingGallery = ref(false)
const galleryImages = ref<any[]>([])
const selectedGalleryImage = ref<any>(null)
const featuredImageFile = ref<File | null>(null)

const fetchCategories = async () => {
  try {
    const response = await api.get('/v1/categories')
    categories.value = response.data
  } catch (error) {
    console.error('Error fetching categories:', error)
  }
}

const fetchTags = async () => {
  try {
    const response = await api.get('/v1/tags')
    tags.value = response.data
  } catch (error) {
    console.error('Error fetching tags:', error)
  }
}

const fetchArticle = async () => {
  if (!isEdit.value) return

  loading.value = true
  try {
    const response = await api.get(`/v1/articles/${articleId.value}`)
    const article = response.data
    
    // Ensure all fields are properly set
    form.value = {
      title: article.title || '',
      slug: article.slug || '',
      excerpt: article.excerpt || '',
      content: article.content || '',
      category_id: article.category_id || article.category?.id || '',
      status: article.status || 'draft',
      tags: article.tags?.map((t: any) => t.id) || [],
      featured_image: article.featured_image || '',
      meta_title: article.meta_title || '',
      meta_description: article.meta_description || '',
    }
    
    // Set image method based on existing featured_image
    if (article.featured_image) {
      // If featured_image exists, set method to 'url' to show it
      imageMethod.value = 'url'
      featuredImageFile.value = null // Clear any uploaded file
    } else {
      imageMethod.value = 'url'
    }
  } catch (error) {
    console.error('Error fetching article:', error)
    await swal.error('Gagal memuat artikel')
    router.push('/articles')
  } finally {
    loading.value = false
  }
}

const getImagePreviewUrl = (imagePath: string) => {
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
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="200"%3E%3Crect fill="%23e0e7ef" width="400" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const handleFileSelect = async (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (!file) return

  // Validate file type
  if (!file.type.startsWith('image/')) {
    await swal.error('File harus berupa gambar')
    return
  }

  // Validate file size (10MB)
  if (file.size > 10 * 1024 * 1024) {
    await swal.error('Ukuran file maksimal 10MB')
    return
  }

  // Store file for later upload (will be uploaded when article is saved)
  featuredImageFile.value = file
  imageMethod.value = 'upload' // Set method to upload
  
  // Create preview URL
  const reader = new FileReader()
  reader.onload = (e) => {
    if (e.target?.result) {
      form.value.featured_image = e.target.result as string
    }
  }
  reader.readAsDataURL(file)
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

const openGalleryModal = () => {
  showGalleryModal.value = true
  imageMethod.value = 'gallery'
  fetchGallery()
}

const selectGalleryImage = () => {
  if (selectedGalleryImage.value) {
    if (selectedGalleryImage.value.path) {
      form.value.featured_image = selectedGalleryImage.value.path
      featuredImageFile.value = null // Clear uploaded file if gallery image is selected
      imageMethod.value = 'url'
      console.log('Selected gallery image:', selectedGalleryImage.value.path) // Debug
    }
    showGalleryModal.value = false
    selectedGalleryImage.value = null
  }
}

const clearUploadedFile = () => {
  featuredImageFile.value = null
  form.value.featured_image = ''
  imageMethod.value = 'url' // Reset to URL method
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const getMediaUrl = (media: any) => {
  if (media.path) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}/storage/${media.path}`
  }
  return ''
}

const handleSubmit = async () => {
  // Validate required fields
  if (!form.value.title || !form.value.title.trim()) {
    await swal.error('Judul artikel harus diisi')
    return
  }
  if (!form.value.slug || !form.value.slug.trim()) {
    await swal.error('Slug artikel harus diisi')
    return
  }
  if (!form.value.content || !form.value.content.trim()) {
    await swal.error('Konten artikel harus diisi')
    return
  }
  if (!form.value.category_id) {
    await swal.error('Kategori harus dipilih')
    return
  }
  if (!form.value.status) {
    await swal.error('Status artikel harus dipilih')
    return
  }

  loading.value = true
  try {
    const formData = new FormData()
    
    // Add all form fields - ensure all required fields have values
    const title = (form.value.title || '').trim()
    const slug = (form.value.slug || '').trim()
    const content = (form.value.content || '').trim()
    const categoryId = form.value.category_id
    const status = form.value.status || 'draft'
    
    if (!title || !slug || !content || !categoryId || !status) {
      await swal.error('Mohon lengkapi semua field yang wajib diisi')
      loading.value = false
      return
    }
    
    formData.append('title', title)
    formData.append('slug', slug)
    formData.append('excerpt', (form.value.excerpt || '').trim())
    formData.append('content', content)
    formData.append('category_id', categoryId.toString())
    formData.append('status', status)
    formData.append('meta_title', (form.value.meta_title || '').trim())
    formData.append('meta_description', (form.value.meta_description || '').trim())
    
    // Add featured image file if uploaded (priority over URL)
    if (featuredImageFile.value) {
      formData.append('featured_image_file', featuredImageFile.value)
    } else {
      // Always send featured_image when editing (even if empty, to allow clearing)
      // This ensures backend knows we want to update this field
      if (isEdit.value) {
        // When editing, always send featured_image (even if empty string)
        // This ensures the backend will update the featured_image field
        const featuredImageValue = form.value.featured_image || ''
        if (featuredImageValue) {
          formData.append('featured_image', featuredImageValue)
          console.log('Sending featured_image for update:', featuredImageValue) // Debug
        } else {
          // Send empty string to clear the image
          formData.append('featured_image', '')
          console.log('Sending empty featured_image to clear') // Debug
        }
        console.log('Form featured_image value:', form.value.featured_image) // Debug
      } else if (form.value.featured_image) {
        // When creating, only send if it exists
        formData.append('featured_image', form.value.featured_image)
      }
    }
    
    // Add tags
    if (form.value.tags && form.value.tags.length > 0) {
      form.value.tags.forEach((tagId: number) => {
        formData.append('tags[]', tagId.toString())
      })
    }

    // Debug: Log FormData contents
    console.log('FormData contents:')
    for (const [key, value] of formData.entries()) {
      console.log(`${key}:`, value)
    }

    const config = {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    }

    if (isEdit.value) {
      console.log('Updating article with ID:', articleId.value)
      await api.put(`/v1/articles/${articleId.value}`, formData, config)
    } else {
      await api.post('/v1/articles', formData, config)
    }

    await swal.success('Artikel berhasil disimpan!')
    router.push('/articles')
  } catch (error: any) {
    console.error('Error saving article:', error)
    const errorMessage = error.response?.data?.message || error.response?.data?.errors || 'Gagal menyimpan artikel'
    await swal.error(typeof errorMessage === 'string' ? errorMessage : 'Gagal menyimpan artikel. Periksa semua field yang wajib diisi.')
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await Promise.all([fetchCategories(), fetchTags()])
  if (isEdit.value) {
    await fetchArticle()
  }
})
</script>


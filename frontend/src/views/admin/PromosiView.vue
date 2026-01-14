<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Promosi</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola promosi untuk ditampilkan di beranda</p>
      </div>
      <button
        @click="openCreateModal"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl"
      >
        + Tambah Promosi
      </button>
    </div>

    <!-- Stats Card -->
    <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-slate-600">Total Promosi</p>
          <p class="mt-2 text-3xl font-bold text-slate-800">{{ promosi.length }}</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
          <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="animate-pulse rounded-2xl border border-sky-100 bg-slate-50 p-6">
        <div class="h-4 w-1/4 rounded bg-sky-100"></div>
        <div class="mt-3 h-4 w-3/4 rounded bg-sky-50"></div>
        <div class="mt-2 h-4 w-1/2 rounded bg-sky-50"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else-if="promosi.length === 0"
      class="rounded-3xl border border-sky-100 bg-gradient-to-br from-slate-50 to-sky-50/30 p-16 text-center shadow-sm"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-sky-100">
        <svg class="h-10 w-10 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Belum Ada Promosi</h3>
      <p class="mt-2 text-slate-600">Tambahkan promosi pertama untuk memulai</p>
    </div>

    <!-- Promosi List -->
    <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="item in promosi"
        :key="item.id"
        class="group relative overflow-hidden rounded-2xl border transition-all duration-300 hover:shadow-lg"
        :class="item.is_active ? 'border-sky-100 bg-white' : 'border-slate-200 bg-slate-50'"
      >
        <div class="relative">
          <img
            v-if="item.image"
            :src="getImageUrl(item.image)"
            :alt="item.title"
            class="h-48 w-full object-cover"
          />
          <div v-else class="flex h-48 w-full items-center justify-center bg-slate-100">
            <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <div
            class="absolute right-2 top-2 rounded-full px-3 py-1 text-xs font-semibold"
            :class="item.is_active ? 'bg-green-500 text-white' : 'bg-slate-500 text-white'"
          >
            {{ item.is_active ? 'Aktif' : 'Tidak Aktif' }}
          </div>
        </div>
        <div class="p-4">
          <div class="mb-2">
            <span class="inline-block rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
              {{ item.type || 'General' }}
            </span>
          </div>
          <h3 class="mb-2 text-lg font-bold text-slate-800 line-clamp-2">{{ item.title }}</h3>
          <p v-if="item.description" class="mb-3 line-clamp-2 text-sm text-slate-600">
            {{ item.description }}
          </p>
          <div v-if="item.link" class="mb-3">
            <a
              :href="item.link"
              target="_blank"
              class="text-sm font-medium text-sky-600 hover:text-sky-700"
            >
              {{ item.link_text || 'Lihat Detail' }} →
            </a>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-xs text-slate-500">Urutan: {{ item.order }}</span>
            <div class="flex gap-2">
              <button
                @click="editPromosi(item)"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-sky-600 transition-colors hover:bg-sky-50"
              >
                Edit
              </button>
              <button
                @click="toggleActive(item)"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors"
                :class="item.is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-green-600 hover:bg-green-50'"
              >
                {{ item.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
              </button>
              <button
                @click="deletePromosi(item.id)"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 transition-colors hover:bg-red-50"
              >
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      @click.self="closeModal"
    >
      <div class="w-full max-w-2xl rounded-2xl border border-sky-100 bg-white p-6 shadow-xl lg:p-8 max-h-[90vh] overflow-y-auto">
        <div class="mb-6 flex items-center justify-between">
          <h2 class="text-2xl font-bold text-slate-800">{{ editingPromosi ? 'Edit Promosi' : 'Tambah Promosi' }}</h2>
          <button
            @click="closeModal"
            class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="savePromosi" class="space-y-5">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul *</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Contoh: Audisi Angkatan 2025"
            />
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
            <textarea
              v-model="form.description"
              rows="3"
              class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Deskripsi promosi..."
            ></textarea>
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tipe</label>
              <select
                v-model="form.type"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              >
                <option value="general">General</option>
                <option value="audisi">Audisi</option>
                <option value="kegiatan">Kegiatan</option>
                <option value="event">Event</option>
                <option value="berita">Berita</option>
              </select>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Urutan</label>
              <input
                v-model.number="form.order"
                type="number"
                min="0"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Link (Opsional)</label>
              <input
                v-model="form.link"
                type="text"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="https://..."
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Teks Link (Opsional)</label>
              <input
                v-model="form.link_text"
                type="text"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="Contoh: Daftar Sekarang"
              />
            </div>
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Mulai (Opsional)</label>
              <input
                v-model="form.start_date"
                type="date"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Akhir (Opsional)</label>
              <input
                v-model="form.end_date"
                type="date"
                class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              />
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Gambar</label>
            <div class="space-y-3">
              <div v-if="form.image || imagePreview" class="relative">
                <img
                  :src="imagePreview || getImageUrl(form.image)"
                  alt="Preview"
                  class="h-48 w-full rounded-lg object-cover border border-sky-200"
                />
                <button
                  type="button"
                  @click="clearImage"
                  class="absolute right-2 top-2 rounded-full bg-red-500 p-2 text-white transition-colors hover:bg-red-600"
                >
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div>
                <input
                  ref="imageInput"
                  type="file"
                  accept="image/*"
                  @change="handleImageChange"
                  class="hidden"
                />
                <button
                  type="button"
                  @click="imageInput?.click()"
                  class="w-full rounded-lg border-2 border-dashed border-sky-300 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700 transition-colors hover:bg-sky-100"
                >
                  {{ form.image || imagePreview ? 'Ganti Gambar' : 'Pilih Gambar' }}
                </button>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <input
              v-model="form.is_active"
              id="is_active"
              type="checkbox"
              class="h-5 w-5 rounded border-sky-300 text-sky-600 focus:ring-sky-500"
            />
            <label for="is_active" class="text-sm font-medium text-slate-700">Aktifkan Promosi</label>
          </div>

          <div class="flex justify-end gap-3">
            <button
              type="button"
              @click="closeModal"
              class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50"
            >
              Batal
            </button>
            <button
              type="submit"
              :disabled="submitting"
              class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] disabled:opacity-50"
            >
              {{ submitting ? 'Menyimpan...' : 'Simpan Promosi' }}
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

interface Promosi {
  id?: number
  title: string
  description: string | null
  image: string | null
  link: string | null
  link_text: string | null
  type: string
  is_active: boolean
  order: number
  start_date: string | null
  end_date: string | null
  created_at?: string
  updated_at?: string
}

const promosi = ref<Promosi[]>([])
const loading = ref(true)
const submitting = ref(false)
const showModal = ref(false)
const editingPromosi = ref<Promosi | null>(null)
const imageInput = ref<HTMLInputElement | null>(null)
const imagePreview = ref<string | null>(null)

const form = ref<Promosi>({
  title: '',
  description: null,
  image: null,
  link: null,
  link_text: null,
  type: 'general',
  is_active: true,
  order: 0,
  start_date: null,
  end_date: null,
})

const getImageUrl = (path: string | null) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  return `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}/storage/${path}`
}

const fetchPromosi = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/promosi?public=false')
    promosi.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching promosi:', error)
    swal.error('Gagal memuat promosi.')
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  editingPromosi.value = null
  form.value = {
    title: '',
    description: null,
    image: null,
    link: null,
    link_text: null,
    type: 'general',
    is_active: true,
    order: 0,
    start_date: null,
    end_date: null,
  }
  imagePreview.value = null
  showModal.value = true
}

const editPromosi = (item: Promosi) => {
  editingPromosi.value = item
  form.value = { ...item }
  imagePreview.value = null
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingPromosi.value = null
  imagePreview.value = null
}

const handleImageChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    imagePreview.value = URL.createObjectURL(file)
    form.value.image = null // Clear existing image path
  }
}

const clearImage = () => {
  form.value.image = null
  imagePreview.value = null
  if (imageInput.value) {
    imageInput.value.value = ''
  }
}

const savePromosi = async () => {
  submitting.value = true
  try {
    const formData = new FormData()
    formData.append('title', form.value.title)
    if (form.value.description) formData.append('description', form.value.description)
    if (form.value.link) formData.append('link', form.value.link)
    if (form.value.link_text) formData.append('link_text', form.value.link_text)
    formData.append('type', form.value.type)
    formData.append('is_active', form.value.is_active ? '1' : '0')
    formData.append('order', form.value.order.toString())
    if (form.value.start_date) formData.append('start_date', form.value.start_date)
    if (form.value.end_date) formData.append('end_date', form.value.end_date)
    
    // Add image file if new image selected
    if (imageInput.value?.files?.[0]) {
      formData.append('image_file', imageInput.value.files[0])
    } else if (form.value.image) {
      formData.append('image', form.value.image)
    }

    if (editingPromosi.value?.id) {
      await api.put(`/v1/promosi/${editingPromosi.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      swal.success('Promosi berhasil diperbarui!')
    } else {
      await api.post('/v1/promosi', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      swal.success('Promosi berhasil ditambahkan!')
    }
    closeModal()
    fetchPromosi()
  } catch (error: any) {
    console.error('Error saving promosi:', error)
    swal.error(error.response?.data?.message || 'Gagal menyimpan promosi.')
  } finally {
    submitting.value = false
  }
}

const toggleActive = async (item: Promosi) => {
  const result = await swal.confirm(
    `Apakah Anda yakin ingin ${item.is_active ? 'menonaktifkan' : 'mengaktifkan'} promosi ini?`,
    'Konfirmasi Aksi'
  )
  if (result.isConfirmed) {
    try {
      const formData = new FormData()
      Object.keys(form.value).forEach(key => {
        const value = (item as any)[key]
        if (value !== null && value !== undefined) {
          if (key === 'is_active') {
            formData.append(key, (!item.is_active).toString())
          } else if (key === 'order') {
            formData.append(key, value.toString())
          } else {
            formData.append(key, value.toString())
          }
        }
      })
      formData.append('title', item.title)
      formData.append('type', item.type)
      formData.append('is_active', (!item.is_active).toString())
      formData.append('order', item.order.toString())
      if (item.image) formData.append('image', item.image)
      
      await api.put(`/v1/promosi/${item.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      swal.success(`Promosi berhasil di${item.is_active ? 'nonaktifkan' : 'aktifkan'}!`)
      fetchPromosi()
    } catch (error: any) {
      console.error('Error toggling status:', error)
      swal.error(error.response?.data?.message || 'Gagal mengubah status promosi.')
    }
  }
}

const deletePromosi = async (id: number) => {
  const result = await swal.confirm('Apakah Anda yakin ingin menghapus promosi ini?', 'Hapus Promosi')
  if (result.isConfirmed) {
    try {
      await api.delete(`/v1/promosi/${id}`)
      swal.success('Promosi berhasil dihapus!')
      fetchPromosi()
    } catch (error: any) {
      console.error('Error deleting promosi:', error)
      swal.error(error.response?.data?.message || 'Gagal menghapus promosi.')
    }
  }
}

onMounted(() => {
  fetchPromosi()
})
</script>


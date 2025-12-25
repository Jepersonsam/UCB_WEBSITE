<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Member SATB</h1>
        <p class="mt-1 text-sm text-slate-600">Kelola member aktif Unceasing Cantica</p>
      </div>
      <button
        @click="showFormModal = true; editingMember = null; resetForm()"
        class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02]"
      >
        + Tambah Member
      </button>
    </div>

    <!-- Filter by Role -->
    <div class="flex flex-wrap gap-2">
      <button
        v-for="role in allRoles"
        :key="role"
        @click="selectedRole = role"
        class="rounded-lg px-4 py-2 text-sm font-medium transition-colors"
        :class="selectedRole === role 
          ? 'bg-sky-100 text-sky-700 border border-sky-300' 
          : 'bg-white text-slate-600 border border-sky-200 hover:bg-sky-50'"
      >
        {{ role }}
      </button>
    </div>

    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="h-24 animate-pulse rounded-xl bg-sky-100"></div>
    </div>
    <div v-else-if="filteredMembers.length === 0" class="rounded-2xl border border-sky-100 bg-white p-12 text-center">
      <p class="text-slate-600">Belum ada member. Tambahkan member pertama Anda!</p>
    </div>
    <div v-else class="space-y-4">
      <div
        v-for="member in filteredMembers"
        :key="member.id"
        class="flex items-center gap-4 rounded-xl border border-sky-100 bg-white p-4 shadow-sm transition-all hover:border-sky-300 hover:shadow-md"
      >
        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full bg-sky-100">
          <img 
            v-if="member.avatar" 
            :src="getAvatarUrl(member.avatar)" 
            :alt="member.name" 
            class="h-full w-full object-cover" 
          />
          <div v-else class="flex h-full items-center justify-center text-sky-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
        </div>
        <div class="flex-1">
          <div class="flex items-center gap-2">
            <h3 class="font-semibold text-slate-900">{{ member.name }}</h3>
            <span class="rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-700">
              {{ member.role }}
            </span>
            <span v-if="!member.is_active" class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">
              Nonaktif
            </span>
          </div>
          <p class="mt-1 text-sm text-slate-600">{{ member.position || '-' }}</p>
          <div v-if="member.badges && member.badges.length > 0" class="mt-1 flex flex-wrap gap-1">
            <span
              v-for="badge in member.badges"
              :key="badge"
              class="rounded-full bg-sky-50 border border-sky-200 px-2 py-0.5 text-xs text-sky-700"
            >
              {{ badge }}
            </span>
          </div>
        </div>
        <div class="flex gap-2">
          <button
            @click="editMember(member)"
            class="rounded-lg px-4 py-2 text-sm text-sky-600 transition-colors hover:bg-sky-50"
          >
            Edit
          </button>
          <button
            @click="deleteMember(member.id)"
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
        <h3 class="mb-4 text-lg font-semibold text-slate-800">{{ editingMember ? 'Edit Member' : 'Tambah Member' }}</h3>
        <form @submit.prevent="saveMember" class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Nama *</label>
            <input v-model="form.name" type="text" required class="w-full rounded-xl border border-sky-200 px-4 py-2" />
          </div>
          
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Role *</label>
              <select v-model="form.role" required class="w-full rounded-xl border border-sky-200 px-4 py-2">
                <option value="">Pilih Role</option>
                <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
              </select>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Posisi</label>
              <input v-model="form.position" type="text" class="w-full rounded-xl border border-sky-200 px-4 py-2" placeholder="Contoh: Vocal Lead, Member" />
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Avatar</label>
            <p class="mb-2 text-xs text-slate-500">Maksimal ukuran: 50MB. Format: JPEG, PNG, GIF, WebP</p>
            <input 
              type="file" 
              accept="image/*" 
              @change="handleAvatarChange"
              class="w-full rounded-xl border border-sky-200 px-4 py-2"
            />
            <div v-if="form.avatar || avatarPreview" class="mt-2">
              <img 
                :src="avatarPreview || (form.avatar ? getAvatarUrl(form.avatar) : '')" 
                alt="Preview" 
                class="h-24 w-24 rounded-full object-cover border border-sky-200"
              />
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Badges</label>
            <div class="space-y-2">
              <div v-for="(badge, index) in form.badges" :key="index" class="flex gap-2">
                <input 
                  v-model="form.badges[index]" 
                  type="text" 
                  class="flex-1 rounded-xl border border-sky-200 px-4 py-2" 
                  placeholder="Contoh: Aktif, Senior"
                />
                <button 
                  type="button"
                  @click="form.badges.splice(index, 1)"
                  class="rounded-xl border border-red-200 px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                >
                  Hapus
                </button>
              </div>
              <button 
                type="button"
                @click="form.badges.push('')"
                class="rounded-xl border border-sky-200 px-4 py-2 text-sm text-sky-600 hover:bg-sky-50"
              >
                + Tambah Badge
              </button>
            </div>
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Urutan</label>
              <input v-model.number="form.order" type="number" min="0" class="w-full rounded-xl border border-sky-200 px-4 py-2" />
            </div>
            <div class="flex items-center gap-2 pt-6">
              <input 
                v-model="form.is_active" 
                type="checkbox" 
                id="is_active"
                class="h-4 w-4 rounded border-sky-300 text-sky-600 focus:ring-sky-500"
              />
              <label for="is_active" class="text-sm font-medium text-slate-700">Aktif</label>
            </div>
          </div>

          <div class="flex gap-3 pt-4">
            <button 
              type="button" 
              @click="showFormModal = false" 
              class="flex-1 rounded-xl border border-sky-200 px-4 py-2 text-sm font-semibold"
            >
              Batal
            </button>
            <button 
              type="submit" 
              :disabled="saving" 
              class="flex-1 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
            >
              {{ saving ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const roles = ['Soprano', 'Alto', 'Tenor', 'Bass', 'Conductor']
const allRoles = ['Semua', ...roles]
const members = ref<any[]>([])
const loading = ref(true)
const showFormModal = ref(false)
const editingMember = ref<any>(null)
const saving = ref(false)
const selectedRole = ref<string>('Semua')
const avatarFile = ref<File | null>(null)
const avatarPreview = ref<string | null>(null)

const form = ref({
  name: '',
  role: '',
  position: '',
  avatar: '',
  badges: [] as string[],
  is_active: true,
  order: 0,
})

const filteredMembers = computed(() => {
  if (selectedRole.value === 'Semua') {
    return members.value
  }
  return members.value.filter(m => m.role === selectedRole.value)
})

const getAvatarUrl = (avatarPath: string) => {
  if (!avatarPath) return ''
  if (avatarPath.startsWith('http')) return avatarPath
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${avatarPath}`
}

const resetForm = () => {
  form.value = {
    name: '',
    role: '',
    position: '',
    avatar: '',
    badges: [],
    is_active: true,
    order: 0,
  }
  avatarFile.value = null
  avatarPreview.value = null
}

const handleAvatarChange = async (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    const file = target.files[0]
    const maxSize = 50 * 1024 * 1024 // 50MB dalam bytes
    
    // Validasi ukuran file
    if (file.size > maxSize) {
      await swal.error(`Ukuran file terlalu besar! Maksimal 50MB. Ukuran file Anda: ${formatFileSize(file.size)}`)
      target.value = '' // Reset input
      avatarFile.value = null
      avatarPreview.value = null
      return
    }
    
    // Validasi tipe file
    if (!file.type.startsWith('image/')) {
      await swal.error('File harus berupa gambar (JPEG, PNG, GIF, WebP)')
      target.value = '' // Reset input
      avatarFile.value = null
      avatarPreview.value = null
      return
    }
    
    avatarFile.value = file
    const reader = new FileReader()
    reader.onload = (e) => {
      avatarPreview.value = e.target?.result as string
    }
    reader.readAsDataURL(avatarFile.value)
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i]
}

const fetchMembers = async () => {
  loading.value = true
  try {
    const response = await api.get('/v1/members')
    members.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching members:', error)
  } finally {
    loading.value = false
  }
}

const editMember = (member: any) => {
  editingMember.value = member
  form.value = {
    name: member.name,
    role: member.role,
    position: member.position || '',
    avatar: member.avatar || '',
    badges: member.badges ? [...member.badges] : [],
    is_active: member.is_active !== undefined ? member.is_active : true,
    order: member.order || 0,
  }
  avatarFile.value = null
  avatarPreview.value = null
  showFormModal.value = true
}

const saveMember = async () => {
  saving.value = true
  try {
    const formData = new FormData()
    
    // Always append all fields - ensure they are sent even if empty
    formData.append('name', form.value.name || '')
    formData.append('role', form.value.role || '')
    formData.append('position', form.value.position || '')
    formData.append('is_active', form.value.is_active ? '1' : '0')
    formData.append('order', form.value.order?.toString() || '0')
    
    // Filter out empty badges and append as array
    const badges = form.value.badges.filter(b => b.trim() !== '')
    if (badges.length > 0) {
      badges.forEach((badge, index) => {
        formData.append(`badges[${index}]`, badge)
      })
    }

    if (avatarFile.value) {
      formData.append('avatar', avatarFile.value)
    }

    // Debug: Log FormData contents
    console.log('FormData contents:')
    for (const [key, value] of formData.entries()) {
      console.log(`${key}:`, value instanceof File ? `[File: ${value.name}]` : value)
    }
    console.log('Editing member:', editingMember.value)
    console.log('Form values:', form.value)

    if (editingMember.value) {
      console.log('Updating member with ID:', editingMember.value.id)
      // Use POST with _method=PUT for FormData compatibility
      formData.append('_method', 'PUT')
      const response = await api.post(`/v1/members/${editingMember.value.id}`, formData)
      console.log('Update response:', response.data)
    } else {
      await api.post('/v1/members', formData)
    }

    showFormModal.value = false
    editingMember.value = null
    resetForm()
    await fetchMembers()
    await swal.success('Member berhasil disimpan!')
  } catch (error: any) {
    let errorMessage = 'Gagal menyimpan member'
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
    console.error('Error saving member:', error)
  } finally {
    saving.value = false
  }
}

const deleteMember = async (id: number) => {
  const result = await swal.confirmDelete('member ini')
  if (!result.isConfirmed) return
  try {
    await api.delete(`/v1/members/${id}`)
    await fetchMembers()
    await swal.success('Member berhasil dihapus!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menghapus member')
    console.error('Error deleting member:', error)
  }
}

onMounted(() => {
  fetchMembers()
})
</script>


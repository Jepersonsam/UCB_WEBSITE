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
            :key="`member-${member.id}-${member.avatar || member.avatar_url || 'no-avatar'}`"
            :src="getMemberAvatarUrl(member)" 
            :alt="member.name" 
            class="h-full w-full object-cover" 
            @error="(e) => { 
              const img = e.target as HTMLImageElement
              const originalSrc = img.src
              console.error('Avatar load error for member:', member.name)
              console.error('Avatar path:', member.avatar)
              console.error('Avatar URL from API:', member.avatar_url)
              console.error('Generated URL:', originalSrc)
              console.error('Full member data:', member)
              // Only set placeholder if it's not already a placeholder
              if (!originalSrc.startsWith('data:')) {
                console.warn('Image failed to load, using placeholder')
                img.src = getPlaceholderAvatar()
              }
            }"
            @load="() => { 
              if (member.avatar || member.avatar_url) {
                console.log('Avatar loaded successfully for:', member.name)
                console.log('Avatar URL:', getMemberAvatarUrl(member))
              }
            }"
          />
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
            <div class="mt-2">
              <!-- Show preview if new file selected -->
              <div v-if="avatarPreview && avatarFile" class="mb-2">
                <img 
                  :src="avatarPreview" 
                  alt="New Avatar Preview" 
                  class="h-24 w-24 rounded-full object-cover border border-sky-200"
                  @error="(e) => { console.error('Preview image error:', e); handleImageError(e) }"
                  @load="() => console.log('Preview image loaded')"
                />
                <p class="mt-1 text-xs text-slate-500">Preview (File baru)</p>
              </div>
              <!-- Show current avatar if exists and no new file selected -->
              <div v-else-if="form.avatar" class="mb-2">
                <img 
                  :key="`form-avatar-${form.avatar}`"
                  :src="getAvatarUrl(form.avatar)" 
                  alt="Current Avatar" 
                  class="h-24 w-24 rounded-full object-cover border border-sky-200"
                  @error="(e) => { 
                    const img = e.target as HTMLImageElement
                    const originalSrc = img.src
                    console.error('Current avatar error:', e); 
                    console.error('Avatar path:', form.avatar); 
                    console.error('Generated URL:', originalSrc);
                    console.error('Trying to fetch:', originalSrc);
                    // Only set placeholder if it's not already a placeholder
                    if (!originalSrc.startsWith('data:')) {
                      console.warn('Image failed to load, using placeholder')
                      img.src = getPlaceholderAvatar()
                    }
                  }"
                  @load="() => {
                    console.log('Current avatar loaded successfully:', getAvatarUrl(form.avatar))
                    console.log('Loaded from URL:', getAvatarUrl(form.avatar))
                  }"
                />
                <p class="mt-1 text-xs text-slate-500">Foto saat ini: {{ form.avatar }}</p>
                <p class="mt-1 text-xs text-slate-400">URL: {{ getAvatarUrl(form.avatar) }}</p>
                <p class="mt-1 text-xs text-blue-500 cursor-pointer" @click="() => window.open(getAvatarUrl(form.avatar), '_blank')">🔗 Buka URL di tab baru</p>
              </div>
              <!-- Show placeholder if no avatar -->
              <div v-else class="h-24 w-24 rounded-full bg-sky-100 flex items-center justify-center border border-sky-200">
                <span class="text-xs text-slate-400">Belum ada foto</span>
              </div>
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

const getPlaceholderAvatar = () => {
  return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3QgZmlsbD0iI2UwZTdlZiIgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiByeD0iMzIiLz48dGV4dCBmaWxsPSIjOTRhM2I4IiBmb250LWZhbWlseT0ic2Fucy1zZXJpZiIgZm9udC1zaXplPSIxMiIgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4='
}

const getMemberAvatarUrl = (member: any) => {
  if (!member) {
    return getPlaceholderAvatar()
  }
  
  // Priority 1: Use avatar_url from API if available (backend provides relative path)
  if (member.avatar_url) {
    // avatar_url from backend is relative path like "/storage/members/filename.jpg"
    // We need to prepend backend base URL
    const getBackendUrl = () => {
      const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
      return apiUrl.replace('/api', '') || 'http://localhost:8000'
    }
    const backendUrl = getBackendUrl()
    const fullUrl = member.avatar_url.startsWith('http') ? member.avatar_url : `${backendUrl}${member.avatar_url}`
    console.log('Using avatar_url from API for', member.name, ':', fullUrl)
    return fullUrl
  }
  
  // Priority 2: Generate URL from avatar path
  if (member.avatar) {
    const url = getAvatarUrl(member.avatar)
    console.log('Generated avatar URL for', member.name, ':', url, 'from path:', member.avatar)
    return url
  }
  
  // Priority 3: Return placeholder
  return getPlaceholderAvatar()
}

const getAvatarUrl = (avatarPath: string) => {
  if (!avatarPath) return getPlaceholderAvatar()
  
  // If already a full URL, return as is
  if (avatarPath.startsWith('http://') || avatarPath.startsWith('https://')) {
    return avatarPath
  }
  
  // Get backend base URL (same as logo)
  const getBackendUrl = () => {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    return apiUrl.replace('/api', '') || 'http://localhost:8000'
  }
  const backendUrl = getBackendUrl()
  
  // Handle different path formats
  if (avatarPath.startsWith('/storage/')) {
    return `${backendUrl}${avatarPath}`
  }
  if (avatarPath.startsWith('storage/')) {
    return `${backendUrl}/${avatarPath}`
  }
  
  // Laravel stores files in storage/app/public, accessible via /storage/ symlink
  // If path is like "members/filename.jpg", convert to "/storage/members/filename.jpg"
  // Remove any leading slashes from avatarPath to avoid double slashes
  const cleanPath = avatarPath.replace(/^\/+/, '')
  const url = `${backendUrl}/storage/${cleanPath}`
  
  // Debug log
  if (import.meta.env.DEV) {
    console.log('Generated avatar URL:', {
      originalPath: avatarPath,
      cleanPath: cleanPath,
      fullUrl: url,
      backendUrl: backendUrl
    })
  }
  
  return url
}

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement
  // Set placeholder image on error
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="96" height="96"%3E%3Crect fill="%23e0e7ef" width="96" height="96" rx="48"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E'
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
    const fetchedMembers = response.data.data || response.data
    members.value = fetchedMembers
    console.log('Fetched members:', fetchedMembers.length)
    // Debug: Log avatar paths and URLs for all members
    fetchedMembers.forEach((m: any) => {
      const avatarUrl = getMemberAvatarUrl(m)
      console.log(`Member: ${m.name}`, {
        id: m.id,
        has_avatar: !!m.avatar,
        avatar_path: m.avatar || 'NULL',
        avatar_url: avatarUrl,
        avatar_url_type: avatarUrl.startsWith('data:') ? 'placeholder' : 'image'
      })
    })
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
  // Clear preview first - will show current avatar from form.avatar
  avatarPreview.value = null
  // Log for debugging
  console.log('Editing member:', {
    id: member.id,
    name: member.name,
    avatar_path: member.avatar,
    avatar_url: member.avatar ? getAvatarUrl(member.avatar) : 'No avatar'
  })
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

    let updatedMember = null
    
    if (editingMember.value) {
      console.log('Updating member with ID:', editingMember.value.id)
      // Use POST with _method=PUT for FormData compatibility
      formData.append('_method', 'PUT')
      const response = await api.post(`/v1/members/${editingMember.value.id}`, formData)
      updatedMember = response.data
      console.log('Update response:', updatedMember)
      console.log('Updated avatar path:', updatedMember.avatar)
      console.log('Avatar URL:', updatedMember.avatar ? getAvatarUrl(updatedMember.avatar) : 'No avatar')
      
      // Update the member in the list immediately with the response data
      const memberIndex = members.value.findIndex(m => m.id === editingMember.value.id)
      if (memberIndex !== -1) {
        // Use splice to ensure Vue reactivity detects the change
        const updatedMemberData = { ...updatedMember }
        members.value.splice(memberIndex, 1, updatedMemberData)
        console.log('Member updated in list:', updatedMemberData)
        console.log('Member avatar path:', updatedMemberData.avatar)
        console.log('Member avatar URL:', updatedMemberData.avatar ? getAvatarUrl(updatedMemberData.avatar) : 'No avatar')
      }
    } else {
      const response = await api.post('/v1/members', formData)
      updatedMember = response.data
      console.log('Create response:', updatedMember)
      console.log('Created member avatar path:', updatedMember.avatar)
      console.log('Created member avatar_url:', updatedMember.avatar_url)
      console.log('Created member avatar URL:', getMemberAvatarUrl(updatedMember))
      // Add new member to list with avatar_url from API
      members.value.push(updatedMember)
    }

    showFormModal.value = false
    editingMember.value = null
    resetForm()
    
    // Refresh members list to get latest data from server
    // This ensures avatar path is correct after upload
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


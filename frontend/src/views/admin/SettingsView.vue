<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Settings</h1>
      <p class="mt-1 text-sm text-slate-600">Pengaturan website dan sistem</p>
    </div>

    <form @submit.prevent="saveSettings" class="space-y-6">
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Informasi Website</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Nama Website</label>
            <input
              v-model="settings.site_name"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Unceasing Cantica Bandung"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi Website</label>
            <textarea
              v-model="settings.site_description"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Deskripsi singkat tentang website"
            ></textarea>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Info Kontak</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Email *</label>
            <input
              v-model="settings.contact_email"
              type="email"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="info@ucb.example"
            />
            <p class="mt-1 text-xs text-slate-500">Email yang akan ditampilkan di halaman kontak</p>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Phone / WhatsApp</label>
            <input
              v-model="settings.contact_phone"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="+62 812-xxx-xxxx"
            />
            <p class="mt-1 text-xs text-slate-500">Nomor telepon atau WhatsApp (dengan format internasional)</p>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Lokasi</label>
            <input
              v-model="settings.contact_location"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="UNAI, Bandung"
            />
            <p class="mt-1 text-xs text-slate-500">Alamat atau lokasi yang akan ditampilkan</p>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Social Media</h3>
        <p class="mb-4 text-sm text-slate-600">Tambahkan URL social media untuk ditampilkan di halaman kontak</p>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Facebook URL</label>
            <input
              v-model="settings.facebook_url"
              type="url"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="https://facebook.com/..."
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Twitter URL</label>
            <input
              v-model="settings.twitter_url"
              type="url"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="https://twitter.com/..."
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Instagram URL</label>
            <input
              v-model="settings.instagram_url"
              type="url"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="https://instagram.com/..."
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">YouTube URL</label>
            <input
              v-model="settings.youtube_url"
              type="url"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="https://youtube.com/..."
            />
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
          <span v-else>Simpan Pengaturan</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

const settings = ref({
  site_name: '',
  site_description: '',
  contact_email: '',
  contact_phone: '',
  contact_location: '',
  facebook_url: '',
  twitter_url: '',
  instagram_url: '',
  youtube_url: '',
})

const saving = ref(false)

const fetchSettings = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    settings.value = {
      site_name: data.site_name || '',
      site_description: data.site_description || '',
      contact_email: data.contact_email || '',
      contact_phone: data.contact_phone || '',
      contact_location: data.contact_location || '',
      facebook_url: data.facebook_url || '',
      twitter_url: data.twitter_url || '',
      instagram_url: data.instagram_url || '',
      youtube_url: data.youtube_url || '',
    }
  } catch (error) {
    console.error('Error fetching settings:', error)
  }
}

const saveSettings = async () => {
  saving.value = true
  try {
    await api.put('/v1/settings', {
      settings: settings.value
    })
    await swal.success('Pengaturan berhasil disimpan!')
  } catch (error) {
    await swal.error('Gagal menyimpan pengaturan')
    console.error('Error saving settings:', error)
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchSettings()
})
</script>

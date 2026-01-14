<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Halaman Bergabung</h1>
      <p class="mt-1 text-sm text-slate-600">Kelola konten halaman Bergabung dengan UCB</p>
      <p v-if="!hasSavedContent" class="mt-2 text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 inline-block">
        ℹ️ Menampilkan konten default dari website. Simpan untuk menyimpan perubahan ke database.
      </p>
    </div>

    <form @submit.prevent="saveJoin" class="space-y-6">
      <!-- Header Section -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm lg:p-8">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Header Section</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul</label>
            <input
              v-model="joinContent.title"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Bergabung dengan UCB"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Subtitle / Deskripsi</label>
            <textarea
              v-model="joinContent.subtitle"
              rows="2"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Mari bergabung dengan keluarga Unceasing Cantica Bandung dan melayani Tuhan melalui musik"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Info Cards -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm lg:p-8">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Info Cards</h3>
        <p class="mb-4 text-sm text-slate-600">Kartu informasi yang ditampilkan di atas formulir (maksimal 2 kartu)</p>
        <div class="space-y-4">
          <div
            v-for="(card, index) in joinContent.infoCards"
            :key="index"
            class="rounded-xl border border-sky-100 bg-slate-50 p-5"
          >
            <div class="mb-3 flex items-center justify-between">
              <h4 class="font-semibold text-slate-800">Kartu {{ index + 1 }}</h4>
              <button
                v-if="joinContent.infoCards.length > 1"
                type="button"
                @click="removeInfoCard(index)"
                class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-100"
              >
                Hapus
              </button>
            </div>
            <div class="space-y-4">
              <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Judul Kartu</label>
                <input
                  v-model="card.title"
                  type="text"
                  class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="Contoh: Terbuka untuk Semua"
                />
              </div>
              <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea
                  v-model="card.description"
                  rows="2"
                  class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="Siapapun yang memiliki passion untuk musik dan melayani Tuhan"
                ></textarea>
              </div>
            </div>
          </div>
          <button
            v-if="joinContent.infoCards.length < 2"
            type="button"
            @click="addInfoCard"
            class="rounded-lg border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-medium text-sky-600 transition-colors hover:bg-sky-100"
          >
            + Tambah Kartu Info
          </button>
        </div>
      </div>

      <!-- Form Section -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm lg:p-8">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Formulir Pendaftaran</h3>
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Judul Formulir</label>
            <input
              v-model="joinContent.formTitle"
              type="text"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Formulir Pendaftaran"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi Formulir</label>
            <textarea
              v-model="joinContent.formDescription"
              rows="2"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Isi formulir di bawah ini atau hubungi kami untuk informasi lebih lanjut tentang audisi"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Contact Alternative -->
      <div class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm lg:p-8">
        <h3 class="mb-4 text-lg font-semibold text-slate-800">Alternatif Kontak</h3>
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700">Pesan Alternatif Kontak</label>
          <textarea
            v-model="joinContent.contactAlternative"
            rows="3"
            class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
            placeholder="Atau hubungi kami langsung melalui halaman kontak untuk informasi lebih lanjut tentang audisi dan proses pendaftaran."
          ></textarea>
        </div>
      </div>

      <!-- Save Button -->
      <div class="flex gap-3">
        <button
          type="submit"
          :disabled="saving"
          class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] disabled:opacity-50"
        >
          {{ saving ? 'Menyimpan...' : 'Simpan Konten' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import api from '@/lib/api/client'
import swal from '@/utils/swal'

interface InfoCard {
  title: string
  description: string
}

interface JoinContent {
  title: string
  subtitle: string
  infoCards: InfoCard[]
  formTitle: string
  formDescription: string
  contactAlternative: string
}

const defaultJoinContent: JoinContent = {
  title: 'Bergabung dengan UCB',
  subtitle: 'Mari bergabung dengan keluarga Unceasing Cantica Bandung dan melayani Tuhan melalui musik',
  infoCards: [
    {
      title: 'Terbuka untuk Semua',
      description: 'Siapapun yang memiliki passion untuk musik dan melayani Tuhan',
    },
    {
      title: 'Latihan Rutin',
      description: 'Latihan teratur untuk meningkatkan kemampuan dan harmoni',
    },
  ],
  formTitle: 'Formulir Pendaftaran',
  formDescription: 'Isi formulir di bawah ini atau hubungi kami untuk informasi lebih lanjut tentang audisi',
  contactAlternative: 'Atau hubungi kami langsung melalui halaman kontak untuk informasi lebih lanjut tentang audisi dan proses pendaftaran.',
}

const joinContent = ref<JoinContent>({ ...defaultJoinContent })
const saving = ref(false)
const hasSavedContent = ref(false)

const addInfoCard = () => {
  if (joinContent.value.infoCards.length < 2) {
    joinContent.value.infoCards.push({
      title: '',
      description: '',
    })
  }
}

const removeInfoCard = (index: number) => {
  if (joinContent.value.infoCards.length > 1) {
    joinContent.value.infoCards.splice(index, 1)
  }
}

const fetchJoinContent = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data

    if (data.join_content) {
      try {
        const parsed = typeof data.join_content === 'string' ? JSON.parse(data.join_content) : data.join_content
        joinContent.value = { ...defaultJoinContent, ...parsed }
        // Ensure infoCards is an array
        if (!Array.isArray(joinContent.value.infoCards)) {
          joinContent.value.infoCards = defaultJoinContent.infoCards
        }
        hasSavedContent.value = true
      } catch (e) {
        console.error('Error parsing join_content:', e)
        joinContent.value = { ...defaultJoinContent }
        hasSavedContent.value = false
      }
    } else {
      joinContent.value = { ...defaultJoinContent }
      hasSavedContent.value = false
    }
  } catch (error) {
    console.error('Error fetching join content:', error)
    joinContent.value = { ...defaultJoinContent }
    hasSavedContent.value = false
  }
}

const saveJoin = async () => {
  saving.value = true
  try {
    await api.put('/v1/settings', {
      settings: {
        join_content: JSON.stringify(joinContent.value),
      },
    })
    hasSavedContent.value = true
    await swal.success('Konten halaman Bergabung berhasil disimpan!')
  } catch (error: any) {
    await swal.error(error.response?.data?.message || 'Gagal menyimpan konten')
  } finally {
    saving.value = false
  }
}

onMounted(() => {
  fetchJoinContent()
})
</script>


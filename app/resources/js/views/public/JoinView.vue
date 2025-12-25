<template>
  <div class="space-y-8 sm:space-y-12">
      <!-- Header Section -->
      <div class="text-center" data-aos="fade-down">
        <h1 class="text-3xl font-bold text-slate-800 sm:text-4xl lg:text-5xl">{{ joinContent.title || 'Bergabung dengan UCB' }}</h1>
        <p class="mt-3 sm:mt-4 text-base sm:text-lg text-slate-600">{{ joinContent.subtitle || 'Mari bergabung dengan keluarga Unceasing Cantica Bandung dan melayani Tuhan melalui musik' }}</p>
        <div class="mt-4 sm:mt-6 flex justify-center">
          <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-sky-400 to-sky-500"></div>
        </div>
      </div>

    <div class="mx-auto max-w-2xl">
      <!-- Info Cards -->
      <div v-if="joinContent.infoCards && joinContent.infoCards.length > 0" class="mb-6 sm:mb-8 grid gap-4 sm:grid-cols-2" data-aos="fade-up" data-aos-delay="100">
        <div
          v-for="(card, index) in joinContent.infoCards"
          :key="index"
          class="rounded-2xl border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-6 shadow-sm"
        >
          <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100">
            <svg v-if="index === 0" class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg v-else class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="font-semibold text-slate-800">{{ card.title }}</h3>
          <p class="mt-2 text-sm text-slate-600">{{ card.description }}</p>
        </div>
      </div>

      <!-- Join Form -->
      <div class="rounded-2xl border border-sky-100 bg-white p-8 shadow-lg lg:p-10" data-aos="fade-up" data-aos-delay="200">
        <h2 class="mb-2 text-2xl font-bold text-slate-800">{{ joinContent.formTitle || 'Formulir Pendaftaran' }}</h2>
        <p class="mb-6 text-slate-600">{{ joinContent.formDescription || 'Isi formulir di bawah ini atau hubungi kami untuk informasi lebih lanjut tentang audisi' }}</p>
        
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap *</label>
            <input
              v-model="form.name"
              type="text"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Masukkan nama lengkap Anda"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Email *</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="nama@email.com"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">No. HP / WhatsApp *</label>
            <input
              v-model="form.phone"
              type="tel"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="0812-3456-7890"
            />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Part Suara yang Diinginkan</label>
            <select
              v-model="form.voicePart"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
            >
              <option value="">Pilih part suara</option>
              <option value="Soprano">Soprano</option>
              <option value="Alto">Alto</option>
              <option value="Tenor">Tenor</option>
              <option value="Bass">Bass</option>
              <option value="Belum Tahu">Belum Tahu</option>
            </select>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Pengalaman Bernyanyi / Part Suara</label>
            <textarea
              v-model="form.experience"
              rows="4"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Ceritakan pengalaman bernyanyi Anda, part suara yang biasa dinyanyikan, atau minat Anda terhadap paduan suara..."
            ></textarea>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Alasan Bergabung (Opsional)</label>
            <textarea
              v-model="form.reason"
              rows="3"
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="Apa yang membuat Anda tertarik untuk bergabung dengan UCB?"
            ></textarea>
          </div>
          <button
            type="submit"
            :disabled="submitting"
            class="w-full rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-sky-500/30 disabled:opacity-50"
          >
            <span v-if="submitting">Mengirim...</span>
            <span v-else>Kirim Formulir</span>
          </button>
          <div v-if="submitSuccess" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            Formulir berhasil dikirim! Kami akan menghubungi Anda segera untuk informasi lebih lanjut tentang audisi.
          </div>
          <div v-if="submitError" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ submitError }}
          </div>
        </form>

        <!-- Contact Alternative -->
        <div v-if="joinContent.contactAlternative" class="mt-8 rounded-xl border border-sky-100 bg-sky-50/50 p-6">
          <p class="text-sm text-slate-600" v-html="formatContactAlternative(joinContent.contactAlternative)"></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'

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

const form = ref({
  name: '',
  email: '',
  phone: '',
  voicePart: '',
  experience: '',
  reason: ''
})

const submitting = ref(false)
const submitSuccess = ref(false)
const submitError = ref('')

const formatContactAlternative = (text: string) => {
  if (!text) return ''
  // Replace /contact with link
  return text.replace(/halaman kontak/g, '<a href="/contact" class="font-semibold text-sky-600 hover:text-sky-700 transition-colors">halaman kontak</a>')
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
      } catch (e) {
        console.error('Error parsing join_content:', e)
        joinContent.value = { ...defaultJoinContent }
      }
    } else {
      joinContent.value = { ...defaultJoinContent }
    }
  } catch (error) {
    console.error('Error fetching join content:', error)
    joinContent.value = { ...defaultJoinContent }
  }
}

const handleSubmit = async () => {
  submitting.value = true
  submitSuccess.value = false
  submitError.value = ''

  try {
    await api.post('/v1/join-applications', form.value)
    
    submitSuccess.value = true
    form.value = {
      name: '',
      email: '',
      phone: '',
      voicePart: '',
      experience: '',
      reason: ''
    }
  } catch (error: any) {
    submitError.value = error.response?.data?.message || 'Gagal mengirim formulir. Silakan coba lagi.'
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchJoinContent()
})
</script>


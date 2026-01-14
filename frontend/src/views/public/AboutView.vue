<template>
  <div class="space-y-8 sm:space-y-12">
    <!-- Konten Utama -->
    <div class="grid gap-8 sm:gap-12 lg:grid-cols-2">
      <div class="space-y-5 sm:space-y-6" data-aos="fade-right" data-aos-duration="800">
        <div>
          <h1 class="text-3xl font-bold text-slate-800 mb-3 sm:mb-4 sm:text-4xl lg:text-5xl">
            {{ aboutContent.title || 'Tentang Unceasing Cantica' }}
          </h1>
          <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-sky-400 to-sky-500"></div>
        </div>
        
        <div class="space-y-4 sm:space-y-5 text-slate-700 leading-relaxed text-base sm:text-lg">
          <p v-if="aboutContent.paragraph1" v-html="formatText(aboutContent.paragraph1)"></p>
          <p v-else class="leading-relaxed">
            Unceasing Cantica Bandung (UCB) adalah paduan suara yang didirikan pada <strong class="text-slate-900">22 Maret 2001</strong> oleh <strong class="text-slate-900">Sir Dante Oblimar</strong>, seorang musisi asal Filipina, di kampus Universitas Advent Indonesia (UNAI) di Bandung.
          </p>
          
          <p v-if="aboutContent.paragraph2" v-html="formatText(aboutContent.paragraph2)"></p>
          <p v-else class="leading-relaxed">
            Nama "<strong class="text-slate-900">Unceasing Cantica</strong>" berasal dari kata "<strong class="text-slate-900">Unceasing</strong>" yang berarti <em>"tak berkesudahan"</em> dan "<strong class="text-slate-900">Cantica</strong>" yang berarti <em>"pujian"</em>, sehingga secara keseluruhan berarti "<strong class="text-sky-600">Pujian yang tak berkesudahan</strong>".
    </p>
          
          <p v-if="aboutContent.paragraph3" v-html="formatText(aboutContent.paragraph3)"></p>
          <p v-else class="leading-relaxed">
            UCB terdiri dari orang-orang muda yang berkomitmen untuk melayani Allah dan menyebarkan Injil melalui musik. Seiring waktu, UCB telah berkembang dan membentuk beberapa cabang di berbagai lokasi, termasuk Jakarta, Manila, AUP, Bangkok, Balikpapan, dan Australia.
          </p>
        </div>
        
        <component
          v-if="aboutContent.learnMoreUrl"
          :is="isExternalLink ? 'a' : 'RouterLink'"
          :href="isExternalLink ? aboutContent.learnMoreUrl : undefined"
          :to="!isExternalLink ? aboutContent.learnMoreUrl : undefined"
          :target="isExternalLink ? '_blank' : undefined"
          class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors font-semibold text-lg"
        >
          {{ aboutContent.learnMoreText || 'Pelajari Lebih Lanjut' }}
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </component>
      </div>

      <!-- Kartu Fitur -->
      <div class="grid grid-cols-2 gap-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
        <div
          v-for="(card, index) in aboutContent.cards"
          :key="index"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100 + 300"
          class="group rounded-2xl border border-slate-800 bg-slate-800/90 p-6 shadow-lg hover:bg-slate-800 hover:shadow-xl transition-all duration-500 hover:-translate-y-2 hover:scale-[1.02]"
        >
          <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-sky-500/20">
            <svg v-if="index === 0" class="h-7 w-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
            </svg>
            <svg v-else-if="index === 1" class="h-7 w-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <svg v-else-if="index === 2" class="h-7 w-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg v-else class="h-7 w-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
      </div>
          <h3 class="font-semibold text-white mb-2 text-lg">{{ card.title }}</h3>
          <p class="text-sm text-slate-300 leading-relaxed">{{ card.description }}</p>
      </div>
    </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/api/client'

const aboutContent = ref({
  title: '',
  paragraph1: '',
  paragraph2: '',
  paragraph3: '',
  learnMoreText: '',
  learnMoreUrl: '',
  cards: [
    { title: 'Musik Koor', description: 'Berbagai genre musik rohani dengan harmoni yang indah' },
    { title: 'Komunitas', description: 'Komunitas yang solid dan saling mendukung' },
    { title: 'Pelayanan', description: 'Melayani Tuhan dan memberkati banyak orang' },
    { title: 'Konser', description: 'Pertunjukan musik di berbagai acara dan gereja' },
  ],
})

const isExternalLink = computed(() => {
  if (!aboutContent.value.learnMoreUrl) return false
  return aboutContent.value.learnMoreUrl.startsWith('http://') || 
         aboutContent.value.learnMoreUrl.startsWith('https://')
})

const formatText = (text: string) => {
  if (!text) return ''
  let formattedText = text.replace(/\*\*(.*?)\*\*/g, '<strong class="text-slate-900">$1</strong>')
  formattedText = formattedText.replace(/\*(.*?)\*/g, '<em>$1</em>')
  return formattedText
}

const fetchAbout = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.about_content) {
      try {
        const parsed = typeof data.about_content === 'string' 
          ? JSON.parse(data.about_content) 
          : data.about_content
        aboutContent.value = { ...aboutContent.value, ...parsed }
        // Pastikan cards selalu ada minimal 4
        if (!parsed.cards || parsed.cards.length < 4) {
          aboutContent.value.cards = [
            ...(parsed.cards || []),
            ...aboutContent.value.cards.slice(parsed.cards?.length || 0)
          ].slice(0, 4)
        }
      } catch (e) {
        console.error('Error parsing about_content:', e)
      }
    }
  } catch (error) {
    console.error('Error fetching about content:', error)
  }
}

onMounted(() => {
  fetchAbout()
})
</script>

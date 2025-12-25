<template>
  <div class="w-full space-y-16 sm:space-y-20 lg:space-y-28">
    <!-- Hero Section -->
    <section class="relative overflow-hidden border-b border-slate-200/80 bg-gradient-to-br from-white via-indigo-50/30 to-slate-50/50 shadow-xl">
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=1200&q=80')] bg-cover bg-center opacity-[0.015]"></div>
      <div class="relative grid gap-0 lg:grid-cols-2 min-h-[600px] lg:min-h-[700px]">
        <!-- Content Side -->
        <div class="flex items-center px-4 py-12 sm:px-6 sm:py-16 lg:px-12 lg:py-20">
          <div class="mx-auto w-full max-w-2xl space-y-6 sm:space-y-8" data-aos="fade-right" data-aos-duration="800">
            <div v-if="heroContent.tag" class="inline-flex items-center gap-2.5 rounded-full border border-indigo-200/70 bg-indigo-50/95 px-5 py-2.5 sm:px-6 sm:py-3 text-indigo-700 text-sm sm:text-base font-semibold shadow-md backdrop-blur-sm animate-fade-in-down">
              <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-indigo-500"></span>
              {{ heroContent.tag }}
            </div>
            <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl md:text-6xl lg:text-7xl tracking-tight">
              <span class="inline-block animate-fade-in-up" style="animation-delay: 0.1s">{{ heroContent.heading1 || 'UNCEASING' }}</span>
              <span class="block bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 bg-clip-text text-transparent mt-2 sm:mt-3 animate-gradient" style="animation-delay: 0.2s">
                {{ heroContent.heading2 || 'CANTICA BANDUNG' }}
              </span>
            </h1>
            <p class="text-lg leading-relaxed text-slate-600 sm:text-xl lg:text-2xl max-w-2xl font-medium animate-fade-in-up" style="animation-delay: 0.3s">
              {{ heroContent.description || 'Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar di Universitas Advent Indonesia (UNAI), Bandung. Melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni.' }}
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 pt-2 animate-fade-in-up" style="animation-delay: 0.4s">
              <component
                :is="isExternalUrl(heroContent.button1?.url) ? 'a' : 'RouterLink'"
                :href="isExternalUrl(heroContent.button1?.url) ? heroContent.button1?.url : undefined"
                :to="!isExternalUrl(heroContent.button1?.url) ? (heroContent.button1?.url || '/schedule') : undefined"
                :target="isExternalUrl(heroContent.button1?.url) ? '_blank' : undefined"
                class="group rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 px-6 py-3.5 sm:px-8 sm:py-4 text-sm sm:text-base font-bold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/30 text-center sm:text-left active:scale-95"
              >
                {{ heroContent.button1?.text || 'Lihat Jadwal Pelayanan' }}
                <span class="ml-2 inline-block transition-transform duration-300 group-hover:translate-x-1">→</span>
              </component>
              <component
                :is="isExternalUrl(heroContent.button2?.url) ? 'a' : 'RouterLink'"
                :href="isExternalUrl(heroContent.button2?.url) ? heroContent.button2?.url : undefined"
                :to="!isExternalUrl(heroContent.button2?.url) ? (heroContent.button2?.url || '/join') : undefined"
                :target="isExternalUrl(heroContent.button2?.url) ? '_blank' : undefined"
                class="rounded-2xl border-2 border-indigo-200/80 bg-white px-6 py-3.5 sm:px-8 sm:py-4 text-sm sm:text-base font-bold text-indigo-600 shadow-md transition-all duration-300 hover:border-indigo-300 hover:bg-indigo-50/50 hover:shadow-lg hover:scale-105 text-center sm:text-left active:scale-95"
              >
                {{ heroContent.button2?.text || 'Bergabung dengan Kami' }}
              </component>
            </div>
          </div>
        </div>
        <!-- Image Side - Full Landscape -->
        <div class="relative h-[400px] sm:h-[500px] lg:h-full lg:min-h-[700px]" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
          <div 
            class="relative h-full w-full overflow-hidden group"
            @mouseenter="stopHeroCarousel"
            @mouseleave="startHeroCarousel"
          >
            <!-- Hero Image Carousel -->
            <Transition name="fade" mode="out-in">
              <img
                :key="currentHeroImageIndex"
                :src="getCurrentHeroImage()"
                alt="Unceasing Cantica Bandung"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                @error="handleHeroImageError"
              />
            </Transition>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
            <!-- Carousel Indicators -->
            <div v-if="heroImages.length > 1" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2.5 z-10">
              <button
                v-for="(img, index) in heroImages"
                :key="img.id"
                @click="goToSlide(index)"
                :class="[
                  'h-2.5 rounded-full transition-all duration-300 cursor-pointer',
                  currentHeroImageIndex === index 
                    ? 'w-10 bg-white shadow-medium' 
                    : 'w-2.5 bg-white/60 hover:bg-white/80'
                ]"
                :aria-label="`Go to slide ${index + 1}`"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section v-if="statsContent && statsContent.stats && statsContent.stats.length > 0" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-wrap justify-center items-center gap-6">
        <div
          v-for="(stat, index) in statsContent.stats"
          :key="index"
          :data-aos="index % 2 === 0 ? 'fade-up' : 'fade-down'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white p-7 shadow-md transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-2 hover:scale-[1.02] w-full sm:w-[calc(50%-12px)] lg:w-[calc(25%-18px)] max-w-sm"
        >
          <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-gradient-to-br from-indigo-50/80 to-transparent opacity-70"></div>
          <div class="relative text-center">
            <p class="text-5xl font-bold bg-gradient-to-br from-indigo-600 to-indigo-500 bg-clip-text text-transparent">{{ stat.value }}</p>
            <p class="mt-3 text-sm font-semibold text-slate-700">{{ stat.title }}</p>
            <p v-if="stat.subtitle" class="mt-1.5 text-xs text-slate-500">{{ stat.subtitle }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Promosi Section -->
    <section v-if="promosi.length > 0" class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="800">
      <div class="text-center">
        <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">Promosi & Informasi</h2>
        <p class="mt-3 text-slate-600">Informasi terbaru dan promosi dari UCB</p>
        <div class="mt-4 flex justify-center">
          <div class="h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
        </div>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(item, index) in promosi"
          :key="item.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100/80 bg-white shadow-lg transition-all duration-500 hover:-translate-y-2 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-100/50 hover:scale-[1.02]"
        >
          <div class="relative overflow-hidden">
            <img
              v-if="item.image"
              :src="getPromosiImageUrl(item.image)"
              :alt="item.title"
              class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <div v-else class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-indigo-50/80 to-slate-50">
              <svg class="h-16 w-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
              </svg>
            </div>
            <div class="absolute right-3 top-3">
              <span class="rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white shadow-lg">
                {{ item.type || 'General' }}
              </span>
            </div>
          </div>
          <div class="p-6">
            <h3 class="mb-3 text-xl font-bold text-slate-800 line-clamp-2">{{ item.title }}</h3>
            <p v-if="item.description" class="mb-4 line-clamp-3 text-sm leading-relaxed text-slate-600">
              {{ item.description }}
            </p>
            <a
              v-if="item.link"
              :href="item.link"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-all hover:bg-indigo-700 hover:scale-105 shadow-md"
            >
              {{ item.link_text || 'Lihat Detail' }}
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Preview -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="800">
      <div class="mb-10 flex items-center justify-between">
        <div data-aos="fade-right">
          <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">Galeri Foto</h2>
          <p class="mt-3 text-slate-600">Momen-momen indah dalam pelayanan</p>
        </div>
        <RouterLink
          to="/gallery"
          class="rounded-xl px-4 py-2 text-sm font-semibold text-indigo-600 transition-all duration-300 hover:bg-indigo-50 hover:text-indigo-700 hover:scale-105"
          data-aos="fade-left"
        >
          Lihat Semua →
        </RouterLink>
      </div>
      <div v-if="loadingGallery" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="i in 4"
          :key="i"
          class="aspect-[4/3] animate-pulse rounded-2xl border border-indigo-100 bg-indigo-100"
        ></div>
      </div>
      <div v-else-if="galleryPreview.length === 0" class="rounded-2xl border border-indigo-100 bg-slate-50 p-8 text-center">
        <p class="text-slate-600">Belum ada foto galeri</p>
      </div>
      <div v-else class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(image, index) in galleryPreview"
          :key="image.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-xl hover:shadow-sky-100/50"
        >
          <div class="aspect-[4/3] overflow-hidden">
            <img
              :src="getGalleryImageUrl(image)"
              :alt="image.alt_text || image.original_filename"
              class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
              @error="(e) => handleGalleryImageError(e as any)"
            />
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
            <div class="absolute bottom-5 left-5 right-5">
              <p class="text-sm font-semibold text-white">{{ image.original_filename }}</p>
              <p v-if="image.caption" class="text-xs text-slate-200 mt-1">{{ image.caption }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Video Highlight -->
    <section class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:px-8 lg:grid-cols-2">
      <div class="space-y-6">
        <div>
          <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">Video Terbaru</h2>
          <p class="mt-3 text-slate-600">Tonton penampilan dan dokumentasi terbaru kami</p>
        </div>
        <div v-if="loadingLatestVideo" class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50/60 to-slate-50 shadow-sm">
          <div class="aspect-video animate-pulse bg-indigo-100"></div>
        </div>
        <div v-else-if="latestVideo" class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-900 shadow-sm">
          <div class="aspect-video">
            <!-- YouTube/Vimeo Embed -->
            <iframe
              v-if="latestVideo.video_type === 'url' && isYouTubeOrVimeo(latestVideo.video_url)"
              :src="getEmbedUrl(latestVideo.video_url)"
              class="h-full w-full"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
            
            <!-- Google Drive Embed -->
            <iframe
              v-else-if="latestVideo.video_type === 'gdrive' || isGoogleDrive(latestVideo.video_url)"
              :src="getGoogleDriveEmbedUrl(latestVideo.video_url)"
              class="h-full w-full"
              frameborder="0"
              allow="autoplay"
              allowfullscreen
            ></iframe>
            
            <!-- Local Video File -->
            <video
              v-else-if="latestVideo.video_type === 'file' && latestVideo.video_file_path"
              :src="getVideoFileUrl(latestVideo)"
              class="h-full w-full object-cover"
              controls
              preload="metadata"
            >
              Browser Anda tidak mendukung video tag.
            </video>
            
            <!-- Fallback -->
            <div v-else class="flex h-full items-center justify-center bg-slate-800">
              <div class="text-center">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-indigo-100">
                  <svg class="h-10 w-10 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                  </svg>
                </div>
                <p class="text-sm text-slate-600">Video Highlight UCB</p>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50/60 to-slate-50 shadow-sm">
          <div class="aspect-video">
            <div class="flex h-full items-center justify-center">
              <div class="text-center">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-indigo-100">
                  <svg class="h-10 w-10 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                  </svg>
                </div>
                <p class="text-sm text-slate-600">Belum ada video</p>
              </div>
            </div>
          </div>
        </div>
        <RouterLink
          to="/videos"
          class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-indigo-600 transition-all hover:bg-indigo-50 hover:text-indigo-700"
        >
          Lihat Semua Video
          <span>→</span>
        </RouterLink>
      </div>
      <div class="space-y-6">
        <div>
          <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">Event Terdekat</h2>
          <p class="mt-3 text-slate-600">Jadwal pelayanan dan konser mendatang</p>
        </div>
        <div v-if="loadingEvents" class="space-y-4">
          <div
            v-for="i in 3"
            :key="i"
            class="animate-pulse rounded-2xl border border-indigo-100 bg-slate-50 p-6"
          >
            <div class="flex items-start gap-5">
              <div class="h-16 w-16 rounded-xl bg-indigo-200"></div>
              <div class="flex-1 space-y-2">
                <div class="h-5 w-3/4 rounded bg-indigo-200"></div>
                <div class="h-4 w-full rounded bg-indigo-100"></div>
                <div class="h-3 w-1/2 rounded bg-indigo-100"></div>
              </div>
            </div>
          </div>
        </div>
        <div v-else-if="upcomingEvents.length === 0" class="rounded-2xl border border-indigo-100 bg-slate-50 p-8 text-center">
          <p class="text-slate-600">Tidak ada event terdekat</p>
        </div>
        <div v-else class="space-y-4">
          <div
            v-for="(event, index) in upcomingEvents"
            :key="event.id"
            :data-aos="'fade-left'"
            :data-aos-delay="index * 100"
            class="group rounded-2xl border border-indigo-100 bg-slate-50 p-6 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-xl hover:shadow-sky-100/50 hover:scale-[1.02]"
          >
            <div class="flex items-start gap-5">
              <div class="flex-shrink-0 rounded-xl border border-indigo-200 bg-indigo-50 p-4 text-center">
                <p class="text-xl font-bold text-indigo-600">{{ formatDay(event.start_date) }}</p>
                <p class="text-xs text-slate-600 mt-1">{{ formatMonth(event.start_date) }}</p>
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-slate-800">{{ event.title }}</h3>
                <p v-if="event.location" class="mt-2 text-sm text-slate-600">{{ event.location }}</p>
                <p class="mt-2 text-xs text-slate-500">{{ formatTime(event.start_date) }}</p>
              </div>
            </div>
          </div>
        </div>
        <RouterLink
          to="/schedule"
          class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-indigo-600 transition-all hover:bg-indigo-50 hover:text-indigo-700"
        >
          Lihat Semua Jadwal
          <span>→</span>
        </RouterLink>
      </div>
    </section>

    <!-- About UCB Section -->
    <section class="border-y border-indigo-100 bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-50 py-10 shadow-xl shadow-indigo-100/30 lg:py-16" data-aos="fade-up" data-aos-duration="800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
        <div class="space-y-7" data-aos="fade-right" data-aos-duration="800">
          <div>
            <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">{{ aboutContent.title || 'Tentang Unceasing Cantica' }}</h2>
            <div class="mt-4 h-1.5 w-24 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"></div>
          </div>
          <div class="space-y-5 text-slate-700 leading-relaxed">
            <p v-if="aboutContent.paragraph1" v-html="formatParagraph(aboutContent.paragraph1)"></p>
            <p v-else>
              <strong class="text-slate-900">Unceasing Cantica Bandung (UCB)</strong> adalah paduan suara yang didirikan pada <strong class="text-indigo-600">22 Maret 2001</strong> oleh <strong class="text-slate-900">Sir Dante Oblimar</strong>, seorang musisi asal Filipina, di kampus Universitas Advent Indonesia (UNAI) di Bandung.
            </p>
            <p v-if="aboutContent.paragraph2" v-html="formatParagraph(aboutContent.paragraph2)"></p>
            <p v-else>
              Nama <strong class="text-indigo-600">"Unceasing Cantica"</strong> berasal dari kata <strong class="text-slate-900">"Unceasing"</strong> yang berarti <em>"tak berkesudahan"</em> dan <strong class="text-slate-900">"Cantica"</strong> yang berarti <em>"pujian"</em>, sehingga secara keseluruhan berarti <strong class="text-indigo-600">"Pujian yang tak berkesudahan"</strong>.
            </p>
            <p v-if="aboutContent.paragraph3" v-html="formatParagraph(aboutContent.paragraph3)"></p>
            <p v-else>
              UCB terdiri dari orang-orang muda yang berkomitmen untuk melayani Allah dan menyebarkan Injil melalui musik. Seiring waktu, UCB telah berkembang dan membentuk beberapa cabang di berbagai lokasi, termasuk Jakarta, Manila, AUP, Bangkok, Balikpapan, dan Australia.
            </p>
          </div>
          <component
            v-if="aboutContent.learnMoreUrl"
            :is="isExternalLink ? 'a' : 'RouterLink'"
            :href="isExternalLink ? aboutContent.learnMoreUrl : undefined"
            :to="!isExternalLink ? aboutContent.learnMoreUrl : undefined"
            :target="isExternalLink ? '_blank' : undefined"
            class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-indigo-600 transition-all hover:bg-indigo-50 hover:text-indigo-700"
          >
            {{ aboutContent.learnMoreText || 'Pelajari Lebih Lanjut' }}
            <span>→</span>
          </component>
        </div>
        <div class="grid gap-5 sm:grid-cols-2" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
          <div
            v-for="(card, index) in aboutContent.cards"
            :key="index"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100 + 300"
            class="rounded-2xl border border-indigo-100 bg-slate-50 p-6 shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02]"
            :class="{ 'bg-white': index % 2 === 1 }"
          >
            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-indigo-50">
              <svg v-if="index === 0" class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
              </svg>
              <svg v-else-if="index === 1" class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <svg v-else-if="index === 2" class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <svg v-else class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="font-semibold text-slate-800">{{ card.title }}</h3>
            <p class="mt-2.5 text-sm text-slate-600 leading-relaxed">{{ card.description }}</p>
          </div>
        </div>
      </div>
      </div>
    </section>

    <!-- Active Members Section -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="800">
      <div class="mb-12 text-center" data-aos="fade-down">
        <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl">Member Aktif</h2>
        <p class="mt-3 text-slate-600">Para anggota yang aktif melayani dalam Unceasing Cantica Bandung</p>
      </div>

      <!-- Soprano Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"></div>
          <h3 class="text-2xl font-bold text-slate-800">Soprano</h3>
          <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
            {{ getMembersByRole('Soprano').length }} Member
          </span>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(member, index) in getMembersByRole('Soprano')"
            :key="`soprano-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-28 w-28">
              <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-60"></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
              />
              <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-400 shadow-sm"></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
            <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
              <span
                v-for="(badge, badgeIndex) in member.badges"
                :key="badgeIndex"
                class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
              >
                {{ badge }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Alto Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"></div>
          <h3 class="text-2xl font-bold text-slate-800">Alto</h3>
          <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
            {{ getMembersByRole('Alto').length }} Member
          </span>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(member, index) in getMembersByRole('Alto')"
            :key="`alto-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-28 w-28">
              <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-60"></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
              />
              <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-400 shadow-sm"></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
            <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
              <span
                v-for="(badge, badgeIndex) in member.badges"
                :key="badgeIndex"
                class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
              >
                {{ badge }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tenor Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"></div>
          <h3 class="text-2xl font-bold text-slate-800">Tenor</h3>
          <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
            {{ getMembersByRole('Tenor').length }} Member
          </span>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(member, index) in getMembersByRole('Tenor')"
            :key="`tenor-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-28 w-28">
              <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-60"></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
              />
              <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-400 shadow-sm"></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
            <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
              <span
                v-for="(badge, badgeIndex) in member.badges"
                :key="badgeIndex"
                class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
              >
                {{ badge }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Bass Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"></div>
          <h3 class="text-2xl font-bold text-slate-800">Bass</h3>
          <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
            {{ getMembersByRole('Bass').length }} Member
          </span>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(member, index) in getMembersByRole('Bass')"
            :key="`bass-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-28 w-28">
              <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-60"></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
              />
              <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-400 shadow-sm"></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
            <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
              <span
                v-for="(badge, badgeIndex) in member.badges"
                :key="badgeIndex"
                class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
              >
                {{ badge }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Conductor Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
          <h3 class="text-2xl font-bold text-slate-800">Conductor</h3>
          <span class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700">
            {{ getMembersByRole('Conductor').length }} Member
          </span>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(member, index) in getMembersByRole('Conductor')"
            :key="`conductor-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-28 w-28">
              <div class="absolute inset-0 rounded-full bg-indigo-50 blur-2xl opacity-60"></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-28 w-28 rounded-full border-3 border-indigo-100 object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
              />
              <div class="absolute bottom-0 right-0 h-5 w-5 rounded-full border-3 border-white bg-indigo-400 shadow-sm"></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">{{ member.role }}</p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">{{ member.position }}</p>
            <div v-if="member.badges && member.badges.length > 0" class="mt-5 flex justify-center gap-2">
              <span
                v-for="(badge, badgeIndex) in member.badges"
                :key="badgeIndex"
                class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
              >
                {{ badge }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-10 text-center">
        <RouterLink
          to="/members"
          class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-indigo-600 transition-all hover:bg-indigo-50 hover:text-indigo-700"
        >
          Lihat Semua Member
          <span>→</span>
        </RouterLink>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="border-y border-indigo-200 bg-gradient-to-r from-indigo-50/70 via-slate-50 to-indigo-50/70 py-10 shadow-xl shadow-indigo-100/30 lg:py-16" data-aos="zoom-in" data-aos-duration="800">
      <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-slate-800 lg:text-4xl" data-aos="fade-down">Bergabunglah dengan Kami</h2>
        <p class="mt-4 text-lg text-slate-700 leading-relaxed" data-aos="fade-up" data-aos-delay="100">
          Apakah Anda memiliki passion untuk musik dan ingin melayani Tuhan melalui paduan suara? Mari bergabung dengan Unceasing Cantica Bandung!
        </p>
        <div class="mt-10 flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
          <RouterLink
            to="/join"
            class="rounded-2xl bg-gradient-to-r from-indigo-500 to-indigo-600 px-9 py-4 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all duration-300 hover:scale-[1.05] hover:shadow-xl hover:shadow-sky-500/30 active:scale-95"
          >
            Daftar Sekarang
          </RouterLink>
          <RouterLink
            to="/contact"
            class="rounded-2xl border-2 border-indigo-200 bg-slate-50 px-9 py-4 text-sm font-semibold text-indigo-600 shadow-sm transition-all duration-300 hover:border-indigo-300 hover:bg-indigo-50/70 hover:shadow-md hover:scale-[1.02] active:scale-95"
          >
            Hubungi Kami
          </RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { ref, onMounted, onUnmounted, computed } from 'vue'
import api from '@/lib/api/client'

// Hero Content
const defaultHeroContent = {
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

const heroContent = ref({ ...defaultHeroContent })

const isExternalUrl = (url?: string) => {
  if (!url) return false
  return url.startsWith('http://') || url.startsWith('https://')
}

const getHeroImageUrl = (url?: string) => {
  if (!url) return '/UCB.png'
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

const fetchHeroContent = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.hero_content) {
      try {
        const parsed = typeof data.hero_content === 'string' 
          ? JSON.parse(data.hero_content) 
          : data.hero_content
        
        heroContent.value = { 
          ...defaultHeroContent, 
          ...parsed,
          button1: { ...defaultHeroContent.button1, ...(parsed.button1 || {}) },
          button2: { ...defaultHeroContent.button2, ...(parsed.button2 || {}) }
        }
      } catch (e) {
        console.error('Error parsing hero_content:', e)
        heroContent.value = { ...defaultHeroContent }
      }
    } else {
      heroContent.value = { ...defaultHeroContent }
    }
  } catch (error) {
    console.error('Error fetching hero content:', error)
    heroContent.value = { ...defaultHeroContent }
  }
}

// Stats Content
const defaultStatsContent = {
  stats: [
    {
      value: '2001',
      title: 'Tahun Berdiri',
      subtitle: '22 Maret 2001'
    },
    {
      value: '100+',
      title: 'Anggota Aktif',
      subtitle: 'Komunitas yang berkembang'
    },
    {
      value: '24',
      title: 'Tahun Melayani',
      subtitle: 'Dengan dedikasi tinggi'
    }
  ]
}

const statsContent = ref({ ...defaultStatsContent })

const fetchStatsContent = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.stats_content) {
      try {
        const parsed = typeof data.stats_content === 'string' 
          ? JSON.parse(data.stats_content) 
          : data.stats_content
        
        statsContent.value = { 
          ...defaultStatsContent, 
          ...parsed,
          stats: parsed.stats && parsed.stats.length > 0 
            ? parsed.stats.slice(0, 4) // Maksimal 4 kartu
            : defaultStatsContent.stats
        }
      } catch (e) {
        console.error('Error parsing stats_content:', e)
        statsContent.value = { ...defaultStatsContent }
      }
    } else {
      statsContent.value = { ...defaultStatsContent }
    }
  } catch (error) {
    console.error('Error fetching stats content:', error)
    statsContent.value = { ...defaultStatsContent }
  }
}

// Data member aktif
interface Member {
  id: number
  name: string
  role: string
  position: string | null
  avatar: string | null
  badges: string[] | null
  is_active: boolean
}

const activeMembers = ref<Member[]>([])

const getAvatarUrl = (avatarPath: string | null) => {
  if (!avatarPath) return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80'
  if (avatarPath.startsWith('http')) return avatarPath
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${avatarPath}`
}

// Function untuk filter member berdasarkan role
const getMembersByRole = (role: string) => {
  return activeMembers.value.filter(member => member.role === role && member.is_active)
}

// Event data
interface Event {
  id: number
  title: string
  description: string | null
  event_type: string
  start_date: string
  end_date: string | null
  location: string | null
  venue: string | null
}

const upcomingEvents = ref<Event[]>([])
const loadingEvents = ref(true)

// Gallery data
interface GalleryImage {
  id: number
  path: string
  original_filename: string
  alt_text?: string
  caption?: string
}

const galleryPreview = ref<GalleryImage[]>([])
const loadingGallery = ref(true)

// Hero carousel images from gallery
const heroImages = ref<GalleryImage[]>([])
const currentHeroImageIndex = ref(0)
let heroCarouselInterval: ReturnType<typeof setInterval> | null = null

const getGalleryImageUrl = (image: GalleryImage) => {
  if (image.path) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}/storage/${image.path}`
  }
  return ''
}

const getCurrentHeroImage = () => {
  if (heroImages.value.length === 0) {
    // Fallback ke hero image dari CMS jika tidak ada foto galeri
    return getHeroImageUrl(heroContent.value.imageUrl)
  }
  const currentImage = heroImages.value[currentHeroImageIndex.value]
  if (currentImage && currentImage.path) {
    return getGalleryImageUrl(currentImage)
  }
  return getHeroImageUrl(heroContent.value.imageUrl)
}

const handleHeroImageError = (event: Event) => {
  const img = event.target as HTMLImageElement
  // Fallback ke hero image dari CMS
  img.src = getHeroImageUrl(heroContent.value.imageUrl)
}

const startHeroCarousel = () => {
  if (heroImages.value.length <= 1) return
  
  // Clear existing interval
  if (heroCarouselInterval) {
    clearInterval(heroCarouselInterval)
  }
  
  // Auto-slide setiap 5 detik
  heroCarouselInterval = setInterval(() => {
    currentHeroImageIndex.value = (currentHeroImageIndex.value + 1) % heroImages.value.length
  }, 5000)
}

const stopHeroCarousel = () => {
  if (heroCarouselInterval) {
    clearInterval(heroCarouselInterval)
    heroCarouselInterval = null
  }
}

const goToSlide = (index: number) => {
  currentHeroImageIndex.value = index
  // Restart carousel setelah 3 detik
  stopHeroCarousel()
  setTimeout(() => {
    startHeroCarousel()
  }, 3000)
}

const handleGalleryImageError = (event: { target: HTMLImageElement }) => {
  const img = event.target
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23e0e7ef" width="200" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

// Latest video data
interface LatestVideo {
  id: number
  title: string
  video_url: string
  video_file_path: string | null
  video_type: 'url' | 'gdrive' | 'file'
}

const latestVideo = ref<LatestVideo | null>(null)
const loadingLatestVideo = ref(true)

// Promosi data
interface Promosi {
  id: number
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
}

const promosi = ref<Promosi[]>([])

const getPromosiImageUrl = (path: string) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
  return `${backendUrl}/storage/${path}`
}

const fetchPromosi = async () => {
  try {
    const response = await api.get('/v1/promosi?filter=active&public=true')
    let allPromosi: Promosi[] = []
    if (response.data.data) {
      allPromosi = response.data.data
    } else if (Array.isArray(response.data)) {
      allPromosi = response.data
    }
    
    // Filter by date range if applicable
    const now = new Date()
    now.setHours(0, 0, 0, 0)
    
    promosi.value = allPromosi
      .filter((item: Promosi) => {
        if (!item.is_active) return false
        if (item.start_date) {
          const startDate = new Date(item.start_date)
          startDate.setHours(0, 0, 0, 0)
          if (startDate > now) return false
        }
        if (item.end_date) {
          const endDate = new Date(item.end_date)
          endDate.setHours(0, 0, 0, 0)
          if (endDate < now) return false
        }
        return true
      })
      .sort((a: Promosi, b: Promosi) => a.order - b.order)
      .slice(0, 6) // Limit to 6 items
  } catch (error) {
    console.error('Error fetching promosi:', error)
    promosi.value = []
  }
}

// About content
const defaultAboutContent = {
  title: 'Tentang Unceasing Cantica',
  paragraph1: '',
  paragraph2: '',
  paragraph3: '',
  learnMoreText: 'Pelajari Lebih Lanjut',
  learnMoreUrl: '',
  cards: [
    { title: 'Musik Koor', description: 'Berbagai genre musik rohani dengan harmoni yang indah' },
    { title: 'Komunitas', description: 'Komunitas yang solid dan saling mendukung' },
    { title: 'Pelayanan', description: 'Melayani Tuhan dan memberkati banyak orang' },
    { title: 'Konser', description: 'Pertunjukan musik di berbagai acara dan gereja' },
  ],
}

const aboutContent = ref({ ...defaultAboutContent })

const isExternalLink = computed(() => {
  if (!aboutContent.value.learnMoreUrl) return false
  return aboutContent.value.learnMoreUrl.startsWith('http://') || 
         aboutContent.value.learnMoreUrl.startsWith('https://')
})

const formatParagraph = (text: string) => {
  if (!text) return ''
  // Convert **text** to <strong>text</strong>
  return text
    .replace(/\*\*(.*?)\*\*/g, '<strong class="text-slate-900">$1</strong>')
    .replace(/\*(.*?)\*/g, '<em>$1</em>')
}

const isYouTubeOrVimeo = (url: string) => {
  if (!url) return false
  return url.includes('youtube.com') || url.includes('youtu.be') || url.includes('vimeo.com')
}

const isGoogleDrive = (url: string) => {
  if (!url) return false
  return url.includes('drive.google.com') || url.includes('docs.google.com')
}

const getEmbedUrl = (url: string) => {
  if (!url) return ''
  
  // YouTube
  if (url.includes('youtube.com/watch?v=')) {
    const videoId = url.split('v=')[1]?.split('&')[0]
    return `https://www.youtube.com/embed/${videoId}`
  }
  if (url.includes('youtu.be/')) {
    const videoId = url.split('youtu.be/')[1]?.split('?')[0]
    return `https://www.youtube.com/embed/${videoId}`
  }
  
  // Vimeo
  if (url.includes('vimeo.com/')) {
    const videoId = url.split('vimeo.com/')[1]?.split('?')[0]
    return `https://player.vimeo.com/video/${videoId}`
  }
  
  return url
}

const getGoogleDriveEmbedUrl = (url: string) => {
  if (!url) return ''
  
  // Extract file ID from various Google Drive URL formats
  let fileId = ''
  
  // Format: https://drive.google.com/file/d/FILE_ID/view
  const fileMatch = url.match(/\/file\/d\/([a-zA-Z0-9_-]+)/)
  if (fileMatch) {
    fileId = fileMatch[1]
  }
  
  // Format: https://drive.google.com/open?id=FILE_ID
  const openMatch = url.match(/[?&]id=([a-zA-Z0-9_-]+)/)
  if (openMatch && !fileId) {
    fileId = openMatch[1]
  }
  
  if (fileId) {
    return `https://drive.google.com/file/d/${fileId}/preview`
  }
  
  return url
}

const getVideoFileUrl = (video: LatestVideo) => {
  if (video.video_file_path) {
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
    const backendUrl = apiUrl.replace('/api', '') || 'http://localhost:8000'
    return `${backendUrl}/storage/${video.video_file_path}`
  }
  return ''
}

const formatDay = (dateString: string) => {
  const date = new Date(dateString)
  return date.getDate().toString().padStart(2, '0')
}

const formatMonth = (dateString: string) => {
  const date = new Date(dateString)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  return months[date.getMonth()]
}

const formatTime = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
}

const fetchAboutContent = async () => {
  try {
    const response = await api.get('/v1/settings')
    const data = response.data
    
    if (data.about_content) {
      try {
        const parsed = typeof data.about_content === 'string' 
          ? JSON.parse(data.about_content) 
          : data.about_content
        aboutContent.value = { 
          ...defaultAboutContent, 
          ...parsed,
          // Pastikan cards selalu ada 4 item
          cards: parsed.cards && parsed.cards.length === 4 
            ? parsed.cards 
            : [
                ...(parsed.cards || []),
                ...defaultAboutContent.cards.slice(parsed.cards?.length || 0)
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

const fetchMembers = async () => {
  try {
    const response = await api.get('/v1/members')
    const allMembers = response.data.data || response.data || []
    // Filter hanya member yang aktif
    activeMembers.value = allMembers.filter((m: Member) => m.is_active)
  } catch (error) {
    console.error('Error fetching members:', error)
    activeMembers.value = []
  }
}

onMounted(async () => {
  // Fetch hero content
  await fetchHeroContent()
  
  // Fetch stats content
  await fetchStatsContent()
  
  // Fetch promosi
  await fetchPromosi()
  
  // Fetch about content
  await fetchAboutContent()
  
  // Fetch members
  await fetchMembers()
  
  // Fetch events
  try {
    loadingEvents.value = true
    const response = await api.get('/v1/events')
    
    let allEvents: Event[] = []
    if (response.data.data) {
      allEvents = response.data.data
    } else if (Array.isArray(response.data)) {
      allEvents = response.data
    }
    
    // Filter events yang akan datang (start_date >= hari ini) dan ambil 3 terdekat
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    
    upcomingEvents.value = allEvents
      .filter((event: Event) => {
        const eventDate = new Date(event.start_date)
        eventDate.setHours(0, 0, 0, 0)
        return eventDate >= today
      })
      .sort((a: Event, b: Event) => {
        return new Date(a.start_date).getTime() - new Date(b.start_date).getTime()
      })
      .slice(0, 3)
  } catch (error) {
    console.error('Error fetching events:', error)
    upcomingEvents.value = []
  } finally {
    loadingEvents.value = false
  }

  // Fetch gallery images
  try {
    loadingGallery.value = true
    const galleryResponse = await api.get('/v1/gallery')
    const allMedia = galleryResponse.data.all_media || []
    // Ambil 4 foto terbaru untuk preview
    galleryPreview.value = allMedia.slice(0, 4)
    
    // Ambil 5-10 foto terbaru untuk hero carousel
    heroImages.value = allMedia.slice(0, 10)
    currentHeroImageIndex.value = 0
    
    // Start carousel jika ada foto
    if (heroImages.value.length > 0) {
      startHeroCarousel()
    }
  } catch (error) {
    console.error('Error fetching gallery:', error)
    galleryPreview.value = []
    heroImages.value = []
  } finally {
    loadingGallery.value = false
  }

  // Fetch latest video
  try {
    loadingLatestVideo.value = true
    const videoResponse = await api.get('/v1/videos')
    const allVideos = videoResponse.data.data || videoResponse.data || []
    if (allVideos.length > 0) {
      latestVideo.value = allVideos[0] // Video terbaru
    }
  } catch (error) {
    console.error('Error fetching latest video:', error)
    latestVideo.value = null
  } finally {
    loadingLatestVideo.value = false
  }
})

// Cleanup on unmount
onUnmounted(() => {
  stopHeroCarousel()
})
</script>

<style scoped>
/* Fade transition for hero carousel */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.8s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

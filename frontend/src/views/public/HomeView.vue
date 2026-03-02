<template>
  <div class="w-full space-y-16 sm:space-y-20 lg:space-y-28 pb-8">
    <!-- Hero Section - Full Screen -->
    <section class="relative h-screen overflow-hidden">
      <!-- Full Screen Hero with Text Overlay -->
      <div class="absolute inset-0">
        <!-- Hero Image Carousel -->
        <Transition name="slide-hero">
          <img
            :key="currentHeroImageIndex"
            :src="getCurrentHeroImage()"
            alt="Unceasing Cantica Bandung"
            class="absolute inset-0 h-full w-full object-cover"
            @error="handleHeroImageError"
          />
        </Transition>

        <!-- Dark gradient overlay for text readability -->
        <div
          class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-black/10"
        ></div>

        <!-- Text Overlay at Bottom -->
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10 lg:p-14">
          <!-- Tag/Badge -->
          <div
            v-if="heroContent.tag"
            class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 text-white/90 text-sm font-medium"
          >
            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
            {{ heroContent.tag }}
          </div>

          <!-- Heading -->
          <h1
            class="text-3xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-tight tracking-tight"
          >
            {{ heroContent.heading1 || "Pujian yang" }}<br />
            <span class="text-indigo-300">{{
              heroContent.heading2 || "Tak Berkesudahan"
            }}</span>
          </h1>

          <!-- Description -->
          <p
            class="mt-4 text-white/70 text-sm sm:text-base lg:text-lg max-w-2xl leading-relaxed line-clamp-2"
          >
            {{
              heroContent.description ||
              "Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 di Bandung."
            }}
          </p>

          <!-- CTA Buttons -->
          <div class="mt-6 flex flex-wrap gap-3">
            <component
              :is="isExternalUrl(heroContent.button1?.url) ? 'a' : 'RouterLink'"
              :href="
                isExternalUrl(heroContent.button1?.url)
                  ? heroContent.button1?.url
                  : undefined
              "
              :to="
                !isExternalUrl(heroContent.button1?.url)
                  ? heroContent.button1?.url || '/schedule'
                  : undefined
              "
              :target="
                isExternalUrl(heroContent.button1?.url) ? '_blank' : undefined
              "
              class="group rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-900 shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl active:scale-95"
            >
              {{ heroContent.button1?.text || "Lihat Jadwal" }}
              <span
                class="ml-2 inline-block transition-transform duration-300 group-hover:translate-x-1"
                >→</span
              >
            </component>
            <component
              :is="isExternalUrl(heroContent.button2?.url) ? 'a' : 'RouterLink'"
              :href="
                isExternalUrl(heroContent.button2?.url)
                  ? heroContent.button2?.url
                  : undefined
              "
              :to="
                !isExternalUrl(heroContent.button2?.url)
                  ? heroContent.button2?.url || '/join'
                  : undefined
              "
              :target="
                isExternalUrl(heroContent.button2?.url) ? '_blank' : undefined
              "
              class="rounded-xl border-2 border-white/70 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-white/10 hover:border-white active:scale-95"
            >
              {{ heroContent.button2?.text || "Bergabung dengan Kami" }}
            </component>
          </div>
        </div>

        <!-- Carousel Indicators -->
        <div
          v-if="heroImages.length > 1"
          class="absolute bottom-6 right-8 lg:right-14 flex gap-2 z-10"
        >
          <button
            v-for="(img, index) in heroImages"
            :key="img.id"
            @click="goToSlide(index)"
            :class="[
              'h-2 rounded-full transition-all duration-300 cursor-pointer',
              currentHeroImageIndex === index
                ? 'w-8 bg-white'
                : 'w-2 bg-white/50 hover:bg-white/80',
            ]"
            :aria-label="`Go to slide ${index + 1}`"
          />
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section
      v-if="statsContent && statsContent.stats && statsContent.stats.length > 0"
      class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative -mt-16 sm:-mt-24 z-20"
    >
      <div
        class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-2xl shadow-indigo-500/10 border border-white/60 p-8 sm:p-12 flex flex-wrap justify-center items-center gap-10 gap-y-14"
      >
        <div
          v-for="(stat, index) in statsContent.stats"
          :key="index"
          :data-aos="index % 2 === 0 ? 'fade-up' : 'fade-down'"
          :data-aos-delay="index * 100"
          class="group relative flex-1 min-w-[200px] text-center"
        >
          <div
            class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-purple-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-700 rounded-3xl -m-6 -z-10"
          ></div>
          <p
            class="text-6xl sm:text-7xl font-black bg-gradient-to-br from-indigo-600 to-purple-600 bg-clip-text text-transparent transform transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2 inline-block filter drop-shadow-sm"
          >
            {{ stat.value }}
          </p>
          <div
            class="w-12 h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-6 mb-4 rounded-full transform transition-all duration-500 group-hover:w-24 group-hover:bg-purple-600"
          ></div>
          <p
            class="text-sm font-extrabold tracking-[0.2em] text-slate-800 uppercase"
          >
            {{ stat.title }}
          </p>
          <p
            v-if="stat.subtitle"
            class="mt-2 text-xs md:text-sm text-slate-500 font-medium"
          >
            {{ stat.subtitle }}
          </p>
        </div>
      </div>
    </section>

    <!-- About UCB Section -->
    <section
      class="border-y border-indigo-50 overflow-hidden relative"
      data-aos="fade-up"
      data-aos-duration="1000"
    >
      <div
        class="absolute inset-0 bg-cover bg-center bg-fixed opacity-100 -z-30"
        :style="{
          backgroundImage: `url(${getHeroImageUrl('/pelayanan.jpg')})`,
        }"
      ></div>
      <div class="absolute inset-0 bg-white/50 backdrop-blur-[2px] -z-20"></div>
      <div
        class="absolute inset-0 bg-gradient-to-b from-white/80 via-transparent to-white/80 -z-10"
      ></div>

      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid gap-16 lg:grid-cols-2 items-center">
          <div class="space-y-8" data-aos="fade-right">
            <div>
              <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100/50 text-indigo-700 text-sm font-bold mb-4 tracking-wide"
              >
                Kisah Kami
              </div>
              <h2
                class="text-4xl font-extrabold text-slate-900 lg:text-5xl leading-tight"
              >
                {{ aboutContent.title || "Tentang Unceasing Cantica" }}
              </h2>
              <div class="mt-6 flex gap-2">
                <div class="h-2 w-20 rounded-full bg-indigo-600"></div>
                <div class="h-2 w-4 rounded-full bg-sky-400"></div>
              </div>
            </div>

            <div
              class="space-y-6 text-lg text-slate-600 leading-relaxed font-medium"
            >
              <p
                v-if="aboutContent.paragraph1"
                v-html="formatParagraph(aboutContent.paragraph1)"
              ></p>
              <p v-else>
                <strong class="text-slate-900"
                  >Unceasing Cantica Bandung (UCB)</strong
                >
                adalah paduan suara yang didirikan pada
                <strong class="text-indigo-600">22 Maret 2001</strong> oleh
                <strong class="text-slate-900">Sir Dante Oblimar</strong>,
                seorang musisi asal Filipina, di kampus Universitas Advent
                Indonesia (UNAI) di Bandung.
              </p>
              <p
                v-if="aboutContent.paragraph2"
                v-html="formatParagraph(aboutContent.paragraph2)"
              ></p>
              <p v-else>
                Nama
                <strong class="text-indigo-600">"Unceasing Cantica"</strong>
                berasal dari kata
                <strong class="text-slate-900">"Unceasing"</strong> (tak
                berkesudahan) dan
                <strong class="text-slate-900">"Cantica"</strong> (pujian), yang
                berarti
                <strong class="text-indigo-600"
                  >"Pujian yang tak berkesudahan"</strong
                >.
              </p>
              <p
                v-if="aboutContent.paragraph3"
                v-html="formatParagraph(aboutContent.paragraph3)"
              ></p>
              <p v-else>
                Kami adalah kaum muda yang berkomitmen melayani Tuhan melalui
                harmoni musik. Seiring waktu, pelayanan ini telah meluas dengan
                berbagai cabang di Jakarta, Manila, Bangkok, Balikpapan, dan
                Australia.
              </p>
            </div>
          </div>
          <div
            class="grid gap-6 sm:grid-cols-2"
            data-aos="fade-left"
            data-aos-delay="200"
          >
            <div
              v-for="(card, index) in aboutContent.cards"
              :key="index"
              class="group relative overflow-hidden rounded-[2rem] border border-white bg-white/60 backdrop-blur-md p-8 shadow-xl shadow-slate-200/40 transition-all duration-500 hover:-translate-y-2 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100"
            >
              <div
                class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-indigo-100 to-sky-50 opacity-50 blur-2xl group-hover:scale-150 transition-transform duration-700"
              ></div>

              <div class="relative z-10">
                <div
                  class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-sky-500 text-white shadow-lg shadow-indigo-500/30 transform group-hover:rotate-6 transition-transform duration-300"
                >
                  <svg
                    v-if="index === 0"
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                    />
                  </svg>
                  <svg
                    v-else-if="index === 1"
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                  </svg>
                  <svg
                    v-else-if="index === 2"
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                    />
                  </svg>
                  <svg
                    v-else
                    class="h-8 w-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">
                  {{ card.title }}
                </h3>
                <p
                  class="mt-3 text-base text-slate-600 leading-relaxed font-medium"
                >
                  {{ card.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Promosi Section -->
    <section
      v-if="promosi.length > 0"
      class="mx-auto max-w-7xl space-y-14 px-4 sm:px-6 lg:px-8 pt-10"
      data-aos="fade-up"
      data-aos-duration="800"
    >
      <div class="max-w-3xl text-center mx-auto">
        <h2
          class="text-4xl font-extrabold tracking-tight text-slate-900 lg:text-5xl"
        >
          Promosi <span class="text-indigo-600">&</span> Informasi
        </h2>
        <p class="mt-5 text-lg text-slate-600 leading-relaxed">
          Kabar terbaru, pengumuman, dan penawaran eksklusif dari Unceasing
          Cantica Bandung.
        </p>
        <div class="mt-6 flex justify-center gap-2">
          <div class="h-2 w-16 rounded-full bg-indigo-600"></div>
          <div class="h-2 w-4 rounded-full bg-indigo-300"></div>
        </div>
      </div>
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(item, index) in promosi"
          :key="item.id"
          :data-aos="'zoom-in'"
          :data-aos-delay="index * 100"
          class="group flex flex-col overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-slate-200/50 transition-all duration-700 hover:-translate-y-4 hover:shadow-2xl hover:shadow-indigo-200"
        >
          <div class="relative overflow-hidden aspect-[16/10]">
            <img
              v-if="item.image"
              :src="getPromosiImageUrl(item.image)"
              :alt="item.title"
              class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div
              v-else
              class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-50 to-slate-100"
            >
              <svg
                class="h-20 w-20 text-indigo-300 transition-transform duration-700 group-hover:scale-110 group-hover:rotate-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                />
              </svg>
            </div>
            <div
              class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
            ></div>
            <div class="absolute right-4 top-4">
              <span
                class="rounded-full bg-indigo-600/90 backdrop-blur-md px-4 py-1.5 text-xs font-bold tracking-wide text-white shadow-lg"
              >
                {{ item.type || "General" }}
              </span>
            </div>
          </div>
          <div class="flex flex-1 flex-col p-8">
            <h3
              class="mb-4 text-2xl font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors duration-300"
            >
              {{ item.title }}
            </h3>
            <p
              v-if="item.description"
              class="mb-6 flex-1 line-clamp-3 text-base leading-relaxed text-slate-600"
            >
              {{ item.description }}
            </p>
            <div v-if="item.link" class="mt-auto">
              <a
                :href="item.link"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-50 border border-slate-200/80 px-5 py-3.5 text-sm font-bold text-indigo-600 transition-all duration-300 group-hover:bg-indigo-600 group-hover:text-white hover:shadow-lg hover:shadow-indigo-500/30 active:scale-95"
              >
                {{ item.link_text || "Lihat Detail" }}
                <svg
                  class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 8l4 4m0 0l-4 4m4-4H3"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Preview -->
    <section
      class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16"
      data-aos="fade-up"
      data-aos-duration="1000"
    >
      <div
        class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6"
      >
        <div data-aos="fade-right">
          <h2
            class="text-4xl font-extrabold text-slate-900 tracking-tight lg:text-5xl"
          >
            Galeri <span class="text-indigo-600">Pelayanan</span>
          </h2>
          <p class="mt-4 text-lg text-slate-600 max-w-2xl">
            Momen-momen indah kebersamaan dan pelayanan yang tak terlupakan.
          </p>
        </div>
        <RouterLink
          to="/gallery"
          class="shrink-0 group relative inline-flex items-center gap-2 overflow-hidden rounded-full bg-slate-900 px-8 py-3.5 text-sm font-semibold text-white transition-all hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-500/30"
          data-aos="fade-left"
        >
          <span>Lihat Semua Foto</span>
          <svg
            class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 border border-white/20 rounded-full w-6 h-6 p-1 bg-white/10"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </RouterLink>
      </div>

      <div
        v-if="loadingGallery"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
      >
        <div
          v-for="i in 4"
          :key="i"
          class="aspect-[4/5] animate-pulse rounded-3xl bg-indigo-100/50"
        ></div>
      </div>
      <div
        v-else-if="galleryPreview.length === 0"
        class="rounded-3xl border border-indigo-100 bg-slate-50 p-12 text-center"
      >
        <p class="text-slate-500 text-lg">Belum ada foto galeri saat ini.</p>
      </div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="(image, index) in galleryPreview"
          :key="image.id"
          :data-aos="'zoom-in-up'"
          :data-aos-delay="index * 150"
          class="group relative overflow-hidden rounded-[2rem] bg-slate-100 shadow-md transition-all duration-700 hover:-translate-y-3 hover:shadow-2xl hover:shadow-indigo-900/20 cursor-pointer"
        >
          <div class="aspect-[4/5] overflow-hidden w-full h-full relative">
            <img
              :src="getGalleryImageUrl(image)"
              :alt="image.alt_text || image.original_filename"
              class="absolute inset-0 h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110"
              @error="(e) => handleGalleryImageError(e as any)"
            />
            <div
              class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"
            ></div>
          </div>

          <div
            class="absolute inset-x-0 bottom-0 p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500"
          >
            <div
              class="w-8 h-1 bg-indigo-500 rounded-full mb-4 opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100"
            ></div>
            <p class="text-lg font-bold text-white mb-1">
              {{ image.original_filename }}
            </p>
            <p
              v-if="image.caption"
              class="text-sm font-medium text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200 line-clamp-2"
            >
              {{ image.caption }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Video Highlight Section -->
    <section class="relative bg-slate-900 overflow-hidden py-24 my-10">
      <!-- Background Effects -->
      <div class="absolute inset-0 overflow-hidden">
        <div
          class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-indigo-600/20 blur-[120px]"
        ></div>
        <div
          class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[60%] rounded-full bg-indigo-900/40 blur-[100px]"
        ></div>
      </div>

      <div
        class="mx-auto grid max-w-7xl gap-16 px-4 sm:px-6 lg:px-8 lg:grid-cols-5 items-center relative z-10"
      >
        <!-- Text Content -->
        <div class="lg:col-span-2 space-y-8" data-aos="fade-right">
          <div>
            <div
              class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-sm font-semibold mb-6"
            >
              <span class="relative flex h-2 w-2">
                <span
                  class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"
                ></span>
                <span
                  class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"
                ></span>
              </span>
              Highlight Terkini
            </div>
            <h2
              class="text-4xl font-extrabold text-white tracking-tight lg:text-5xl leading-tight"
            >
              Tonton Penampilan
              <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-sky-400"
                >Terbaik</span
              >
              Kami.
            </h2>
          </div>
          <p class="text-lg text-slate-400 leading-relaxed">
            Rasakan harmoni dan semangat pelayanan kami melalui dokumentasi
            video terbaru.
          </p>
          <div>
            <RouterLink
              to="/videos"
              class="group inline-flex items-center gap-3 rounded-full bg-indigo-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 transition-all hover:bg-indigo-500 hover:scale-105"
            >
              <span>Jelajahi Semua Video</span>
              <svg
                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"
                />
              </svg>
            </RouterLink>
          </div>
        </div>

        <!-- Video Player -->
        <div
          class="lg:col-span-3 relative"
          data-aos="fade-left"
          data-aos-delay="200"
        >
          <div
            class="absolute -inset-1 rounded-[2.5rem] bg-gradient-to-r from-indigo-500 via-sky-500 to-indigo-500 opacity-30 blur-xl"
          ></div>

          <div
            class="relative rounded-[2rem] border border-white/10 bg-slate-800/80 backdrop-blur-sm p-2 shadow-2xl"
          >
            <div
              class="relative overflow-hidden rounded-[1.8rem] bg-black aspect-video group"
            >
              <!-- Loading State -->
              <div
                v-if="loadingLatestVideo"
                class="absolute inset-0 animate-pulse bg-slate-800 flex items-center justify-center"
              >
                <svg
                  class="h-10 w-10 text-indigo-500 animate-spin"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
              </div>

              <!-- Player Formats -->
              <template v-else-if="latestVideo">
                <iframe
                  v-if="
                    latestVideo.video_type === 'url' &&
                    isYouTubeOrVimeo(latestVideo.video_url)
                  "
                  :src="getEmbedUrl(latestVideo.video_url)"
                  class="absolute inset-0 h-full w-full"
                  frameborder="0"
                  allow="
                    accelerometer;
                    autoplay;
                    clipboard-write;
                    encrypted-media;
                    gyroscope;
                    picture-in-picture;
                  "
                  allowfullscreen
                ></iframe>

                <iframe
                  v-else-if="
                    latestVideo.video_type === 'gdrive' ||
                    isGoogleDrive(latestVideo.video_url)
                  "
                  :src="getGoogleDriveEmbedUrl(latestVideo.video_url)"
                  class="absolute inset-0 h-full w-full bg-white"
                  frameborder="0"
                  allow="autoplay"
                  allowfullscreen
                ></iframe>

                <video
                  v-else-if="
                    latestVideo.video_type === 'file' &&
                    latestVideo.video_file_path
                  "
                  :src="getVideoFileUrl(latestVideo)"
                  class="absolute inset-0 h-full w-full object-cover"
                  controls
                  preload="metadata"
                ></video>
              </template>

              <!-- Empty State -->
              <div
                v-else
                class="absolute inset-0 flex items-center justify-center bg-slate-900 border border-slate-700/50 rounded-[1.8rem]"
              >
                <div class="text-center text-slate-500">
                  <svg
                    class="mx-auto h-12 w-12 text-slate-600 mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                    />
                  </svg>
                  <p class="font-medium">Belum ada video tersedia.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Event Terdekat Section -->
    <section
      class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16"
      data-aos="fade-up"
    >
      <div
        class="mb-12 flex flex-col sm:flex-row sm:items-end justify-between gap-6"
      >
        <div>
          <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-600 text-sm font-semibold mb-4 border border-sky-100"
          >
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              ></path>
            </svg>
            Agenda Kami
          </div>
          <h2
            class="text-4xl font-extrabold text-slate-900 tracking-tight lg:text-5xl"
          >
            Event <span class="text-indigo-600">Terdekat</span>
          </h2>
          <p class="mt-4 text-lg text-slate-600 max-w-2xl">
            Jangan lewatkan jadwal pelayanan dan konser terbaru dari kami.
          </p>
        </div>
        <RouterLink
          to="/schedule"
          class="shrink-0 group inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-50 border border-slate-200 px-6 py-3 text-sm font-bold text-slate-700 transition-all hover:bg-slate-100 hover:text-indigo-600 hover:border-indigo-200"
        >
          Lihat Semua Jadwal
          <svg
            class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </RouterLink>
      </div>

      <div
        v-if="loadingEvents"
        class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
      >
        <div
          v-for="i in 3"
          :key="i"
          class="animate-pulse rounded-[2rem] border border-slate-100 bg-slate-50 p-8"
        >
          <div class="flex items-start gap-6">
            <div class="h-20 w-20 rounded-2xl bg-indigo-100/50"></div>
            <div class="flex-1 space-y-3">
              <div class="h-6 w-3/4 rounded bg-slate-200"></div>
              <div class="h-4 w-full rounded bg-slate-100"></div>
              <div class="h-4 w-1/2 rounded bg-slate-100"></div>
            </div>
          </div>
        </div>
      </div>

      <div
        v-else-if="upcomingEvents.length === 0"
        class="rounded-[2.5rem] border border-dashed border-slate-300 bg-slate-50/50 p-16 text-center"
      >
        <div
          class="mx-auto w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-sm mb-6"
        >
          <svg
            class="h-10 w-10 text-slate-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            ></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Jadwal</h3>
        <p class="text-slate-500">
          Saat ini belum ada event atau pelayanan terdekat.
        </p>
      </div>

      <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(event, index) in upcomingEvents"
          :key="event.id"
          :data-aos="'fade-up'"
          :data-aos-delay="index * 100"
          class="group relative overflow-hidden rounded-[2rem] border border-slate-200/60 bg-white p-6 shadow-lg shadow-slate-200/20 transition-all duration-500 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-2xl hover:shadow-indigo-100/40"
        >
          <div
            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-sky-50 rounded-bl-[100px] -z-10 group-hover:scale-110 transition-transform duration-700"
          ></div>

          <div class="flex items-start gap-5">
            <div class="flex-shrink-0 relative">
              <div
                class="absolute -inset-1 rounded-[1.2rem] bg-indigo-500/20 blur-sm opacity-0 group-hover:opacity-100 transition-opacity"
              ></div>
              <div
                class="relative flex flex-col items-center justify-center w-20 h-20 rounded-[1.2rem] border border-indigo-100 bg-white shadow-sm overflow-hidden"
              >
                <div
                  class="w-full text-center bg-indigo-500 py-1 text-[0.65rem] font-bold text-white uppercase tracking-wider"
                >
                  {{ formatMonth(event.start_date) }}
                </div>
                <div class="flex-1 flex items-center justify-center">
                  <p class="text-2xl font-black text-slate-800">
                    {{ formatDay(event.start_date) }}
                  </p>
                </div>
              </div>
            </div>

            <div class="flex-1 min-w-0 pt-1">
              <h3
                class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-snug"
              >
                {{ event.title }}
              </h3>

              <div class="mt-4 space-y-2">
                <div
                  class="flex items-center gap-2 text-sm text-slate-600 font-medium"
                >
                  <svg
                    class="h-4 w-4 text-sky-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                  </svg>
                  {{ formatTime(event.start_date) }} WIB
                </div>
                <div
                  v-if="event.location"
                  class="flex items-start gap-2 text-sm text-slate-600 font-medium"
                >
                  <svg
                    class="h-4 w-4 text-rose-400 shrink-0 mt-0.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    ></path>
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    ></path>
                  </svg>
                  <span class="line-clamp-2 leading-tight">{{
                    event.location
                  }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Active Members Section -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
      <div class="mb-16 text-center max-w-3xl mx-auto" data-aos="fade-down">
        <h2
          class="text-4xl font-extrabold text-slate-900 tracking-tight lg:text-5xl"
        >
          Anggota
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-sky-500"
            >Aktif</span
          >
        </h2>
        <p class="mt-5 text-lg text-slate-600">
          Para penyanyi berbakat yang menyatukan suara dalam pelayanan Unceasing
          Cantica Bandung.
        </p>
        <div class="mt-8 flex justify-center gap-2">
          <div class="h-1.5 w-12 rounded-full bg-indigo-200"></div>
          <div class="h-1.5 w-24 rounded-full bg-indigo-500"></div>
          <div class="h-1.5 w-12 rounded-full bg-indigo-200"></div>
        </div>
      </div>

      <!-- Soprano Section -->
      <div class="mb-14" data-aos="fade-up" data-aos-duration="800">
        <div class="mb-8 flex items-center gap-4">
          <div
            class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"
          ></div>
          <h3 class="text-2xl font-bold text-slate-800">Soprano</h3>
          <span
            class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700"
          >
            {{ getMembersByRole("Soprano").length }} Member
          </span>
        </div>
        <div
          class="flex flex-nowrap overflow-x-auto pb-6 gap-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:pb-0 snap-x snap-mandatory scrollbar-hide"
        >
          <div
            v-for="(member, index) in getMembersByRole('Soprano')"
            :key="`soprano-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="min-w-[280px] sm:min-w-0 flex-shrink-0 snap-center group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-36 w-36 shadow-lg rounded-full">
              <div
                class="absolute inset-0 rounded-full bg-indigo-50 blur-xl opacity-60"
              ></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-36 w-36 rounded-full border-4 border-white object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
              />
              <div
                class="absolute bottom-1 right-1 h-6 w-6 rounded-full border-2 border-white bg-indigo-500 shadow-sm"
              ></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">
              {{ member.role }}
            </p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">
              {{ member.position }}
            </p>
            <div
              v-if="member.badges && member.badges.length > 0"
              class="mt-5 flex justify-center gap-2"
            >
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
          <div
            class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"
          ></div>
          <h3 class="text-2xl font-bold text-slate-800">Alto</h3>
          <span
            class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700"
          >
            {{ getMembersByRole("Alto").length }} Member
          </span>
        </div>
        <div
          class="flex flex-nowrap overflow-x-auto pb-6 gap-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:pb-0 snap-x snap-mandatory scrollbar-hide"
        >
          <div
            v-for="(member, index) in getMembersByRole('Alto')"
            :key="`alto-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="min-w-[280px] sm:min-w-0 flex-shrink-0 snap-center group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-36 w-36 shadow-lg rounded-full">
              <div
                class="absolute inset-0 rounded-full bg-indigo-50 blur-xl opacity-60"
              ></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-36 w-36 rounded-full border-4 border-white object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
              />
              <div
                class="absolute bottom-1 right-1 h-6 w-6 rounded-full border-2 border-white bg-indigo-500 shadow-sm"
              ></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">
              {{ member.role }}
            </p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">
              {{ member.position }}
            </p>
            <div
              v-if="member.badges && member.badges.length > 0"
              class="mt-5 flex justify-center gap-2"
            >
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
          <div
            class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"
          ></div>
          <h3 class="text-2xl font-bold text-slate-800">Tenor</h3>
          <span
            class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700"
          >
            {{ getMembersByRole("Tenor").length }} Member
          </span>
        </div>
        <div
          class="flex flex-nowrap overflow-x-auto pb-6 gap-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:pb-0 snap-x snap-mandatory scrollbar-hide"
        >
          <div
            v-for="(member, index) in getMembersByRole('Tenor')"
            :key="`tenor-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="min-w-[280px] sm:min-w-0 flex-shrink-0 snap-center group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-36 w-36 shadow-lg rounded-full">
              <div
                class="absolute inset-0 rounded-full bg-indigo-50 blur-xl opacity-60"
              ></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-36 w-36 rounded-full border-4 border-white object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
              />
              <div
                class="absolute bottom-1 right-1 h-6 w-6 rounded-full border-2 border-white bg-indigo-500 shadow-sm"
              ></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">
              {{ member.role }}
            </p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">
              {{ member.position }}
            </p>
            <div
              v-if="member.badges && member.badges.length > 0"
              class="mt-5 flex justify-center gap-2"
            >
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
          <div
            class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-500"
          ></div>
          <h3 class="text-2xl font-bold text-slate-800">Bass</h3>
          <span
            class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700"
          >
            {{ getMembersByRole("Bass").length }} Member
          </span>
        </div>
        <div
          class="flex flex-nowrap overflow-x-auto pb-6 gap-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:pb-0 snap-x snap-mandatory scrollbar-hide"
        >
          <div
            v-for="(member, index) in getMembersByRole('Bass')"
            :key="`bass-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="min-w-[280px] sm:min-w-0 flex-shrink-0 snap-center group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-36 w-36 shadow-lg rounded-full">
              <div
                class="absolute inset-0 rounded-full bg-indigo-50 blur-xl opacity-60"
              ></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-36 w-36 rounded-full border-4 border-white object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
              />
              <div
                class="absolute bottom-1 right-1 h-6 w-6 rounded-full border-2 border-white bg-indigo-500 shadow-sm"
              ></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">
              {{ member.role }}
            </p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">
              {{ member.position }}
            </p>
            <div
              v-if="member.badges && member.badges.length > 0"
              class="mt-5 flex justify-center gap-2"
            >
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
          <div
            class="h-1.5 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600"
          ></div>
          <h3 class="text-2xl font-bold text-slate-800">Conductor</h3>
          <span
            class="rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-medium text-indigo-700"
          >
            {{ getMembersByRole("Conductor").length }} Member
          </span>
        </div>
        <div
          class="flex flex-nowrap overflow-x-auto pb-6 gap-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:pb-0 snap-x snap-mandatory scrollbar-hide"
        >
          <div
            v-for="(member, index) in getMembersByRole('Conductor')"
            :key="`conductor-${index}`"
            :data-aos="'zoom-in'"
            :data-aos-delay="index * 100"
            class="min-w-[280px] sm:min-w-0 flex-shrink-0 snap-center group relative overflow-hidden rounded-2xl border border-indigo-100 bg-slate-50 p-7 text-center shadow-sm transition-all duration-500 hover:border-indigo-200 hover:shadow-xl hover:shadow-sky-100/50 hover:-translate-y-2 hover:scale-[1.02]"
          >
            <div class="relative mx-auto mb-5 h-36 w-36 shadow-lg rounded-full">
              <div
                class="absolute inset-0 rounded-full bg-indigo-50 blur-xl opacity-60"
              ></div>
              <img
                :src="getAvatarUrl(member.avatar)"
                :alt="member.name"
                class="relative h-36 w-36 rounded-full border-4 border-white object-cover shadow-md transition-transform duration-300 group-hover:scale-105"
              />
              <div
                class="absolute bottom-1 right-1 h-6 w-6 rounded-full border-2 border-white bg-indigo-500 shadow-sm"
              ></div>
            </div>
            <h3 class="font-semibold text-slate-800">{{ member.name }}</h3>
            <p class="mt-2 text-sm text-indigo-600 font-medium">
              {{ member.role }}
            </p>
            <p v-if="member.position" class="mt-2 text-xs text-slate-500">
              {{ member.position }}
            </p>
            <div
              v-if="member.badges && member.badges.length > 0"
              class="mt-5 flex justify-center gap-2"
            >
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
    <section
      class="relative overflow-hidden bg-slate-900 py-24 lg:py-32"
      data-aos="fade-in"
      data-aos-duration="1200"
    >
      <div
        class="absolute inset-0 bg-cover bg-center opacity-30 mix-blend-overlay filter grayscale"
        :style="{ backgroundImage: `url(${getHeroImageUrl('/UCB.jpg')})` }"
      ></div>
      <div
        class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-indigo-900/60"
      ></div>

      <div
        class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center z-10"
      >
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white font-semibold tracking-wide mb-8"
        >
          Mulai Pelayanan Anda
        </div>
        <h2
          class="text-4xl font-extrabold text-white tracking-tight lg:text-6xl mb-6"
          data-aos="fade-up"
        >
          Siap
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-indigo-400"
            >Bergabung</span
          >
          Bersama Kami?
        </h2>
        <p
          class="text-xl text-slate-300 leading-relaxed mb-12 max-w-2xl mx-auto font-medium"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          Mari kembangkan talenta bernyanyi Anda dan jadilah bagian dari
          keluarga besar paduan suara Unceasing Cantica Bandung.
        </p>
        <div
          class="flex flex-col sm:flex-row justify-center items-center gap-5"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <RouterLink
            to="/join"
            class="group w-full sm:w-auto overflow-hidden relative inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-10 py-5 text-base font-bold text-white shadow-2xl shadow-indigo-600/40 transition-all duration-300 hover:scale-[1.03]"
          >
            <div
              class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-12deg)_translateX(-150%)] group-hover:duration-1000 group-hover:[transform:skew(-12deg)_translateX(150%)]"
            >
              <div class="relative h-full w-8 bg-white/20"></div>
            </div>
            <span class="relative">Ayo Daftar Sekarang</span>
          </RouterLink>
          <RouterLink
            to="/contact"
            class="group w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 px-10 py-5 text-base font-bold text-white shadow-xl transition-all duration-300 hover:bg-white/20 hover:scale-[1.02]"
          >
            Hubungi Pengurus
          </RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from "vue-router";
import { ref, onMounted, onUnmounted } from "vue";
import api from "@/lib/api/client";

// Hero Content
const defaultHeroContent = {
  tag: "Harmoni • Pelayanan • Komunitas",
  heading1: "Pujian yang",
  heading2: "Tak Berkesudahan",
  description:
    "Unceasing Cantica Bandung adalah paduan suara yang didirikan pada 22 Maret 2001 oleh Sir Dante Oblimar di Universitas Advent Indonesia (UNAI), Bandung. Melayani Tuhan dan memberkati banyak orang melalui musik koor yang penuh harmoni.",
  button1: {
    text: "Lihat Jadwal Pelayanan",
    url: "/schedule",
  },
  button2: {
    text: "Bergabung dengan Kami",
    url: "/join",
  },
  imageUrl: "/UCB.jpg",
};

const heroContent = ref({ ...defaultHeroContent });

const isExternalUrl = (url?: string) => {
  if (!url) return false;
  return url.startsWith("http://") || url.startsWith("https://");
};

const getHeroImageUrl = (url?: string) => {
  if (!url) {
    // Default fallback - coba dari backend public folder
    const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
    let backendUrl = apiUrl.replace("/api", "");
    if (backendUrl === "" && apiUrl !== "/api")
      backendUrl = "http://localhost:8000";
    return `${backendUrl}/UCB.jpg`;
  }
  if (url.startsWith("http://") || url.startsWith("https://")) {
    return url;
  }
  if (url.startsWith("/")) {
    // Jika path dimulai dengan /, cek apakah file ada di frontend public
    // Jika tidak, coba dari backend
    const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
    let backendUrl = apiUrl.replace("/api", "");
    if (backendUrl === "" && apiUrl !== "/api")
      backendUrl = "http://localhost:8000";
    // Untuk development, coba dari backend public folder
    return `${backendUrl}${url}`;
  }
  // Jika path dari storage (contoh: media/images/filename.jpg)
  const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
  let backendUrl = apiUrl.replace("/api", "");
  if (backendUrl === "" && apiUrl !== "/api")
    backendUrl = "http://localhost:8000";
  return `${backendUrl}/storage/${url}`;
};

const fetchHeroContent = async () => {
  try {
    const response = await api.get("/v1/settings");
    const data = response.data;

    if (data.hero_content) {
      try {
        const parsed =
          typeof data.hero_content === "string"
            ? JSON.parse(data.hero_content)
            : data.hero_content;

        heroContent.value = {
          ...defaultHeroContent,
          ...parsed,
          button1: { ...defaultHeroContent.button1, ...(parsed.button1 || {}) },
          button2: { ...defaultHeroContent.button2, ...(parsed.button2 || {}) },
        };
      } catch (e) {
        console.error("Error parsing hero_content:", e);
        heroContent.value = { ...defaultHeroContent };
      }
    } else {
      heroContent.value = { ...defaultHeroContent };
    }
  } catch (error) {
    console.error("Error fetching hero content:", error);
    heroContent.value = { ...defaultHeroContent };
  }
};

// Stats Content
const defaultStatsContent = {
  stats: [
    {
      value: "2001",
      title: "Tahun Berdiri",
      subtitle: "22 Maret 2001",
    },
    {
      value: "100+",
      title: "Anggota Aktif",
      subtitle: "Komunitas yang berkembang",
    },
    {
      value: "24",
      title: "Tahun Melayani",
      subtitle: "Dengan dedikasi tinggi",
    },
  ],
};

const statsContent = ref({ ...defaultStatsContent });

const fetchStatsContent = async () => {
  try {
    const response = await api.get("/v1/settings");
    const data = response.data;

    if (data.stats_content) {
      try {
        const parsed =
          typeof data.stats_content === "string"
            ? JSON.parse(data.stats_content)
            : data.stats_content;

        statsContent.value = {
          ...defaultStatsContent,
          ...parsed,
          stats:
            parsed.stats && parsed.stats.length > 0
              ? parsed.stats.slice(0, 4) // Maksimal 4 kartu
              : defaultStatsContent.stats,
        };
      } catch (e) {
        console.error("Error parsing stats_content:", e);
        statsContent.value = { ...defaultStatsContent };
      }
    } else {
      statsContent.value = { ...defaultStatsContent };
    }
  } catch (error) {
    console.error("Error fetching stats content:", error);
    statsContent.value = { ...defaultStatsContent };
  }
};

// Data member aktif
interface Member {
  id: number;
  name: string;
  role: string;
  position: string | null;
  avatar: string | null;
  badges: string[] | null;
  is_active: boolean;
}

const activeMembers = ref<Member[]>([]);

const getAvatarUrl = (avatarPath: string | null) => {
  if (!avatarPath)
    return "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80";
  if (avatarPath.startsWith("http")) return avatarPath;
  const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
  let backendUrl = apiUrl.replace("/api", "");
  if (backendUrl === "" && apiUrl !== "/api")
    backendUrl = "http://localhost:8000";
  return `${backendUrl}/storage/${avatarPath}`;
};

// Function untuk filter member berdasarkan role
const getMembersByRole = (role: string) => {
  return activeMembers.value.filter(
    (member) => member.role === role && member.is_active,
  );
};

// Event data
interface Event {
  id: number;
  title: string;
  description: string | null;
  event_type: string;
  start_date: string;
  end_date: string | null;
  location: string | null;
  venue: string | null;
}

const upcomingEvents = ref<Event[]>([]);
const loadingEvents = ref(true);

// Gallery data
interface GalleryImage {
  id: number;
  path: string;
  original_filename: string;
  alt_text?: string;
  caption?: string;
}

const galleryPreview = ref<GalleryImage[]>([]);
const loadingGallery = ref(true);

// Hero carousel images
const heroImages = ref<GalleryImage[]>([]);
const currentHeroImageIndex = ref(0);
let heroCarouselInterval: ReturnType<typeof setInterval> | null = null;

const getGalleryImageUrl = (image: GalleryImage) => {
  if (image.path) {
    const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
    let backendUrl = apiUrl.replace("/api", "");
    if (backendUrl === "" && apiUrl !== "/api")
      backendUrl = "http://localhost:8000";
    return `${backendUrl}/storage/${image.path}`;
  }
  return "";
};

const getCurrentHeroImage = () => {
  if (heroImages.value.length === 0) {
    // Fallback ke hero image dari CMS jika tidak ada foto galeri
    return getHeroImageUrl(heroContent.value.imageUrl);
  }
  const currentImage = heroImages.value[currentHeroImageIndex.value];
  if (currentImage && currentImage.path) {
    return getGalleryImageUrl(currentImage);
  }
  return getHeroImageUrl(heroContent.value.imageUrl);
};

const handleHeroImageError = (event: globalThis.Event) => {
  const img = event.target as HTMLImageElement | null;
  if (!img) return;

  // Cegah infinite loop - jika sudah mencoba fallback dan masih error, gunakan placeholder
  if (img.src.includes("/UCB.png") || img.src.includes("UCB.png")) {
    // Jika sudah mencoba UCB.png dan masih error, gunakan placeholder SVG
    img.src =
      'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="800" height="600"%3E%3Crect fill="%23e0e7ef" width="800" height="600"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="24" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';
    return;
  }
  // Fallback ke hero image dari CMS hanya jika belum mencoba
  const fallbackUrl = getHeroImageUrl(heroContent.value.imageUrl);
  if (fallbackUrl && fallbackUrl !== img.src) {
    img.src = fallbackUrl;
  } else {
    // Jika fallback sama dengan current src, gunakan placeholder
    img.src =
      'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="800" height="600"%3E%3Crect fill="%23e0e7ef" width="800" height="600"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="24" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';
  }
};

const startHeroCarousel = () => {
  if (heroImages.value.length < 2) return;

  // Clear existing interval
  if (heroCarouselInterval) {
    clearInterval(heroCarouselInterval);
  }

  // Auto-slide setiap 4 detik, loop terus menerus
  heroCarouselInterval = setInterval(() => {
    currentHeroImageIndex.value =
      (currentHeroImageIndex.value + 1) % heroImages.value.length;
  }, 5000);
};

const stopHeroCarousel = () => {
  if (heroCarouselInterval) {
    clearInterval(heroCarouselInterval);
    heroCarouselInterval = null;
  }
};

const goToSlide = (index: number) => {
  currentHeroImageIndex.value = index;
  // Restart carousel setelah 3 detik
  stopHeroCarousel();
  setTimeout(() => {
    startHeroCarousel();
  }, 3000);
};

const handleGalleryImageError = (event: { target: HTMLImageElement }) => {
  const img = event.target;
  img.src =
    'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23e0e7ef" width="200" height="200"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';
};

// Latest video data
interface LatestVideo {
  id: number;
  title: string;
  video_url: string;
  video_file_path: string | null;
  video_type: "url" | "gdrive" | "file";
}

const latestVideo = ref<LatestVideo | null>(null);
const loadingLatestVideo = ref(true);

// Promosi data
interface Promosi {
  id: number;
  title: string;
  description: string | null;
  image: string | null;
  link: string | null;
  link_text: string | null;
  type: string;
  is_active: boolean;
  order: number;
  start_date: string | null;
  end_date: string | null;
}

const promosi = ref<Promosi[]>([]);

const getPromosiImageUrl = (path: string) => {
  if (!path) return "";
  if (path.startsWith("http")) return path;
  const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
  let backendUrl = apiUrl.replace("/api", "");
  if (backendUrl === "" && apiUrl !== "/api")
    backendUrl = "http://localhost:8000";
  return `${backendUrl}/storage/${path}`;
};

const fetchPromosi = async () => {
  try {
    const response = await api.get("/v1/promosi?filter=active&public=true");
    let allPromosi: Promosi[] = [];
    if (response.data.data) {
      allPromosi = response.data.data;
    } else if (Array.isArray(response.data)) {
      allPromosi = response.data;
    }

    // Filter by date range if applicable
    const now = new Date();
    now.setHours(0, 0, 0, 0);

    promosi.value = allPromosi
      .filter((item: Promosi) => {
        if (!item.is_active) return false;
        if (item.start_date) {
          const startDate = new Date(item.start_date);
          startDate.setHours(0, 0, 0, 0);
          if (startDate > now) return false;
        }
        if (item.end_date) {
          const endDate = new Date(item.end_date);
          endDate.setHours(0, 0, 0, 0);
          if (endDate < now) return false;
        }
        return true;
      })
      .sort((a: Promosi, b: Promosi) => a.order - b.order)
      .slice(0, 6); // Limit to 6 items
  } catch (error) {
    console.error("Error fetching promosi:", error);
    promosi.value = [];
  }
};

// About content
const defaultAboutContent = {
  title: "Tentang Unceasing Cantica",
  paragraph1: "",
  paragraph2: "",
  paragraph3: "",
  cards: [
    {
      title: "Musik Koor",
      description: "Berbagai genre musik rohani dengan harmoni yang indah",
    },
    {
      title: "Komunitas",
      description: "Komunitas yang solid dan saling mendukung",
    },
    {
      title: "Pelayanan",
      description: "Melayani Tuhan dan memberkati banyak orang",
    },
    {
      title: "Konser",
      description: "Pertunjukan musik di berbagai acara dan gereja",
    },
  ],
};

const aboutContent = ref({ ...defaultAboutContent });

const formatParagraph = (text: string) => {
  if (!text) return "";
  // Convert **text** to <strong>text</strong>
  return text
    .replace(/\*\*(.*?)\*\*/g, '<strong class="text-slate-900">$1</strong>')
    .replace(/\*(.*?)\*/g, "<em>$1</em>");
};

const isYouTubeOrVimeo = (url: string) => {
  if (!url) return false;
  return (
    url.includes("youtube.com") ||
    url.includes("youtu.be") ||
    url.includes("vimeo.com")
  );
};

const isGoogleDrive = (url: string) => {
  if (!url) return false;
  return url.includes("drive.google.com") || url.includes("docs.google.com");
};

const getEmbedUrl = (url: string) => {
  if (!url) return "";

  // YouTube
  if (url.includes("youtube.com/watch?v=")) {
    const videoId = url.split("v=")[1]?.split("&")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }
  if (url.includes("youtu.be/")) {
    const videoId = url.split("youtu.be/")[1]?.split("?")[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }

  // Vimeo
  if (url.includes("vimeo.com/")) {
    const videoId = url.split("vimeo.com/")[1]?.split("?")[0];
    return `https://player.vimeo.com/video/${videoId}`;
  }

  return url;
};

const getGoogleDriveEmbedUrl = (url: string) => {
  if (!url) return "";

  // Extract file ID from various Google Drive URL formats
  let fileId = "";

  // Format: https://drive.google.com/file/d/FILE_ID/view
  const fileMatch = url.match(/\/file\/d\/([a-zA-Z0-9_-]+)/);
  if (fileMatch) {
    fileId = fileMatch[1];
  }

  // Format: https://drive.google.com/open?id=FILE_ID
  const openMatch = url.match(/[?&]id=([a-zA-Z0-9_-]+)/);
  if (openMatch && !fileId) {
    fileId = openMatch[1];
  }

  if (fileId) {
    return `https://drive.google.com/file/d/${fileId}/preview`;
  }

  return url;
};

const getVideoFileUrl = (video: LatestVideo) => {
  if (video.video_file_path) {
    const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
    let backendUrl = apiUrl.replace("/api", "");
    if (backendUrl === "" && apiUrl !== "/api")
      backendUrl = "http://localhost:8000";
    return `${backendUrl}/storage/${video.video_file_path}`;
  }
  return "";
};

const formatDay = (dateString: string) => {
  const date = new Date(dateString);
  return date.getDate().toString().padStart(2, "0");
};

const formatMonth = (dateString: string) => {
  const date = new Date(dateString);
  const months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "Mei",
    "Jun",
    "Jul",
    "Agu",
    "Sep",
    "Okt",
    "Nov",
    "Des",
  ];
  return months[date.getMonth()];
};

const formatTime = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleTimeString("id-ID", {
    hour: "2-digit",
    minute: "2-digit",
  });
};

const fetchAboutContent = async () => {
  try {
    const response = await api.get("/v1/settings");
    const data = response.data;

    if (data.about_content) {
      try {
        const parsed =
          typeof data.about_content === "string"
            ? JSON.parse(data.about_content)
            : data.about_content;
        aboutContent.value = {
          ...defaultAboutContent,
          ...parsed,
          // Pastikan cards selalu ada 4 item
          cards:
            parsed.cards && parsed.cards.length === 4
              ? parsed.cards
              : [
                  ...(parsed.cards || []),
                  ...defaultAboutContent.cards.slice(parsed.cards?.length || 0),
                ].slice(0, 4),
        };
      } catch (e) {
        console.error("Error parsing about_content:", e);
      }
    }
  } catch (error) {
    console.error("Error fetching about content:", error);
  }
};

const fetchMembers = async () => {
  try {
    const response = await api.get("/v1/members");

    // Handle response yang mungkin string (seperti masalah login sebelumnya)
    let responseData = response.data;
    if (typeof responseData === "string") {
      if (responseData.startsWith("x")) {
        responseData = responseData.substring(1);
      }
      try {
        responseData = JSON.parse(responseData);
      } catch (parseError) {
        console.error("Error parsing members response:", parseError);
        activeMembers.value = [];
        return;
      }
    }

    // Pastikan allMembers adalah array
    let allMembers = responseData?.data || responseData || [];

    // Jika bukan array, set ke array kosong
    if (!Array.isArray(allMembers)) {
      console.warn("Members response is not an array:", allMembers);
      allMembers = [];
    }

    // Filter hanya member yang aktif
    activeMembers.value = allMembers.filter((m: Member) => m.is_active);
  } catch (error) {
    console.error("Error fetching members:", error);
    activeMembers.value = [];
  }
};

onMounted(async () => {
  // Fetch hero content
  await fetchHeroContent();

  // Populate hero carousel from CMS heroImages setting
  const cmsHeroImages = (heroContent.value as any).heroImages;
  if (Array.isArray(cmsHeroImages) && cmsHeroImages.length > 0) {
    // Convert path strings to GalleryImage-like objects
    heroImages.value = cmsHeroImages.map((path: string, idx: number) => ({
      id: idx,
      path,
      original_filename: path.split("/").pop() || "",
    }));
    currentHeroImageIndex.value = 0;
    if (heroImages.value.length > 1) {
      startHeroCarousel();
    }
  }

  // Fetch stats content
  await fetchStatsContent();

  // Fetch promosi
  await fetchPromosi();

  // Fetch about content
  await fetchAboutContent();

  // Fetch members
  await fetchMembers();

  // Fetch events
  try {
    loadingEvents.value = true;
    const response = await api.get("/v1/events");

    // Handle response yang mungkin string (seperti masalah login sebelumnya)
    let responseData = response.data;
    if (typeof responseData === "string") {
      if (responseData.startsWith("x")) {
        responseData = responseData.substring(1);
      }
      try {
        responseData = JSON.parse(responseData);
      } catch (parseError) {
        console.error("Error parsing events response:", parseError);
        upcomingEvents.value = [];
        return;
      }
    }

    // Pastikan allEvents adalah array
    let allEvents: Event[] = [];
    if (responseData?.data && Array.isArray(responseData.data)) {
      allEvents = responseData.data;
    } else if (Array.isArray(responseData)) {
      allEvents = responseData;
    }

    console.log("Fetched events:", allEvents.length);
    console.log("All events:", allEvents);

    // Filter events yang akan datang (start_date >= hari ini) atau belum selesai (end_date >= hari ini)
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const filteredEvents = allEvents.filter((event: Event) => {
      if (!event.start_date) return false;

      const eventStartDate = new Date(event.start_date);
      eventStartDate.setHours(0, 0, 0, 0);

      // Jika ada end_date, cek apakah event belum selesai
      if (event.end_date) {
        const eventEndDate = new Date(event.end_date);
        eventEndDate.setHours(23, 59, 59, 999); // Sampai akhir hari
        return eventEndDate >= today;
      }

      // Jika tidak ada end_date, cek start_date >= hari ini
      return eventStartDate >= today;
    });

    console.log("Filtered upcoming events:", filteredEvents.length);
    console.log("Filtered events:", filteredEvents);

    // Sort berdasarkan start_date dan ambil 3 terdekat
    upcomingEvents.value = filteredEvents
      .sort((a: Event, b: Event) => {
        return (
          new Date(a.start_date).getTime() - new Date(b.start_date).getTime()
        );
      })
      .slice(0, 3);

    console.log("Final upcoming events:", upcomingEvents.value.length);
    console.log("Final events:", upcomingEvents.value);
  } catch (error) {
    console.error("Error fetching events:", error);
    upcomingEvents.value = [];
  } finally {
    loadingEvents.value = false;
  }

  // Fetch gallery images (hanya untuk preview, bukan hero carousel)
  try {
    loadingGallery.value = true;
    const galleryResponse = await api.get("/v1/gallery");

    let responseData = galleryResponse.data;
    if (typeof responseData === "string") {
      if (responseData.startsWith("x")) {
        responseData = responseData.substring(1);
      }
      try {
        responseData = JSON.parse(responseData);
      } catch (parseError) {
        console.error("Error parsing gallery response:", parseError);
        galleryPreview.value = [];
        return;
      }
    }

    const allMedia = Array.isArray(responseData?.all_media)
      ? responseData.all_media
      : [];

    // Hanya untuk preview galeri di beranda — heroImages TIDAK diubah di sini
    galleryPreview.value = allMedia.slice(0, 4);
  } catch (error) {
    console.error("Error fetching gallery:", error);
    galleryPreview.value = [];
  } finally {
    loadingGallery.value = false;
  }

  // Fetch latest video
  try {
    loadingLatestVideo.value = true;
    const videoResponse = await api.get("/v1/videos");
    const allVideos = videoResponse.data.data || videoResponse.data || [];
    if (allVideos.length > 0) {
      latestVideo.value = allVideos[0]; // Video terbaru
    }
  } catch (error) {
    console.error("Error fetching latest video:", error);
    latestVideo.value = null;
  } finally {
    loadingLatestVideo.value = false;
  }
});

// Cleanup on unmount
onUnmounted(() => {
  stopHeroCarousel();
});
</script>

<style scoped>
/* Slide horizontal transition - simultaneous (no gap) */
.slide-hero-enter-active,
.slide-hero-leave-active {
  transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  will-change: transform;
}

.slide-hero-enter-from {
  transform: translateX(100%);
}

.slide-hero-enter-to,
.slide-hero-leave-from {
  transform: translateX(0);
}

.slide-hero-leave-to {
  transform: translateX(-100%);
}
</style>

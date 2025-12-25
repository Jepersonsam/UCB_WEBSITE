<template>
  <div class="mx-auto max-w-4xl space-y-8">
    <!-- Loading State -->
    <div v-if="loading" class="space-y-6">
      <div class="h-8 w-3/4 animate-pulse rounded bg-sky-100"></div>
      <div class="h-4 w-1/2 animate-pulse rounded bg-sky-50"></div>
      <div class="aspect-[16/9] animate-pulse rounded-2xl bg-sky-100"></div>
      <div class="space-y-3">
        <div class="h-4 w-full animate-pulse rounded bg-sky-50"></div>
        <div class="h-4 w-full animate-pulse rounded bg-sky-50"></div>
        <div class="h-4 w-3/4 animate-pulse rounded bg-sky-50"></div>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="rounded-3xl border border-red-100 bg-red-50 p-12 text-center"
    >
      <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100">
        <svg class="h-10 w-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
      <h3 class="mt-6 text-2xl font-semibold text-slate-800">Artikel Tidak Ditemukan</h3>
      <p class="mt-2 text-slate-600">Artikel yang Anda cari tidak ditemukan atau telah dihapus.</p>
      <RouterLink
        to="/news"
        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-sky-700"
      >
        Kembali ke Berita
      </RouterLink>
    </div>

    <!-- Article Content -->
    <article v-else-if="article" class="space-y-8" data-aos="fade-up">
      <!-- Header -->
      <header class="space-y-4">
        <!-- Category & Date -->
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <RouterLink
              v-if="article.category"
              :to="`/news?category=${article.category.slug}`"
              class="inline-block rounded-full border border-sky-200 bg-sky-50 px-4 py-1.5 text-sm font-semibold text-sky-700 transition-colors hover:bg-sky-100"
            >
              {{ article.category.name }}
            </RouterLink>
            <span v-else class="text-sm text-slate-400">Artikel</span>
            <span class="text-sm text-slate-500">
              {{ formatDate(article.published_at || article.created_at) }}
            </span>
          </div>
        </div>

        <!-- Title -->
        <h1 class="text-3xl font-bold leading-tight text-slate-900 sm:text-4xl lg:text-5xl">
          {{ article.title }}
        </h1>

        <!-- Excerpt -->
        <p v-if="article.excerpt" class="text-lg leading-relaxed text-slate-600">
          {{ article.excerpt }}
        </p>

        <!-- Tags -->
        <div v-if="article.tags && article.tags.length > 0" class="flex flex-wrap gap-2">
          <span
            v-for="tag in article.tags"
            :key="tag.id"
            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-medium text-slate-600"
          >
            #{{ tag.name }}
          </span>
        </div>
      </header>

      <!-- Featured Image -->
      <div v-if="article.featured_image" class="overflow-hidden rounded-2xl">
        <img
          :src="getFeaturedImageUrl(article.featured_image)"
          :alt="article.title"
          class="h-full w-full object-cover"
          @error="handleImageError"
        />
      </div>

      <!-- Article Content -->
      <div
        class="prose prose-slate max-w-none prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed prose-a:text-sky-600 prose-a:no-underline hover:prose-a:text-sky-700 prose-strong:text-slate-900 prose-ul:text-slate-700 prose-li:text-slate-700"
        v-html="formatContent(article.content)"
      ></div>

      <!-- Back Button -->
      <div class="pt-8">
        <RouterLink
          to="/news"
          class="inline-flex items-center gap-2 rounded-xl border border-sky-200 bg-white px-6 py-3 text-sm font-semibold text-sky-600 transition-all hover:bg-sky-50 hover:text-sky-700"
        >
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali ke Berita
        </RouterLink>
      </div>
    </article>

    <!-- Comments Section -->
    <section v-if="article" class="space-y-8" data-aos="fade-up" data-aos-delay="200">
      <div class="border-t border-sky-100 pt-8">
        <h2 class="mb-6 text-2xl font-bold text-slate-800">Komentar ({{ comments.length }})</h2>

        <!-- Comment Form -->
        <div class="mb-8 rounded-2xl border border-sky-100 bg-white p-6 shadow-sm">
          <h3 class="mb-4 text-lg font-semibold text-slate-800">Tulis Komentar</h3>
          <form @submit.prevent="submitComment" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Nama *</label>
                <input
                  v-model="commentForm.name"
                  type="text"
                  required
                  class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="Masukkan nama Anda"
                />
              </div>
              <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Email *</label>
                <input
                  v-model="commentForm.email"
                  type="email"
                  required
                  class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                  placeholder="nama@email.com"
                />
              </div>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700">Komentar *</label>
              <textarea
                v-model="commentForm.comment"
                required
                rows="4"
                class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                placeholder="Tulis komentar Anda di sini..."
              ></textarea>
            </div>
            <button
              type="submit"
              :disabled="submittingComment"
              class="rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all hover:scale-[1.02] hover:shadow-xl disabled:opacity-50"
            >
              <span v-if="submittingComment">Mengirim...</span>
              <span v-else>Kirim Komentar</span>
            </button>
            <div v-if="commentSuccess" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
              Komentar berhasil dikirim!
            </div>
            <div v-if="commentError" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
              {{ commentError }}
            </div>
          </form>
        </div>

        <!-- Comments List -->
        <div v-if="loadingComments" class="space-y-4">
          <div v-for="i in 3" :key="i" class="animate-pulse rounded-2xl border border-sky-100 bg-slate-50 p-6">
            <div class="h-4 w-1/4 rounded bg-sky-100"></div>
            <div class="mt-3 h-4 w-3/4 rounded bg-sky-50"></div>
            <div class="mt-2 h-4 w-1/2 rounded bg-sky-50"></div>
          </div>
        </div>

        <div v-else-if="comments.length === 0" class="rounded-2xl border border-sky-100 bg-slate-50 p-12 text-center">
          <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
          <p class="mt-4 text-slate-600">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
        </div>

        <div v-else class="space-y-6">
          <div
            v-for="comment in comments"
            :key="comment.id"
            class="rounded-2xl border border-sky-100 bg-white p-6 shadow-sm"
            data-aos="fade-up"
          >
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 font-semibold">
                {{ comment.name.charAt(0).toUpperCase() }}
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-2">
                  <h4 class="font-semibold text-slate-800">{{ comment.name }}</h4>
                  <span class="text-xs text-slate-500">{{ formatDate(comment.created_at) }}</span>
                </div>
                <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ comment.comment }}</p>
                
                <!-- Reply Button -->
                <button
                  @click="toggleReplyForm(comment.id)"
                  class="mt-4 text-sm font-medium text-sky-600 hover:text-sky-700 transition-colors"
                >
                  {{ activeReplyForm === comment.id ? 'Batal' : 'Balas' }}
                </button>

                <!-- Reply Form -->
                <div v-if="activeReplyForm === comment.id" class="mt-4 rounded-xl border border-sky-200 bg-sky-50/50 p-4">
                  <form @submit.prevent="submitReply(comment.id)" class="space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                      <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nama *</label>
                        <input
                          v-model="replyForm.name"
                          type="text"
                          required
                          class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                          placeholder="Masukkan nama Anda"
                        />
                      </div>
                      <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Email *</label>
                        <input
                          v-model="replyForm.email"
                          type="email"
                          required
                          class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                          placeholder="nama@email.com"
                        />
                      </div>
                    </div>
                    <div>
                      <label class="mb-2 block text-sm font-medium text-slate-700">Balasan *</label>
                      <textarea
                        v-model="replyForm.comment"
                        required
                        rows="3"
                        class="w-full rounded-lg border border-sky-200 bg-white px-4 py-2 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Tulis balasan Anda..."
                      ></textarea>
                    </div>
                    <div class="flex gap-3">
                      <button
                        type="submit"
                        :disabled="submittingReply"
                        class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition-all hover:bg-sky-700 disabled:opacity-50"
                      >
                        <span v-if="submittingReply">Mengirim...</span>
                        <span v-else>Kirim Balasan</span>
                      </button>
                      <button
                        type="button"
                        @click="activeReplyForm = null"
                        class="rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition-all hover:bg-sky-50"
                      >
                        Batal
                      </button>
                    </div>
                  </form>
                </div>

                <!-- Replies -->
                <div v-if="comment.replies && comment.replies.length > 0" class="mt-6 ml-4 space-y-4 border-l-2 border-sky-200 pl-6">
                  <div
                    v-for="reply in comment.replies"
                    :key="reply.id"
                    class="rounded-xl border border-sky-100 bg-slate-50 p-4"
                    data-aos="fade-up"
                    data-aos-delay="100"
                  >
                    <div class="flex items-start gap-3">
                      <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 text-sm font-semibold">
                        {{ reply.name.charAt(0).toUpperCase() }}
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                          <h5 class="text-sm font-semibold text-slate-800">{{ reply.name }}</h5>
                          <span class="text-xs text-slate-500">{{ formatDate(reply.created_at) }}</span>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ reply.comment }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import api from '@/lib/api/client'

interface Category {
  id: number
  name: string
  slug: string
}

interface Tag {
  id: number
  name: string
}

interface Article {
  id: number
  title: string
  slug: string
  excerpt: string | null
  content: string
  featured_image: string | null
  category_id: number | null
  category: Category | null
  tags: Tag[]
  status: string
  published_at: string | null
  created_at: string
  updated_at: string
}

const route = useRoute()
const article = ref<Article | null>(null)
const loading = ref(true)
const error = ref(false)

// Comments
interface Comment {
  id: number
  article_id: number
  parent_id: number | null
  name: string
  email: string
  comment: string
  is_approved: boolean
  created_at: string
  updated_at: string
  replies?: Comment[]
}

const comments = ref<Comment[]>([])
const loadingComments = ref(false)
const commentForm = ref({
  name: '',
  email: '',
  comment: '',
})
const replyForm = ref({
  name: '',
  email: '',
  comment: '',
})
const submittingComment = ref(false)
const submittingReply = ref(false)
const commentSuccess = ref(false)
const commentError = ref('')
const activeReplyForm = ref<number | null>(null)

const getFeaturedImageUrl = (imagePath: string) => {
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
  img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="800" height="450"%3E%3Crect fill="%23e0e7ef" width="800" height="450"/%3E%3Ctext fill="%2394a3b8" font-family="sans-serif" font-size="16" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E'
}

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`
}

const formatContent = (content: string) => {
  if (!content) return ''
  // Convert HTML content safely
  // Note: In production, you should sanitize HTML content
  return content
}

const fetchArticle = async () => {
  loading.value = true
  error.value = false
  
  try {
    const slug = route.params.slug as string
    
    // Fetch article by slug (backend now supports slug lookup)
    const response = await api.get(`/v1/articles/${slug}`)
    article.value = response.data
    
    // Double check status for published articles
    if (article.value && article.value.status !== 'published') {
      error.value = true
      article.value = null
    } else if (article.value) {
      // Fetch comments after article is loaded
      await fetchComments()
    }
  } catch (err: any) {
    console.error('Error fetching article:', err)
    error.value = true
    article.value = null
  } finally {
    loading.value = false
  }
}

const fetchComments = async () => {
  if (!article.value) return
  
  loadingComments.value = true
  try {
    const response = await api.get(`/v1/comments?article_id=${article.value.id}`)
    comments.value = response.data || []
  } catch (error) {
    console.error('Error fetching comments:', error)
    comments.value = []
  } finally {
    loadingComments.value = false
  }
}

const submitComment = async () => {
  if (!article.value) return
  
  submittingComment.value = true
  commentSuccess.value = false
  commentError.value = ''
  
  try {
    await api.post('/v1/comments', {
      article_id: article.value.id,
      name: commentForm.value.name,
      email: commentForm.value.email,
      comment: commentForm.value.comment,
    })
    
    commentSuccess.value = true
    commentForm.value = {
      name: '',
      email: '',
      comment: '',
    }
    
    // Refresh comments to show the new comment immediately
    await fetchComments()
    
    setTimeout(() => {
      commentSuccess.value = false
    }, 3000)
  } catch (err: any) {
    commentError.value = err.response?.data?.message || 'Gagal mengirim komentar. Silakan coba lagi.'
  } finally {
    submittingComment.value = false
  }
}

const toggleReplyForm = (commentId: number) => {
  if (activeReplyForm.value === commentId) {
    activeReplyForm.value = null
    replyForm.value = { name: '', email: '', comment: '' }
  } else {
    activeReplyForm.value = commentId
  }
}

const submitReply = async (parentId: number) => {
  if (!article.value) return
  
  submittingReply.value = true
  
  try {
    await api.post('/v1/comments', {
      article_id: article.value.id,
      parent_id: parentId,
      name: replyForm.value.name,
      email: replyForm.value.email,
      comment: replyForm.value.comment,
    })
    
    activeReplyForm.value = null
    replyForm.value = { name: '', email: '', comment: '' }
    
    // Refresh comments to show the new reply immediately
    await fetchComments()
    
    // Show success message
    commentSuccess.value = true
    setTimeout(() => {
      commentSuccess.value = false
    }, 3000)
  } catch (err: any) {
    commentError.value = err.response?.data?.message || 'Gagal mengirim balasan. Silakan coba lagi.'
    setTimeout(() => {
      commentError.value = ''
    }, 3000)
  } finally {
    submittingReply.value = false
  }
}

onMounted(() => {
  fetchArticle()
})
</script>

<style scoped>
/* Prose styling for article content */
.prose {
  @apply text-base leading-relaxed;
}

.prose h2 {
  @apply mt-8 mb-4 text-2xl font-bold text-slate-900;
}

.prose h3 {
  @apply mt-6 mb-3 text-xl font-bold text-slate-900;
}

.prose p {
  @apply mb-4 text-slate-700 leading-relaxed;
}

.prose ul {
  @apply mb-4 ml-6 list-disc space-y-2;
}

.prose ol {
  @apply mb-4 ml-6 list-decimal space-y-2;
}

.prose li {
  @apply text-slate-700;
}

.prose strong {
  @apply font-semibold text-slate-900;
}

.prose em {
  @apply italic;
}

.prose a {
  @apply text-sky-600 underline hover:text-sky-700;
}

.prose img {
  @apply my-6 rounded-xl;
}
</style>


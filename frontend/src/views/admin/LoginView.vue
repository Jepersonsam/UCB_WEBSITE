<template>
  <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-sky-50 via-slate-50 to-sky-50 px-4">
    <div class="w-full max-w-md">
      <div class="rounded-3xl border border-sky-100 bg-slate-50 p-8 shadow-xl shadow-sky-100/30">
        <div class="mb-8 text-center">
          <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 shadow-sm">
            <span class="text-2xl font-bold">UCB</span>
          </div>
          <h1 class="text-2xl font-bold text-slate-800">CMS Admin Panel</h1>
          <p class="mt-2 text-sm text-slate-600">Masuk untuk mengelola website</p>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-5">
          <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="admin@ucb.com"
            />
          </div>

          <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-slate-800 shadow-sm transition-all focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
              placeholder="••••••••"
            />
          </div>

          <div v-if="error" class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            {{ error }}
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-sky-500/30 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Memproses...</span>
            <span v-else>Masuk</span>
          </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
          <p>Unceasing Cantica Bandung CMS</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/lib/api/client'

const router = useRouter()

const form = ref({
  email: '',
  password: ''
})

const loading = ref(false)
const error = ref('')

const handleLogin = async () => {
  loading.value = true
  error.value = ''

  try {
    const response = await api.post('/v1/auth/login', form.value)
    
    if (response.data.status === 'success') {
      // Simpan token
      localStorage.setItem('token', response.data.data.token)
      localStorage.setItem('user', JSON.stringify(response.data.data.user))
      
      // Redirect ke dashboard
      router.push('/admin/dashboard')
    }
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Email atau password salah'
  } finally {
    loading.value = false
  }
}
</script>


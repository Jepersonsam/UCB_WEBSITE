import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import { fileURLToPath, URL } from 'node:url'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/main.ts',
      ],
      refresh: true,
    }),
    vue(),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
    },
  },
  publicDir: 'public',
  server: {
    port: 5173,
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
})



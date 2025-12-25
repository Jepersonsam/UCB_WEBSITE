import './bootstrap'
import { createApp } from 'vue'
import '../css/app.css'
import './style.css'
import App from './App.vue'
import router from './router'
import AOS from 'aos'
import 'aos/dist/aos.css'

const app = createApp(App)

app.use(router)

app.mount('#app')

// Initialize AOS after mount (untuk public routes)
AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: false, // Allow animations to repeat when scrolling up
  offset: 100,
  delay: 0,
  mirror: true, // Animate elements when scrolling past them in both directions
})



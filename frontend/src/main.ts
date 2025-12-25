import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import AOS from 'aos'
import 'aos/dist/aos.css'

const app = createApp(App)

app.use(router)

app.mount('#app')

// Initialize AOS after mount
AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: false, // Allow animations to repeat when scrolling up
  offset: 100,
  delay: 0,
  mirror: true, // Animate elements when scrolling past them in both directions
})

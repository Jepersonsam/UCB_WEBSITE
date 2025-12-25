import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  // Public routes
  { path: '/', name: 'home', component: () => import('../views/HomeView.vue') },
  { path: '/gallery', name: 'gallery', component: () => import('../views/GalleryView.vue') },
  { path: '/videos', name: 'videos', component: () => import('../views/VideosView.vue') },
  { path: '/schedule', name: 'schedule', component: () => import('../views/ScheduleView.vue') },
  { path: '/news', name: 'news', component: () => import('../views/NewsView.vue') },
  { path: '/news/:slug', name: 'article-detail', component: () => import('../views/ArticleDetailView.vue') },
  { path: '/members', name: 'members', component: () => import('../views/MembersView.vue') },
  { path: '/contact', name: 'contact', component: () => import('../views/ContactView.vue') },
  { path: '/join', name: 'join', component: () => import('../views/JoinView.vue') },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { 
        top: 0,
        behavior: 'smooth'
      }
    }
  },
})

export default router


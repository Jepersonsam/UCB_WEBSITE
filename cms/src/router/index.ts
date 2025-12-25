import { createRouter, createWebHistory } from 'vue-router'
import AdminLayout from '../layouts/AdminLayout.vue'

const routes = [
  { path: '/login', name: 'login', component: () => import('../views/LoginView.vue') },
  {
    path: '/',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/dashboard' },
      { path: 'dashboard', name: 'dashboard', component: () => import('../views/DashboardView.vue') },
      { path: 'articles', name: 'articles', component: () => import('../views/ArticlesView.vue') },
      { path: 'articles/create', name: 'article-create', component: () => import('../views/ArticleFormView.vue') },
      { path: 'articles/:id/edit', name: 'article-edit', component: () => import('../views/ArticleFormView.vue') },
      { path: 'gallery', name: 'gallery', component: () => import('../views/GalleryView.vue') },
      { path: 'videos', name: 'videos', component: () => import('../views/VideosView.vue') },
      { path: 'events', name: 'events', component: () => import('../views/EventsView.vue') },
      { path: 'about', name: 'about', component: () => import('../views/AboutView.vue') },
      { path: 'join', name: 'join', component: () => import('../views/JoinView.vue') },
      { path: 'join-applications', name: 'join-applications', component: () => import('../views/JoinApplicationsView.vue') },
      { path: 'hero', name: 'hero', component: () => import('../views/HeroView.vue') },
      { path: 'stats', name: 'stats', component: () => import('../views/StatsView.vue') },
      { path: 'regular-schedule', name: 'regular-schedule', component: () => import('../views/RegularScheduleView.vue') },
      { path: 'audition-schedules', name: 'audition-schedules', component: () => import('../views/AuditionSchedulesView.vue') },
      { path: 'promosi', name: 'promosi', component: () => import('../views/PromosiView.vue') },
      { path: 'members', name: 'members', component: () => import('../views/MembersView.vue') },
      { path: 'media', name: 'media', component: () => import('../views/MediaView.vue') },
      { path: 'contact-messages', name: 'contact-messages', component: () => import('../views/ContactMessagesView.vue') },
      { path: 'comments', name: 'comments', component: () => import('../views/CommentsView.vue') },
      { path: 'settings', name: 'settings', component: () => import('../views/SettingsView.vue') },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

// Auth guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)

  if (requiresAuth && !token) {
    next('/login')
  } else if (to.path === '/login' && token) {
    next('/dashboard')
  } else {
    next()
  }
})

export default router


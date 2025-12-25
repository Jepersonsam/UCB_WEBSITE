import { createRouter, createWebHistory } from 'vue-router'
import AdminLayout from '../layouts/AdminLayout.vue'

const routes = [
  // Public routes (Website)
  { 
    path: '/', 
    name: 'home', 
    component: () => import('../views/public/HomeView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/gallery', 
    name: 'gallery', 
    component: () => import('../views/public/GalleryView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/videos', 
    name: 'videos', 
    component: () => import('../views/public/VideosView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/schedule', 
    name: 'schedule', 
    component: () => import('../views/public/ScheduleView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/news', 
    name: 'news', 
    component: () => import('../views/public/NewsView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/news/:slug', 
    name: 'article-detail', 
    component: () => import('../views/public/ArticleDetailView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/members', 
    name: 'members', 
    component: () => import('../views/public/MembersView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/contact', 
    name: 'contact', 
    component: () => import('../views/public/ContactView.vue'),
    meta: { layout: 'public' }
  },
  { 
    path: '/join', 
    name: 'join', 
    component: () => import('../views/public/JoinView.vue'),
    meta: { layout: 'public' }
  },

  // Admin routes (CMS) - dengan prefix /admin
  { 
    path: '/admin/login', 
    name: 'admin-login', 
    component: () => import('../views/admin/LoginView.vue'),
    meta: { layout: 'admin', requiresAuth: false }
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { layout: 'admin', requiresAuth: true },
    children: [
      { path: '', redirect: '/admin/dashboard' },
      { path: 'dashboard', name: 'admin-dashboard', component: () => import('../views/admin/DashboardView.vue') },
      { path: 'articles', name: 'admin-articles', component: () => import('../views/admin/ArticlesView.vue') },
      { path: 'articles/create', name: 'admin-article-create', component: () => import('../views/admin/ArticleFormView.vue') },
      { path: 'articles/:id/edit', name: 'admin-article-edit', component: () => import('../views/admin/ArticleFormView.vue') },
      { path: 'gallery', name: 'admin-gallery', component: () => import('../views/admin/GalleryView.vue') },
      { path: 'videos', name: 'admin-videos', component: () => import('../views/admin/VideosView.vue') },
      { path: 'events', name: 'admin-events', component: () => import('../views/admin/EventsView.vue') },
      { path: 'about', name: 'admin-about', component: () => import('../views/admin/AboutView.vue') },
      { path: 'join', name: 'admin-join', component: () => import('../views/admin/JoinView.vue') },
      { path: 'join-applications', name: 'admin-join-applications', component: () => import('../views/admin/JoinApplicationsView.vue') },
      { path: 'hero', name: 'admin-hero', component: () => import('../views/admin/HeroView.vue') },
      { path: 'stats', name: 'admin-stats', component: () => import('../views/admin/StatsView.vue') },
      { path: 'regular-schedule', name: 'admin-regular-schedule', component: () => import('../views/admin/RegularScheduleView.vue') },
      { path: 'audition-schedules', name: 'admin-audition-schedules', component: () => import('../views/admin/AuditionSchedulesView.vue') },
      { path: 'promosi', name: 'admin-promosi', component: () => import('../views/admin/PromosiView.vue') },
      { path: 'members', name: 'admin-members', component: () => import('../views/admin/MembersView.vue') },
      { path: 'media', name: 'admin-media', component: () => import('../views/admin/MediaView.vue') },
      { path: 'contact-messages', name: 'admin-contact-messages', component: () => import('../views/admin/ContactMessagesView.vue') },
      { path: 'comments', name: 'admin-comments', component: () => import('../views/admin/CommentsView.vue') },
      { path: 'settings', name: 'admin-settings', component: () => import('../views/admin/SettingsView.vue') },
    ]
  },
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

// Auth guard untuk admin routes
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)

  if (requiresAuth && !token) {
    next('/admin/login')
  } else if (to.path === '/admin/login' && token) {
    next('/admin/dashboard')
  } else {
    next()
  }
})

export default router



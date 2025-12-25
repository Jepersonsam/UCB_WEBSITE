import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor untuk menambahkan token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor untuk handle error
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expired atau tidak valid
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      window.location.href = '/admin/login'
    }
    return Promise.reject(error)
  }
)

export default api


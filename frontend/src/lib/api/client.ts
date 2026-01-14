import axios from 'axios'

// Pastikan baseURL selalu berakhir dengan /api
const getBaseURL = () => {
  let envURL = import.meta.env.VITE_API_URL
  
  if (!envURL) {
    // Default ke http://localhost:8000/api untuk development
    envURL = 'http://localhost:8000/api'
  } else {
    // Jika sudah ada /api di akhir, gunakan langsung
    if (!envURL.endsWith('/api')) {
      envURL = envURL.endsWith('/') ? `${envURL}api` : `${envURL}/api`
    }
  }
  
  return envURL
}

const api = axios.create({
  baseURL: getBaseURL(),
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  // Pastikan tidak ada redirect ke HTTPS
  maxRedirects: 0,
  // Timeout default untuk request biasa (60 detik untuk mengakomodasi preflight)
  timeout: 60000,
  // Tambahkan withCredentials jika diperlukan
  withCredentials: false,
})

// Debug: Log baseURL untuk troubleshooting
if (import.meta.env.DEV) {
  console.log('API Base URL:', api.defaults.baseURL)
  console.log('Environment VITE_API_URL:', import.meta.env.VITE_API_URL)
}

// Request interceptor untuk menambahkan token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    
    // Jika data adalah FormData, biarkan axios mengatur Content-Type dengan boundary
    if (config.data instanceof FormData) {
      delete config.headers['Content-Type']
    }
    
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor untuk handle response dan error
api.interceptors.response.use(
  (response) => {
    // Handle case dimana response.data adalah string (tidak ter-parse oleh axios)
    if (typeof response.data === 'string') {
      // Hapus karakter 'x' di awal jika ada (bug dari backend/middleware)
      let dataString = response.data
      if (dataString.startsWith('x')) {
        dataString = dataString.substring(1)
      }
      
      // Coba parse JSON
      try {
        response.data = JSON.parse(dataString)
      } catch (parseError) {
        console.error('Error parsing JSON response:', parseError)
        // Biarkan response.data tetap string jika parse gagal
      }
    }
    
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      // Token expired atau tidak valid
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      // Redirect ke login admin jika di route admin
      if (window.location.pathname.startsWith('/admin')) {
        window.location.href = '/admin/login'
      }
    }
    return Promise.reject(error)
  }
)

export default api



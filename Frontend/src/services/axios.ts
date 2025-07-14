import axios from 'axios'
import { useAuthStore } from '@/stores/auth'
import router from '@/router' 

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
})

// Request interceptor to add token
api.interceptors.request.use((config) => {
  const authStore = useAuthStore()
  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`
  }
  return config
})

// Response interceptor to handle token expiration
api.interceptors.response.use(
  (response) => response,
  (error) => {
    const authStore = useAuthStore()

    if (error.response && error.response.status === 401) {
      // Token is likely expired or invalid
      authStore.token = null // Clear the token
      router.push('/login') // Redirect to login page
    }

    return Promise.reject(error)
  }
)

export default api

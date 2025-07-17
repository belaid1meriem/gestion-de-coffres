import axios from 'axios'
import { useAuthStore } from '@/stores/auth'
import router from '@/router' 
import { nextTick } from 'vue'

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
  async (error) => {
    const authStore = useAuthStore()

    if (error.response && error.response.status === 401) {
      authStore.token = null // Clear the token
      await nextTick()
      router.push('/login') // Redirect to login page
    }

    return Promise.reject(error)
  }
)

export default api

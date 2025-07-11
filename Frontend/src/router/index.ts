import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import SignupView from '../views/SignupView.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignupView ,
    },
    {
      path: '/history/:id',
      name: 'history',
      component: () => import('../views/HistoryView.vue')
    },
    {
      path: '/search',
      name: 'search',
      component: () => import('../views/SearchView.vue')
    },
    {
      path:'/user/add',
      name: 'user-add',
      component: () => import('../views/AddUserView.vue')
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',  
      component: () => import('../views/NotFoundView.vue')
    },
  ],
})

export default router

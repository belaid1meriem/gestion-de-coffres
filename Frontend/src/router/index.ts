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
      path: '/historique',
      name: 'historique',
      component: () => import('../views/HistoriqueView.vue')
    },
    {
      path: '/recherche',
      name: 'recherche',
      component: () => import('../views/SearchView.vue')
    },
    {
      path:'/user/add',
      name: 'user-add',
      component: () => import('../views/AddUserView.vue')
    },
    // {
    //   path: '/coffre/add',
    //   name: 'coffre-add',
    //   component: () => import('../views/AddCoffreView.vue')
    // },
    // {
    //   path: '/coffre/edit/:id',
    //   name: 'coffre-edit',
    //   component: () => import('../views/EditCoffreView.vue'),
    // },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',  
      component: () => import('../views/NotFoundView.vue')
    },
  ],
})

export default router

import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/home/index.vue'
import CashierView from '../views/home/home_cashier/index.vue'
import ProfileView from '../views/profile/index.vue'
import VeiculosView from '../views/veiculos/index.vue'
import ConfigView from '../views/config/index.vue'
import RegisterView from '../views/register/index.vue'
import LoginView from '../views/login/index.vue'
import ProductsGeneral from '../views/manager/products/table/index.vue'
import ProductsStock from '../views/manager/products/stock/index.vue'
import StockDetails from '../views/manager/products/stock/details/index.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      props:true
    },
    {
      path: '/cashier',
      name: 'cashier',
      component: CashierView,
      props:true
    },
    {
      path:'/products',
      name:'products-general',
      component:ProductsGeneral,
      props:true
    },
    {
      path:'/products/stock',
      name:'products-stock',
      component:ProductsStock,
      props:true
    },
    {
      path:'/products/stock/:id',
      name:'stocks-details',
      component:StockDetails,
      props:true
    },
    {
      path: '/home/profile/me',
      name: 'my-profile',
      component: ProfileView
    },
    {
      path: '/home/veiculos',
      name: 'veiculos',
      component: VeiculosView
    },
    {
      path: '/config',
      name: 'config',
      component: ConfigView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    }
  ]
})

export default router

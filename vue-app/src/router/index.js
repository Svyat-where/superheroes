import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Heroes from '../views/Heroes.vue'
import CreateHero from '../views/CreateHero.vue'
import Hero from '../views/Hero.vue'
import EditHero from '../views/EditHero.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
      path: '/heroes',
      name: 'Heroes',
      component: Heroes
  },
  {
      path: '/create-hero',
      name: 'create-hero',
      component: CreateHero
  },
  {
      path: '/hero/:nick_name',
      name: 'Hero',
      component: Hero
  },
  {
      path:'/edit-hero/:nick_name',
      name: 'EditHero',
      component: EditHero
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

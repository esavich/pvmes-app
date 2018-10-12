import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Post from './views/Post.vue'

Vue.use(Router);

export default new Router({
    // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
        path: '/page/:page',
        name: 'homePaged',
        component: Home
    },
      {
          path: '/tag/:tag',
          name: 'tagged',
          component: Home,
          children: [
              {
                  path: 'page/:page',
                  name: 'taggedPaged',
                  component: Home
              }
          ]
      },
      {
          path: '/post/:id',
          name: 'post',
          component: Post
      },
      // {
      //   path: '/about',
      //   name: 'about',
      //   // route level code-splitting
      //   // this generates a separate chunk (about.[hash].js) for this route
      //   // which is lazy-loaded when the route is visited.
      //   component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
      // }
  ]
})

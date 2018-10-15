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
        }
    ]
})

//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    { path: '/', name: 'login', component: () => import('@/views/auth/Login.vue')},
    { path: '/register', name: 'register', component: () => import('@/views/auth/Register.vue')},
    { path: '/dashboard', name: 'dashboard', component: () => import('@/views/dashboard/Index.vue'),
        children: [
            { path: '/post', name: 'post.index', component: () => import('@/views/post/Index.vue')},
            { path: '/create', name: 'post.create',component: () => import('@/views/post/Create.vue')},
            { path: '/edit/:id', name: 'post.edit', component: () => import('@/views/post/Edit.vue')},
            { path: '/product', name: 'product.index', component: () => import('@/views/product/Index.vue')},
            { path: '/sub-category', name: 'sub-category.index', component: () => import('@/views/sub-category/Index.vue'),},
            { path: '/sub-category', name: 'sub-category.edit', component: () => import('@/views/sub-category/Edit.vue')},
            { path: '/sub-category', name: 'sub-category.create', component: () => import('@/views/sub-category/Create.vue')},
            { path: '/category', name: 'category.index', component: () => import('@/views/category/Index.vue')},
            { path: '/category', name: 'category.edit', component: () => import('@/views/category/Edit.vue')},
            { path: '/category', name: 'category.create', component: () => import('@/views/category/Create.vue')},
        ]
    }
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes  // config routes
})

export default router
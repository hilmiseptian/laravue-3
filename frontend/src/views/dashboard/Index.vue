<template>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <router-link :to="{ name: 'post.index' }" class="navbar-brand">LARAVEL PASSPORT + VUE</router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link :to="{ name: 'register' }" class="nav-link" href="">REGISTER</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'login' }" class="nav-link" href="#">LOGIN</router-link>
        </li>
      </ul>
    </div>
  </nav>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        Main Menu
                        <hr>
                        <ul class="list-group">
                            <router-link :to="{ name: 'dashboard' }"
                                class="list-group-item text-dark text-decoration-none">Dashboard</router-link>
                            <li @click="selectMenu('post.index')" class="list-group-item text-dark text-decoration-none" hidden style="cursor:pointer">POST</li>
                            <li @click="selectMenu('product.index')" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">Product</li>
                            <li @click="selectMenu('category.index')" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">Category</li>
                            <li @click="selectMenu('sub-category.index')" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">Sub Category</li>
                            <li @click="selectMenu('store.index')" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">Store</li>
                            <li @click.prevent="logout" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">LOGOUT</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {

    setup() {

        //state token
        const token = localStorage.getItem('token')

        //inisialisasi vue router on Composition API
        const router = useRouter()

        //state user
        const user = ref('')

        //mounted properti
        onMounted(() => {

            //check Token exist
            if (!token) {
                return router.push({
                    name: 'login'
                })
            }

            //get data user
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/user')
                .then(response => {

                    //console.log(response.data.name)
                    user.value = response.data

                })
                .catch(error => {
                    console.log(error.response.data)
                })

        })

        //method logout
        function logout() {

            //logout
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/logout')
                .then(response => {

                    if (response.data.success) {

                        //remove localStorage
                        localStorage.removeItem('token')

                        //redirect ke halaman login
                        return router.push({
                            name: 'login'
                        })

                    }

                })
                .catch(error => {
                    console.log(error.response.data)
                })

        }

        // Method: selectMenu
        function selectMenu(menu) {
            router.push({ name: menu })
        }
        
        return {
            token,      // <-- state token
            user,       // <-- state user
            logout,      // <-- method logout
            selectMenu
        }

    }

}
</script>
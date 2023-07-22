<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Product</h4>
                        <hr>
                        <router-link :to="{ name: 'product.create' }" class="btn btn-md btn-success">Create Product</router-link>

                        <table class="table table-striped table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Sub Category</th>
                                    <th scope="col">OPTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="index">
                                    <td>{{ post.productName }}</td>
                                    <td>{{ post.categoryName }}</td>
                                    <td>{{ post.subCategoryName }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'product.edit', params: { id: post.id } }" class="btn btn-sm btn-primary mr-1">Edit</router-link>
                                        <button @click.prevent="postDelete(post.id)" class="btn btn-sm btn-danger ml-1">Delete</button>                                    
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { onMounted, ref } from 'vue'

export default {

    setup() {
        //reactive state
        let posts = ref([])

        //mounted
        onMounted(() => {

            //get API from Laravel Backend
            axios.get('http://localhost:8000/api/product')
                .then(response => {
                    //assign state posts with response data
                    posts.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })

        })

        // Method to get the full image URL
        function getImageUrl(imagePath) {
            if (imagePath) {
                return `http://localhost:8000/storage/${imagePath}`; // Adjust the base URL to match your Laravel backend setup
            } else {
                return require('@/assets/NoImage.png'); // Provide a default image URL or a placeholder image
            }
        }

        //method delete
        function postDelete(id) {
            //delete data post by ID
            axios.delete(`http://localhost:8000/api/product/${id}`)
                .then(() => {
                    //splice posts 
                    posts.value.splice(posts.value.indexOf(id), 1);
                }).catch(error => {
                    console.log(error.response.data)
                })
        }

        //return
        return {
            posts,
            postDelete,
            getImageUrl
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
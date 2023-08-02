<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Store</h4>
                        <hr>
                        <router-link :to="{ name: 'store.create' }" class="btn btn-md btn-success">Create</router-link>

                        <table class="table table-striped table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Store Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ post.store_name }}</td>
                                    <td>{{ post.address }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'store.edit', params: { id: post.id } }" class="btn btn-sm btn-primary mr-1">Edit</router-link>
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
        const options = ref([])

        //mounted
        onMounted(() => {
            //get API from Laravel Backend
            axios.get('http://localhost:8000/api/store')
                .then(response => {
                    const Address = response.data.data.map(city => ({
                        ...city, // bisa di gunakan jika ingin menambahkan properti baru
                        address: `${city.street} - ${city.city_name} - ${city.province} ${city.postal_code}`,
                        store_name: city.store_name,
                    }));
                    posts.value = Address
                }).catch(error => {
                    console.log(error.response.data)
                })
        })

        //method delete
        function postDelete(id) {

            //delete data post by ID
            axios.delete(`http://localhost:8000/api/store/${id}`)
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
            postDelete
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
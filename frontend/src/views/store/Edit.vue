<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Update Store</h4>
                        <hr>
                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label for="categoryName" class="font-weight-bold">Store Name</label>
                                <input type="text" class="form-control" v-model="state.store_name" placeholder="Insert Here">
                                <!-- validation -->
                                <div v-if="validation.store_name" class="mt-2 alert alert-danger">
                                    {{ validation.store_name[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryID" class="font-weight-bold">Province</label>
                                <select class="form-select" v-model="state.province_id" @click="fetchProvince">
                                    <option value="" disabled selected>Select province</option>
                                    <option :value="state.province_id" disabled>{{ state.province }}</option>
                                    <option v-for="option in provinces" :key="option.id" :value="option.province_id">{{ option.province }}</option>
                                </select>
                                <div v-if="validation.categoryID" class="mt-2 alert alert-danger">
                                    {{ validation.categoryID[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryID" class="font-weight-bold">City</label>
                                <select class="form-select" v-model="state.city_id" @click="fetchCity">
                                    <option value="" disabled selected>Select city</option>
                                    <option :value="state.city_id" disabled>{{ state.city_name }}</option>
                                    <option v-for="option in cities" :key="option.id" :value="option.city_id">{{ option.city_name }}</option>
                                </select>
                                <div v-if="validation.categoryID" class="mt-2 alert alert-danger">
                                    {{ validation.categoryID[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryName" class="font-weight-bold">Postal Code</label>
                                <input type="text" class="form-control" v-model="state.postal_code" disabled>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Notes</label>
                                <textarea class="form-control" rows="4" v-model="state.street" placeholder="Insert Notes Name"></textarea>
                                <!-- validation -->
                                <div v-if="validation.notes" class="mt-2 alert alert-danger">
                                    {{ validation.notes[0] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="mx-2 btn btn-primary">Save</button>
                                <button class="btn btn-danger" @click="$router.go(-1)">Back</button>
                            </div> 
                        </form>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

export default {

    setup() {

        //state posts
        const state = reactive({
            store_name: '',
            province_id: '',
            province: '',
            city_id: '',
            city_name: ''

        })

        //state validation
        const validation = ref([])
        const provinces = ref([]);
        const cities = ref([]);

        //vue router
        const router = useRouter()

        //vue router
        const route = useRoute()

        //mounted
        onMounted(() => {
            //get API from Laravel Backend
            axios.get(`http://localhost:8000/api/store/${route.params.id}`)
                .then(response => {
                    //assign state posts with response data
                    state.store_name = response.data.data.store_name
                    state.province_id = response.data.data.province_id
                    state.province = response.data.data.province
                    state.city_id = response.data.data.city_id
                    state.city_name = response.data.data.city_name
                    //provinces.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })

        })

        function fetchProvince() {
            axios.get('http://localhost:8000/api/province').then(response => {
                console.log(state.province);
                console.log(provinces.value);
                provinces.value = response.data.data
                cities.value = response.data.data
                //fetchCity(state.province_id)
            })
                .catch(error => {
                    console.log(error.response.data)
                })
        }

        function fetchCity() {

            axios.get(`http://localhost:8000/api/city/${state.province_id}`).then(response => {
                const cityData = response.data.data;
                // Use map to create a new array with 'provinceType' property
                const cityDataWithProvinceType = cityData.map(city => ({
                    //...city, // bisa di gunakan jika ingin menambahkan properti baru
                    city_name: `${city.city_name} - ${city.type}`,
                    city_id: city.city_id,
                    postal_code: city.postal_code,
                }));

                // Now you have a new array with 'provinceType' property in each city object

                cities.value = cityDataWithProvinceType;
                //console.log(citys.value);

            })
                .catch(error => {
                    console.log(error.response.data)
                })

        }

        //method update
        function update() {

            let categoryName = post.categoryName
            let notes = post.notes

            axios.put(`http://localhost:8000/api/category/${route.params.id}`, {
                categoryName: categoryName,
                notes: notes
            }).then(() => {

                //redirect ke post index
                router.push({
                    name: 'category.index'
                })

            }).catch(error => {
                //assign state validation with error 
                validation.value = error.response.data
            })

        }

        //return
        return {
            state,
            provinces,
            cities, 
            fetchProvince,
            fetchCity,
            validation,
            router,
            update
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
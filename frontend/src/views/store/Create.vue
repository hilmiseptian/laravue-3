<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Add Store</h4>
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
                                <select class="form-select" v-model="state.province_id" @click="fetchCity">
                                    <option value="" disabled selected>Select province</option>
                                    <option v-for="option in options" :key="option.id" :value="option.province_id">{{ option.province }}</option>
                                </select>
                                <div v-if="validation.categoryID" class="mt-2 alert alert-danger">
                                    {{ validation.categoryID[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryID" class="font-weight-bold">City</label>
                                <select class="form-select" v-model="state.city_id" @click="getPostalCode">
                                    <option value="" disabled selected>Select city</option>
                                    <option v-for="option in citys" :key="option.id" :value="option.city_id">{{ option.city_name }}</option>
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
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {

    setup() {

        //state posts
        const state = reactive({
            store_name: '',
            province_id: '',
            city_id: '',
            postal_code: '',
            categoryName: '',
            street: ''
        })
        const options = ref([])
        const citys = ref([])


        //state validation
        const validation = ref([])

        //vue router
        const router = useRouter()

        onMounted(() => {

            axios.get('http://localhost:8000/api/province').then(response => {
                options.value = response.data.data
            })
                .catch(error => {
                    console.log(error.response.data)
                })

        })

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

                citys.value = cityDataWithProvinceType;
                //console.log(citys.value);

                })
                .catch(error => {
                    console.log(error.response.data)
                })

        }
        
        function getPostalCode() {
            const data = citys.value
            const filteredData = data.filter(item => item.city_id === state.city_id);
            const postalCodes = filteredData.map(item => item.postal_code);
            state.postal_code = postalCodes[0]
        }

        //method store
        function store() {

            let store_name = state.store_name
            let province_id = state.province_id
            let city_id = state.city_id
            let postal_code = state.postal_code
            let street = state.street
            console.log(state);
            axios.post('http://localhost:8000/api/store', {
                store_name: store_name,
                province_id: province_id,
                city_id: city_id,
                postal_code: postal_code,
                street: street
            }).then(() => {

                //redirect ke post index
                router.push({
                    name: 'store.index'
                })

            }).catch(error => {
                //assign state validation with error 
                validation.value = error.response.data
            })

        }

        //return
        return {
            options,
            citys,
            state,
            validation,
            router,
            store,
            fetchCity,
            getPostalCode
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Edit Sub Category</h4>
                        <hr>
                        <form @submit.prevent="update">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Sub Category Name</label>
                                <input type="text" class="form-control" v-model="post.subCategoryName" placeholder="Insert Here">
                                <!-- validation -->
                                <div v-if="validation.subCategoryName" class="mt-2 alert alert-danger">
                                    {{ validation.subCategoryName[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Notes</label>
                                <textarea class="form-control" rows="4" v-model="post.notes" placeholder="Insert Here"></textarea>
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
        const post = reactive({
            subCategoryName: '',
            notes: ''
        })

        //state validation
        const validation = ref([])

        //vue router
        const router = useRouter()

        //vue router
        const route = useRoute()

        //mounted
        onMounted(() => {

            //get API from Laravel Backend
            axios.get(`http://localhost:8000/api/sub-category/${route.params.id}`)
                .then(response => {

                    //assign state posts with response data
                    post.subCategoryName = response.data.data.subCategoryName
                    post.notes = response.data.data.notes

                }).catch(error => {
                    console.log(error.response.data)
                })

        })

        //method update
        function update() {

            let subCategoryName = post.subCategoryName
            let notes = post.notes
            
            axios.put(`http://localhost:8000/api/sub-category/${route.params.id}`, {
                subCategoryName: subCategoryName,
                notes: notes
            }).then(() => {

                //redirect ke post index
                router.push({
                    name: 'sub-category.index'
                })

            }).catch(error => {
                //assign state validation with error 
                validation.value = error.response.data
            })

        }

        //return
        return {
            post,
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
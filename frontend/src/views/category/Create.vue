<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Add Category</h4>
                        <hr>
                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label for="categoryName" class="font-weight-bold">Category Name</label>
                                <input type="text" class="form-control" v-model="post.categoryName" placeholder="Insert Category Name">
                                <!-- validation -->
                                <div v-if="validation.categoryName" class="mt-2 alert alert-danger">
                                    {{ validation.categoryName[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Notes</label>
                                <textarea class="form-control" rows="4" v-model="post.notes" placeholder="Insert Notes Name"></textarea>
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
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {

    setup() {

        //state posts
        const post = reactive({
            categoryName: '',
            notes: ''
        })

        //state validation
        const validation = ref([])

        //vue router
        const router = useRouter()

        //method store
        function store() {

            let categoryName = post.categoryName
            let notes = post.notes

            axios.post('http://localhost:8000/api/category', {
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
            post,
            validation,
            router,
            store
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
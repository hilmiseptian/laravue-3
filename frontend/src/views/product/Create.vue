<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                    <h4>Add Product</h4>
                    <hr>
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item" v-bind:class="{ 'active': activeTab === 'productInfo' }">
                            <a class="nav-link" :class="{ 'active': activeTab === 'productInfo' }" @click="activeTab = 'productInfo'">Product Info</a>
                        </li>
                        <li class="nav-item" v-bind:class="{ 'active': activeTab === 'imageUpload' }">
                            <a class="nav-link" :class="{ 'active': activeTab === 'imageUpload' }" @click="activeTab = 'imageUpload'">Image Upload</a>
                        </li>
                    </ul>
                        <div class="tab-content mt-2">
                            <div class="tab-pane" :class="{ 'show active': activeTab === 'productInfo' }">
                                <form @submit.prevent="store">
                                    <div class="form-group">
                                        <label for="productName" class="font-weight-bold">Product Name</label>
                                        <input type="text" class="form-control" v-model="post.productName" placeholder="Insert Here">
                                        <!-- validation -->
                                        <div v-if="validation.productName" class="mt-2 alert alert-danger">
                                            {{ validation.productName[0] }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryID" class="font-weight-bold">Category</label>
                                        <select class="form-select" v-model="post.categoryID" @click="fetchCategories">
                                            <option value="" disabled selected>Select a category</option>
                                            <option v-for="option in options" :key="option.value" :value="option.id">{{ option.categoryName }}</option>
                                        </select>
                                        <div v-if="validation.categoryID" class="mt-2 alert alert-danger">
                                            {{ validation.categoryID[0] }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subCategoryID" class="font-weight-bold">Sub Category</label>
                                        <select class="form-select" v-model="post.subCategoryID" @click="fetchSubCategories">
                                            <option value="" disabled selected>Select a sub category</option>
                                            <option v-for="option in options" :key="option.value" :value="option.id">{{ option.subCategoryName }}</option>
                                        </select>
                                        <div v-if="validation.subCategoryID" class="mt-2 alert alert-danger">
                                            {{ validation.subCategoryID[0] }}
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
                                </form> 
                            </div>
                            <div class="tab-pane" :class="{ 'show active': activeTab === 'imageUpload' }">
                                <div class="tab-pane" :class="{ 'show active': activeTab === 'imageUpload' }">
                                    <div class="card border-0 rounded shadow">
                                        <div class="card-body">
                                            <form @submit.prevent="update">
                                                <div class="container text-center">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div v-if="imagePreview" class="mt-2">
                                                                <img :src="imagePreview" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-md-4">
                                                            <div class="input-group input-group-md">
                                                                <input type="file" class="form-control custom-file-input" ref="imageInput" @change="handleImageChange" accept="image/*">
                                                                <button class="btn btn-danger" type="button" id="inputGroupFileAddon04" @click="removeImage">X</button>
                                                            </div>
                                                        </div>
                                                        <!-- validation -->
                                                        <div class="col-md-8">
                                                            <div v-if="validation.image" class="mt-2 alert alert-danger">
                                                                {{ validation.image[0] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" @click="store" class="mx-2 btn btn-primary">Save</button>
                            <button class="btn btn-danger" @click="$router.go(-1)">Back</button>
                        </div> 
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
            productName: '',
            notes: '',
            categoryID: '',
            subCategoryID: ''
        })

        //state validation
        const validation = ref([])
        const options = ref([])
        const activeTab = ref('productInfo'); // Tab state
        // Image upload state
        const image = ref(null);
        const imageInput = ref(null); // for placeholder name
        const imagePreview = ref(require('@/assets/NoImage.png'));
        //vue router
        const router = useRouter()
        
        async function fetchCategories() {
            if (options.value == '') {
                try {
                    const response = await axios.get('http://localhost:8000/api/category')
                    options.value = response.data.data
                } catch (error) {
                    console.error('Error fetching options:', error)
                    return []
                }
            }
        }

        async function fetchSubCategories() {
            if (options.value == '') {
                try {
                    const response = await axios.get('http://localhost:8000/api/sub-category')
                    options.value = response.data.data
                } catch (error) {
                    console.error('Error fetching options:', error)
                    return []
                }
            }
        }
        
        function handleImageChange(event) {
            const file = event?.target?.files[0];
            if (file) {
                image.value = file;
                // Read the image file and set the preview
                const reader = new FileReader();
                reader.onload = () => {
                    imagePreview.value = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                // If no image selected, show the default image
                removeImage()
            }
        }

        function removeImage() {
            // Clear the selected image and reset the file input value
            image.value = null;
            imageInput.value.value = '';
            imagePreview.value = require('@/assets/NoImage.png');
        }

        //method store
        function store() {

            let productName = post.productName
            let categoryID = post.categoryID
            let notes = post.notes

            // FormData to handle the image upload
            const formData = new FormData();
            formData.append('productName', productName);
            formData.append('categoryID', categoryID);
            formData.append('notes', notes);

            // Check if there's an image to upload
            if (image.value) {
                formData.append('image', image.value, image.value.name);
            }

            axios.post('http://localhost:8000/api/product', formData).then(() => {
                router.push({
                    name: 'product.index'
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
            options,
            activeTab,
            store,
            fetchCategories,
            fetchSubCategories,
            image,
            imagePreview,
            imageInput,
            handleImageChange,
            removeImage,
        }

    }

}
</script>

<style>
body {
    background: lightgray;
}
</style>
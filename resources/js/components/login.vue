<template>

    <div class="card container shadow-sm bg-light mt-5" style="width: 25em;">
    <div class="card-body">
        <h5 class="card-title mb-4">Login</h5>
        <div class="alert alert-danger p-2" v-if="this.data != null">{{ this.data }}</div>
        <form @submit.prevent="submit">
                    
            <div class="mb-2">
                <div class="col-md-12">
                    <input type="email" class="form-control" name="email" placeholder="Email" v-model="fields.email">
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.email">{{ errors.email[0] }}</div>
                </div>
            </div>
        
            <div class="mb-3">
                <div class="col-md-12">
                    <input type="password" class="form-control" name="password" placeholder="Password" v-model="fields.password" >
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.password">{{ errors.password[0] }}</div>
                </div>
                
            </div>
            <div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Login</button>
                    <a href="/register" class="btn btn-primary">Register</a>
                </div>
            </div>
        </form>
    </div>
    </div>

</template>

<script>
    import axios from 'axios';

    export default{
        data() {
            return  {
                fields: {
                    email: null,
                    password: null,   
                },
                errors: {},
                data: null,
            }
        },
        methods: {
            submit() {
                axios.post('/validate/user', this.fields).then(response =>{
                    this.fields = {};
                    this.data = response.data.data;
                    if(response.data.auth) {
                        window.location.href = '/home';
                    }
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log("ERROR:: ",error.response.data);
                });
            },
        }
    }


</script>
<template>

<div class="card container shadow-sm bg-light mt-5" style="width: 25rem;">
    <div class="card-body">
        <h5 class="card-title mb-4">Register</h5>
        <div class="alert alert-success p-2" v-show="success">Registered Successful</div>
    <form @submit.prevent="submit">
        <div>
            <div class="col-md-12 mb-2">
                <input type="text" class="form-control" name="name" placeholder="Full Name" v-model="fields.name">
                <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.name">{{ errors.name[0] }}</div>
            </div>
        </div>
    
        <div>
            <div class="col-md-12 mb-2">
                <input type="email" class="form-control" name="email" placeholder="Email" v-model="fields.email">
                <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.email">{{ errors.email[0] }}</div>
            </div>
        </div>
    
        <div>
            <div class="col-md-12 mb-2">
                <input type="password" class="form-control" name="password" placeholder="Password" v-model="fields.password">
                <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.password">{{ errors.password[0] }}</div>
            </div>
        </div>
    
        <div>
            <div class="col-md-12 mb-3">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" v-model="fields.password_confirmation">
            </div>
        </div>
    
        <div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Register</button>
                <a href="/login" class="btn btn-primary">Sign in</a>
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
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,    
                },
                success: false,
                errors: {},
            }
        },
        methods: {
            submit() {
                axios.post('/register/user', this.fields).then(response =>{
                    this.fields = {};
                    this.success = true;
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log("ERROR:: ",error.response.data);
                });
            }
        }
    }


</script>
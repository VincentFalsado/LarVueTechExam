<template>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 15%;">
        <h1 style="font-size: 58px;">Welcome to LarVue, <br> <span style="font-size: 45px;margin-left: 15%;">{{ this.users.usr_name }}</span></h1>
    </div>
    <div class="container d-flex flex-column" style="margin-left: 35%;">
        <a href="/logout" style="margin-top: 20px;">Logout</a>
    </div>
</template>

<script>
    import axios from 'axios';

    export default{
        data() {
            return  {
                users: null,
            }
        },
        mounted() {
            axios.get('/authUser').then(response => {
                this.users = response.data.users;
                console.log(this.users);
            })
        },
    }
</script> 
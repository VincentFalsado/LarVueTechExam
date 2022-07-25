<template>
    
    <!-- User Management section -->
<div class="card container shadow-sm bg-light" style="width: auto;">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="card-title p-2">User Management</h5>
        </div>
    <!-- Add section -->
        <div class="container p-2 mb-2">
            <form @submit.prevent="add">
            <div class="form-row d-flex gap-2">
                <div class="col-md-3">
                    <input type="text"  class="form-control" name="name" placeholder="full name" v-model="fields.name">
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.name">{{ errors.name[0] }}</div>
                </div>
                <div class="col-md-2">
                    <input type="text"  class="form-control" name="email" placeholder="email" v-model="fields.email">
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.email">{{ errors.email[0] }}</div>
                </div>
                <div class="d-flex flex-column">
                <select class="custom-select col border border-2" style="border-radius: 3px;" name="role" v-model="fields.role">
                    <option v-for="role in roles" :value="role.rol_id">{{ role.rol_name }}</option>
                </select>
                <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.role">{{ errors.role[0] }}</div>
                </div>
                <div class="col-md-2">
                    <input type="text"  class="form-control" name="password" placeholder="password" v-model="fields.password">
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.password">{{ errors.password[0] }}</div>
                </div>
                <div class="col-md-2">
                    <input type="text"  class="form-control" name="confirm_password" placeholder="confirm password" v-model="fields.confirm_password">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
                
            </form>
        </div>

        <!-- Users data table -->
        <div class="container p-2">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users">
                    <td>
                            <input type="text" class="borderless bg-transparent" name="id" placeholder="full name" :value="user.usr_name" disabled>
                    </td>
                    <td>
                            <input type="text" class="borderless bg-transparent" name="id" placeholder="email" :value="user.email" disabled>
                    </td>
                    <td>
                            <input  name="role" class="borderless bg-transparent" :value="user.role.rol_name" disabled>
                    </td>
                    <td>
                        <input name="role" class="borderless bg-transparent" v-if="user.deleted_at == null" disabled value="Active">
                        <input name="role" class="borderless bg-transparent" v-if="user.deleted_at != null" disabled value="Deleted">
                    </td>
                    <td class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm" data-toggle="#editForm" @click="edit(user)">Edit</button>
                        <button type="submit" class="btn btn-danger btn-sm" v-if="user.deleted_at == null" @click="remove(user,index)">Delete</button> 
                        <button type="submit" class="btn btn-primary btn-sm" v-if="user.deleted_at != null" @click="restore(user,index)">Restore</button>


                        <div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                            </div>
                            <div class="modal-body">
                                <form class="d-flex flex-column">
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="FullName">Full Name</label>
                                            <input type="text"  class="form-control" name="editName" placeholder="full name" v-model="editForm.editName">
                                            <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editName">{{ errors.editName[0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="Email">Email</label>
                                            <input type="text"  class="form-control" name="editEmail" placeholder="email" v-model="editForm.editEmail">
                                            <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editEmail">{{ errors.editEmail[0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="Role">Role</label>
                                            <select class="custom-select border border-2 col-md-12 p-1" style="border-radius: 3px;" name="editRole" v-model="editForm.editRole">
                                                <option v-for="role in roles" :value="role.rol_id">{{ role.rol_name }}</option>
                                            </select>
                                        </div>
                                        <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editRole">{{ errors.editRole[0] }}</div>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="Password">Password</label>
                                            <input type="text"  class="form-control" name="editPassword" placeholder="password" v-model="editForm.editPassword">
                                            <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editPassword">{{ errors.editPassword[0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="ConfirmPassword">Confirm Password</label>
                                            <input type="text"  class="form-control" name="editConfirm_password" placeholder="confirm password" v-model="editForm.editConfirm_password">
                                            <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editConfirm_password">{{ errors.editConfirm_password[0] }}</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelChanges()">Cancel</button>
                                <button type="submit" class="btn btn-primary" @click="saveChanges()">Save Changes</button>
                            </div>
                            </div>
                        </div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
        </div>
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
                    role: null,
                    password: null,
                    confirm_password: null,    
                },
                roles: {},
                users: {},
                editForm: {
                    editName: null,
                    editEmail: null,
                    emailRole: null,
                    editPassword: null,
                    editConfirm_password: null, 
                },
                userID: null,
                errors: {},
            }
        },
        mounted() {
            axios.get('/roles').then(response => {
                this.roles = response.data.roles;
            }),
            axios.get('/users').then(response => {
                this.users = response.data.users;
            })
        },
        methods: {
            add() {
                axios.post('/user/add', this.fields).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log("ERROR:: ",error.response.data);
                });
            }, 
            restore(item) {
                axios.post(`/user/restore/${item.id}`).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    console.log("ERROR:: ",error.response.data);
                });
            }, 
            remove(item) {
                axios.delete(`/user/delete/${item.id}`).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    console.log("ERROR:: ",error.response.data);
                });
            },
            edit(item) {
                $('#editForm').modal('show');
                this.userID = item.id;
                this.editForm.editName = item.usr_name;
                this.editForm.editEmail = item.email;
                this.editForm.editRole = item.usr_rol_id;
            },
            cancelChanges() {
                $('#editForm').modal('hide');
            },
            saveChanges() {
                axios.put(`/user/update/${this.userID}`, this.editForm).then(response =>{
                    window.location.href = '/home';
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
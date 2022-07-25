<template>

<div class="card container shadow-sm bg-light" style="width: auto;">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="card-title p-2">Role Management</h5>
        </div>
        <!-- Add section -->
        <div class="container p-2 mb-2">
            <form @submit.prevent="add">
            <div class="form-row d-flex gap-2">
                <div class="col-md-3">
                    <input type="text"  class="form-control" name="role_name" placeholder="role name" v-model="fields.name">
                    <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.name">{{ errors.name[0] }}</div>
                </div>
                <div class="col-md-8">
                    <input type="text"  class="form-control" name="role_description" placeholder="description" v-model="fields.description">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
                
            </form>
        </div>

        <!-- Roles data table -->
        <div class="container p-2">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Role Name</th>
                <th scope="col">Role Description</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(role, index) in roles">
                    <td>
                        <input type="text" class="borderless bg-transparent" name="role_name" :value="role.rol_name" disabled>
                    </td>
                    <td>
                        <textarea type="text" class="borderless bg-transparent col-md-12" name="role_description" :value="role.rol_description" disabled></textarea>
                    </td>
                    <td>
                        <input name="role" class="borderless bg-transparent" v-if="role.deleted_at == null" disabled value="Active">
                        <input name="role" class="borderless bg-transparent" v-if="role.deleted_at != null" disabled value="Deleted">
                    </td>
                    <td class="d-flex gap-1 borderless">
                        <button type="submit" class="btn btn-primary btn-sm" data-toggle="#editRoleInfo" @click="edit(role)">Edit</button>
                        <button type="submit" class="btn btn-danger btn-sm" v-if="role.deleted_at == null" @click="remove(role,index)">Delete</button> 
                        <button type="submit" class="btn btn-primary btn-sm" v-if="role.deleted_at != null" @click="restore(role,index)">Restore</button>


                        <div class="modal fade" id="editRoleInfo" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Role</h5>
                            </div>
                            <div class="modal-body">
                                <form class="d-flex flex-column">
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="RoleName">Name</label>
                                            <input type="text"  class="form-control" name="editName" v-model="editForm.editName">
                                            <div class="alert alert-danger p-1 mt-1" v-if="errors && errors.editName">{{ errors.editName[0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <div class="form-group">
                                            <label for="RoleDescription">Description</label>
                                            <textarea type="text"  class="form-control" name="description" v-model="editForm.description"></textarea>
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
                    description: null,    
                },
                roles: {},
                editForm: {
                    editName: null,
                    description: null,   
                },
                roleID: null,
                errors: {},
            }
        },
        mounted() {
            axios.get('/roles').then(response => {
                this.roles = response.data.roles;
            })
        },
        methods: {
            add() {
                axios.post('/role/add', this.fields).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log("ERROR:: ",error.response.data);
                });
            }, 
            restore(item) {
                axios.post(`/role/restore/${item.rol_id}`).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    console.log("ERROR:: ",error.response.data);
                });
            }, 
            remove(item) {
                axios.delete(`/role/delete/${item.rol_id}`).then(response =>{
                    window.location.href = '/home';
                }).catch(error => {
                    console.log("ERROR:: ",error.response.data);
                });
            },
            edit(item) {
                $('#editRoleInfo').modal('show');
                this.roleID = item.rol_id;
                this.editForm.editName = item.rol_name;
                this.editForm.description = item.rol_description;
            },
            cancelChanges() {
                $('#editRoleInfo').modal('hide');
            },
            saveChanges() {
                axios.put(`/role/update/${this.roleID}`, this.editForm).then(response =>{
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
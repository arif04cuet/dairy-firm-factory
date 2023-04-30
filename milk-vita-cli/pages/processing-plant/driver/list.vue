<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2"><i class="fa fa-users"></i>&nbsp;সকল চালক</h4>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/driver/add" class="btn btn-primary" v-if="checkAction('/processing-plant/driver/add')">
                        <i class="fa fa-plus"></i>
                        <span>নতুন ব্যবহারকারী যুক্ত করুন </span>
                    </NuxtLink>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="filter()">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" v-model="search.username" placeholder="Username">
                    </div>
                    <!-- // -->
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" v-model="search.mobile" placeholder="Mobile">
                    </div>
                    <!-- // -->
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" v-model="search.email" placeholder="E-mail">
                    </div>
                    <!-- // -->
                    <div class="col-md-3 form-group">
                        <button class="btn btn-success">
                            <i class="fa fa-search"></i>
                            <span>Search</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered custom" v-if="!loader">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">SL</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Mobile</th>
                            <th>E-mail</th>
                            <th width="70" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in users" :key="index">
                            <td class="text-center">{{++index}}</td>
                            <td>{{row.name_bn}}</td>
                            <td>{{row.username}}</td>
                            <td>{{row.mobile}}</td>
                            <td>{{row.email}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <NuxtLink :to="'/processing-plant/driver/view?id='+row.id"  v-if="checkAction('/processing-plant/driver/view')">
                                        <button class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </NuxtLink>

                                    <NuxtLink :to="'/processing-plant/driver/edit?id='+row.id" v-if="checkAction('/processing-plant/driver/edit')">
                                        <button class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </NuxtLink>

                                    <NuxtLink to="#" v-if="checkAction('/processing-plant/driver/delete')">
                                        
                                    <button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </NuxtLink>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="users.length <= 0">
                            <th colspan="8" class="text-center">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end mt-2">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchUser"/>
                </div>
            </div>
            <Loader :loader="loader"/>
        </div>
        <div class="card-footer">&nbsp;</div>
    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
        },
        data(){
            return {
                users       :[],
                per_page    : 10,
                page_no     : 1,
                total_row   : 0,
                loader      : true,
                search      : {},
            }
        },
        mounted(){
            this.fetchUser();
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchUser();
            },
            fetchUser(){
                this.loader = true;
                this.users = [];
                this.$axios.post('user/all', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search,
                    type        : 'driver-processing-plant'
                }).then(res=>{
                    this.users      = res.data.data;
                    this.total_row  = res.data.total_row;
                    this.loader     = false;
                })
                .catch(err=>console.log(err));
            },
            edit:function(item){
                this.$router.push({path:`/user/informative/edit?id=${item.id}`});
            },
            checkAction(uri){
                var actions = (this.$store.state.actions) ? (this.$store.state.actions) : [];
                return (actions.indexOf(uri) > -1);
            }
        }
    }
</script>

<style scoped>

</style>

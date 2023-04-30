<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;
                    <span>সকল পরিবেশক</span>    
                </h4>
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
                            <!-- <th>E-mail</th> -->
                            <th>Entity</th>
                            <th>Role</th>
                            <th width="70" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in users" :key="index">
                            <td class="text-center">{{++index}}</td>
                            <td>{{row.name_bn}}</td>
                            <td>{{row.username}}</td>
                            <td>{{row.mobile}}</td>
                            <!-- <td>{{row.email}}</td> -->
                            <td class="text-nowrap">
                                <span v-if="row.entity_name!='N/A'">{{row.entity_name}}</span>
                                <span v-else >System</span>
                            </td>
                            <td>{{row.role_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <NuxtLink :to="'/distributor/area/map?id='+row.id"  v-if="checkAction('/distributor/area/map')">
                                        <button class="btn btn-success"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
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
                    slug        : 'distributor',
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

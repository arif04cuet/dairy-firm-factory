<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল ইউজার রোল</h5>
                <div class="btn-group">
                    <nuxt-link to="/role/add" class="btn btn-primary" v-if="$ck_action('/role/add')" v-b-tooltip.hover title="নতুন রোল যুক্ত করুন">
                        <i class="fa fa-plus"></i>
                    </nuxt-link>
                    <button class="btn btn-success" @click="roleSync" v-b-tooltip.hover title="ড্যাশবোর্ডের সাথে রোল সিঙ্ক করুন">
                        <i class="fa fa-history" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <!--                             
                            <select class="form-control" v-model="search.entity_id">
                                <option value="">এনটিটির নির্বাচন করুন</option>
                                <option value="0">N/A</option>
                                <option v-for="(row, index) in all_entity" :value="row.id" :key="index">{{row.entity_name}}</option>
                            </select> 
                            -->
                            
                            <select-picker 
                                :options="all_entity"
                                label="entity_name"
                                :reduce="row=>row.id"
                                v-model="search.entity_id"
                                placeholder="এনটিটির নির্বাচন করুন"
                            />
                        </div>
                        
                        <div class="col-md-2">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">রোলের নাম</th>
                            <th class="text-left">এনটিটির নাম</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in roles" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td class="text-left">{{ row.role_name }}</td>
                            <td class="text-left">
                                <span v-if="row.parent_entity_name != 'N/A'">{{ row.parent_entity_name }}
                                    <i class="fa fa-angle-right text-success p-2" aria-hidden="true"></i>
                                </span>
                                {{ row.entity_name }}
                            </td>

                            <td class="text-center" v-if="row.system_id==0 && row.entity_id==0 && ((row.role_name).toLowerCase())=='superadmin'">
                                ---
                            </td>
                            
                            <td class="text-center" v-else >
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger" :class="(row.is_system==1 ? 'disabled' : '')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchRole"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


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
                kernel      : {},
                all_entity  : [],
                roles       : [],
                search              : {
                    entity_id:'',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
                is_sync         : false,
            }
        },
        mounted(){
            this.fetchRole();
            //
            this.http('entity/all', 'all_entity', {
                select:['id', 'entity_name']
            });
        },
        methods:{
            roleSync(){
                this.is_sync = true;
                this.http('role/sync', 'sync');
            },
            filter(){
                this.fetchRole();
            },
            edit(row){
                this.$router.push({path:'/role/edit?id='+row.id});
            },
            fetchRole(){
                this.loader = true;
                this.http('role/all', 'roles', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='roles'){
                        this.roles     = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row;
                        this.loader    = false;
                    }
                    else if(key=='all_entity'){
                        this.all_entity = this.kernel[key].data;
                    }
                    else if(key=='sync')
                    {
                        this.$toastr.s(this.kernel[key].message);
                        this.is_sync = false;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

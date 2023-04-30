<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল মেনু তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/dev/menu/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;মেনু সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select-picker 
                                placeholder="মেনু নির্বাচন করুন"
                                :options="all_menu"
                                v-model="search.id"
                                :reduce="row=>row.id"
                                label="name_en"
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
                            <th>প্যারেন্ট</th>
                            <th>মেনুর নাম (BN)</th>
                            <th>মেনুর নাম (EN)</th>
                            <th>আইকন</th>
                            <th>ইউআরএল</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in menus" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td>{{row.parent_name}}</td>
                            <td>{{row.name_bn}}</td>
                            <td>{{row.name_en}}</td>
                            <td><img :src="$store.state.host_server+row.icon" alt="" style="height:25px; width: 25px;"></td>
                            <td>{{row.url}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/dev/menu/edit?id='+row.id" class="btn btn-primary">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </nuxt-link>
                                    

                                    <button class="btn btn-danger" @click="destroy(row.id)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(menus.length <= 0)">
                            <th colspan="5">কোনো ডিপার্টমেন্ট পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllMenu"/>
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
                kernel          : {},
                all_menu        : [],
                menus           : [],
                search          : {
                    id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllMenu();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('menu/list', 'all-menu', {
                select:['id', 'name_bn', 'name_en']
            });
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'Are You Sure, want to delete this menu?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                })
                .then((result)=>{
                    if(result.isConfirmed){
                        this.http('menu/delete/'+id, 'delete')
                    }
                });
            },
            filter(){
                this.fetchAllMenu();
            },
            fetchAllMenu(){
                this.loader = true;
                this.http('menu/list', 'menu-list', {
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
                    if(key=='menu-list'){
                        this.menus = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='all-menu'){
                        this.all_menu = this.kernel[key].data;
                    }
                    else if(key=='delete'){
                        if(this.kernel[key]==1){
                            this.$toastr.s('মেনুটি সফলভাবে মুছে ফেলা হয়েছে');
                            this.fetchAllMenu();
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

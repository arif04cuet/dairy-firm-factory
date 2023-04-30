<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল ডিস্ট্রিবিউটর তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/distributor/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;ডিস্ট্রিবিউটর সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.zone_id">
                                <option value="">জোন নির্বাচন করুন</option>
                                <option v-for="(row, index) in zones" :key="index" :value="row.id">{{row.zone_name_bn}}</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="text" v-model="search.distributor_mobile" class="form-control" placeholder="ডিস্ট্রিবিউটর মোবাইল">
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
                            <th>জোনের নাম</th>
                            <th>ডিস্ট্রিবিউটর নাম (BN)</th>
                            <th>ডিস্ট্রিবিউটর নাম (EN)</th>
                            <th>ডিস্ট্রিবিউটর মোবাইল</th>
                            <th>ডিস্ট্রিবিউটর ঠিকানা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in distributors" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.zone_name}}</td>
                            <td>{{row.distributor_name_bn}}</td>
                            <td>{{row.distributor_name_en}}</td>
                            <td>{{row.distributor_mobile}}</td>
                            <td>{{row.distributor_address}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/distributor/edit')">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/distributor/destroy')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(distributors.length <= 0)">
                            <th colspan="7">কোনো ডিপার্টমেন্ট পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAlldistributor"/>
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
                zones          : [],
                distributors     : [],
                search          : {
                    zone_id : '',
                    distributor_mobile : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAlldistributor();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('zone/list', 'zones');
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, জোন মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('distributor/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.fetchAlldistributor();
            },
            edit(row){
                this.$router.push({path:'/distributor/edit?id='+row.id});
            },
            fetchAlldistributor(){
                this.loader = true;
                this.http('distributor/list', 'all-distributor', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-distributor'){
                        this.distributors = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='zones'){
                        console.log(this.zones);
                        this.zones = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.fetchAlldistributor();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            }
        }
    }
</script>

<style>

</style>

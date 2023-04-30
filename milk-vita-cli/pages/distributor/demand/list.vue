<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সকল ডিমান্ডের তালিকা</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/distributor/demand/add" class="btn btn-primary" v-if="$ck_action('/distributor/demand/add')">
                        <i class="fa fa-plus"></i>&nbsp;ডিমান্ড সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                           <input type="text" class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <date-picker 
                                v-model="search.date['from']"
                                placeholder="শুরুর তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <date-picker 
                                v-model="search.date['to']"
                                placeholder="শেষ তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-2">
                            <button class="btn btn-success text-nowrap">
                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                সার্চ করুন&nbsp;
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>ভাউচার</th>
                            <th v-if="($auth.user.role_slug=='zone-supervisor')">ডিস্ট্রিবিউটর</th>
                            <th>মোট আইটেম</th>
                            <th>মোট পরিমান </th>
                            <th>অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in demands" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.date}}</td>
                            <td>{{row.voucher_no}}</td>
                            <td v-if="($auth.user.role_slug=='zone-supervisor')">{{row.distributor_name}}</td>
                            <td>{{row.total_item}}</td>
                            <td>{{row.total_quantity}}</td>
                            <td class="text-capitalize">{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="view(row)" v-if="$ck_action('/distributor/demand/view')">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button v-if="$ck_action('/distributor/demand/edit') && row.received_processing_plant_id==0" @click="$router.push({path:'/distributor/demand/edit?id='+row.id})" class="btn btn-primary" >
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button @click="destroy(row.id)" v-if="$ck_action('/distributor/demand/destroy') && row.received_processing_plant_id==0" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(demands.length <= 0)">
                            <th :colspan="($auth.user.role_slug=='zone-supervisor' ? 8 : 7)">কোনো ডিমান্ডের পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="allDemand"/>
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
                areas          : [],
                demands     : [],
                search          : {
                    area_id : '',
                    date:{
                        from : '',
                        to   : ''
                    }
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.allDemand();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('area/list', 'areas', {
                select:['id', 'area_name_bn', 'area_name_en']
            });
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, এরিয়া মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('distributor/demand/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.allDemand();
            },
            view(row){
                this.$router.push({path:'/distributor/demand/view?id='+row.id});
            },
            allDemand(){
                this.loader = true;
                this.http('distributor/demand/list', 'all-demand', {
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
                    if(key=='all-demand'){
                        this.demands   = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row;
                        this.loader    = false;
                        console.log(this.demands);
                    }
                    else if(key=='areas'){
                        this.areas = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.allDemand();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সকল ডিস্ট্রিবিউটর ডিমান্ডের তালিকা</span>
                </h5>
                <!-- <div class="btn-group">
                    <nuxt-link to="/distributor/demand/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;ডিমান্ড সংযুক্ত করুন
                    </nuxt-link>
                </div> -->
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
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
                        <div class="col-md-3 form-group">
                           <input type="text" class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
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
                            <th>ডিস্ট্রিবিউটর</th>
                            <th>মোবাইল</th>
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
                            <td><span v-if="row.distributor">{{row.distributor.name_bn}}</span></td>
                            <td><span v-if="row.distributor">{{row.distributor.mobile}}</span></td>
                            <td>{{row.total_item}}</td>
                            <td>{{row.total_quantity}}</td>
                            <td class="text-capitalize">{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="view(row)" v-if="$ck_action('/head-office/distributor/demand-view')">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button @click="edit(row)" v-if="$ck_action('/head-office/distributor/challan/add') && row.is_challan==0" class="btn btn-primary" title="Create Challan">
                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(demands.length <= 0)">
                            <th colspan="9">কোনো ডিমান্ড পাওয়া যায়নি </th>
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
    export default {
        layout:'admin',
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
            filter(){
                this.page_no = 1;
                this.allDemand();
            },
            view(row){
                this.$router.push({path:'/head-office/distributor/demand-view?id='+row.id});
            },
            edit(row){
                this.$router.push({path:'/head-office/distributor/challan/add?id='+row.id});
            },
            allDemand(){
                this.loader = true;
                this.http('head-office/distributor/demand/list', 'demand-list', {
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
                    if(key=='demand-list'){
                        this.demands    = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

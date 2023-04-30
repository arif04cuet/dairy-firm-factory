<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/processing-plant/stock-list" class="info-box">
                    <div class="icon" style="background:rgb(166 222 153 / 53%)">
                        <img src="@/assets/icons/milk-jar.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(48 147 25)">বর্তমান দুধের স্টক</span>
                        <strong>{{$en2bn(data.milk_stock_quantity)}} লিটার</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(26 91 208)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#1552c1">মোট অপেক্ষমান চালান</span>
                        <strong>{{$en2bn(data.total_incomplete_challan)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:#D01A67">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#b3225d">অপেক্ষমান ডিমান্ড</span>
                        <strong>{{$en2bn(data.total_pending_demand)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(36 170 164 / 48%)">
                        <img src="@/assets/icons/gift.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#207c77">ফিনিশ প্রোডাক্ট</span>
                        <strong>{{$en2bn(data.total_finish_product)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
        </div>
        <div class="row">


            <!-- // LIST OF DEMAND LIST // -->
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> সকল ডিমান্ডের তালিকা </h5>
                            <!-- // -->
                            <form @submit.prevent="fetchData">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
                                    </div>

                                    <div class="col-md-4">
                                        <button class="btn btn-success text-nowrap" >সার্চ করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                        <!-- // -->

                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
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
                                                    <!-- // -->
                                                    <button class="btn btn-primary" title="Create Challan" @click="edit(row)" v-if="$ck_action('/head-office/distributor/challan/add')">
                                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="(demands.length<=0 && !loading)">
                                            <th colspan="9">কোনো ডিমান্ড পাওয়া যায়নি</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
                            </div>
                        </div>
                        <!-- // -->
                    </div>
                </div>
            </div>

            <!-- // LIST OF QC LIST // -->
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> স্টক ইন হওয়া চালান সমূহ </h5>
                            <!-- // -->
                            <!-- <form @submit.prevent="fetchData">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
                                    </div>

                                    <div class="col-md-4">
                                        <button class="btn btn-success text-nowrap" >সার্চ করুন</button>
                                    </div>
                                </div>
                            </form> -->
                        </div>  
                        <!-- // -->

                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
                                    <thead>
                                        <tr>
                                           <th width="50" class="text-center">ক্রমিক</th>
                                            <th>তারিখ</th>
                                            <th>গাড়ী</th>
                                            <th>চালকের নাম</th>
                                            <th>দুধের পরিমান</th>
                                            <th>বর্তমান অবস্থা</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(row, index) in bulks" :key="index">
                                            <td class="text-center">{{$en2bn(++index)}}</td>
                                            <td>{{$en2bn(row.receive_date)}}</td>
                                            <td>{{row.vehicle}}</td>
                                            <td>{{row.driver_name}}</td>
                                            <td>{{$en2bn(row.grand_total_milk)}} লিটার</td>
                                            <td>{{row.is_qc==0?'অপেক্ষমান':'কিউ.সি সম্পন্ন হয়েছে'}}</td>
                                        </tr>
                                        <tr v-if="(bulks.length<=0 && !loading)">
                                            <th colspan="6">কোনো চালান পাওয়া যায়নি</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <pagination v-model="page_no_bulk" :records="total_row_bulk" :per-page="per_page_bulk" @paginate="fetchBulks"/>
                            </div>
                        </div>
                        <!-- // -->
                    </div>
                </div>
            </div>


        </div>
        <!-- // -->
    </div>
</div>
</template>

<script>
import Pagination from 'vue-pagination-2';
export default {
  components: {Pagination},
    name:'',
    data(){
        return {
            search : {},
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                milk_stock_quantity : 0
            },
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            demands : [],
            association_id:'',



            bulks          : [],
            total_row_bulk : 0,
            per_page_bulk  : 10,
            page_no_bulk   : 1,

            
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.fetchData();
        this.fetchBulks();
    },
    methods:{
        track_stasus(association){
            this.association_id = association.id;
        },
        fetchData(){
            this.loader = true;
            //
            this.http('head-office/distributor/demand/list', 'distributor_demand', {
                per_page    : this.per_page,
                page_no     : this.page_no,
                where       : this.search,
            });
        },
        fetchBulks(){
            this.loader = true;
            this.http('processing-plant/bulk/list', 'bulks', {
                per_page    : this.per_page_bulk,
                page_no     : this.page_no_bulk,
                type        : 'qc',
            });
        },
        http(url, type, data=null){
            this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
        },
    },
    watch:{
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data    = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='distributor_demand'){
                    this.demands    = this.kernel[key].data;
                    this.total_row  = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading    = false;
                }
                else if(key=='bulks'){
                    console.log(this.kernel[key], 'k');
                    this.bulks           = this.kernel[key].data;
                    this.total_row_bulk  = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading    = false;
                }
            }
        }
    }
}
</script>

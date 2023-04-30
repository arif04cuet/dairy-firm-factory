<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/processing-plant/qc/bulk-list" class="info-box">
                    <div class="icon" style="background:rgb(229 231 235 / 84%)">
                        <img src="@/assets/icons/test.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(94 94 99)">মোট কিউ.সি</span>
                        <strong>{{$en2bn(data.total_qc)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/processing-plant/qc/bulk-list" class="info-box">
                    <div class="icon" style="background:rgb(155 169 183)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(77 99 120)">মোট সম্পন্ন কিউ.সি</span>
                        <strong>{{$en2bn(data.total_complete_qc)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/processing-plant/qc/bulk-list" class="info-box">
                    <div class="icon" style="background:rgb(75 104 155 / 84%)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <!-- // -->
                    <div class="info">
                        <span style="color:rgb(83 104 141)">মোট অপেক্ষমান কিউ.সি</span>
                        <strong>{{$en2bn(data.total_pending_qc)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between pb-2">
                            <div class="col-md-2">
                                <h5 class="mt-2"><i class="fa fa-list-alt" aria-hidden="true"></i> কিউ.সি / চালান  </h5>
                            </div>
                            <!-- // -->
                            <div class="col-md-8">
                                <form @submit.prevent="fetchData">
                                    <div class="row">
                                        <div class="col-md-5 form-group">
                                            <date-picker
                                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                                class="form-control p-0"
                                                v-model="search.date['from']"
                                                :bind="$local('bind')"
                                                :locale="$store.state.local"
                                            />
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <date-picker
                                                placeholder="শেষের তারিখ নির্বাচন করুন"
                                                class="form-control p-0"
                                                v-model="search.date['to']"
                                                :bind="$local('bind')"
                                                :locale="$store.state.local"
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success">সার্চ করুন</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                            <th width="70" class="text-center">অ্যাকশন</th>
                                        </tr>
                                    </thead>
                                    <!-- // -->
                                    <tbody>
                                        <tr v-for="(row, index) in bulks" :key="index">
                                            <td class="text-center">{{$en2bn(++index)}}</td>
                                            <td>{{$en2bn(row.sand_qc_date)}}</td>
                                            <td>{{row.bulk.vehicle}}</td>
                                            <td>{{row.bulk.driver_name}}</td>
                                            <td>{{$en2bn(row.sample_quantity)}} লিটার</td>
                                            <td>{{row.is_qc==0?'অপেক্ষমান':'কিউ.সি সম্পন্ন হয়েছে'}}</td>
                                            <td class="text-center">
                                                <div class="btn-group custom">
                                                    <nuxt-link :to="'/processing-plant/qc/challan/report?id='+row.id" v-if="row.is_qc==0 && $ck_action('/processing-plant/qc/challan/report')" title="কিউ.সি রিপোর্ট করুন">
                                                        <button class="btn btn-success">
                                                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                                        </button>
                                                    </nuxt-link>
                                                    <!-- // -->
                                                    <nuxt-link :to="'/processing-plant/qc/challan/view?id='+row.id" class="ml-1" v-if="row.is_qc==1 && $ck_action('/processing-plant/qc/challan/view')" title="কিউ.সি রিপোর্ট দেখুন  ">
                                                        <button class="btn btn-info">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </nuxt-link>
                                                    <!-- // -->
                                                    <nuxt-link :to="'/processing-plant/qc/challan/report-update?id='+row.id" class="ml-1" v-if="row.is_qc==1 && $ck_action('/processing-plant/qc/bulk-report-update')" title="কিউ.সি রিপোর্ট আপডেট করুন">
                                                        <button class="btn btn-primary">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        </button>
                                                    </nuxt-link>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- // -->
                                        <tr v-if="(bulks.length <= 0)">
                                            <th colspan="7">Data Not Found</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
                            </div>
                        </div>
                        <!-- // -->
                        <Loader :loader="loader" />
                    </div>
                </div>
            </div>
        </div>
        <!-- LIST OF ALL MEMBERS OF AN ASSOCIATION -->
        <div v-if="association_id" class="popup">
            <div class="popup-box">
                <status-track v-model="association_id" ></status-track>
            </div>
        </div>
        <!-- // -->
    </div>
</div>
</template>

<script>
import Track from '@/components/association/Track.vue';
export default {
    components: {'status-track':Track},
    data(){
        return {
            search : {date:{}},
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                today_milk_collections : []
            },
            loading   : true,
            loader    : true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            bulks     : [],
            association_id:'',
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.fetchData();
    },
    methods:{
        track_stasus(association){
            this.association_id = association.id;
        },
        edit(row){
            this.$router.push({path:'/shop/order/edit?id='+row.id});
        },
        view(row){
            this.$router.push({path:'/shop/order/view?id='+row.id});
        },
        toPlace(row){
            this.$router.push({path:'/shop/order/place?id='+row.id});
        },
        fetchData(){
            this.loader = true;
            this.search.qc_manager_id = this.$auth.user.id;
            this.http('processing-plant/challan/list', 'bulks', {
                per_page    : this.per_page,
                page_no     : this.page_no,
                where       : this.search,
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
                else if(key=='bulks'){
                    this.bulks     = this.kernel[key].data;
                    this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loader   = false;
                }
            }
        }
    }
}
</script>

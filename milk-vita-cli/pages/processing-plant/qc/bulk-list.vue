<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;&nbsp;কিউ.সি / বাল্ক</h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <date-picker
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                class="form-control p-0"
                                v-model="search.date['from']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <div class="col-md-4 form-group">
                            <date-picker
                                placeholder="শেষের তারিখ নির্বাচন করুন"
                                class="form-control p-0"
                                v-model="search.date['to']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
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
                            <th>তারিখ</th>
                            <th>গাড়ী</th>
                            <th>চালকের নাম</th>
                            <th>দুধের পরিমান</th>
                            <th>বর্তমান অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
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
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/processing-plant/qc/bulk-qc?id='+row.id" v-if="row.is_qc==0 && $ck_action('/processing-plant/qc/bulk-qc')" title="কিউ.সি রিপোর্ট করুন">
                                        <button class="btn btn-success">
                                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link :to="'/processing-plant/qc/bulk-report?id='+row.id" class="ml-1" v-if="row.is_qc==1 && $ck_action('/processing-plant/qc/bulk-report')" title="কিউ.সি রিপোর্ট দেখুন  ">
                                        <button class="btn btn-info">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link :to="'/processing-plant/qc/bulk-report-update?id='+row.id" class="ml-1" v-if="row.is_qc==1 && $ck_action('/processing-plant/qc/bulk-report-update')" title="কিউ.সি রিপোর্ট আপডেট করুন">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(bulks.length <= 0)">
                            <th colspan="7">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchBulks"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>
        <!-- // -->
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
                kernel              : {},
                all_chilling_plant  : [],
                bulks     : [],
                search              : {
                    id:'',
                    date:{
                        from :'',
                        to   :'',
                    }
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchBulks();
            // FETCH ALL CHILLING PLANT WITHOUT CONDITION
            this.http('chilling-plant/all', 'all-chilling-plant', {
                select:['id', 'chilling_plant_name']
            });
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchBulks();
            },
            fetchBulks(){
                this.loader = true;
                this.http('processing-plant/bulk/list', 'bulks', {
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
            kernel(){
                for(const key in this.kernel){
                    if(key=='bulks'){
                        this.bulks = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='all-chilling-plant'){
                        this.all_chilling_plant = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

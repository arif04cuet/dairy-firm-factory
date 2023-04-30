<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2"><i class="fa fa-th-large" aria-hidden="true"></i>&nbsp;&nbsp;স্টক স্থানান্তরের তালিকা</h4>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/stock/transfer/add" class="btn btn-primary" v-if="$ck_action('/processing-plant/stock/transfer/add')">
                        <i class="fa fa-plus"></i>
                        <span>নতুন ট্রান্সফার যুক্ত করুন </span>
                    </NuxtLink>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <date-picker 
                                v-model="search.date['from']"
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <date-picker 
                                v-model="search.date['to']"
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-5 form-group">
                            <select-picker 
                                v-model="search.from_processing_plant_id"
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                :options="plants"
                                :reduce="row=>row.id"
                                label="processing_plant_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-1">
                            <button class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50">নং</th>
                            <th width="50" class="text-nowrap">পাঠানোর তারিখ</th>
                            <th width="50" class="text-nowrap">গ্রহণের তারিখ</th>
                            <th>প্রসেসিং প্লান্ট <span v-if="user && user.role_slug!='processing-plant-manager'">(আসছে)</span></th>
                            <th  v-if="user && user.role_slug!='processing-plant-manager'">প্রসেসিং প্লান্ট (থেকে)</th>
                            <th>পরিমান (লিটার)</th>
                            <th>ঘনত্ব</th>
                            <th width="100" class="text-center text-nowrap">বর্তমান অবস্থা</th>
                            <th width="50" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in records" :key="index" >
                            <!-- / -->
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td>{{$en2bn(row.date)}}</td>
                            <td>{{row.received_date ? $en2bn(row.received_date) : '---'}}</td>
                            <td v-if="user && user.role_slug!='processing-plant-manager'">{{row.from_processing_plant_name}}</td>
                            <td>{{row.to_processing_plant_name}}</td>
                            <td>{{row.sdr_liter}}</td>
                            <td>{{row.sdr_density}}</td>
                            <!-- // -->
                            <td>{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/processing-plant/stock/receive/view?id='+row.id" v-if="$ck_action('/processing-plant/stock/receive/view')">
                                        <button class="btn btn-success">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(records.length <= 0)">
                            <th colspan="9">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchrecords"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel          : {},
                plants          : [],
                records         : [],
                search          : {
                    id:'',
                    date:{
                        from  : '',
                        to    : '',
                    }
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
                user            : {},
            }
        },
        mounted(){
            this.fetchrecords();
            // FETCH ALL CHILLING PLANT WITHOUT CONDITION
            this.http('processing-plant/all', 'plants', {
                select:['id', 'processing_plant_name']
            });
            this.user = this.$auth.user;
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchrecords();
            },
            fetchrecords(){
                this.loader = true;
                this.http('stock-transfer/milk-receive/list', 'records', {
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
                    if(key=='records')
                    {
                        this.records   = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row;
                        this.loader    = false;
                    }
                    else if(key=='plants'){
                        this.plants = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

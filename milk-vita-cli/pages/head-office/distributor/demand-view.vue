<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-sticky-note-o"></i> ডিস্ট্রিবিউটর ডিমান্ড </h5>
                <div class="btn-group">
                    <nuxt-link to="/head-office/distributor/demand-list" class="btn btn-primary">
                        <i class="fa fa-chevron-circle-left"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <!-- // -->
            <div class="row">
                <div class="col-md-6 mb-2">
                    <span><span class="min-label">ডিস্ট্রিবিউটর</span>: <span v-if="data.distributor">{{data.distributor.name_bn}}</span></span>
                    <br>
                    <span><span class="min-label">মোবাইল নাম্বার </span>: <span v-if="data.distributor">{{data.distributor.mobile}}</span></span>
                    <br>
                    <span><span class="min-label">ভাউচার নাম্বার</span>:   {{$en2bn(data.voucher_no)}}</span>
                </div>

                <div class="col-md-6 text-right">
                    <span><span>তারিখ</span>: {{$en2bn(data.date)}}</span>
                </div>
            </div>
            <!-- // -->
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <th width="40">নং</th>
                        <th>ক্যাটাগরি</th>
                        <th>পণ্যের</th>
                        <th>ইউনিট</th>
                        <th class="text-right">পরিমান</th>
                    </thead>
                    <tbody v-if="data.items">
                       <tr v-for="(row, index) in data.items" :key="index">
                           <td>{{$en2bn(index + 1)}}</td>
                           <td>{{row.category_name}}</td>
                           <td>{{row.product_name}}</td>
                           <td>{{row.unit_name}}</td>
                           <td class="text-right">{{$en2bn(row.quantity)}}</td>
                       </tr>

                        <tr>
                            <td colspan="3" rowspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td colspan="2" class="text-right">{{number(total_quantity)}}</td>
                        </tr>
                    </tbody>
                </table>
            <!-- // -->
                <div class="alert alert-success text-right mt-3">
                    <div class="btn-group">
                        <button @click="receiveChallan()" v-if="data.received_processing_plant_id==0" class="btn btn-success">
                            <span v-if="is_processing">
                                <i class="fa fa-spinner fa-spin"></i>&nbsp;প্রসেসিং হচ্ছে...
                            </span>
                            <span v-else >

                            </span>
                            <i class="fa fa-handshake-o" aria-hidden="true"></i> &nbsp;রিসিভ করুন
                        </button>
                        <nuxt-link v-else-if="data.is_challan==0" :to="'/head-office/distributor/challan/add?id='+$route.query.id" class="btn btn-success">
                            <span v-if="is_processing">
                                <i class="fa fa-spinner fa-spin"></i>&nbsp;প্রসেসিং হচ্ছে...
                            </span>
                            <span v-else >
                                ডিস্ট্রিবিউটর চালান করুন <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                            </span>
                        </nuxt-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel     : {},
                categories : [],
                products   : [],
                product_id : '',
                data       : [],
                search     : {
                    cat_id       : '',
                    product_code : '',
                    id           : '',
                },
                total_quantity : 0,
                total_price    : 0,
                is_submit      : false,
                is_processing  : false,
            }
        },
        mounted(){
            this.http('/head-office/distributor/demand/details/'+this.$route.query.id, 'view');
        },
        methods:{
            totalQuantity(){
                this.total_quantity = 0;
                if(this.data.items){
                    (this.data.items).forEach(item=>{
                        this.total_quantity += +item.quantity;
                    });
                }
            },
            receiveChallan(){
                this.is_processing = true;
                this.http('/head-office/distributor/demand/receive/'+this.$route.query.id, 'receive');
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            number(value){
                return this.$en2bn(Number.parseFloat(value).toFixed(2));
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='view')
                    {
                        this.data = this.kernel[key];
                        this.totalQuantity();
                        this.is_processing = false;
                    }
                    else if(key=='receive'){
                        if(this.kernel[key]==1){
                            this.http('/head-office/distributor/demand/details/'+this.$route.query.id, 'view');
                        }
                    }
                }
            }
        },
    }
</script>

<style scoped>
    .min-label {
        display: block;
        float: left;
        width: 111px;
    }
</style>

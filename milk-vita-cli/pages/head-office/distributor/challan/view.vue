<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-sticky-note-o"></i> ডিস্ট্রিবিউটর চালান </h5>
                <div class="btn-group">
                    <nuxt-link to="/head-office/distributor/challan/list" class="btn btn-primary">
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
                    <table v-if="data.distributor">
                        <tr>
                            <td>ডিস্ট্রিবিউটর</td>
                            <td>: {{data.distributor.name_bn}}</td>
                        </tr>
                        <tr>
                            <td>মোবাইল নাম্বার</td>
                            <td>: {{$en2bn(data.distributor.mobile)}}</td>
                        </tr>
                        <tr>
                            <td>ভাউচার নাম্বার</td>
                            <td>:  {{$en2bn(data.voucher_no)}}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="float-right">
                        <tr>
                            <td>তারিখ</td>
                            <td>: {{$en2bn(data.challan_date)}}</td>
                        </tr>
                        <tr v-if="data.challan_creator">
                            <td>তৈরিকারক</td>
                            <td>: {{data.challan_creator.name_bn}}</td>
                        </tr>
                        <tr>
                            <td>বর্তমান অবস্থা</td>
                            <td>: {{data.status}}</td>
                        </tr>
                    </table>
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
                        <th class="text-right" v-if="data.status=='challan'">মূল্য</th>
                        <th class="text-right">ডিমান্ড পরিমান</th>
                        <th class="text-right" v-if="data.status=='challan'">চালান পরিমান</th>
                        <th class="text-right" v-if="data.status=='challan'">মোট</th>
                    </thead>
                    <tbody v-if="data.items">
                       <tr v-for="(row, index) in data.items" :key="index" :class="(+row.challan_quantity==0 ? 'bg-warning' : '')">
                           <td>{{$en2bn(index + 1)}}</td>
                           <td>{{row.category_name}}</td>
                           <td>{{row.product_name}}</td>
                           <td>{{row.unit_name}}</td>
                           <td class="text-right" v-if="data.status=='challan'">{{number(row.price)}}</td>
                           <td class="text-right">{{$en2bn(row.quantity)}}</td>
                           <td class="text-right" v-if="data.status=='challan'">{{$en2bn(row.challan_quantity)}}</td>
                           <td class="text-right" v-if="data.status=='challan'">{{number((row.challan_quantity * row.price))}}</td>
                       </tr>

                        <tr>
                            <td :colspan="(data.status=='challan' ? 4 : 3)"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td class="text-right">{{number(total_quantity)}}</td>
                            <td class="text-right" v-if="data.status=='challan'">{{number(total_challan_quantity)}}</td>
                            <td class="text-right" v-if="data.status=='challan'">{{number(grand_total)}}</td>
                        </tr>
                    </tbody>
                </table>

                
                <div class="alert alert-success mt-3 text-right" v-if="$auth.user && $auth.user.role_slug=='distributor'">
                    <div class="btn-group">
                        <button v-if="data.is_distributor_received==0" class="btn btn-success" @click="receiveChallan()"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;নিশ্চিত করুন</button>
                        <button v-else class="btn btn-default"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;চালানটি রিসিভ করা হয়েছে</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        data(){
            return {
                kernel     : {},
                categories : [],
                products   : [],
                product_id : '',
                data       : {},
                search     : {
                    cat_id       : '',
                    product_code : '',
                    id           : '',
                },
                total_quantity         : 0,
                total_challan_quantity : 0,
                grand_total            : 0,
                total_price    : 0,
                is_submit      : false,
            }
        },
        mounted(){
            this.http('/head-office/distributor/challan/details/'+this.$route.query.id, 'view');
        },
        methods:{
            receiveChallan(){
                this.http('/distributor/challan/receive/'+this.$route.query.id, 'receive');
            },
            totalQuantity(){
                this.total_quantity = this.total_challan_quantity = 0;
                if(this.data.items){
                    (this.data.items).forEach(item=>{
                        this.total_quantity         += +item.quantity;
                        this.total_challan_quantity += +item.challan_quantity;
                        this.grand_total            += +(item.challan_quantity * item.price);
                    });
                }
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
                    }
                    else if(key=='receive'){
                        this.http('/head-office/distributor/challan/details/'+this.$route.query.id, 'view');
                        this.is_submit = false;
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

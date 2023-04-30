<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-sticky-note-o"></i> ডিস্ট্রিবিউটর ডিমান্ড </h5>
                <div class="btn-group">
                    <nuxt-link to="/distributor/demand/list" class="btn btn-primary">
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
                            <td>: {{$en2bn(data.voucher_no)}}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="float-right">
                        <tr>
                            <td class="text-right">তারিখ</td>
                            <td>: {{$en2bn(data.date)}}</td>
                        </tr>
                        <tr>
                            <td>বর্তমান অবস্থা</td>
                            <td>: {{$en2bn(data.status)}}</td>
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
            }
        },
        mounted(){
            this.getChallan();
        },
        methods:{
            getChallan(){
                this.http('distributor/demand/details/'+this.$route.query.id, 'view');
            },
            totalQuantity(){
                this.total_quantity = 0;
                if(this.data.items){
                    (this.data.items).forEach(item=>{
                        this.total_quantity += +item.quantity;
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

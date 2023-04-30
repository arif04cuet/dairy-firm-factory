<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-plus"></i> নতুন কাঁচামালের ক্রয়</h5>
                <div class="btn-group">
                    <nuxt-link to="/raw-material/use/list" class="btn btn-primary">
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
                    <span><span class="min-label">তৈরি কারকের নাম</span>: {{$en2bn(data.user_name)}}</span>
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
                        <th>কোড</th>
                        <th>পণ্যের নাম</th>
                        <th>ইউনিট</th>
                        <th>পরিমান</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in data.items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td>{{row.product_code}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td class="text-nowrap">{{row.unit_name}}</td>
                            <td width="130" class="text-right">{{number(row.quantity)}}</td>
                        </tr>

                        <tr>
                            <td colspan="3" rowspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td class="text-right">{{number(total_quantity)}}</td>
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
            this.http('raw-material/use/view/'+this.$route.query.id, 'view');
        },
        methods:{
            financialCalculation(){
                this.total_quantity = this.total_price = 0;
                (this.data.items).forEach(row=>{
                    this.total_quantity += +row.quantity;
                    this.total_price += +row.price;
                });
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
                        this.financialCalculation();
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .min-label {
        display: block;
        float: left;
        width: 111px;
    }
</style>>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-cubes" aria-hidden="true"></i> কাঁচামাল ক্রয়ের বিবরণ</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/finish/list" class="btn btn-primary">
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
            
            <hr class="mt-1">
            <!-- // -->
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-left">
                                <i class="fa fa-tasks" aria-hidden="true"></i> &nbsp;
                                তৈরিকৃত পণ্যের তথ্য
                            </th>
                            <th colspan="8" class="text-left">
                                <i class="fa fa-database" aria-hidden="true"></i> &nbsp;
                                তৈরিকৃত পণ্যের কিউ.সি. তথ্য
                            </th>
                        </tr>
                        <tr>
                            <th width="40">ক্রমিক</th>
                            <th class="text-nowrap">পণ্যের নাম</th>
                            <th>ইউনিট</th>
                            <th>পরিমান</th>
                            <th class="text-nowrap">লিটার</th>
                            <th class="text-nowrap">ঘনত্ব</th>
                            <th class="text-nowrap">কেজি</th>
                            <th class="text-nowrap">ফ্যাট %</th>
                            <th class="text-nowrap">এস.এন.ফ %</th>
                            <th class="text-nowrap">ফ্যাট(কেজি)</th>
                            <th class="text-nowrap">এস.এন.ফ(কেজি)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in data.items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td width="130">{{row.unit_name}}</td>
                            <td width="130" class="text-right">{{ $en2bn(row.quantity) }}</td>
                            <td width="130">{{ $en2bn(row.pro_liter) }}</td>
                            <td width="130">{{ $en2bn(row.density) }}</td>
                            <td width="130">{{ $en2bn(row.pro_kg) }}</td>
                            <td width="130">{{ $en2bn(row.fat_persentase) }}</td>
                            <td width="130">{{ $en2bn(row.snf_persentase) }}</td>
                            <td width="130">{{ $en2bn(row.fat_kg) }}</td>
                            <td width="130">{{ $en2bn(row.snf_kg) }}</td>
                            
                        </tr>

                        <tr>
                            <th colspan="3" rowspan="4" class="text-right">সর্বমোট পরিমানঃ</th>
                            <td colspan="1" class="text-right">{{number(total_quantity)}}</td>
                            <td colspan="8"></td>
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
            this.http('product/finish/view/'+this.$route.query.id, 'view');
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
                        console.log(this.kernel[key]);
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

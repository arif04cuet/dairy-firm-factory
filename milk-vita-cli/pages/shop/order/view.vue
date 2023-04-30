<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-sticky-note-o"></i> শপ অর্ডার</h5>
                <div class="btn-group">
                    <nuxt-link to="/shop/order/list" class="btn btn-primary">
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
                    <span><span class="min-label">শপের নাম</span>: {{$en2bn(data.shop_name)}}</span>
                    <br>
                    <span><span class="min-label">মোবাইল নাম্বার </span>: {{$en2bn(data.shop_mobile)}}</span>
                    <br>
                    <span><span class="min-label">ভাউচার নাম্বার</span>:   {{$en2bn(data.voucher_no)}}</span>
                </div>
                <!-- // -->
                <div class="col-md-6 text-right">
                    <span><span>তারিখ</span>: {{$en2bn(data.date)}}</span>
                    <br>
                    <span><span>তৈরিকারক</span>: {{$en2bn(data.user_name)}}</span>
                    <br>
                    <span><span>এলাকা</span>: {{$en2bn(data.area_name)}}</span>
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
                        <th v-if="data.status!='pending'">মূল্য</th>
                        <th class="text-right">পরিমান</th>
                        <th v-if="data.status!='pending'" class="text-right">মোট মূল্য</th>
                    </thead>
                    <tbody v-if="data.items">
                       <tr v-for="(row, index) in data.items" :key="index">
                           <td>{{$en2bn(index + 1)}}</td>
                           <td>{{row.category_name}}</td>
                           <td>{{row.product_name}}</td>
                           <td>{{row.unit_name}}</td>
                           <td v-if="data.status!='pending'">{{$en2bn(row.price)}}</td>
                           <td class="text-right">{{$en2bn(row.quantity)}}</td>
                           <td v-if="data.status!='pending'" class="text-right">{{number((row.quantity * row.price))}}</td>
                       </tr>
                        <!-- // -->
                        <tr>
                            <td colspan="3" rowspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td colspan="2" class="text-right">{{number(total_quantity)}}</td>
                            <td v-if="data.status!='pending'" class="text-right">{{number(grand_total)}}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- // -->
            </div>
            <div class="btn-group float-right" v-if="$ck_action('/shop/order/place') && data.status=='pending'">
                <nuxt-link :to="'/shop/order/place?id='+this.$route.query.id" class="btn btn-success">
                    <i class="fa fa-paper-plane-o"></i>&nbsp;
                    <span>অর্ডারটি সম্পন্য করুন</span>
                </nuxt-link>
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
                grand_total    : 0,
                is_submit      : false,
            }
        },
        mounted(){
            this.http('shop/order/details/'+this.$route.query.id, 'view');
        },
        methods:{
            totalQuantity(){
                this.total_quantity = 0;
                if(this.data.items){
                    (this.data.items).forEach(item=>{
                        this.total_quantity += +item.quantity;
                        this.grand_total    += +(item.quantity * item.price);
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

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-plus"></i> শপ অর্ডার যুক্ত করুন </h5>
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

                <div class="col-md-6 text-right">
                    <span><span>তারিখ</span>: {{$en2bn(data.date)}}</span>
                    <br>
                    <span><span>তৈরিকারক</span>: {{$en2bn(data.user_name)}}</span>
                    <br>
                    <span><span>এলাকা</span>: {{$en2bn(data.area_name)}}</span>
                </div>
            </div>
            
            <hr class="m-0">
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <th width="40">নং</th>
                        <th>ক্যাটাগরি</th>
                        <th>পণ্যের নাম</th>
                        <th>ইউনিট</th>
                        <th>মূল্য</th>
                        <th>অর্ডার পরিমান</th>
                        <th>ডেলিভারি পরিমান</th>
                        <th>মোট মূল্য</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td>{{row.category_name}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td width="130">{{row.unit_name}}</td>
                            <td width="130">{{row.price}}</td>
                            <td width="130">{{row.order_quantity}}</td>
                            <td width="130"><input @change="financialCalculation" @input="financialCalculation" v-model="items[index].quantity" type="number" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input :value="(row.price * row.quantity)" readonly min="1" step="any" class="form-control text-center"></td>
                        </tr>

                        <tr v-if="items.length>0">
                            <td colspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td class="text-center">
                                <input type="text" :value="total_order_quantity" class="form-control text-center" readonly>
                            </td>
                            <td>
                                <input type="text" :value="total_quantity" class="form-control text-center" readonly>
                            </td>
                            <td>
                                <input type="text" :value="grand_total" class="form-control text-center" readonly>
                            </td>
                        </tr>
                    </tbody>

                    <!-- // -->
                    <tr v-if="items.length==0">
                        <th colspan="8">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                    </tr>
                    <!-- // -->
                </table>
                
            </div>
            <!-- // -->
            <div class="btn-group float-right" v-if="items.length > 0">
                <!-- // -->
                <button type="button" class="btn btn-success" v-if="is_submit">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                    <span>সাবমিট হচ্ছে</span>
                </button>
                <!-- // -->
                <button @click="submit" class="btn btn-success" v-else >
                    <i class="fa fa-floppy-o"></i>
                    <span>সাবমিট করুন</span>
                </button>
            </div>
        </div>

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
                kernel     : {},
                items      : [],
                data       : {},
                search     : {
                    cat_id       : '',
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity       : 0,
                grand_total          : 0,
                total_order_quantity : 0,
                is_submit            : false,
            }
        },
        mounted(){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            this.http('shop/order/details/'+this.$route.query.id, 'details');
        },
        methods:{
            submit(){
                this.is_submit = true;
                this.http('shop/order/place/'+this.$route.query.id, 'store', {
                    order_id : this.$route.query.id,
                    items    : this.items
                });
            },
            financialCalculation(){
                this.total_quantity = this.total_order_quantity = 0;
                (this.items).forEach(row=>{
                    this.total_quantity       += +row.quantity;
                    this.total_order_quantity += +row.order_quantity;
                    this.grand_total += +(row.order_quantity * row.price);
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='units' && (this.kernel[key].data).length>0){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='details'){
                        console.log(this.kernel[key]);
                        if(this.kernel[key]){
                            this.data = this.kernel[key];
                            this.shop_mobile = this.data.shop_mobile;
                            this.items       = this.data.items;
                            //
                            if(this.data.items){
                                (this.data.items).forEach((row, key)=>{
                                    this.items[key].order_quantity = row.quantity;
                                });
                            }
                            this.financialCalculation();
                        }
                    }
                    else if(key=='store')
                    {
                        this.is_submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                          this.$toastr.s("সফল ভাবে সাবমিট হয়েছে");
                          this.$router.push({path:'/shop/order/view?id='+this.kernel[key]});
                        }
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
        width: 95px;
    }
</style>

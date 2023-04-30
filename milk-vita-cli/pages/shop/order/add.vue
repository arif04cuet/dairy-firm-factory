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
            <form @submit.prevent="addRow()">
                <div class="row">
                    <div class="col-md-3 form-group">
                       <input type="text" v-model="shop_mobile" class="form-control" placeholder=" শপ মোবাইল নাম্বার ">
                    </div>
                    <!-- // -->
                    <div class="col-md-3 form-group">
                        <select class="form-control" v-model="search.cat_id">
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            <!-- <option v-for="(row, index) in products" :value="row.id" :key="index">{{row.product_name}} - ({{row.product_code}})</option> -->
                        </select>
                    </div>
                    <!-- // -->
                    <div class="col-md-3 form-group">
                        <select class="form-control" v-model="search.product_id">
                            <option value="">পণ্য নির্বাচন করুন</option>
                            <option v-for="(row, index) in products" :value="row.id" :key="index">{{row.product_name}} - ({{row.product_code}})</option>
                        </select>
                    </div>
                    <!-- // -->
                    <div class="col-md-2 form-group">
                        <select class="form-control" v-model="search.unit_id" required>
                            <option value="">ইউনিট</option>
                            <option v-for="(row, index) in units" :value="row.id" :key="index">{{row.unit_name}}</option>
                        </select>
                    </div>
                    <!-- // -->
                    <div class="col-md-1">
                        <button class="btn btn-success text-nowrap">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <hr class="m-0">
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <th width="40">নং</th>
                        <th>কোড</th>
                        <th>পণ্যের নাম</th>
                        <th>ইউনিট</th>
                        <th>পরিমান</th>
                        <th>অ্যাকশন</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td>{{row.product_code}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td width="130">{{row.unit_name}}</td>
                            <td width="130"><input @change="financialCalculation" @input="financialCalculation" v-model="items[index].quantity" type="number" min="1" step="any" class="form-control text-center"></td>
                            <td width="30">
                                <div class="btn-group custom">
                                    <button class="btn btn-danger" @click="rmRow(index)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="items.length>0">
                            <td colspan="3" rowspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td class="text-center">
                                <input type="text" :value="total_quantity" class="form-control text-center" readonly>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>

                    <!-- // -->
                    <tr v-if="items.length==0">
                        <th colspan="8">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                    </tr>

                    <tr v-if="shop_info.shop_name_bn">
                        <td colspan="3" rowspan="4"></td>
                        <th class="text-right">এরিয়া:</th>
                        <td class="text-left" colspan="2">
                            {{shop_info.area_name}}
                        </td>
                    </tr>

                    <tr v-if="shop_info.shop_name_bn">
                        <th class="text-right">শপের মোবাইল:</th>
                        <td class="text-left" colspan="2">
                            {{shop_info.shop_mobile}}
                        </td>
                    </tr>

                    <tr v-if="shop_info.shop_name_bn">
                        <th class="text-right">শপের নাম:</th>
                        <td class="text-left" colspan="2">
                            {{shop_info.shop_name_bn}}
                        </td>
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
                units      : [],
                products   : [],
                shop_info  : {},
                shop_mobile: '',
                product_id : '',
                items      : [],
                search     : {
                    cat_id       : '',
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity : 0,
                is_submit      : false,
                mobileInterval : '',
            }
        },
        mounted(){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            this.getProductList();
        },
        methods:{
            submit(){
                if(this.shop_info.id)
                {
                    this.is_submit = true;
                    this.http('shop/order/store', 'store', {
                        shop_id : this.shop_info.id,
                        items   : this.items
                    });
                }
                else {
                    this.$toastr.w('শপ নাম্বার সঠিক নয়');
                }
            },
            financialCalculation(){
                this.total_quantity = this.total_price = 0;
                (this.items).forEach(row=>{
                    this.total_quantity += +row.quantity;
                    this.total_price += +row.price;
                });
            },
            rmRow(index){
                this.$delete(this.items, index);
                this.financialCalculation();
            },
            addRow(){
                if(this.search.product_id!='' && this.search.unit_id!=''){
                    this.http('product/finish/make-production-item', 'add-to-items', this.search);
                }
                else this.$toastr.w("পণ্যের কোড / পণ্য এবং ইউনিট নির্বাচন করুন ");
            },
            getProductList(){
                this.http('product/list', 'product-list', {
                    select:['id', 'product_name', 'product_code'],
                    type:'finish-product',
                    where:this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            shop_mobile:function(){
                if(this.mobileInterval) clearTimeout(this.mobileInterval);

                var obj = this;

                this.mobileInterval = setTimeout(function(){
                    obj.http('shop/list', 'shop-details', {
                        where:{shop_mobile:obj.shop_mobile}
                    });
                }, 400);
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='units' && (this.kernel[key].data).length>0){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='product-list'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='shop-details')
                    {
                        this.shop_info = {};
                        if((this.kernel[key].data).length > 0){
                            this.shop_info = this.kernel[key].data[0];
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
                    else if(key=='add-to-items'){
                        if(this.kernel[key].errors){
                            this.$toastr.w("কোনো পণ্য পাওয়া যায়নি");
                        }
                        else {
                            var product = this.kernel[key], is_available = false;
                            //
                            (this.items).forEach((row)=>{if(row.product_id==product.product_id && row.unit_id==product.unit_id) is_available=true});
                            //
                            if(is_available) 
                            {
                                this.$toastr.w("পণ্যটি ইতিমধ্যেই আপনার কার্টে যোগ করা রয়েছে");
                            }
                            else{
                                product.quantity =  1;
                                this.items.unshift(product);
                                this.search.unit_id = '';
                                this.financialCalculation();
                            }
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

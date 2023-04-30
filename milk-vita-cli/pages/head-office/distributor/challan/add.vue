<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-plus"></i> ডিস্ট্রিবিউটর চালান </h5>
                <div class="btn-group">
                    <nuxt-link to="/head-office/distributor/challan/list" class="btn btn-primary">
                        <i class="fa fa-chevron-circle-left"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
             <div class="row">
                <div class="col-md-6 mb-2">
                    <span><span class="min-label">ডিস্ট্রিবিউটর</span>: <span v-if="data.distributor">{{data.distributor.name_bn}}</span></span>
                    <br>
                    <span><span class="min-label">মোবাইল নাম্বার </span>: <span v-if="data.distributor">{{$en2bn(data.distributor.mobile)}}</span></span>
                    <br>
                    <span><span class="min-label">ভাউচার নাম্বার</span>:   {{$en2bn(data.voucher_no)}}</span>
                </div>

                <div class="col-md-6 text-right">
                    <span><span>তারিখ</span>: {{$en2bn(data.date)}}</span>
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
                        <th>স্টক</th>
                        <th>ডিমান্ড পরিমান</th>
                        <th>চালান পরিমান</th>
                        <th>মোট</th>
                    </thead>
                    <tbody>
                        <!-- // -->
                        <tr v-for="(row, index) in items" :key="index" :style="(+row.stock_quantity==0 ? 'background:#ffc8c8' : '')">
                            <td>{{$en2bn(index+1)}}</td>
                            <td class="text-nowrap">{{row.category_name}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td width="130">{{row.unit_name}}</td>
                            <td width="130">{{row.price}}</td>
                            <td width="130">{{row.stock_quantity ? row.stock_quantity : 0}}</td>
                            <td width="130">{{row.demand_quantity}}</td>
                            <td width="130"><input @change="financialCalculation" @input="financialCalculation(); onChangeQuantity(index, row)" v-model="items[index].quantity" type="number" min="0" :max="row.stock_quantity" step="any" class="form-control text-center"></td>
                            <td width="130"><input :value="(row.quantity * row.price)" type="number" min="1" step="any" class="form-control text-center" readonly></td>
                        </tr>
                        <!-- // -->
                        <tr v-if="items.length>0">
                            <td colspan="5"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td class="text-center">
                                <input type="text" :value="total_demand_quantity" class="form-control text-center" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" :value="total_quantity" class="form-control text-center" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" :value="grand_total" class="form-control text-center" readonly>
                            </td>
                        </tr>
                        <!-- // -->
                    </tbody>

                    <!-- // -->
                    <tr v-if="items.length==0">
                        <th colspan="7">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                    </tr>
                    <!-- // -->
                </table>
                
            </div>
            <!-- // -->
            <div class="btn-group float-right" v-if="items.length > 0">
                <button @click="submit" class="btn btn-success" :type="is_submit ? 'button' : 'submit'">
                    <span v-if="is_submit">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>
                        <span>সাবমিট হচ্ছে...</span>
                    </span>
                    <span v-else >
                        <i class="fa fa-floppy-o"></i>
                        <span>সাবমিট করুন</span>
                    </span>
                </button>
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
                units      : [],
                products   : [],
                product_id : '',
                items      : [],
                data       : {},
                search     : {
                    cat_id       : '',
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity        : 0,
                total_demand_quantity : 0,
                grand_total : 0,
                is_submit      : false,
                mobileInterval : '',
            }
        },
        mounted(){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            //
            this.http('head-office/distributor/demand/details/'+this.$route.query.id, 'details');
        },
        methods:{
            onChangeQuantity(index, row){
                if(+row.stock_quantity < +row.quantity){
                    this.items[index].quantity = +row.stock_quantity;
                }
                if(row.quantity < 0){
                    this.items[index].quantity = 0;
                }
            },
            submit()
            {
                this.is_submit = true;
                this.http('head-office/distributor/challan/store', 'store', {
                    demand_id : this.$route.query.id,
                    items     : this.items
                });
            },
            financialCalculation(){
                this.total_quantity = this.total_demand_quantity = this.grand_total = 0;
                (this.items).forEach((row, key)=>{
                    this.total_quantity        += +row.quantity;
                    this.total_demand_quantity += +row.demand_quantity;
                    this.grand_total           += +(row.quantity * row.price);
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
                    else if(key=='details')
                    {
                        this.data = this.kernel[key];
                        this.items = this.kernel[key].items;
                        //
                        if(this.kernel[key].items){
                            (this.kernel[key].items).forEach((row, key)=>{
                                this.items[key].demand_quantity = row.quantity;
                                this.items[key].quantity = (+row.stock_quantity > +row.quantity ? row.quantity : (+row.stock_quantity));

                            });
                        }
                        //
                        this.financialCalculation();
                    }
                    else if(key=='store')
                    {
                        this.is_submit = false;
                        //
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                          this.$toastr.s("সফল ভাবে সাবমিট হয়েছে");
                          this.$router.push({path:'/head-office/distributor/challan/view?id='+this.kernel[key]});
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

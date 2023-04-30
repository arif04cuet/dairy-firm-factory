<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-pencil-square-o"></i> ভাউচার এডিট করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/raw-material/use/list" class="btn btn-primary">
                        <i class="fa fa-chevron-circle-left"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <span><span class="min-label">ভাউচার নাম্বার</span>:   {{$en2bn(data.voucher_no)}}</span>
                </div>

                <div class="col-md-6 text-right">
                    <span><span>তারিখ</span>: {{$en2bn(data.date)}}</span>
                </div>
            </div>
            <hr class="mt-1">
            <!-- // -->
            <form @submit.prevent="addRow()">
                <div class="row">
                    <!-- // -->
                    <div class="col-md-4 form-group">
                        <select class="form-control" v-model="search.cat_id" @change="onChangeCategory()">
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            <option v-for="(row, index) in categories" :value="row.id" :key="index">{{row.category_name}}</option>
                        </select>
                    </div>
                    <!-- // -->
                    <div class="col-md-4 form-group">
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
                    <div class="col-md-2">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>
                            <span>যোগ করুন</span>
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
                        <th class="text-nowrap">বর্তমান স্টক</th>
                        <th>পরিমান</th>
                        <th>অ্যাকশন</th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td>{{row.product_code}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td class="text-nowrap">{{row.unit_name}}</td>
                            <td class="text-nowrap">{{row.stock_quantity}}</td>
                            <td width="130"><input @change="financialCalculation" @input="financialCalculation" v-model="items[index].quantity" type="number" min="1" step="any" class="form-control text-center"></td>
                            <td width="30">
                                <div class="btn-group custom">
                                    <button class="btn btn-danger" @click="itemDelete(row.id)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- // -->
                        <tr v-if="items.length>0">
                            <td colspan="5" rowspan="4"></td>
                            <th class="text-right">সর্বমোট পরিমানঃ</th>
                            <td colspan="2" class="text-right">{{total_quantity}}</td>
                        </tr>
                    </tbody>
                    <!-- // -->
                    <tr v-if="items.length==0">
                        <th colspan="8">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                    </tr>
                </table>
                <!-- // -->
            </div>
            <!-- // -->
            <div class="btn-group float-right" v-if="items.length > 0">
                <!-- // -->
                <button type="button" class="btn btn-success" v-if="is_submit">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                    <span>আপডেট হচ্ছে</span>
                </button>
                <!-- // -->
                <button @click="submit" class="btn btn-success" v-else >
                    <i class="fa fa-floppy-o"></i>
                    <span>আপডেট করুন</span>
                </button>
            </div>
        </div>
        <!-- // -->
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
                items      : [],
                units      : [],
                search     : {
                    cat_id       : '',
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity : 0,
                total_price    : 0,
                is_submit      : false,
                data           : {}
            }
        },
        mounted(){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            // 
            this.http('raw-material/use/view/'+this.$route.query.id, 'editable');
            //
            this.http('product/category/list', 'categories', {
                select:['id', 'category_name'],
                where :{slug:'raw-material'},
                children:'true'
            });
            this.getProductList();
        },
        methods:{
            itemDelete(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, পণ্যটি মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('raw-material/use/item-delete/'+id, 'item-delete');
                    }
                })
            },
            submit(){
                if(this.$route.query.id){
                    this.is_submit = true;
                    //
                    var form = {
                        total_price    : this.total_price,
                        total_quantity : this.total_quantity,
                        total_product  : (this.items).length,
                        items           : this.items
                    };
                    //
                    this.http('raw-material/use/update/'+this.$route.query.id, 'update', form);
                }
            },
            financialCalculation(){
                this.total_quantity = this.total_price = 0;
                (this.items).forEach(row=>{
                    this.total_quantity += +row.quantity;
                    this.total_price += +row.price;
                });
            },
            addRow(){
                if(this.search.product_id!='' && this.search.unit_id!=''){
                    this.http('raw-material/use/check-item', 'add-to-items', this.search);
                }
                else this.$toastr.w("পণ্যের কোড / পণ্য নির্বাচন করুন");
            },
            onChangeCategory(){
                this.getProductList();
            },
            getProductList(){
                this.http('product/list', 'product-list', {
                    select:['id', 'product_name', 'product_code'],
                    type:'raw-material',
                    where:this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='categories' && (this.kernel[key].data).length>0){
                        this.categories = (this.kernel[key].data[0]).children;
                    }
                    else if(key=='units' && (this.kernel[key].data).length>0){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='item-delete' && this.kernel[key])
                    {
                        (this.items).forEach((row, index)=>{
                            if(this.kernel[key] == row.id) this.$delete(this.items, index);
                        });
                    }
                    else if(key=='editable'){
                        this.items = this.kernel[key].items;
                        this.data  = this.kernel[key];
                        this.financialCalculation();
                    }
                    else if(key=='product-list'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='update')
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                          this.$toastr.s("সফল ভাবে আপডেট হয়েছে");
                          this.$router.push({path:'/raw-material/use/view?id='+this.kernel[key]});
                        }
                        this.is_submit = false;
                    }
                    else if(key=='add-to-items'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            var product = this.kernel[key], is_available = false;
                            //
                            (this.items).forEach((row)=>{if(row.product_id==product.product_id && row.unit_id==product.unit_id) is_available=true});
                            //
                            if(is_available) this.$toastr.w("পণ্যটি ইতিমধ্যেই আপনার কার্টে যোগ করা রয়েছে");
                            else{
                                //
                                product['quantity'] = 1;
                                product['price']    = 0;
                                //
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

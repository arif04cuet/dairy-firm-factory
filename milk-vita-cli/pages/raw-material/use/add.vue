<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-plus"></i> নতুন ব্যবহৃত কাঁচামাল</h5>
                <div class="btn-group">
                    <nuxt-link to="/raw-material/use/list" class="btn btn-primary">
                        <i class="fa fa-chevron-circle-left"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div>
                <!-- // -->
                <form @submit.prevent="addRow()">
                    <div class="row">
                        <div class="col-md-3">
                            <caption class="text-nowrap">উৎপাদিত পণ্য</caption>
                        </div>
                        <div class="col-md-4 form-group">
                            <select-picker
                                placeholder="পণ্য নির্বাচন করুন"
                                v-model="search.product_id"
                                :options="products"
                                :reduce="row=>row.id"
                                label="product_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-4 form-group">
                            <select-picker
                                placeholder="ইউনিট নির্বাচন করুন"
                                v-model="search.unit_id"
                                :options="units"
                                :reduce="row=>row.id"
                                label="unit_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-1">
                            <button class="btn btn-success">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                
                </form>
                <!-- // -->
                <div class="table-responsive">
                    <table class="table table-bordered custom">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-left">
                                    <i class="fa fa-tasks" aria-hidden="true"></i> &nbsp;
                                    তৈরিকৃত পণ্যের তথ্য
                                </th>
                                <th colspan="9" class="text-left">
                                    <i class="fa fa-database" aria-hidden="true"></i> &nbsp;
                                    তৈরিকৃত পণ্যের কিউ.সি. তথ্য
                                </th>
                            </tr>
                            <tr>
                                <th>পণ্যের নাম</th>
                                <th>ইউনিট</th>
                                <th>পরিমান</th>
                                <th class="text-nowrap">লিটার</th>
                                <th class="text-nowrap">ঘনত্ব</th>
                                <th class="text-nowrap">কেজি</th>
                                <th class="text-nowrap">ফ্যাট %</th>
                                <th class="text-nowrap">এস.এন.ফ %</th>
                                <th class="text-nowrap">ফ্যাট(কেজি)</th>
                                <th class="text-nowrap">এস.এন.ফ(কেজি)</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-if="product.product_name">
                                <td class="text-nowrap">{{product.product_name}}</td>
                                <td width="130">{{product.unit_name}}</td>
                                <td width="130"><input v-model="product.quantity" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="product.pro_liter" @click="calculation" @input="calculation" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="product.density" @click="calculation" @input="calculation" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="product.pro_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="product.fat_persentase" @click="calculation" @input="calculation" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="product.snf_persentase" @click="calculation" @input="calculation" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="product.fat_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="product.snf_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="30">
                                    <div class="btn-group custom">
                                        <button class="btn btn-danger" @click="product={}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- // -->
                            <tr v-else >
                                <th colspan="12">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
            
            <br>

            <div>
                <div class="row">
                    <div class="col-md-3">
                        <caption class="text-nowrap">উৎপাদিত পণ্যের ব্যবহৃত কাঁচামাল</caption>
                    </div>
                    <div class="col-md-4 form-group">
                        <select-picker
                            placeholder="পণ্য নির্বাচন করুন"
                            v-model="search.product_id"
                            :options="products"
                            :reduce="row=>row.id"
                            label="product_name"
                        />
                    </div>
                    <!-- // -->
                    <div class="col-md-4 form-group">
                        <select-picker
                            placeholder="ইউনিট নির্বাচন করুন"
                            v-model="search.unit_id"
                            :options="units"
                            :reduce="row=>row.id"
                            label="unit_name"
                        />
                    </div>
                    <!-- // -->
                    <div class="col-md-1">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered custom">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-left">
                                    <i class="fa fa-tasks" aria-hidden="true"></i> &nbsp;
                                    কাঁচামালের তথ্য
                                </th>
                                <th colspan="9" class="text-left">
                                    <i class="fa fa-database" aria-hidden="true"></i> &nbsp;
                                    কাঁচামালের কিউ.সি. তথ্য
                                </th>
                            </tr>
                            <tr>
                                <th width="40">ক্রমিক</th>
                                <th>পণ্যের নাম</th>
                                <th>ইউনিট</th>
                                <th>পরিমান</th>
                                <th class="text-nowrap">লিটার</th>
                                <th class="text-nowrap">ঘনত্ব</th>
                                <th class="text-nowrap">কেজি</th>
                                <th class="text-nowrap">ফ্যাট %</th>
                                <th class="text-nowrap">এস.এন.ফ %</th>
                                <th class="text-nowrap">ফ্যাট(কেজি)</th>
                                <th class="text-nowrap">এস.এন.ফ(কেজি)</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- // -->
                            <tr v-for="(row, index) in raw_meterals" :key="index">
                                <td>{{$en2bn(index+1)}}</td>
                                <td class="text-nowrap">{{row.product_name}}</td>
                                <td width="130">{{row.unit_name}}</td>
                                <td width="130"><input v-model="raw_meterals[index].quantity" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="raw_meterals[index].pro_liter" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="raw_meterals[index].density" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="raw_meterals[index].pro_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="raw_meterals[index].fat_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="raw_meterals[index].snf_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="raw_meterals[index].fat_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="raw_meterals[index].snf_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="30">
                                    <div class="btn-group custom">
                                        <button class="btn btn-danger" @click="rmRow(index)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="raw_meterals.length>0">
                                <th colspan="3" rowspan="4" class="text-right">সর্বমোট পরিমানঃ</th>
                                <td class="text-center">{{total_quantity}}</td>
                                <td colspan="8" class="text-center"></td>
                            </tr>

                            <!-- // -->
                            <tr v-if="raw_meterals.length==0">
                                <th colspan="13">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                            </tr>
                        </tbody>
                        
                    </table>
                    
                </div>
                <!-- // -->
                <div class="btn-group float-right" v-if="raw_meterals.length > 0">
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
                categories : [],
                products   : [],


                product      : {},
                raw_meterals : [],



                units      : [],
                product_id : '',
                search     : {
                    cat_id       : '',
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity : 0,
                total_price    : 0,
                is_submit      : false,
            }
        },
        mounted(){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            //
            this.http('product/category/list', 'categories', {
                select:['id', 'category_name'],
                where :{slug:'raw-material'},
                children:'true'
            });
            this.getProductList();
        },
        methods:{
            submit(){
                this.is_submit = true;
                //
                var form = {
                    total_price    : this.total_price,
                    total_quantity : this.total_quantity,
                    total_product  : (this.raw_meterals).length,
                    raw_meterals   : this.raw_meterals
                };
                //
                this.http('raw-material/use/store', 'store', form);
            },
            calculation(index)
            {
                if(index)
                {
                    var item = this.raw_meterals[index];
                    //
                    item.pro_kg = Number.parseFloat(item.pro_liter * item.density).toFixed(2);
                    item.fat_kg = Number.parseFloat((item.pro_kg / 100) * item.fat_persentase).toFixed(2);
                    item.snf_kg = Number.parseFloat((item.pro_kg / 100) * item.snf_persentase).toFixed(2);
                    //
                    this.raw_meterals[index] = item;
                }
                else {
                    var item = this.product;
                    //
                    item.pro_kg = Number.parseFloat(item.pro_liter * item.density).toFixed(2);
                    item.fat_kg = Number.parseFloat((item.pro_kg / 100) * item.fat_persentase).toFixed(2);
                    item.snf_kg = Number.parseFloat((item.pro_kg / 100) * item.snf_persentase).toFixed(2);
                    //
                    this.product = item;
                }
            },
            rmRow(index){
                this.$delete(this.raw_meterals, index);
            },
            addRow(){
                if(this.search.product_id!='' && this.search.unit_id!=''){
                    this.http('product/finish/make-production-item', 'add-to-raw_meterals', this.search);
                }
                else this.$toastr.w("পণ্যের কোড / পণ্য এবং ইউনিট নির্বাচন করুন ");
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
            product(){
                if(!this.product.product_name){
                    this.raw_meterals = [];
                }
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='categories' && (this.kernel[key].data).length>0){
                        this.categories = (this.kernel[key].data[0]).children;
                    }
                    else if(key=='units' && (this.kernel[key].data).length>0){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='product-list'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='store')
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                          this.$toastr.s("সফল ভাবে সাবমিট হয়েছে");
                          this.$router.push({path:'/raw-material/use/view?id='+this.kernel[key]});
                        }
                    }
                    else if(key=='add-to-raw_meterals')
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w("কোনো পণ্য পাওয়া যায়নি");
                        }
                        else {
                            this.product      = this.kernel[key];
                            this.raw_meterals = [
                                {
                                    "id": 7,
                                    "slug": 'raw-milk',
                                    "product_name": "Raw Milk",
                                    "product_code": "---",
                                    "cat_id": 0,
                                    "vat": "0.00",
                                    "product_id": 0,
                                    "unit_id": 0,
                                    "unit_name": "---",
                                    "category_name": "Milk < Raw Materials",
                                    "quantity": 1,
                                    "pro_liter": 0,
                                    "density": 0,
                                    "pro_kg": 0,
                                    "fat_kg": 0,
                                    "snf_kg": 0,
                                    "fat_persentase": 0,
                                    "snf_persentase": 0
                                }
                            ];
                        }
                    }
                }
            }
        }
    }
</script>

<style>
    tr td {
        padding: 3px 3px!important;
    }
    tr td input[type='text'] {
        outline: none!important;
        box-shadow: none!important;
    }
    tr td input {
        font-size: 14px!important;
    }
    tr td:first-child {
        padding: 0px 6px!important;
    }
</style>

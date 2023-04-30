<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0"><img src="/images/add.webp" height="25px" alt=""> নতুন ট্রান্সফার </h4>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/product-stock/transfer/list" class="btn btn-primary">
                        <img src="/images/requirement-white.webp" height="25px" alt="">
                        <span>তালিকায় ফিরে যান</span>
                    </NuxtLink>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()">
                <div class="row justify-content-between">

                    <div class="col-md-5">
                        <div class="form-group">
                            <date-picker
                                :locale="$store.state.local"
                                v-model="challan.date"
                            />
                        </div>
                        <div class="form-group mb-0">
                            <select-picker
                                v-model="challan.to_processing_plant_id"
                                placeholder="প্রসেসিং প্ল্যান্ট নির্বাচন করুন"
                                :options="plants"
                                label="processing_plant_name"
                                :reduce="row=>row.id"
                            />
                        </div>
                    </div>

                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <table>
                            <tr>
                                <td>তৈরিকারক</td>
                                <td>: {{user ? user.name_bn : 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>প্রসেসিং প্ল্যান্ট</td>
                                <td>: {{user ? user.entity_real_name : 'N/A'}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <select-picker
                                placeholder="পণ্য নির্বাচন করুন"
                                v-model="search.product_id"
                                :options="products"
                                :reduce="row=>row.id"
                                label="product_name"
                                @input="getUnits(search.product_id)"
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
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" @click="addRow()">
                                <i class="fa fa-plus"></i>
                                <span>যোগ করুন</span>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered custom">
                            <tr>
                                <th colspan="4" class="text-left">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                    পণ্যের তথ্য
                                </th>
                                <th colspan="9" class="text-left">
                                    <i class="fa fa-database" aria-hidden="true"></i>
                                    পণ্যের কিউ.সি. তথ্য
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
                            <!-- // -->
                            <tr v-for="(row, index) in challan.items" :key="index">
                                <td>{{$en2bn(index+1)}}</td>
                                <td class="text-nowrap">{{row.product_name}}</td>
                                <td width="130">{{row.unit_name}}</td>
                                <td width="130"><input @change="financialCalculation" @input="financialCalculation" v-model="challan.items[index].quantity" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="challan.items[index].quantity_litre" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="challan.items[index].density" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="challan.items[index].quantity_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="challan.items[index].fat_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="challan.items[index].snf_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                                <td width="130"><input v-model="challan.items[index].fat_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="130"><input v-model="challan.items[index].snf_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                                <td width="30">
                                    <div class="btn-group custom">
                                        <button class="btn btn-danger" @click="rmRow(index)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="challan.items && challan.items.length >0">
                                <th colspan="3" rowspan="4" class="text-right">সর্বমোট পরিমানঃ</th>
                                <td class="text-center">{{total_quantity}}</td>
                                <td colspan="8" class="text-center"></td>
                            </tr>

                            <!-- // -->
                            <tr v-if="challan.items && challan.items.length ==0">
                                <th colspan="13">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                            </tr>
                        </table>
                    </div>

                    <div class="text-right">
                        <div class="btn-group">
                            <button :type="is_submit==true?'button':'submit'" class="btn btn-success" style="min-width:127px">
                                <span v-if="is_submit"><i class="fa fa-spinner fa-spin"></i>&nbsp;লোডিং...</span>
                                <span v-else ><i class="fa fa-floppy-o"></i>&nbsp;সাবমিট করুন</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    layout: "admin",
    data() {
        return {
            kernel          : {},
            form            : {},
            location_data   : '',
            plants          : [],
            units           : [],
            products        : [],
            challan         : {
                date        : this.$date(),
                items       : [],
            },
            search      : {},
            user        : this.$auth.user,
            is_submit   : false,
            total_quantity  : 0,
            total_price     : 0,
        }
    },
    mounted() {
        this.http('processing-plant/all', 'plants');
        this.getProductList();
    },
    methods: {
        getUnits(unit_id){
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name'],
                product_id : unit_id,
                type:'product',
            });
        },
        rmRow(index){
            this.$delete(this.challan.items, index);
            this.financialCalculation();
        },
        addRow(){
            if(this.search.product_id!='' && this.search.unit_id!=''){
                this.http('product/finish/make-production-item', 'add-to-items', this.search);
            }
            else this.$toastr.w("পণ্যের কোড / পণ্য এবং ইউনিট নির্বাচন করুন ");
        },
        financialCalculation(){
            this.total_quantity = this.total_price = 0;
            (this.challan.items).forEach(row=>{
                this.total_quantity += +row.quantity;
                this.total_price += +row.price;
            });
        },
        getProductList(){
            this.http('product/list', 'product-list', {
                select:['id', 'product_name', 'product_code'],
                type:'finish-product',
                where:this.search
            });
        },
        calculation(index)
        {
            var item = this.challan.items[index];
            //
            item.quantity_kg = Number.parseFloat(item.quantity_litre * item.density).toFixed(2);
            item.fat_kg = Number.parseFloat((item.quantity_kg / 100) * item.fat_persentase).toFixed(2);
            item.snf_kg = Number.parseFloat((item.quantity_kg / 100) * item.snf_persentase).toFixed(2);
            //
            this.challan.items[index] = item;
        },
        submit: function () {
            this.http("stock-transfer/finish-product/store", "submit", this.challan);
            this.is_submit = true;
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
    },
    watch: {
        kernel: function () {
            for (const key in this.kernel) {
                if(key=='units'){
                    this.units = (this.kernel[key].data ? this.kernel[key].data : this.kernel[key]);
                }
                else if(key=='product-list'){
                    this.products = this.kernel[key].data;
                }
                else if(key == "submit") {
                    console.log(this.kernel[key]);
                    if(this.kernel[key].errors)
                        this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                    else {
                        this.$toastr.s("সফলভাবে সাবমিট হয়েছে");
                        this.$router.push({path:'/processing-plant/product-stock/transfer/view?id='+this.kernel[key].id});
                    }
                    this.is_submit = false;
                }
                else if(key=='plants' && this.kernel[key].data)
                {
                    var $sanitize = [];
                    (this.kernel[key].data).forEach(row => {
                        if(row.id!=this.user.processing_plant_id)
                            $sanitize.push(row);
                    });
                    this.plants = $sanitize;
                }
                else if(key=='add-to-items')
                {
                    if(this.kernel[key].errors)
                        this.$toastr.w("কোনো পণ্য পাওয়া যায়নি");
                    else {
                        var product = this.kernel[key], is_available = false;
                        //
                        (this.challan.items).forEach((row)=>{if(row.product_id==product.product_id && row.unit_id==product.unit_id) is_available=true});
                        //
                        if(is_available) {
                            this.$toastr.w("পণ্যটি ইতিমধ্যেই আপনার কার্টে যোগ করা রয়েছে");
                        }
                        else{
                            product.quantity       =  1;
                            product.quantity_kg    =  0;
                            product.quantity_litre =  0;
                            this.challan.items.unshift(product);
                            this.search.unit_id = '';
                            this.financialCalculation();
                        }
                    }
                }
            }
        },
    },
};
</script>


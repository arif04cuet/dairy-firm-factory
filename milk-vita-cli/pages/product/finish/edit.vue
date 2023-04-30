<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ফিনিশ পণ্য সম্পাদন করুন </h5>
                <div class="btn-group">
                    <nuxt-link to="/product/finish/list" class="btn btn-primary">
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
            
            <form @submit.prevent="addRow()">
                <div class="row">
                    <div class="col-md-6 form-group">
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
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in items" :key="index">
                            <td>{{$en2bn(index+1)}}</td>
                            <td class="text-nowrap">{{row.product_name}}</td>
                            <td width="130">{{row.unit_name}}</td>
                            <td width="130"><input @change="financialCalculation" @input="financialCalculation" v-model="items[index].quantity" type="text" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input v-model="items[index].pro_liter" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input v-model="items[index].density" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input v-model="items[index].pro_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                            <td width="130"><input v-model="items[index].fat_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input v-model="items[index].snf_persentase" @click="calculation(index)" @input="calculation(index)" type="text" min="1" step="any" class="form-control text-center"></td>
                            <td width="130"><input v-model="items[index].fat_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                            <td width="130"><input v-model="items[index].snf_kg" type="text" min="1" step="any" class="form-control text-center" readonly></td>
                            <td width="30">
                                <div class="btn-group custom">
                                    <button class="btn btn-danger" @click="itemDelete(row.id)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tr v-if="items.length>0">
                        <th colspan="3" rowspan="4" class="text-right">সর্বমোট পরিমানঃ</th>
                        <td class="text-center">{{total_quantity}}</td>
                        <td colspan="8" class="text-center"></td>
                    </tr>

                    <!-- // -->
                    <tr v-if="items.length==0">
                        <th colspan="13">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                    </tr>
                </table>
                
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
                data       : {},
                items      : [],
                search     : {
                    unit_id      : '',
                    product_id   : '',
                },
                total_quantity : 0,
                is_submit      : false,
            }
        },
        mounted(){
            this.http('product/finish/view/'+this.$route.query.id, 'view');
            //
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            this.getProductList();
        },
        methods:{
            calculation(index)
            {
                var item = this.items[index];
                //
                item.pro_kg = Number.parseFloat(item.pro_liter * item.density).toFixed(2);
                item.fat_kg = Number.parseFloat((item.pro_kg / 100) * item.fat_persentase).toFixed(2);
                item.snf_kg = Number.parseFloat((item.pro_kg / 100) * item.snf_persentase).toFixed(2);
                //
                this.items[index] = item;
            },
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
                        this.http('product/finish/item-delete/'+id, 'item-delete');
                    }
                })
            },
            submit(){
                this.is_submit = true;
                this.http('product/finish/update/'+this.$route.query.id, 'store', {items:this.items});
            },
            financialCalculation(){
                this.total_quantity = this.total_price = 0;
                (this.items).forEach(row=>{
                    this.total_quantity += +row.quantity;
                    this.total_price += +row.price;
                });
            },
            addRow()
            {
                console.log(this.search);
                if(this.search.product_id!='' && this.search.unit_id!='')
                {
                    console.log(this.search);
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
            kernel(){
                for(const key in this.kernel){
                    if(key=='units' && (this.kernel[key].data).length>0){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='product-list'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='item-delete' && this.kernel[key])
                    {
                        (this.items).forEach((row, index)=>{
                            if(this.kernel[key] == row.id) this.$delete(this.items, index);
                        });
                    }
                    else if(key=='view'){
                        this.data  = this.kernel[key];
                        this.items = this.kernel[key].items;
                        this.financialCalculation();
                    }
                    else if(key=='store')
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                          this.$toastr.s("সফল ভাবে সাবমিট হয়েছে");
                          this.$router.push({path:'/product/finish/view?id='+this.kernel[key]});
                        }
                        this.is_submit = false;
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

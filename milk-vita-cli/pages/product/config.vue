<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">নতুন পণ্য যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()"  v-if="!loaders.product">
                <!-- // -->
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th class="text-left">পণ্যের নাম</th>
                            <th class="text-left">পণ্যের কোড</th>
                            <th class="text-left">পণ্যের ক্যাটাগরি</th>
                            <th class="text-left">ভ্যাট(%) </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="product.product_name">
                            <td class="text-left">{{ product.product_name }}</td>
                            <td class="text-left">{{ product.product_code }}</td>
                            <td class="text-left">{{ product.category_name }}</td>
                            <td class="text-left">{{ $en2bn(+product.vat) }}%</td>
                        </tr>
                    </tbody>
                </table>

                <!-- // -->
                <fieldset class="border p-2 mt-5 pl-4 pr-4" style="border-color:rgb(167 161 161)!important">
                    <legend style="width:auto;margin:0">মৌলিক বৈশিষ্ট্যসহ</legend>
                    <div class="row form-group">
                        <div class="col-md-3 form-group">
                            <label for="">ফর্মুলেশন ডেন্সিটি (CLR)</label>
                            <input type="number" step="any" class="form-control" v-model="product.formulation_density">
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <label for="">ব্রান (%)</label>
                            <div class="input-group">
                                <input type="number" step="any" v-model="product.formulation_bran" class="form-control" placeholder="ব্রান (%)">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- // -->
                <fieldset class="border p-2 mt-5 pl-4 pr-4" style="border-color:rgb(167 161 161)!important">
                    <legend style="width:auto;margin:0">ইউনিট অনুযায়ী পণ্যের দাম</legend>
                    <div class="row form-group" v-for="(price, p_index) in product_prices" :key="p_index">
                        <div class="col-md-3 form-group">
                            <label for="">ইউনিট</label>
                            <select-picker
                                v-model="product_prices[p_index].unit_id"
                                :placeholder="(!loaders.unit ? 'ইউনিট নির্বাচন করুন' : 'ইউনিট লোড হচ্ছে ...')"
                                :options="untis"
                                :reduce="row=>row.id"
                                label="unit_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-2 form-group" v-for="(row, index) in price_labels" :key="index">
                            <label for="">{{row.label_name}}</label>
                            <input type="number" step="any" v-model="product_prices[p_index].price_labels[row.slug]" class="form-control" :placeholder="row.label_name">
                        </div>  
                        <!-- // -->
                        <div class="col-md-2 form-group">
                            <label for="" class="w100">&nbsp;</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" @click="itemAdd('price', price)" v-if="+p_index==((Object.values(product_prices)).length-1)" ><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger" @click="removeItem('price', p_index, price)" v-else :data-index="p_index" :data-index1="(Object.values(product_prices)).length" ><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- // -->
                    </div>
                </fieldset>



                <!-- // -->
                <fieldset class="border p-2 mt-5 pl-4 pr-4" style="border-color:rgb(167 161 161) !important">
                    <legend style="width:auto;margin:0">ফর্মুলা এবং প্যাকিং</legend>
                    <!-- // -->
                    <div class="row">
                        <!-- // -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <select-picker
                                        v-model="category_slug"
                                        :placeholder="(!loaders.categories ? 'ক্যাটাগরি নির্বাচন করুন' : 'ক্যাটাগরি লোডিং হচ্ছে...')"
                                        :options="categories"
                                        :reduce="row=>row.slug"
                                        label="category_name"
                                        @input="onChangeCategory(category_slug)"
                                    />
                                </div>

                                <div class="col-md-4">
                                    <select-picker
                                        v-model="product_dtls"
                                        :placeholder="(!loaders.products ? 'পণ্য নির্বাচন করুন' : 'পণ্য লোডিং হচ্ছে...')"
                                        :options="products"
                                        :reduce="row=>row"
                                        label="product_name"
                                    />
                                </div>

                                <div class="col-md-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info" @click="itemAdd('formula', product_dtls, true)">রও (Raw)</button>
                                        <button type="button" class="btn btn-primary" @click="itemAdd('formula', product_dtls, false)">ইনগ্রেডিয়েন্টস</button>
                                        <button type="button" class="btn btn-success ml-1" @click="itemAdd('packing', product_dtls)">প্যাকিং</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // -->
                        <div class="col-md-7">
                            <hr>
                            <!-- // -->
                            <h6 class="text-nowrap mt-4">প্রোডাকশন ফর্মুলা</h6>
                            <!-- // -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
                                    <thead>
                                        <tr>
                                            <th width="5">SL</th>
                                            <th class="text-left">Ingredients</th>
                                            <th class="text-nowrap">% of Ingredients</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in formula_items" :key="index">
                                            <td>{{index+1}}</td>
                                            <td class="text-left">{{row.product_name}} {{row.is_raw==1?'(Row Materials)':''}}</td>
                                            <td width="120">
                                                <input type="number" v-model="formula_items[index].material_percentage" class="form-control">
                                            </td>
                                            <td width="50">
                                                <button type="button" class="btn btn-danger" @click="removeItem('formula', index, row)"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- // -->
                        <div class="col-md-5">
                            <hr>
                            <h6 class="text-nowrap mt-4">প্যাকিং ম্যাটেরিয়ালস</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
                                    <thead>
                                        <tr width="5">
                                            <th>SL</th>
                                            <th class="text-nowrap text-left">Packing Materials</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in packing_items" :key="index">
                                            <td>{{index+1}}</td>
                                            <td class="text-left">{{row.product_name}}</td>
                                            <td width="120">
                                                ---
                                            </td>
                                            <td width="50">
                                                <button type="button" class="btn btn-danger" @click="removeItem('packing', index, row)"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button :type="loaders.submit ? 'button' : 'submit'" class="btn btn-success float-right mb-3">
                        <span v-if="loaders.submit"><i class="fa fa-spinner fa-spin fa-fw"></i> লোডিং ...</span>
                        <span v-else ><i class="fa fa-floppy-o"></i> সাবমিট করুন</span>
                    </button>
                </fieldset>
            </form>
            <loader :loader="loaders.product" />
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel              : {}, 
                form                : {},
                product             : {},
                untis               : [],
                products            : [],
                categories          : [],
                category_slug       : '',
                product_dtls        : '',
                price_labels        : [],
                formula_items       : [],
                packing_items       : [],
                product_prices      : [{
                    unit_id      : '',
                    price_labels : {}
                }],
                loaders : {
                    product      : true,
                    products     : true,
                    unit         : true,
                    label        : true,
                    categories   : true,
                    submit       : false,
                }
            }
        },
        mounted(){
            this.http('product/list', 'product', {where:{id:this.$route.query.id}});
            this.http('product/unit/list', 'units', {select:['id', 'unit_name']});
            this.http('product/price/label/list', 'labels');
            this.http('product/category/list', 'categories', {
                select:['id', 'category_name', 'slug'],
                where:{parent_id:'0'}
            });

            //
            this.http('product/list', 'products', {
                select:['id', 'product_name'],
                cat_slug:this.category_slug
            });

            //
            this.http('product/details/'+this.$route.query.id, 'details', {

            });
        },
        methods:{
            submit(){
                this.loaders.submit = true;
                this.http('product/config/set', 'set', {
                    product_id     : this.$route.query.id,
                    product_prices : this.product_prices,
                    formula_items  : this.formula_items,
                    packing_items  : this.packing_items,
                    formulation_density : this.product.formulation_density,
                    formulation_bran    : this.product.formulation_bran,
                });
            },
            itemAdd(type, item, is_raw){
                if(type=='formula'){
                    item.product_id = item.id;
                    item.material_percentage = 0;
                    item.is_raw = is_raw ? 1 : 0;
                    (this.formula_items).push(item);
                }
                else if(type=='packing'){
                    item.product_id = item.id;
                    (this.packing_items).push(item);
                }
                else if(type=='price'){
                    (this.product_prices).push({
                        label_id     : '',
                        unit_id      : '',
                        price_labels : {}
                    });
                }
            },
            removeItem(type, index, item){
                if(type=='formula')
                    this.$delete(this.formula_items, index)
                else if(type=='packing')
                    this.$delete(this.packing_items, index);
                else if(type=='price')
                    this.$delete(this.product_prices, index);
            },
            onChangeCategory(category_slug){
                this.loaders.products = true; this.product_dtls = '';
                this.http('product/list', 'products', {
                    select:['id', 'product_name'],
                    cat_slug:this.category_slug
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='product' && this.kernel[key].data && this.kernel[key].data[0]){
                        this.product = this.kernel[key].data[0];
                        this.loaders.product = false;
                    }
                    else if(key=='units'){
                        this.loaders.unit = false;
                        this.untis = this.kernel[key].data;
                    }
                    else if(key=='labels'){
                        this.loaders.label = false;
                        this.price_labels = this.kernel[key].data;
                    }
                    else if(key=='products'){
                        this.loaders.products = false;
                        this.products = this.kernel[key].data;
                        (this.products).map(item=>{
                            item.material_product_id = item.id;
                            return item;
                        });
                    }
                    else if(key=='categories'){
                        this.loaders.categories = false;
                        this.categories = this.kernel[key].data;
                    }
                    else if(key=='set'){
                        this.loaders.submit = false;
                        if(this.kernel[key].errors)
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else
                            this.$toastr.s("সফলভাবে হালনাগাদ করা হয়েছে");
                    }
                    else if(key=='details') {
                        let record = this.kernel[key];
                        //
                        if(Object.values(record.packing_items).length>0)
                            this.packing_items = record.packing_items;
                        if(Object.values(record.formula_items).length>0)
                            this.formula_items = record.formula_items;
                        if(Object.values(record.product_prices).length>0){
                            var prices = [];
                            Object.values(record.product_prices).forEach(price=>{
                                prices.push(price);
                            });
                            this.product_prices = prices;
                        }
                    }
                }
            }
        }
    }
</script>

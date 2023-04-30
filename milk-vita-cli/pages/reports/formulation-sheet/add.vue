<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-plus"></i>
                    নতুন যোগ করুন
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/reports/formulation-sheet/list" class="btn btn-primary" >
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div class="row">
                <div class="col-md-10">
                    <select-picker
                        placeholder="পণ্য নির্বাচন করুন"
                        v-model="product_id"
                        :options="product_list"
                        :reduce="row=>row.id"
                        label="product_name"
                    />
                </div>
                <div class="col-md-2">
                    <button @click="find(product_id)" class="btn btn-success w100">
                        <span v-if="loading.search" ><i class="fa fa-spinner fa-pulse" aria-hidden="true"></i> লোডিং...</span>
                        <span v-else ><i class="fa fa-search" aria-hidden="true"></i> সার্চ করুন </span>
                    </button>
                </div>
            </div>
            <!-- // -->
            <br>
            <!-- // -->
            <div class="row bg-white" v-if="product_details">

                <div class="col-md-12">
                    <h4 class="text-center mt-4">Formulation Sheet For {{product_details.product_name}}</h4>
                    <hr>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <Category v-model="category_id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div data-category></div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <select-picker
                                        v-model="selected_ingredient"
                                        :placeholder="loading.ingredient ? 'লোডিং হচ্ছে...' : 'পণ্য নির্বাচন করুন'"
                                        :options="ingredient_list"
                                        :reduce="row=>row"
                                        label="product_name"
                                    />
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="btn-group">
                                        <button class="btn btn-success" @click="setItem(selected_ingredient, false)">Ingredients</button>
                                        <button class="btn btn-info ml-1" @click="setItem(selected_ingredient, true)">Raw</button>
                                    </div>
                                </div>
                            </div>
                        </Category>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered custom">
                            <thead>
                                <tr>
                                    <th width="50" class="text-nowrap">SL</th>
                                    <th>Ingredients</th>
                                    <th>% of Ingredients</th>
                                    <th>Fat %</th>
                                    <th>CLR %</th>
                                    <th class="text-center" width="120">Quantity</th>
                                    <th width="50" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th width="50" class="text-nowrap">-</th>
                                    <th>Current Stock</th>
                                    <th>---</th>
                                    <td>{{stock.fat_percentage}}</td>
                                    <td>{{stock.density}}</td>
                                    <td :title="stock.stock_quantity+' Litre'">{{Number.parseFloat(stock.stock_quantity_kg).toFixed(2)}} KG</td>
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <th width="50" class="text-nowrap">-</th>
                                    <th>Use Milk</th>
                                    <th>---</th>
                                    <td>{{stock.fat_percentage}}</td>
                                    <td>{{stock.density}}</td>
                                    <td :title="stock.stock_quantity+' Litre'">
                                        <input type="number" class="form-control" v-model="used_stock" @change="milkUsing()" @input="milkUsing()">
                                    </td>
                                        
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Whole Milk</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td :title="braned_milk.stock_quantity+' Litre'">
                                        {{Number.parseFloat(braned_milk.stock_quantity_kg).toFixed(2)}}
                                    </td>
                                    <td>--</td>
                                </tr>
                                <tr v-for="(row, formula_key) in product_ingredient_items" :key="formula_key" :style="row.is_raw ? 'background:#ff72964f':''" :title="row.is_raw ? 'Row Materials':''">
                                    <td class="text-center">{{formula_key+2}}</td>
                                    <td>{{row.product_name}}</td>
                                    <td colspan="3">

                                        <div class="input-group">
                                            <input type="number" @change="equation()" @input="equation()" v-model="product_ingredient_items[formula_key].material_percentage" class="form-control">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{Number.parseFloat(row.quantity).toFixed(2)}} KG</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-danger" @click="ingredientRemove(formula_key)">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Mix</td>
                                    <td colspan="3">--</td>
                                    <td>{{Number.parseFloat(total_mix).toFixed(2)}} KG</td>
                                    <td>--</td>
                                </tr>
                                
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Input (KG)</td>
                                    <td colspan="3">--</td>
                                    <td>{{Number.parseFloat(total_mix+total_raw_mix).toFixed(2)}} KG</td>
                                    <td>--</td>
                                </tr>
                                
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Input (Litre)</td>
                                    <td colspan="3">--</td>
                                    <td>{{Number.parseFloat(total_input_litre).toFixed(2)}} LTR</td>
                                    <td>--</td>
                                </tr>

                                <tr v-if="(product_ingredient_items.length) <= 0">
                                    <th colspan="7" class="text-center">Ingredients Not Found</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- // -->
                    <div class="table-responsive">
                        <table class="table table-bordered custom">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center">Production</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="50" class="text-nowrap">SL</th>
                                    <th width="250">Item</th>
                                    <th>No of Product</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                                <tr v-for="(unit, index) in production_items" :key="index">
                                    <td class="text-center">{{index+1}}</td>
                                    <td>{{unit.unit_name}}</td>
                                    <td class="p-1 align-middle">
                                        <input :value="unit.no_of_product" type="number" class="form-control text-center" readonly>
                                    </td>
                                    <td class="p-1 align-middle">
                                        <div class="input-group">
                                            <input :value="unit.quantity" type="text" class="form-control text-center" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Litre</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">-</td>
                                    <td>Total Output</td>
                                    <td class="p-1 align-middle">-</td>
                                    <td class="p-1 align-middle">
                                        <div class="input-group">
                                            <input :value="total_production_litre" type="text" class="form-control text-center" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Litre</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="(production_items.length) <= 0">
                                    <td colspan="5" class="text-center"> Item Not Found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- // -->
                    <div class="text-right">
                        <div class="btn-group mb-3">
                            <button @click="submit" class="btn btn-primary" v-if="product_ingredient_items.length > 0">
                                <span v-if="loading.submit"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</span>
                                <span v-else ><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- /PACKAGING METERIAL/ -->
                <div class="col-md-4">
                    <table class="table table-bordered custom" >
                        <thead>
                            <tr>
                                <th>Packing Materials</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(material, material_key) in packing_items" :key="material_key">
                                <td>{{material.product_name}}</td>
                                <td width="130" class="p-1 align-middle">
                                    <input v-model="packing_items[material_key].quantity" type="number" class="form-control text-center">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- // -->
            <Loader :loader="loading.loader"/>
        </div>
    </div>
</template>
<script>
    import Category from '@/components/system/Category.vue';
    export default {
        components: { Category },
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel          : {},
                product_list    : [],
                product_id      : '',
                product_details : '',
                category_id     : '',

                ingredient_list     : [],
                selected_ingredient : '',


                packing_items    : [],
                production_items : [],

                stock           : {},
                braned_milk     : {},
                used_stock      : 0,
                total_mix       : 0,
                total_raw_mix   : 0,
                total_input_litre : 0,
                total_production_litre : 0,

                product_ingredient_items : [],

                loading : {ingredient : false, loader : false, submit : false, search : false},
            }
        },
        mounted(){
            this.fetchAllProducts();
            this.$axios.post('department/stock').then(response=>{
                if(!response.data.errors){
                    this.stock                   = response.data;
                    this.stock.stock_quantity_kg = (this.stock.stock_quantity * this.stock.density);
                    this.used_stock              = Number.parseFloat(this.stock.stock_quantity * this.stock.density).toFixed(2);
                    this.braned_milk             = Object.assign({}, this.stock);
                }
            });
        },
        methods:{
            setItem(item, is_raw){
                var is_available = false;
                //
                if(item)
                Object.values(this.product_ingredient_items).filter(row=>{
                    if(row.product_id==item.id) {
                        is_available = true;
                        this.$toastr.w("পণ্যটি ইতিমধ্যে তালিকায় রয়েছে");
                    }
                });

                if(is_available==false && item){
                    this.product_ingredient_items.unshift(Object.assign(
                    {
                        product_id : item.id,
                        material_percentage : 0,
                        quantity : 0,
                        is_raw   : is_raw,
                    }, 
                    item));
                }
                this.selected_ingredient = '';
            },
            milkUsing(){
                this.braned_milk.stock_quantity_kg = (this.used_stock - ((this.used_stock/100)*this.product_details.formulation_bran));
                this.equation();
            },
            equation()
            {
                this.total_mix     = 0;
                this.total_raw_mix = 0;
                var stock_quantity = this.braned_milk.stock_quantity_kg ? this.braned_milk.stock_quantity_kg : 0;
                //
                (this.product_ingredient_items).forEach((item, key)=>
                {
                    if(!item.is_raw ){
                        item.quantity  = (stock_quantity > 0 ? ((stock_quantity/100)*item.material_percentage) : 0);
                        this.product_ingredient_items[key] = item;
                        (item.is_raw ? this.total_raw_mix += item.quantity : this.total_mix += item.quantity);
                    }
                });

                this.total_mix += stock_quantity;

                (this.product_ingredient_items).forEach((item, key)=>
                {
                    if(item.is_raw){
                        item.quantity = (this.total_mix > 0 ? ((this.total_mix/100)*item.material_percentage) : 0);
                        this.total_raw_mix += item.quantity;
                    }

                });

                this.total_input_litre = (this.total_mix+this.total_raw_mix) / (this.product_details.formulation_density > 0 ? this.product_details.formulation_density : 1.04);

                this.productionEquation();
            },
            ingredientRemove(index){
                this.$delete(this.product_ingredient_items, index);
                this.equation()
            },
            fetchAllProducts(){
                this.http('product/list', 'all-products', {
                    select:['id', 'product_name', 'product_code', 'slug']
                });
            },
            getingredients(){
                this.loading.ingredient = true;
                this.http('product/list', 'ingredients', {
                    select : ['id', 'product_name', 'product_code', 'slug', 'cat_id'],
                    cat_id : this.category_id
                });
            },
            find(product_id)
            {
                if(product_id){
                    this.loading.search = true;
                    this.http('product/details/'+product_id, 'details', {
                        where:{id:product_id}
                    });
                }
            },
            submit(){
                this.loading.submit = true;
                var data = {
                    ingredient_items : this.product_ingredient_items,
                    packing_items    : this.packing_items,
                    production_items : this.production_items,
                    product_id       : this.product_details.id,
                    total_mix        : this.total_mix,
                    total_raw_mix    : this.total_raw_mix,
                    density          : this.braned_milk.density,
                    fat_percentage   : this.braned_milk.fat_percentage,
                    used_stock       : this.used_stock,
                    was_in_stock        : this.stock.stock_quantity_kg,
                    formulation_density : this.product_details.formulation_density,
                    formulation_bran    : this.product_details.formulation_bran,
                };
                //
                this.http('report/formula-estimate/store', 'store', data);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            productionEquation(){
                //
                var production = [];
                this.total_production_litre = 0;
                //
                var par_step = (this.total_input_litre / (this.production_items.length));
                //
                (this.production_items).forEach((item, key)=>{
                    // total_production_litre

                    var ml_key    = (item.unit_name.indexOf('ML') > -1 ? item.unit_name.indexOf('ML') : item.unit_name.indexOf('ml'));
                    var kg_key    = (item.unit_name.indexOf('KG') > -1 ? item.unit_name.indexOf('KG') : item.unit_name.indexOf('kg'));
                    item.quantity = Number.parseFloat(par_step).toFixed(2);
                    //
                    if(item.unit_name && (ml_key>-1))
                    {
                        var unit  = item.unit_name.substr(0, ml_key);
                        item.no_of_product = Math.floor((item.quantity*1000)/unit);
                    }
                    else if(item.unit_name && (kg_key>-1))
                    {
                        var unit  = item.unit_name.substr(0, kg_key);
                        item.no_of_product = Math.floor(item.quantity/unit);
                    }

                    this.total_production_litre += +item.quantity;


                    production.push(item);
                });
                this.production_items = production;
            }
        },
        watch:{
            category_id() {
                this.getingredients();
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-products'){
                        this.product_list = this.kernel[key].data;
                    }
                    else if(key=='details'){
                        this.product_details = this.kernel[key];

                        this.milkUsing();

                        this.product_ingredient_items = this.kernel[key].formula_items;

                        this.packing_items = Object.values(this.kernel[key].packing_items).filter(row=>{
                            row.quantity = 0;
                            return row;
                        });
                        
                        this.production_items = Object.values(this.kernel[key].product_prices).filter(row=>{
                            row.no_of_product = 0;
                            row.quantity = 0;
                            return row;
                        });

                        this.equation();
                        this.loading.search = false;
                    }
                    else if(key=='store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else {
                            this.$router.push({path:'/reports/formulation-sheet/view?id='+this.kernel[key]});
                            this.$toastr.s('সফলভাবে সাবমিট হয়েছে');
                        }
                        //
                        this.loading.submit = false;
                    }
                    else if(key=='ingredients'){
                        this.ingredient_list    = this.kernel[key].data;
                        this.loading.ingredient = false;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    table.formulation tr td, table.formulation tr th {
        border-color: #a9a8a8!important;;
    }
    .input-group-text {
        padding: 1px 10px;
    }
</style>
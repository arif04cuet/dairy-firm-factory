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
            <!-- // -->
            <div class="row" v-if="product_details">
                <div class="col-md-12">
                    <h4 class="text-center">Formulation Sheet For {{product_details.product_name}}</h4>
                    <hr>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive" v-if="ingredient_items.length>0">
                        <table class="table table-bordered custom">
                            <thead>
                                <tr>
                                    <th width="50" class="text-nowrap">SL</th>
                                    <th>Ingredients</th>
                                    <th>% of Ingredients</th>
                                    <th>Fat %</th>
                                    <th>CLR %</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- // -->
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Whole Milk</td>
                                    <td>--</td>
                                    <td>{{product_details.fat_percentage}}</td>
                                    <td>{{product_details.density}}</td>
                                    <td>{{Number.parseFloat(product_details.used_stock).toFixed(2)}} KG</td>
                                </tr>
                                <!-- // -->
                                <tr v-for="(row, formula_key) in ingredient_items" :key="formula_key">
                                    <td class="text-center">{{formula_key+1}}</td>
                                    <td>{{row.product_name}}</td>
                                    <td>{{row.material_percentage}}</td>
                                    <td colspan="2">--</td>
                                    <td width="160" class="p-1 align-middle text-center">{{row.quantity}} KG</td>
                                </tr>
                                <!-- // -->
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Mix</td>
                                    <td colspan="3">--</td>
                                    <td>{{product_details.total_mix}} KG</td>
                                </tr>
                                <!-- // -->
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Input (KG)</td>
                                    <td colspan="3">--</td>
                                    <td>{{Number.parseFloat((+product_details.total_mix + +product_details.total_raw_mix)).toFixed(2)}} KG</td>
                                </tr>
                                <!-- // -->
                                <tr style="background:#dfdfdf">
                                    <td class="text-center">-</td>
                                    <td>Total Input (Liter)</td>
                                    <td colspan="3">--</td>
                                    <td>{{Number.parseFloat(((+product_details.total_mix + +product_details.total_raw_mix)/1.04)).toFixed(2)}} LTR</td>
                                </tr>
                                <!-- // -->
                                <tr v-if="(ingredient_items.length) <= 0">
                                    <th colspan="7" class="text-center">Ingredients Not Found</th>
                                </tr>
                                <!-- // -->
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
                                <tr>
                                    <th width="50" class="text-nowrap">SL</th>
                                    <th>Item</th>
                                    <th class="text-center">No of Product</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(unit, index) in production_items" :key="index">
                                    <td class="text-center">{{index+1}}</td>
                                    <td>{{unit.unit_name}}</td>
                                    <td width="160" class="p-1 align-middle text-center">{{unit.no_of_product}}</td>
                                    <td width="160" class="p-1 align-middle text-center">{{unit.quantity}} Litre</td>
                                </tr>
                                <tr>
                                    <td class="text-center">-</td>
                                    <td>Total Output</td>
                                    <td width="160" class="p-1 align-middle text-center">-</td>
                                    <td width="160" class="p-1 align-middle text-center">{{calculateOutput(production_items)}} Litre</td>
                                </tr>
                                <tr v-if="(production_items.length) <= 0">
                                    <td colspan="5" class="text-center"> Item Not Found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- // -->
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
                                <td width="130" class="p-1 align-middle text-center">{{material.quantity}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                kernel          : {},
                product_list    : [],
                product_details : '',
                product_id      : '',
                production      : [],
                loader          : false,
                form   : {
                    items : []
                },
                is_submit : false,
                index:{
                    unit:0
                },

                ingredient_items : [],
                packing_items    : [],
                production_items : [],

            }
        },
        mounted(){
            if(this.$route.query.id)
            this.find(this.$route.query.id);
        },
        methods:{
            calculateOutput(production_items){
                var sum = 0;
                Object.values(production_items).forEach(item=>{
                    sum += +item.quantity;
                });
                return sum;
            },
            find(product_id)
            {
                this.http('report/formula-estimate/details/'+product_id, 'details', {
                    where:{id:product_id}
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-products'){
                        this.product_list = this.kernel[key].data;
                    }
                    else if(key=='details')
                    {
                        this.product_details  = this.kernel[key];
                        this.ingredient_items = this.kernel[key].ingredient;
                        this.packing_items    = this.kernel[key].packing;
                        this.production_items = this.kernel[key].production;
                    }
                    else if(key=='store'){
                        this.$router.push({path:'/reports/formulation-sheet/view?id='+this.kernel[key]});
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
</style>
<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল পণ্যের তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/add" class="btn btn-primary" v-if="$ck_action('/product/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন পণ্য যুক্ত করুন 
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <category class="row" v-model="cat_slug" slug="1">
                        <!-- // -->
                        <div class="col-md-2 form-group">
                            <input type="text" v-model="search.product_code" class="form-control" placeholder="পণ্যের কোড ">
                        </div>

                        <div class="col-md-3 from-group">
                            <div data-category></div>
                        </div>

                        <div class="col-md-3 from-group">
                            <div data-sub_category></div>
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <select-picker
                                placeholder="পণ্য নির্বাচন করুন"
                                v-model="search.id"
                                :options="all_product"
                                :reduce="row=>row.id"
                                label="product_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-1">
                            <button class="btn btn-success">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </category>
                </form>
            </div>
            <!-- // -->
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">পণ্যের নাম</th>
                            <th class="text-left">পণ্যের কোড</th>
                            <th class="text-left">পণ্যের ক্যাটাগরি</th>
                            <th class="text-left">ভ্যাট(%) </th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in products" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td class="text-left">{{ row.product_name }}</td>
                            <td class="text-left">{{ row.product_code }}</td>
                            <td class="text-left">{{ row.category_name }}</td>
                            <td class="text-left">{{ $en2bn(+row.vat) }}%</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/product/config?id='+row.id" v-if="$ck_action('/product/config')">
                                        <button class="btn btn-info">
                                           <i class="fa fa-cogs" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link :to="'/product/edit?id='+row.id" v-if="$ck_action('/product/edit')">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link to="#" v-if="$ck_action('/product/destroy')">
                                        <button class="btn btn-danger" @click="destroy(row.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="(products).length==0">
                            <td colspan="6">কোনো পণ্য পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchProducts"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>

    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel     : {},
                all_product: [],
                products   : [],
                cat_slug     : '',
                search     : {
                    id     : '',
                    cat_id : '',
                    
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchProducts();
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchProducts();
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, পণ্যটি মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('product/destroy/'+id, 'destroy');
                    }
                })
            },
            fetchProducts(){
                this.loader = true;
                this.http('product/list', 'products', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search,
                    cat_slug    : this.cat_slug,
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            cat_slug(){
                this.http('product/list', 'all_product', {
                    cat_slug:this.cat_slug,
                    select:['id', 'product_name']
                });
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='products'){
                        this.products = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                    else if(key=='all_product'){
                        this.all_product = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('সফলভাবে মুছে ফেলা হয়েছে');
                            this.filter();
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

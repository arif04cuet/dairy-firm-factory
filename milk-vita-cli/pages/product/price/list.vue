<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল পণ্য মূল্যের তালিকা</h5>
                <!-- <div class="btn-group">
                    <nuxt-link to="/product/price/add" class="btn btn-primary" v-if="$ck_action('/product/price/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন পণ্যের মূল্য যুক্ত করুন 
                    </nuxt-link>
                </div> -->
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select-picker 
                                v-model="search.product_id"
                                placeholder="প্রোডাক্ট নির্বাচন করুন"
                                :options="products"
                                :reduce="(row)=>row.id"
                                label="product_name"
                            />
                        </div>

                        <div class="col-md-3 form-group">
                            <select class="form-control" v-model="search.id">
                                <option value="">প্রাইস লেবেল নির্বাচন করুন</option>
                                <option v-for="(row, index) in all_label" :value="row.id" :key="index">{{row.price_label}}</option>
                            </select>
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <select class="form-control" v-model="search.unit_id">
                                <option value="">ইউনিট নির্বাচন করুন</option>
                                <option v-for="(row, index) in units" :value="row.id" :key="index">{{row.unit_name}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- // -->
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">মূল্যের লেবেল</th>
                            <th class="text-left">পণ্যের নাম</th>
                            <th class="text-left">উনিটের নাম</th>
                            <th class="text-left">মূল্য</th>
                            <!-- <th width="70" class="text-center">অ্যাকশন</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in prices" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td class="text-left">{{ row.price_label }}</td>
                            <td class="text-left">{{ row.product_name }}</td>
                            <td class="text-left">{{ row.unit_name }}</td>
                            <td class="text-left">{{ $en2bn(+row.price) }}</td>

                            <!-- 
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/product/price/edit?id='+row.id" v-if="$ck_action('/product/price/edit')">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    
                                    <nuxt-link to="#" v-if="$ck_action('/product/price/destroy')">
                                        <button class="btn btn-danger" @click="destroy(row.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                             -->
                        </tr>
                        <tr v-if="(prices).length==0">
                            <td colspan="5">কোনো প্রাইস লেবেল পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchPrice"/>
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
                kernel      : {},
                all_label   : [],
                units       : [],
                prices      : [],
                products    : [],
                search      : {
                    id      : '',
                    unit_id : '',
                    product_id:'',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchPrice();
            //
            this.http('product/price/list', 'all_label');
            //
            this.http('product/unit/list', 'units', {
                select:['id', 'unit_name']
            });
            //
            this.http('product/list', 'products', {
                select:['id', 'product_name']
            });
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchPrice();
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, প্রাইস লেবেল মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('product/price/destroy/'+id, 'destroy');
                    }
                })
            },
            fetchPrice(){
                console.log(this.search);
                this.loader = true;
                this.http('product/price/list', 'prices', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='prices'){
                        this.prices = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                    else if(key=='all_label'){
                        this.all_label = this.kernel[key].data;
                    }
                    else if(key=='units'){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='products'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        if(this.kernel[key].errors){
                            this.$toastr.s(this.kernel[key].errors);
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

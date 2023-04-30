<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-list"></i> ফিনিশ প্রোডাক্টের তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/finish/add" class="btn btn-primary" v-if="$ck_action('/product/finish/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন ফিনিশ প্রোডাক্টের যোগ করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <input type="text" v-model="search.voucher_no" class="form-control" placeholder="ভাউচার নাম্বার">
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <date-picker
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                v-model="search.date['from']"
                                v-bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <date-picker
                                placeholder="শেষ তারিখ নির্বাচন করুন"
                                v-model="search.date['to']"
                                v-bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-2">
                            <button type="button" @click="search.voucher_no=''; search.date['from']='';search.date['to']=''" class="btn btn-info"><i class="fa fa-history" aria-hidden="true"></i></button>
                            <button class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
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
                            <th class="text-left">তারিখ</th>
                            <th class="text-left">ভাউচার নাম্বার</th>
                            <th class="text-left">তৈরি কারকের নাম</th>
                            <th class="text-left">মোট পণ্য</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in vouchers" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td class="text-left">{{ $en2bn(row.date) }}</td>
                            <td class="text-left">{{ $en2bn(row.voucher_no) }}</td>
                            <td class="text-left">{{ row.user_name }}</td>
                            <td class="text-center">{{ $en2bn(row.total_item) }}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/product/finish/view?id='+row.id" v-if="$ck_action('/product/finish/view')">
                                        <button class="btn btn-info">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link :to="'/product/finish/edit?id='+row.id" v-if="$ck_action('/product/finish/edit')">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    <!-- // -->
                                    <nuxt-link to="#" v-if="$ck_action('/product/finish/destroy')">
                                        <button class="btn btn-danger" @click="destroy(row.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="(vouchers).length==0">
                            <td colspan="7">কোনো ভাউচার পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="getVouchers"/>
                </div>
                <!-- // -->
            </div>
            <Loader :loader="loader"/>
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
                all_product: [],
                categories : [],
                vouchers   : [],
                search     : {
                    id     : '',
                    cat_id : '',
                    date   : {to:'', from:''}
                },
                per_page   : 10,
                page_no    : 1,
                total_row  : 0,
                loader     : true,
            }
        },
        mounted(){
            this.getVouchers();
            //
            this.http('product/list', 'all_product', {
                select:['id', 'product_name']
            });
            //
            this.http('product/category/list', 'categories', {
                select:['id', 'category_name']
            });
        },
        methods:{
            number(value){
                return this.$en2bn(Number.parseFloat(value).toFixed(2));
            },
            filter(){
                this.page_no = 1;
                this.getVouchers();
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, ভাউচারটি মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('product/finish/destroy/'+id, 'destroy');
                    }
                })
            },
            getVouchers(){
                this.loader = true;
                this.http('product/finish/list', 'list', {
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
                    if(key=='list'){
                        this.vouchers   = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
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

<style>

</style>

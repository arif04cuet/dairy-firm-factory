<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-list"></i> স্টক পণ্যের তালিকা</h5>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <select v-model="type" class="form-control">
                                <option value="raw-milk">কাঁচা-দুধ </option>
                                <option value="raw-material">কাঁচামাল</option>
                                <option value="finish-product">ফিনিশ প্রোডাক্ট</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group" v-if="type!='raw-milk'">
                            <select v-model="search.product_id" class="form-control">
                                <option value="">পণ্যের তালিকা</option>
                                <option v-for="(row, key) in products" :value="row.id" :key="key" >{{row.product_name}} - ({{row.product_code}})</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group" v-if="type!='raw-milk'">
                            <select v-model="search.unit_id" class="form-control">
                                <option value="">পণ্যের ইউনিট</option>
                                <option v-for="(row, key) in units" :value="row.id" :key="key" >{{row.unit_name}})</option>
                            </select>
                        </div>
                        <!-- // -->
                        <div class="col-md-2">
                            <button class="btn btn-success">
                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                <span>সার্চ করুন </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- // -->
            <div class="table-responsive" v-if="!loader && type=='raw-milk'">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">ক্যাটাগরি</th>
                            <th class="text-right">পরিমান</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in vouchers" :key="index">
                            <td class="text-center">{{ $en2bn(++index) }}</td>
                            <td class="text-left">{{ row.category_name }}</td>
                            <td class="text-right">{{ $en2bn(row.quantity) }}&nbsp;লিটার</td>
                        </tr>
                        <tr v-if="(vouchers).length==0">
                            <td colspan="7">কোনো ভাউচার পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="stockList"/>
                </div>
                <!-- // -->
            </div>
            <!-- // -->
            <div class="table-responsive" v-if="!loader && type!='raw-milk'">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">ধরণ</th>
                            <th class="text-left">পণ্যের নাম</th>
                            <th class="text-left">পণ্যের কোড</th>
                            <th class="text-left">ইউনিটের নাম</th>
                            <th class="text-right">পরিমান</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in vouchers" :key="index">
                            <td class="text-center">{{ $en2bn(++index) }}</td>
                            <td class="text-left text-capitalize">{{ row.stockable_type }}</td>
                            <td class="text-left">{{ row.product_name }}</td>
                            <td class="text-left">{{ row.product_code }}</td>
                            <td class="text-left">{{ row.unit_name }}</td>
                            <td class="text-right">{{ $en2bn(row.quantity) }}</td>
                        </tr>
                        <tr v-if="(vouchers).length==0">
                            <td colspan="7">কোনো ভাউচার পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="stockList"/>
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
                type       : 'raw-milk',
                products   : [],
                units      : [],
                vouchers   : [],
                raw_milks  : [],
                search     : {
                    product_id : '',
                    unit_id    : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.stockList();
            //
            this.http('product/unit/list', 'unit-list', {
                select:['id', 'unit_name']
            });
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.stockList();
            },
            stockList(){
                this.loader = true;
                this.http('processing-plant/stock-list/'+this.type, 'list', {
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
                    else if(key=='product-list'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='unit-list'){
                        this.units = this.kernel[key].data;
                    }
                }
            },
            type:function(){
                this.vouchers = [];
                this.filter();
                if(this.type!='raw-milk'){
                    this.http('product/list', 'product-list', {
                        select:['id', 'product_name', 'product_code'],
                        type:this.type
                    });
                }
            }
        }
    }
</script>

<style>

</style>

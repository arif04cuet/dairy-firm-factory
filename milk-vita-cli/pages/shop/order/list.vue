<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সকল অর্ডারের তালিকা</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/shop/order/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;অর্ডার সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                           <input type="text" class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <input type="date" class="form-control" v-model="search.date['from']">
                        </div>
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <input type="date" class="form-control" v-model="search.date['to']">
                        </div>
                        <!-- // -->
                        <div class="col-md-2">
                            <button class="btn btn-success text-nowrap">
                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                সার্চ করুন&nbsp;
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>ভাউচার</th>
                            <th>এরিয়া</th>
                            <th>শপের নাম</th>
                            <th>শপের মোবাইল</th>
                            <th>স্টেটাস</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in shops" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.date}}</td>
                            <td>{{row.voucher_no}}</td>
                            <td>{{row.area_name}}</td>
                            <td>{{row.shop_name}}</td>
                            <td>{{row.shop_mobile}}</td>
                            <td>{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="view(row)" v-if="$ck_action('/shop/order/view')">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/shop/order/edit') && row.status=='pending'">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-success" @click="toPlace(row)" v-if="$ck_action('/shop/order/place') && row.status=='pending'">
                                        <i class="fa fa-paper-plane-o"></i>
                                    </button>

                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/shop/order/destroy') && row.status=='pending'">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(shops.length <= 0)">
                            <th colspan="8">কোনো অর্ডার পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="allOrder"/>
                </div>

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
                kernel    : {},
                areas     : [],
                shops     : [],
                search      : {
                    area_id : '',
                    date :{
                        from : '',
                        to   : ''
                    }
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.allOrder();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('area/list', 'areas', {
                select:['id', 'area_name_bn', 'area_name_en']
            });
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, এরিয়া মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('shop/order/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.allOrder();
            },
            edit(row){
                this.$router.push({path:'/shop/order/edit?id='+row.id});
            },
            view(row){
                this.$router.push({path:'/shop/order/view?id='+row.id});
            },
            toPlace(row){
                this.$router.push({path:'/shop/order/place?id='+row.id});
            },
            allOrder(){
                this.loader = true;
                this.http('shop/order/list', 'all-shop', {
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
                    if(key=='all-shop'){
                        this.shops = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='areas'){
                        this.areas = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.allOrder();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            }
        }
    }
</script>

<style>

</style>

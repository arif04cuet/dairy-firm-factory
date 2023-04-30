<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(26 91 208 / 84%)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#3561b7">মোট শপ অর্ডার</span>
                        <strong>{{$en2bn(data.total_shop_order)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> শপ অর্ডার সমূহ  </h5>
                            <!-- // -->
                            <form @submit.prevent="fetchData">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="search.association_code" placeholder="সমিতির কোড">
                                    </div>

                                    <div class="col-md-4">
                                        <button class="btn btn-success text-nowrap" >সার্চ করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                        <!-- // -->

                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
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
                                        <tr v-for="(row, index) in shop_orders" :key="index">
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
                                        <tr v-if="(shop_orders.length<=0 && !loading)">
                                            <th colspan="8">Data Not Found</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
                            </div>
                        </div>
                        <!-- // -->
                    </div>
                </div>
            </div>
        </div>
        <!-- LIST OF ALL MEMBERS OF AN ASSOCIATION -->
        <div v-if="association_id" class="popup">
            <div class="popup-box">
                <status-track v-model="association_id" ></status-track>
            </div>
        </div>
        <!-- // -->
    </div>
</div>
</template>

<script>
import Pagination from 'vue-pagination-2';
import Track from '@/components/association/Track.vue';
export default {
  components: { Pagination, 'status-track':Track},
    name:'',
    data(){
        return {
            search : {},
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                today_milk_collections : []
            },
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            shop_orders : [],
            association_id:'',
            
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
            this.fetchData();
    },
    methods:{
        track_stasus(association){
            this.association_id = association.id;
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
        fetchData(){
            this.loader = true;
            //
            this.http('shop/order/list', 'shop-order', {
                per_page    : this.per_page,
                page_no     : this.page_no,
                where       : this.search,
                type        : 'application-list'
            });
        },
        http(url, type, data=null){
            this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
        },
    },
    watch:{
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='shop-order'){
                    this.shop_orders = this.kernel[key].data;
                    this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading   = false;
                }
            }
        }
    }
}
</script>

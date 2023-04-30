<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(62 169 121 / 84%)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(80 140 111)">মোট ডিমান্ড</span>
                        <strong>{{$en2bn(data.total_demand)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(198 213 239 / 84%)">
                        <img src="@/assets/icons/pending.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#3561b7">মোট পেন্ডিং ডিমান্ড</span>
                        <strong>{{$en2bn(data.total_pending_demand)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(182 229 235)">
                        <img src="@/assets/icons/gift.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(89 148 156)">মোট ডিমান্ড চালান</span>
                        <strong>{{$en2bn(data.total_challan)}} টি</strong>
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
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> সকল ডিমান্ডের তালিকা </h5>
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
                                           <tr>
                                                <th width="50" class="text-center">ক্রমিক</th>
                                                <th>তারিখ</th>
                                                <th>ভাউচার</th>
                                                <th>ডিস্ট্রিবিউটর</th>
                                                <th>মোট আইটেম</th>
                                                <th>মোট পরিমান </th>
                                                <th>অবস্থা</th>
                                                <th width="70" class="text-center">অ্যাকশন</th>
                                            </tr>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(row, index) in demands" :key="index">
                                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                                            <td>{{row.date}}</td>
                                            <td>{{row.voucher_no}}</td>
                                            <td v-if="($auth.user.role_slug=='zone-supervisor')">{{row.distributor_name}}</td>
                                            <td>{{row.total_item}}</td>
                                            <td>{{row.total_quantity}}</td>
                                            <td class="text-capitalize">{{row.status}}</td>
                                            <td class="text-center">
                                                <div class="btn-group custom">
                                                    <button class="btn btn-info" @click="view(row)" v-if="$ck_action('/distributor/demand/view')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/distributor/demand/edit')">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    </button>

                                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/distributor/demand/destroy')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="(demands.length <= 0)">
                                            <th :colspan="($auth.user.role_slug=='zone-supervisor' ? 8 : 7)">কোনো ডিমান্ডের পাওয়া যায়নি </th>
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
            data   : {},
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            demands   : [],
            
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
            this.fetchData();
    },
    methods:{
        fetchData(){
            this.loader = true;
            //
            this.http('distributor/demand/list', 'all-demand', {
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
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='all-demand'){
                    this.demands   = this.kernel[key].data;
                    this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading   = false;
                }
            }
        }
    }
}
</script>

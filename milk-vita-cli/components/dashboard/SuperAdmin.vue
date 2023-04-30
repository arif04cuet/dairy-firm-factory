<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/user/access/all" class="info-box">
                    <div class="icon" style="background:rgb(229 231 235 / 84%)">
                        <img src="@/assets/icons/communities.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(94 94 99)">মোট ব্যবহারকারী</span>
                        <strong>{{$en2bn(data.total_user)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/chilling-plant/all" class="info-box">
                    <div class="icon" style="background:rgb(216 234 229)">
                        <img src="@/assets/icons/chilling-plant.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(111 136 129)">মোট চিলিং প্ল্যান্ট</span>
                        <strong>{{$en2bn(data.total_chilling_plat)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/processing-plant/all" class="info-box">
                    <div class="icon" style="background:rgb(217 239 212 / 84%)">
                        <img src="@/assets/icons/processing-plant.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(86 145 77)">মোট প্রসেসিং প্ল্যান্ট</span>
                        <strong>{{$en2bn(data.total_processing_plant)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/zone/list" class="info-box">
                    <div class="icon" style="background:rgb(205 215 233 / 84%)">
                        <img src="@/assets/icons/location.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(83 104 141)">মোট জোন</span>
                        <strong>{{$en2bn(data.total_zone)}} টি</strong>
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
                            <h5 class="m-0 pt-2"><i class="fa fa-list-alt" aria-hidden="true"></i> প্রস্তাবিত প্রাথমিক দুগ্ধ উৎপাদনকারী সমিতির তালিকাঃ  </h5>
                            <!-- // -->
                            <form @submit.prevent="fetchData">
                                <div class="row">
                                    <div class="col-md-5">
                                        <select class="form-control" v-model="search.id">
                                            <option value="">সমিতির নির্বাচন করুন</option>
                                            <option v-for="(row, index) in all_association" :key="index" :value="row.id">{{row.association_name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" v-model="search.association_code" placeholder="সমিতির কোড">
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-success float-right" >&nbsp;<i class="fa fa-search" aria-hidden="true"></i>&nbsp;</button>
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
                                            <th>প্রস্তাবিত সমিতির নাম</th>
                                            <th>কোড</th>
                                            <th>সমিতির কার্যকরী এলাকা</th>
                                            <th>দুগ্ধ এলাকার নাম</th>
                                            <th>সদস্যগনের সংখ্যা</th>
                                            <th class="text-center"> বর্তমান অবস্থা</th>
                                            <th width="70" class="text-center">অ্যাকশন</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(row, index) in paginate_associations" :key="index">
                                            <td class="text-center">{{$paginatedIndex(per_page, page_no, (index+1))}}</td>
                                            <td>{{row.association_name}}</td>
                                            <td>{{row.association_code ? row.association_code : '#'}}</td>
                                            <td>{{row.working_area_of_association}}</td>
                                            <td>{{row.name_of_dairy_area}}</td>
                                            <td>{{row.total_members}}</td>
                                            <td>{{row.last_status}}</td>
                                            <td class="text-center">
                                                <div class="btn-group custom">
                                                    <button @click="track_stasus(row)" class="btn btn-info mr-1">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </button>

                                                    <nuxt-link :to="'/association/application/details?id='+row.id" v-if="$ck_action('/association/application/details')">
                                                        <button  class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </nuxt-link>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="(paginate_associations.length<=0 && !loader)">
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
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                today_milk_collections : []
            },
            search : {
                id:'',
            },
            all_association : [],
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            paginate_associations     : [],
            association_id:'',
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.http('association/list', 'all_association', {
            select:['id', 'association_name'],
            type: 'survey-list'
        });
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
            this.http('association/list', 'paginate_associations', {
                per_page    : this.per_page,
                page_no     : this.page_no,
                where       : this.search,
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
                    this.data    = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='paginate_associations'){
                    this.paginate_associations = this.kernel[key].data;
                    this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading   = false;
                }
                if(key=='all_association'){
                    this.all_association = this.kernel[key].data;
                }
            }
        }
    }
}
</script>

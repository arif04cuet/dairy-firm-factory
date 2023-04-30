<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="#" class="info-box">
                    <div class="icon" style="background:rgb(166 222 153 / 53%)">
                        <img src="@/assets/icons/milk-jar.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(48 147 25)">বর্তমান দুধের স্টক</span>
                        <strong>{{$en2bn(data.milk_stock_quantity)}} লিটার</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/plant-manager/challan/request/list" class="info-box">
                    <div class="icon" style="background:rgb(26 91 208)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#1552c1">অপেক্ষমান সমিতির চালান</span>
                        <strong>{{$en2bn(data.total_incomplete_challan)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/plant-manager/challan/list" class="info-box">
                    <div class="icon" style="background:#D01A67">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#b3225d">অপেক্ষমান দুধের চালান</span>
                        <strong>{{$en2bn(data.total_pending_milk_challan)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/plant-manager/application/list" class="info-box">
                    <div class="icon" style="background:rgb(36 170 164 / 48%)">
                        <img src="@/assets/icons/communities.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#207c77">আবেদনকৃত সমিতির সংখ্যা</span>
                        <strong>{{$en2bn(data.total_applied_application)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> আবেদনকৃত সমিতির তালিকা </h5>
                            <!-- // -->
                        </div>  
                        <!-- // -->

                        <div>
                            <association-list
                                type="chilling-manager-application-list"
                            ></association-list>
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
import list from '@/components/association/AssociationList.vue';
export default {
    components : {'association-list':list},
    name:'',
    data(){
        return {
            search : {},
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                milk_stock_quantity : 0
            },
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page      : 1,
            demands : [],
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
        fetchData(){
            this.loader = true;
            //
            this.http('head-office/distributor/demand/list', 'distributor_demand', {
                per_page    : this.per_page,
                page_no     : this.page,
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
                else if(key=='distributor_demand'){
                    this.demands    = this.kernel[key].data;
                    this.total_row  = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading    = false;
                }
            }
        }
    }
}
</script>

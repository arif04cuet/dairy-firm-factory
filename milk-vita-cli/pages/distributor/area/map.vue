<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
                    <span>এরিয়া ম্যাপ</span>    
                </h4>
            </div>
        </div>

        <div class="card-body min75vh">

            <div class="row">
                <div class="col-md-6 border-right">
                    <ul>
                        <li>Name: {{user.name_bn}}</li>
                        <li>Mobile: {{user.mobile}}</li>
                        <li>E-mail: {{user.email}}</li>
                    </ul>
                    <hr>
                    <div>
                        <form @submit.prevent="zoneFilter()">
                            <div class="row">
                                <div class="col-md-8">
                                    <select-picker
                                        :options="zones"
                                        label="zone_name_bn"
                                        :reduce="(row)=>row.id"
                                        placeholder="Select Zone"
                                        v-model="zone_id"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                        <caption class="text-nowrap">এরিয়ার তালিকা</caption>
                        <ol class="area-grid" v-if="areas.length > 0">
                            <li v-for="(row, index) in areas" :key="index"><label :for="'zone'+index"><input :id="'zone'+index" @change="onChangeArea()" v-model="area_ids[index]" :checked="((old_ids.area_ids).indexOf(row.id) > -1 ? (area_ids[index]=row.id) : '')" :true-value="row.id" type="checkbox">&nbsp;{{row.area_name_bn}}</label></li>
                        </ol>
                        <span v-else >কোনো এরিয়া পাওয়া যায়নি</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <caption class="text-nowrap">শপের তালিকা </caption>
                        <ol class="area-grid" v-if="shops.length > 0">
                            <li v-for="(row, index) in shops" :key="index"><label :for="'area'+index"><input :id="'area'+index" type="checkbox" @change="storeMapData()" v-model="shop_ids[index]" :checked="((old_ids.shop_ids).indexOf(row.id) > -1 ? (shop_ids[index]=row) : '')" :true-value="row">&nbsp;{{row.shop_name_bn}} ({{row.area_name}})</label></li>
                        </ol>
                        <span v-else-if="loading.is_area==false" >কোনো শপের পাওয়া যায়নি</span>
                        <span v-else ><i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>&nbsp;অপেক্ষা করুন লোড হচ্ছে</span>
                    </div>
                </div>
            </div>
            <!-- // -->
            <Loader :loader="loader"/>
        </div>
        <div class="card-footer">&nbsp;</div>
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
                user        : {},
                areas       : [],
                shops       : [],
                per_page    : 10,
                page_no     : 1,
                total_row   : 0,
                zone_id     : '',
                loader      : true,
                search      : {},
                area_ids    : [],
                shop_ids    : [],
                zones       : [],
                loading     : {
                    is_area : false
                },
                old_ids : {
                    area_ids : [],
                    shop_ids : [],
                },
            }
        },
        mounted(){
            this.fetchUser();
        },
        methods:{
            fetchZones(){
                this.$axios.post('zone/list', {
                    select:['id', 'zone_name_bn', 'zone_name_en']
                })
                .then(res=>{
                    this.zones = res.data.data;
                });
            },
            zoneFilter(){
                this.fetchAreas();
                setTimeout(()=>{
                    this.onChangeArea();
                }, 300);
            },
            fetchMapData()
            {
                this.old_ids.area_ids = [];
                this.old_ids.shop_ids = [];
                //
                this.$axios.post('distributor/shop-map/data/'+this.user.id)
                .then(res=>{
                    this.old_ids.area_ids = (res.data.area_ids ? res.data.area_ids : []);
                    this.old_ids.shop_ids = (res.data.shop_ids ? res.data.shop_ids : []);
                    this.zoneFilter();
                });

                this.fetchZones();
            },
            storeMapData(){
                var shops = [];
                //
                (this.shop_ids).forEach(value=>{
                    if(value) {
                        value.zone_id        = this.zone_id;
                        value.distributor_id = this.user.id;
                        shops.push(value);
                    }
                });
                //
                this.$axios.post('distributor/shop-map/store/'+this.user.id, {shops:shops})
                .then(res=>{
                    if(res.data.errors){
                        this.$toastr.w(this.$msgSanitize(res.data.errors));
                    }
                    else {
                        this.$toastr.s("এরিয়া সফলভাবে পরিবর্তন হয়েছে");
                        // this.fetchMapData();
                    }
                });
            },
            onChangeArea(){
                this.loading.is_area = true;
                var ids = [];
                (this.area_ids).forEach((value)=>{
                    if(value)
                        ids.push(value);
                });
                this.fetchShop(ids);
            },
            fetchShop(area_ids=[]){
                this.shops = [];
                this.$axios.post('shop/list', {
                    whereIn:{
                        area_id:area_ids
                    }
                })
                .then(res=>{
                    if(res.data.data && (res.data.data).length > 0){
                        this.shops = (res.data.data).map(row=>{
                            var data = row; data.shop_id = row.id;
                            return data;
                        });
                    }
                    this.loading.is_area = false;
                });
            },
            fetchAreas(){
                this.loader = true;
                this.areas = [];
                this.$axios.post('area/list', {
                    where:{zone_id:this.zone_id}
                })
                .then(res=>{
                    if(res.data.data && (res.data.data).length > 0){
                        this.areas = res.data.data;
                    }
                    this.loader = false;
                });

            },
            fetchUser(){
                this.loader = true;
                this.user = [];
                this.$axios.post('user/all', {
                    where       : {
                        id:this.$route.query.id
                    },
                    slug        : 'distributor',
                }).then(res=>{
                    if(res.data.data && (res.data.data).length > 0){
                        this.user = res.data.data[0];
                        (this.user.zone_ids ? (this.zone_id = this.user.zone_ids[0].zone_id) : '');  
                        this.fetchMapData();    
                    }
                    this.loader = false;
                });
            },
        }
    }
</script>

<style scoped>
    .area-grid {
        user-select: none;
    }
    .area-grid li label {
        cursor: pointer;
    }
</style>

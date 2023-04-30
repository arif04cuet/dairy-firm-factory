<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    <span>সকল এরিয়ার তালিকা</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/area/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;এরিয়া সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.zone_id">
                                <option value="">জোন নির্বাচন করুন</option>
                                <option v-for="(row, index) in zones" :key="index" :value="row.id">{{row.zone_name_bn}}</option>
                            </select>
                        </div>
                        <Location class="col-md-6" v-model="locations">
                            <div class="row">
                                <div class="col-md-6 form-group" data-division></div>
                                <div class="col-md-6 form-group" data-district></div>
                            </div>
                        </Location>
                        <div class="col-md-2 text-right">
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
                            <th>জোনের নাম</th>
                            <th>লোকেশন</th>
                            <th>এরিয়ার নাম (BN)</th>
                            <th>এরিয়ার নাম (EN)</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <!-- // -->
                    <tbody>
                        <tr v-for="(row, index) in areas" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.zone_name}}</td>
                            <td><span v-if="row.area_details" v-for="(area, key) in row.area_details" :key="key">{{area.name ? area.name.bn : ''}}, </span></td>
                            <td>{{row.area_name_bn}}</td>
                            <td>{{row.area_name_en}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/area/edit')">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                    <!-- // -->
                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/area/destroy')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(areas.length <= 0)">
                            <th colspan="5">কোনো এরিয়া পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllarea"/>
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
                kernel          : {},
                zones          : [],
                areas     : [],
                search          : {
                    zone_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
                locations       : {}
            }
        },
        mounted(){
            this.fetchAllarea();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('zone/list', 'zones', {
                select:['id', 'zone_name_en', 'zone_name_bn']
            });
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, জোন মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('area/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.fetchAllarea();
            },
            edit(row){
                this.$router.push({path:'/area/edit?id='+row.id});
            },
            fetchAllarea(){
                this.loader = true;
                this.http('area/list', 'all-area', {
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
                    if(key=='all-area'){
                        this.areas = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='zones'){
                        this.zones = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.fetchAllarea();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            },
            locations(){
                this.search.division_id = this.locations.division_id;
                this.search.district_id = this.locations.district_id;
            }
        }
    }
</script>

<style>

</style>

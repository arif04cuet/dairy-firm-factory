<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল জোন তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/zone/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;জোন সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.processing_plant_id">
                                <option value="">প্রসেসিং প্ল্যান্ট নির্বাচন করুন</option>
                                <option v-for="(row, index) in plants" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>প্রসেসিং প্ল্যান্টের নাম</th>
                            <th>জোন নাম (BN)</th>
                            <th>জোন নাম (EN)</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in zones" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.processing_plant_name}}</td>
                            <td>{{row.zone_name_bn}}</td>
                            <td>{{row.zone_name_en}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/zone/edit')">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/zone/destroy')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(zones.length <= 0)">
                            <th colspan="5">কোনো ডিপার্টমেন্ট পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllzone"/>
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
                kernel          : {},
                plants          : [],
                zones     : [],
                search          : {
                    processing_plant_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllzone();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('processing-plant/all', 'all-plants', {
                select:['id', 'processing_plant_name']
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
                        this.http('zone/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.fetchAllzone();
            },
            edit(row){
                this.$router.push({path:'/zone/edit?id='+row.id});
            },
            fetchAllzone(){
                this.loader = true;
                this.http('zone/list', 'all-zone', {
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
                    if(key=='all-zone'){
                        this.zones = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='all-plants'){
                        this.plants = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.fetchAllzone();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল চিলিং প্ল্যান্ট তালিকা</h5>
                <div class="btn-group">
                    <!-- <nuxt-link to="/chilling-plant/add" class="btn btn-primary" v-if="$ck_action('/chilling-plant/add')">
                        <i class="fa fa-plus"></i>&nbsp;চিলিং প্ল্যান্ট সংযুক্ত করুন
                    </nuxt-link> -->
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="filter">
                <div class="row">
                    <Location v-model="location_data" class="col-md-12 row">
                        <div class="form-group col-md-3">
                            <label>বিভাগ</label>
                            <div data-division></div>
                        </div>

                        <div class="form-group col-md-3">
                            <label>জেলা</label>
                            <div data-district data-required="true"></div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="">চিলিং প্ল্যান্ট</label>
                            <select class="form-control" v-model="search.id">
                                <option value="">চিলিং প্ল্যান্ট নির্বাচন করুন</option>
                                <option v-for="(row, index) in all_chilling_plant" :key="index" :value="row.id">{{row.chilling_plant_name}}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 form-group">
                            <label for="">&nbsp;</label>
                            <div class="btn-group form-control p-0 bg-default">
                                <button class="btn btn-success">সার্চ করুন</button>
                                <button class="btn btn-info ml-1" type="button" @click="syncOffices()"><i class="fa fa-refresh" :class="(is_sysnc_runing==true?'fa-spin':'')" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </Location>
                </div>
            </form>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>চিলিং প্ল্যান্টের নাম</th>
                            <th>প্রসেসিং প্ল্যান্টের নাম</th>
                            <th>ঠিকানা</th>
                            <th>পুরো ঠিকানা</th>
                            <th>স্টক ক্যাপাসিটি</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in chilling_plants" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td>{{row.chilling_plant_name}}</td>
                            <td>{{row.processing_plant_name}}</td>
                            <td>
                                <span v-if="row.location_details" v-for="(area, key) in row.location_details" :key="key">{{area.name ? area.name.bn : ''}}, </span>
                            </td>
                            <td>{{row.full_address}}</td>
                            <td>{{row.stock_capacity}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/chilling-plant/edit')">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger" @click="destroy(row.id)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(chilling_plants.length <= 0)">
                            <th colspan="6">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllPlant"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>
    </div>
</template>
<script>

    import Location from '@/components/system/Location.vue';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Location
        },
        data(){
            return {
                kernel              : {},
                all_chilling_plant  : [],
                chilling_plants     : [],
                search              : {
                    id:'',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
                is_sysnc_runing : false,
                location_data   : {},
            }
        },
        mounted(){
            this.fetchAllPlant();
            // FETCH ALL CHILLING PLANT WITHOUT CONDITION
            this.http('chilling-plant/all', 'all-chilling-plant', {
                select:['id', 'chilling_plant_name']
            });
        },
        methods:{
            syncOffices(){
                this.is_sysnc_runing = true;
                this.http('office/synchronize', 'office-sync');
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, চিলিং প্লান্ট মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('chilling-plant/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.fetchAllPlant();
            },
            edit(row){
                this.$router.push({path:'/chilling-plant/edit?id='+row.id});
            },
            fetchAllPlant(){
                this.loader = true;
                this.http('chilling-plant/all', 'all-plant', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            location_data(){
                this.search.id = '';
                this.search.division_id = this.location_data.division_id;
                this.search.district_id = this.location_data.district_id;
                //
                this.http('chilling-plant/all', 'all-chilling-plant', {
                    select:['id', 'chilling_plant_name'],
                    where : this.search
                });
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-plant'){
                        this.chilling_plants = this.kernel[key].data;
                        this.total_row       = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='all-chilling-plant'){
                        this.all_chilling_plant = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("চিলিং প্লান্ট সফলভাবে মুছে ফেলা হয়েছে");
                            this.fetchAllPlant();
                        }
                    }
                    if(key=='office-sync'){
                        this.$toastr.s('সকল অফিস সিঙ্ক্রোনাইজ করা হয়েছে');
                        this.is_sysnc_runing = false;
                        this.filter();
                    }
                }
            }
        }
    }
</script>

<style>

</style>

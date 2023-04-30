<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">চিলিং প্ল্যান্ট যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/chilling-plant/all" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="submit(form)">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="" class="">চিলিং প্লান্টের নাম</label>
                            <input type="text" class="form-control" v-model="form.chilling_plant_name" placeholder="আপনার চিলিং প্লান্টের নাম লিখন" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="" class="">প্রসেসিং প্লান্টের নাম</label>
                            <select class="form-control" v-model="form.processing_plant_id">
                                <option value="">প্রসেসিং প্লান্ট নির্বাচন করুন</option>
                                <option v-for="(row, index) in processing_plants" :value="row.id" :key="index">{{row.processing_plant_name}}</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="" class="">স্টক ক্যাপাসিটি</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" v-model="form.stock_capacity" placeholder="স্টক ক্যাপাসিটি লিখন" required aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">লিটার</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <hr class="mt-0">
                        </div>
                        <!-- // -->
                        <div class="col-md-12">
                            <Location v-model="location_data">
                                <div class="row form-group">
                                    <label for="" class="col-md-3 text-md-right">বিভাগ</label>
                                    <div class="col-md-6" data-division></div>
                                </div>
                                <!-- // -->
                                <div class="row form-group">
                                    <label for="" class="col-md-3 text-md-right">জেলা</label>
                                    <div class="col-md-6" data-district data-required="true"></div>
                                </div>
                                <!-- // -->
                                <div class="row form-group">
                                    <label for="" class="col-md-3 text-md-right">উপজেলা</label>
                                    <div class="col-md-6" data-upazila data-required="true"></div>
                                </div>
                                <!-- // -->
                                <div class="row form-group">
                                    <label for="" class="col-md-3 text-md-right">ইউনিয়ন</label>
                                    <div class="col-md-6" data-union data-required="true"></div>
                                </div>
                            </Location>
                        </div>
                        
                        <div class="col-md-12">
                            <hr class="mt-0">
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="full_address">পুরো ঠিকানা লিখনঃ</label>
                            <textarea name="" id="full_address" v-model="form.full_address" class="form-control" cols="30" rows="4"></textarea>
                        </div>

                        <div class="col-md-12 text-right">
                            <div class="btn-group">
                                <button type="button" v-if="is_submit" class="btn btn-success float-right">
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                    <span>অপেক্ষা করুন</span>
                                </button>

                                <button type="submit" v-else class="btn btn-success float-right">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    <span>সংরক্ষণ করুন</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <Loader />
        </div>


    </div>
</template>
<script>
    import Location from '@/components/system/Location.vue';
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'Add',
        components : {
            Pagination,
            Location,
        },
        data(){
            return {
                kernel              : {},
                chilling_plants     : [],
                search              : {},
                processing_plants   : [],
                location_data       : {},
                is_submit           : false,

                form : {
                    chilling_plant_name : '',
                    processing_plant_id : '',
                    full_address        : '',
                },
            }
        },
        mounted(){
            this.http('location/divisions', 'divisions');
            this.http('processing-plant/all', 'plants', {
                select:['id', 'processing_plant_name']
            });
        },
        methods:{
            submit(form){
                this.is_submit = true;
                this.http('chilling-plant/store', 'store', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            checkLocation:function(type, id){
                var url = 'location/'+(type=='division' ? 'districts' : (type=='district' ? 'thanas' : ''));
                this.$axios.post(url, {where:{[type+'_id']:id}})
                .then(res=>{
                    if(type=='division'){
                        this.districts = res.data;
                    }
                    else if(type=='district'){
                        this.thanas = res.data;
                    }
                });
            }
        },
        watch:{
            location_data:function(){
                this.form.division_id = this.location_data.division_id; 
                this.form.district_id = this.location_data.district_id; 
                this.form.upazila_id  = this.location_data.upazila_id; 
                this.form.union_id    = this.location_data.union_id; 
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_parent_entities'){
                        this.parent_entities = this.kernel[key].data;
                    }
                    else if(key=='plants'){
                        this.processing_plants = this.kernel[key].data;
                    }
                    else if(key=='all_child_entities'){
                        this.child_entities = this.kernel[key].data;
                    }
                    else if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='store'){
                        this.is_submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('চিলিং প্লান্ট সফলভাবে সংরক্ষণ করা হয়েছে');
                            this.$router.push({path:'/chilling-plant/all'});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

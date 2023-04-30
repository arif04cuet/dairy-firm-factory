<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>এরিয়া যুক্ত করুন</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/area/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="submit()">
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right">এরিয়ার নাম (BN)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.area_name_bn" placeholder="এরিয়ার নাম লিখন (BN)" required>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right">এরিয়ার নাম (EN)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.area_name_en" placeholder="এরিয়ার নাম লিখন (EN)" required>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right">জোন</label>
                        <div class="col-md-6">
                            <select v-model="form.zone_id" class="form-control" required>
                                <option value="">জোন নির্বাচন করুন</option>
                                <option v-for="(row, index) in zones" :key="index" :value="row.id">{{row.zone_name_bn}}</option>
                            </select>
                        </div>
                    </div>
                    <!-- // -->
                    <Location v-model="location_data" v-if="is_loading==false">
                        <div class="form-group row">
                            <label class="col-md-3 text-right">বিভাগ</label>
                            <div class="col-md-6" data-division></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right">জেলা</label>
                            <div class="col-md-6" data-district data-required="true"></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right">উপজেলা</label>
                            <div class="col-md-6" data-upazila data-required="true"></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 text-right">ইউনিয়ন</label>
                            <div class="col-md-6" data-union data-required="true"></div>
                        </div>
                    </Location>

                    <div class="col-md-9 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success">
                                <div v-if="is_submit">
                                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    অপেক্ষা করুন
                                </div>
                                <div v-else >
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    আপডেট করুন
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Location from '@/components/system/Location.vue';
    export default {
        components:{Location},
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel     : {},
                zones  : [],
                form : {
                    zone_id:'',
                    area_name_en:'',
                    area_name_bn:'',
                },
                is_submit:false,
                location_data:{
                    district_id: 171,
                    division_id: 1428,
                    union_id: 1539,
                    upazila_id: 1536
                },
                is_loading: true,
            }
        },
        mounted(){
            this.http('zone/list', 'zones');
            this.http('area/list', 'area', {
                where:{
                    id:this.$route.query.id
                }
            })
        },
        methods:{
            submit(){
                this.is_submit = true;
                this.http('area/update/'+(this.$route.query.id), 'update-area', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='zones'){
                        this.zones = this.kernel[key].data;
                    }
                    else if(key=='update-area'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("জনের নামটি আপডেট করা হয়েছে");
                            this.$router.push({
                                path:'/area/list'
                            });
                        }
                        this.is_submit = false;
                    }
                    else if(key=='area'){
                        this.form = this.kernel[key].data[0];
                        this.location_data = {
                            division_id : this.form.division_id,
                            district_id : this.form.district_id,
                            upazila_id  : this.form.upazila_id,
                            union_id    : this.form.union_id,
                        }
                        this.is_loading = false;
                    }
                }
            },
            location_data(){
                this.form.division_id = this.location_data.division_id;
                this.form.district_id = this.location_data.district_id;
                this.form.upazila_id  = this.location_data.upazila_id;
                this.form.union_id    = this.location_data.union_id;
            }
        }
    }
</script>

<style>

</style>

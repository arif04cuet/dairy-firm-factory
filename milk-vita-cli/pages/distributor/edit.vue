<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">ডিস্ট্রিবিউটর এডিট করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/distributor/list" class="btn btn-primary">
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
                        <label class="col-md-3 text-right" for="">জোন</label>
                        <div class="col-md-6">
                            <select v-model="form.zone_id" class="form-control" required>
                                <option value="">জোন নির্বাচন করুন</option>
                                <option v-for="(row, index) in zones" :key="index" :value="row.id">{{row.zone_name_bn}}</option>
                            </select>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right" for="">ডিস্ট্রিবিউটর নাম (BN)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.distributor_name_bn" placeholder="ডিস্ট্রিবিউটর নাম লিখন" required>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right" for="">ডিস্ট্রিবিউটর নাম (EN)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.distributor_name_en" placeholder="ডিস্ট্রিবিউটর নাম লিখন" required>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right" for="">ডিস্ট্রিবিউটর মোবাইল</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.distributor_mobile" placeholder="ডিস্ট্রিবিউটর মোবাইল" required>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <label class="col-md-3 text-right" for="">ডিস্ট্রিবিউটর ঠিকানা</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="4" v-model="form.distributor_address" placeholder="ডিস্ট্রিবিউটর ঠিকানা"></textarea>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="form-group row">
                        <div class="col-md-9 text-right">
                            <div class="btn-group">
                                <!-- // -->
                                <button type="submit" class="btn btn-success" v-if="is_submit==false">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    সেইভ
                                </button>
                                <!-- // -->
                                <button type="button" class="btn btn-success" v-else >
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel     : {},
                zones  : [],
                form : {
                    processing_plant_id:'',
                    distributor_name_en:'',
                    distributor_name_bn:'',
                },
                is_submit:false,
            }
        },
        mounted(){
            this.http('zone/list', 'zones');
            this.http('distributor/list', 'distributor', {
                where:{
                    id:this.$route.query.id
                }
            })
        },
        methods:{
            submit(){
                this.http('distributor/update/'+(this.$route.query.id), 'update-distributor', this.form);
                this.submit = true;
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
                    else if(key=='update-distributor'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("জোনের নামটি আপডেট করা হয়েছে");
                            this.$router.push({
                                path:'/distributor/list'
                            });
                        }
                        this.submit = false;
                    }
                    else if(key=='distributor'){
                        this.form = this.kernel[key].data[0];
                    }
                }
            }
        }
    }
</script>

<style>

</style>

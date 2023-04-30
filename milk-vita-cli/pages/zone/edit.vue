<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">জোন এডিট করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/zone/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="submit()">
                    
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">চিলিং প্ল্যান্ট</label>
                            <select v-model="form.processing_plant_id" class="form-control" required>
                                <option value="">চিলিং প্ল্যান্ট নির্বাচন করুন</option>
                                <option v-for="(row, index) in all_plant" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">জোনের নাম (BN)</label>
                            <input type="text" class="form-control" v-model="form.zone_name_bn" placeholder="জোনের নাম লিখন" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">জোনের নাম (EN)</label>
                            <input type="text" class="form-control" v-model="form.zone_name_en" placeholder="জোনের নাম লিখন" required>
                        </div>
                    </div>

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
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel     : {},
                all_plant  : [],
                form : {
                    processing_plant_id:'',
                    zone_name_en:'',
                    zone_name_bn:'',
                },
                is_submit:false,
            }
        },
        mounted(){
            this.http('processing-plant/all', 'all_plant');
            this.http('zone/list', 'zone', {
                where:{
                    id:this.$route.query.id
                }
            })
        },
        methods:{
            submit(){
                this.http('zone/update/'+(this.$route.query.id), 'update-zone', this.form);
                this.submit = true;
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_plant'){
                        this.all_plant = this.kernel[key].data;
                    }
                    else if(key=='update-zone'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("জোনের নাম হালনাগাদ করা হয়েছে");
                            this.$router.push({
                                path:'/zone/list'
                            });
                        }
                        this.submit = false;
                    }
                    else if(key=='zone'){
                        this.form = this.kernel[key].data[0];
                    }
                }
            }
        }
    }
</script>

<style>

</style>

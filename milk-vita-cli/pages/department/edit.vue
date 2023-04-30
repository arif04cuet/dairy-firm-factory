<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">ডিপার্টমেন্ট যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/department/all" class="btn btn-primary">
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
                            <label for="">ডিপার্টমেন্টের নাম (BN)</label>
                            <input type="text" class="form-control" v-model="form.department_name_bn" placeholder="ডিপার্টমেন্টের নাম লিখন" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">ডিপার্টমেন্টের নাম (EN)</label>
                            <input type="text" class="form-control" v-model="form.department_name_en" placeholder="ডিপার্টমেন্টের নাম লিখন" required>
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
                    department_name_en:'',
                    department_name_bn:'',
                },
                is_submit:false,
            }
        },
        mounted(){
            this.http('processing-plant/all', 'all_plant');
            this.http('department/list', 'department', {
                where:{
                    id:this.$route.query.id
                }
            })
        },
        methods:{
            submit(){
                this.http('department/update/'+(this.$route.query.id), 'update-department', this.form);
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
                    else if(key=='update-department'){
                        this.submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("ডিপার্টমেন্ট নামটি আপডেট করা হয়েছে");
                            this.$router.push({
                                path:'/department/all'
                            });
                        }
                    }
                    else if(key=='department'){
                        this.form = this.kernel[key].data[0];
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-pencil-square-o"></i>&nbsp;
                    <span>শপ এডিট করুন</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/shop/list" class="btn btn-primary">
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
                            <label for="">এরিয়া</label>
                            <select v-model="form.area_id" class="form-control" required>
                                <option value="">এরিয়া নির্বাচন করুন</option>
                                <option v-for="(row, index) in areas" :key="index" :value="row.id">{{row.area_name_bn}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">শপের নাম (BN)</label>
                            <input type="text" class="form-control" v-model="form.shop_name_bn" placeholder="শপের নাম লিখন" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">শপের নাম (EN)</label>
                            <input type="text" class="form-control" v-model="form.shop_name_en" placeholder="শপের নাম লিখন" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">মোবাইল</label>
                            <input type="text" class="form-control" v-model="form.shop_mobile" placeholder="মোবাইল লিখন" required>
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
                areas  : [],
                form : {
                    area_id:'',
                    shop_name_en:'',
                    shop_name_bn:'',
                },
                is_submit:false,
            }
        },
        mounted(){
            this.http('area/list', 'areas');
            this.http('shop/list', 'shop', {
                where:{
                    id:this.$route.query.id
                }
            })
        },
        methods:{
            submit(){
                this.is_submit = true;
                this.http('shop/update/'+(this.$route.query.id), 'update-shop', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='areas'){
                        this.areas = this.kernel[key].data;
                    }
                    else if(key=='update-shop'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("দোকানের নাম সফলভাবে হালনাগাদ করা হয়েছে");
                            this.$router.push({
                                path:'/shop/list'
                            });
                        }
                        this.is_submit = false;
                    }
                    else if(key=='shop'){
                        this.form = this.kernel[key].data[0];
                    }
                }
            }
        }
    }
</script>

<style>

</style>

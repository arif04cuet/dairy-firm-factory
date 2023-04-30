<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-plus"></i>&nbsp;
                    <span>শপ যুক্ত করুন</span>
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
                   <!-- //  -->
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
                            <!-- // -->
                            <button type="submit" class="btn btn-success" v-if="is_submit==false">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                সেইভ
                            </button>

                            <button type="button" class="btn btn-success" v-else >
                                <i class="fa fa-spinner fa-spin fa-fw"></i>
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
                is_submit  : false,
                form : {
                    area_id : '',
                    shop_name_en : '',
                    shop_name_bn : '',
                },
            }
        },
        mounted(){
            this.http('area/list', 'areas');
        },
        methods:{
            submit(){
                this.is_submit = true;
                this.http('shop/store', 'add-shop', this.form);
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
                    else if(key=='add-shop'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("দোকানের নাম সফলভাবে সংরক্ষিত হয়েছে ");
                            this.$router.push({
                                path:'/shop/list'
                            });
                        }
                        this.is_submit = false;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

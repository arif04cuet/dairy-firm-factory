<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">পণ্যের ইউনিট তৈরি করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/unit/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit(form)">

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">পণ্যের উনিটের নাম </label>
                    <div class="col-md-7 form-group">
                        <input type="text" class="form-control" placeholder="পণ্যের উনিটের নাম লিখুন " v-model="form.unit_name" required />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সেইভ করুন</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel : {}, 
                form   : {
                    unit_name : ''
                },
            }
        },
        methods:{
            submit(form){
                this.http('product/unit/store', 'store', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("ইউনিট সফলভাবে সংরক্ষণ করা হয়েছে৷");
                            this.$router.push({path:'/product/unit/list'});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

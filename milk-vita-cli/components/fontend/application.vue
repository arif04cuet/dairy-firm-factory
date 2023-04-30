<template>
    <div class="card w100 min70vh">
        <div class="card-header">
            <h4 class="m-0">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;
                <span>{{type=='distributor' ? 'পরিবেশকের' : 'শপের'}} আবেদন</span>
            </h4>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="img-wrapper">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSo4EzIadT5BNjNZjfrYzGxUkdMT8EDoE-T3w&usqp=CAU" alt="">
                        </div>
                        <!-- // -->
                        <div class="choose">
                            <span>Chose Profile Photo</span>
                            <input type="file">
                        </div>
                    </div>

                    <!-- // -->
                    <div class="col-md-10">
                        <!-- // -->
                        <div class="row form-group" v-if="type=='shop'" >
                            
                            <label for="" class="col-md-2 text-right pt-2">শপের নাম (<small>BN</small>) <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" v-model="form.shop_name_bn" class="form-control" placeholder="শপের নাম (BN)" required>
                            </div>
                        </div>

                        <!-- // -->
                        <div class="row form-group" v-if="type=='shop'">
                            <label for="" class="col-md-2 text-right pt-2">শপের নাম (<small>EN</small>) <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" v-model="form.shop_name_en" class="form-control" placeholder="শপের নাম (EN)" required>
                            </div>
                        </div>

                        <!-- // -->
                        <div class="row form-group">
                            <label for="" class="col-md-2 text-right pt-2">নাম (<small>BN</small>) <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" v-model="form.name_bn" class="form-control" placeholder="নাম (BN)" required>
                            </div>
                        </div>

                        <!-- // -->
                        <div class="row form-group">
                            <label for="" class="col-md-2 text-right pt-2">নাম (<small>EN</small>) <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" v-model="form.name_en" class="form-control" placeholder="নাম (EN)" required>
                            </div>
                        </div>

                        <!-- // -->
                        <div class="row form-group">
                            <label for="" class="col-md-2 text-right pt-2">মোবাইল <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" v-model="form.mobile" class="form-control" placeholder="মোবাইল" required>
                            </div>
                        </div>
                        
                        <!-- // -->
                        <div class="row form-group">
                            <label for="" class="col-md-2 text-right pt-2">ইমেইল <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="email" v-model="form.email" class="form-control" placeholder="ইমেইল" required>
                            </div>
                        </div>

                        <!-- // -->
                        <div class="row form-group">
                            <label for="" class="col-md-2 text-right pt-2">মন্তব্য</label>
                            <div class="col-md-7">
                                <textarea name="" v-model="form.remarks" id="" cols="30" rows="3" class="form-control" placeholder="মন্তব্য"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- // -->
                    <div class="col-md-12">
                        <hr>
                        <Location v-model="location_data" class="row">
                            <div class="col-md-3 form-group m-md-0">
                                <label for="">বিভাগ <span class="text-danger">*</span></label>
                                <div data-division></div>
                            </div>

                            <div class="col-md-3 form-group m-md-0">
                                <label for="">জেল <span class="text-danger">*</span></label>
                                <div data-district></div>
                            </div>

                            <div class="col-md-3 form-group m-md-0">
                                <label for="">উপজেলা <span class="text-danger">*</span></label>
                                <div data-upazila></div>
                            </div>

                            <div class="col-md-3 form-group m-md-0">
                                <label for="">ইউনিয়ন <span class="text-danger">*</span></label>
                                <div data-union></div>
                            </div>
                        </Location>
                        <hr>
                    </div>

                    <!-- // -->
                    <div class="col-md-12 text-right">
                        <div class="btn-group">
                            <!-- // -->
                            <button type="button" v-if="is_submit==false" @click="cancel()" class="btn btn-info mr-1">
                                <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>
                                <span>বাতিল করুন</span>
                            </button>

                            <!-- // -->
                            <button :type="is_submit ? 'button': 'submit'" class="btn btn-success">
                                <i :class="is_submit ? 'fa fa-spinner fa-pulse fa-fw': 'fa fa-floppy-o' " aria-hidden="true"></i>
                                <span>{{(is_submit ? 'সাবমিট হচ্ছে ...' : 'সাবমিট করুন')}}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
var cookies = require('vue-cookies');
export default {
    props:['type'],
    data(){
        return {
            is_submit     : false,
            form          : {},
            location_data : {},
            end_url       : false,
            d_user_token  : "",
        }
    },
    mounted()
    {
        if(this.$route.query.token)
        {
            var token = this.$route.query.token;
            ///
            cookies.set('service_token', token);
            ///
            var param = Object.assign({}, this.$route.query);
            ///
            delete param.token;
            ///
            setTimeout(() => {this.$router.replace({param});}, 400);
        }
        this.tokenValidation();
    },
    methods:{
        tokenValidation(){
            var token = cookies.get('service_token');
            if(token){
                token = JSON.parse(atob(token));
                this.end_url      = token.end_url;
                this.d_user_token = token.user_token;
            }
        },
        submit(){
            this.is_submit = true;
            this.form.type = this.type;
            this.$axios.post('application', this.form)
            .then(res=>{
                if(res.data.errors){
                    this.$toastr.w(this.$msgSanitize(res.data.errors));
                }
                else {
                    this.$toastr.s("আপনার আবেদনটি সফলভাবে গ্রহণ করা হয়েছে");
                    //
                    if(this.end_url){
                        window.localStorage.serviceMessage = JSON.stringify({
                            status:'success',
                            message:'আপনার আবেদনটি সফলভাবে গ্রহণ করা হয়েছে'
                        });
                    }
                    else
                        this.$router.push({path:'/'});
                }
                this.is_submit = false;
            });
        },
        cancel(){
            if(this.end_url){
                window.localStorage.serviceMessage = JSON.stringify({
                    status:'fail',
                    message:'আপনার আবেদনটি বাতিল করা হয়েছে'
                });
            }
            else 
                this.$router.push({path:'/'});
        },
    },
    watch:{
        location_data(){
            this.form = Object.assign(this.form, this.location_data);
        }
    }
}
</script>



<style scoped>
    th, td {
        vertical-align: middle;
    }
    .img-wrapper {
        width: 100%;
        overflow: hidden;
        box-sizing: border-box;
        padding: 7px;
        border:1px solid #ddd;
    }
    .img-wrapper img{
        width: 100%;
    }
    .choose {
        width: 100%;
        height: 30px;
        background: #ddd;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .choose input[type='file'], .choose span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        opacity: 0;
        cursor: pointer;
    }
    .choose span {
        z-index: 998;
        opacity: 1;
        border: 1px solid #ddd;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
</style>
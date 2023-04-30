<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2" v-if="is_loading==false">
                    <i class="fa fa-list"></i>
                    <span>{{view_data.type=='shop' ? 'শপের' : (view_data.type=='distributor' ? 'পরিবেশকের' : 'ভ্যান ড্রাইভারের')}} আবেদন</span>
                </h5>
            </div>
        </div>
        <!-- // -->
        <div class="card-body min75vh">
            <div class="row" v-if="is_loading==false">
                <div class="col-md-2">
                    <div class="img-wrapper">
                        <img width="150" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSo4EzIadT5BNjNZjfrYzGxUkdMT8EDoE-T3w&usqp=CAU" alt="">
                    </div>
                </div>

                <!-- // -->
                <div class="col-md-10">
                    <!-- // -->
                    <div class="row form-group" v-if="view_data.type=='shop'">
                        <label for="" class="col-md-2 text-right">শপের নাম (<small>BN</small>) :</label>
                        <div class="col-md-7">
                            {{ view_data.shop ? view_data.shop.shop_name_bn : 'N/A' }}
                        </div>
                    </div>

                    <!-- // -->
                    <div class="row form-group" v-if="view_data.type=='shop'">
                        <label for="" class="col-md-2 text-right">শপের নাম (<small>EN</small>) :</label>
                        <div class="col-md-7">
                            {{ view_data.shop ? view_data.shop.shop_name_en : 'N/A' }}
                        </div>
                    </div>

                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-2 text-right">নাম (<small>BN</small>) :</label>
                        <div class="col-md-7">
                            {{ view_data.name_bn }}
                        </div>
                    </div>

                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-2 text-right">নাম (<small>EN</small>) :</label>
                        <div class="col-md-7">
                            {{ view_data.name_en }}
                        </div>
                    </div>

                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-2 text-right">মোবাইল :</label>
                        <div class="col-md-7">
                            {{ view_data.mobile }}
                        </div>
                    </div>
                    
                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-2 text-right">ইমেইল :</label>
                        <div class="col-md-7">
                            {{ view_data.email }}
                        </div>
                    </div>

                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-2 text-right">মন্তব্য :</label>
                        <div class="col-md-7">
                            {{ view_data.remarks }}
                        </div>
                    </div>
                </div>

                <!-- // -->
                <div class="col-md-12 text-right">
                    <div class="btn-group" v-if="view_data.status=='pending'">
                        <button @click="setStatus('rejected')" class="btn btn-danger">
                            <i :class="is_submit.reject ? 'fa fa-spinner fa-pulse fa-fw' : 'fa fa-times'" aria-hidden="true"></i>
                            <span>বাতিল করুন</span>
                        </button>
                        <!-- // -->
                        <button @click="setStatus('approved')" class="btn btn-success ml-1">
                            <i :class="is_submit.approve ? 'fa fa-spinner fa-pulse fa-fw' : 'fa fa-check-square-o'" aria-hidden="true"></i>
                            <span>অনুমোদন করুন</span>
                        </button>
                    </div>
                    <!-- // -->
                    <button v-else class="btn border p-2" :class="view_data.status=='rejected' ? 'border-danger' : 'border-success'">{{$local(view_data.status)}}</button>
                </div>
            </div>
            <Loader :loader="loader"/>
        </div>
        <!-- // -->
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel        : {},
                view_data     : {},
                is_submit     : {
                    reject  : false,
                    approve : false,
                },
                is_loading  : true,
            }
        },
        mounted(){
            this.http('application/view/'+this.$route.query.id, 'view');
        },
        methods:{
            setStatus(status){
                if(status=='rejected') this.is_submit.reject = true; else this.is_submit.approve = true;
                this.http('application/set-status', 'set-status', {status:status, app_id:this.$route.query.id})
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='view'){
                        if(this.kernel[key].errors) this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else this.view_data = this.kernel[key];
                        this.is_loading = false;
                    }
                    else if(key=='set-status'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else { 
                            this.$toastr.s("স্টেটাস সফলভাবে হালনাগাদ করা হয়েছে");
                            this.http('application/view/'+this.$route.query.id, 'view');
                        }
                        this.is_submit = {
                            reject  : false,
                            approve : false,
                        };
                    }
                }
            },
        }
    }
</script>

<style>

</style>

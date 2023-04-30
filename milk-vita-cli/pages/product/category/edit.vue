<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">পণ্যের ক্যাটাগরি আপডেট করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/category/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit(form)">
                <!-- /\\/ -->
                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="parent_category">প্যারেন্ট ক্যাটাগরির </label>
                    <div class="col-md-7 form-group">
                        <select v-model="form.parent_id" id="parent_category" class="form-control" required>
                            <option value="">প্যারেন্ট ক্যাটাগরি নির্বাচন করুন</option>
                            <option v-for="(row, index) in parents" :key="index" :value="row.id">{{row.category_name}}</option>
                        </select>
                    </div>
                </div>
                <!-- /\\/ -->
                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="parent_category">পণ্যের ক্যাটাগরির নাম </label>
                    <div class="col-md-7 form-group">
                        <input type="text" class="form-control" placeholder="পণ্যের ক্যাটাগরির নাম" v-model="form.category_name" required />
                    </div>
                </div>
                <!-- /\\/ -->
                <div class="row">
                    <div class="col-md-10 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;আপডেট করুন</button>
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
                    category_name : '',
                    parent_id:0
                },
                parents:[]
            }
        },
        mounted(){
            this.http('product/category/list', 'parents', {
                where:{parent_id:'0'}
            });

            if(this.$route.query.id){
                this.http('product/category/list', 'editable', {
                    where:{id:this.$route.query.id}
                });
            }
        },
        methods:{
            submit(){
                if(this.$route.query.id){
                    this.http('product/category/update/'+this.$route.query.id, 'store', this.form);
                }
                else {
                    this.$toastr.w('কিছু একটা সমস্যা! অনুগ্রহপূর্বক আবার চেষ্টা করুন');
                }
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
                            this.$toastr.s("ক্যাটাগরি সফলভাবে সংরক্ষণ করা হয়েছে৷");
                            this.$router.push({path:'/product/category/list'});
                        }
                    }
                    else if(key=='editable'){
                        if((this.kernel[key].data).length > 0){
                            this.form = this.kernel[key].data[0]
                        }
                    }
                    else if(key=='parents'){
                        this.parents = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

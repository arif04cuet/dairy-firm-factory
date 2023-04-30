<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">নতুন পণ্য যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit(form)">

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">পণ্যের নাম </label>
                    <div class="col-md-7 form-group">
                        <input type="text" class="form-control" placeholder="পণ্যের নাম" v-model="form.product_name" required />
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">পণ্যের কোড </label>
                    <div class="col-md-7 form-group">
                        <input type="text" class="form-control" placeholder="পণ্যের কোড" v-model="form.product_code" required />
                    </div>
                </div>

                <Category v-model="category_id">
                    <div class="row form-group">
                        <label class="col-md-3 text-right pt-2" for="product_category">ক্যাটাগরি নির্বাচন করুন </label>
                        <div class="col-md-7" data-category></div>
                    </div>

                    <div class="row form-group" data-sub_category_parent>
                        <label class="col-md-3 text-right pt-2" for="product_category">সাব-ক্যাটাগরি নির্বাচন করুন </label>
                        <div class="col-md-7" data-sub_category></div>
                    </div>
                </Category>

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">ভ্যাট(%) </label>
                    <div class="col-md-7 form-group">
                        <input type="number" class="form-control" placeholder="ভ্যাট(%)" min="0" v-model="form.vat" required />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;আপডেট করুন </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import Category from "@/components/system/Category";
    export default {
        layout:'admin',
        components:{Category},
        name:'all',
        data(){
            return {
                kernel : {}, 
                categories:[],
                category_id:'',
                form   : {
                    product_name : '',
                    product_code : '',
                    cat_id:'',
                    vat:0,
                },
            }
        },
        mounted(){
            this.http('product/category/list', 'categories');
            this.http('product/list', 'product', {
                where:{id:this.$route.query.id}
            });
        },
        methods:{
            submit(form){
                this.http('product/update/'+this.$route.query.id, 'update', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            category_id(){
                this.form.cat_id = this.category_id;
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='update'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("পণ্য সফলভাবে আপডেট করা হয়েছে৷");
                            this.$router.push({path:'/product/list'});
                        }
                    }
                    else if(key=='categories'){
                        this.categories = this.kernel[key].data;
                    }
                    else if(key=='product'){
                        if(this.kernel[key].data.length>0){
                            this.form = this.kernel[key].data[0];
                            this.category_id = this.form.cat_id;
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

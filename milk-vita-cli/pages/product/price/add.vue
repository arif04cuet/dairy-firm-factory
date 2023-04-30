<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">নতুন পণ্যের মূল্য যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/price/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit(form)">

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="product_category">পণ্য নির্বাচন করুন </label>
                    <div class="col-md-7 form-group">
                        <select  id="product_category" class="form-control" v-model="form.product_id" required>
                            <option value="">পণ্য নির্বাচন করুন</option>
                            <option v-for="(row, index) in products" :key="index" :value="row.id">{{row.product_name}}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="product_unit">ইউনিট নির্বাচন করুন </label>
                    <div class="col-md-7 form-group">
                        <select  id="product_unit" class="form-control" v-model="form.unit_id" required>
                            <option value="">পণ্যের ইউনিট নির্বাচন করুন</option>
                            <option v-for="(row, index) in units" :key="index" :value="row.id">{{row.unit_name}}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">মূল্যের লেবেল </label>
                    <div class="col-md-7 form-group">
                        <select class="form-control" v-model="form.price_label_id">
                            <option value="">মূল্যের লেবেল নির্বাচন করুন</option>
                            <option v-for="(row, key) in price_labels" :key="key" :value="row.id">{{row.label_name}}</option>
                        </select>
                        <!-- <input type="text" class="form-control" placeholder="মূল্যের লেবেল" v-model="form.price_label" required /> -->
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right pt-2" for="">পণ্যের মূল্য </label>
                    <div class="col-md-7 form-group">
                        <input type="number" min=1 class="form-control" placeholder="পণ্যের মূল্য" v-model="form.price" required />
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
                kernel   : {}, 
                units    :[],
                products : [],
                form     : {
                    product_id     : '',
                    unit_id        : '',
                    price_label_id : '',
                    price          : 0,
                },
                price_labels : [],
            }
        },
        mounted(){
            this.http('product/unit/list', 'units');
            this.http('product/list', 'products', {
                type:'finish-product'
            });
            this.http('product/price/label/list', 'price-label');
        },
        methods:{
            submit(form){
                this.http('product/price/store', 'store', this.form);
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
                            this.$toastr.s("মূল্যের লেবেল সফলভাবে সংরক্ষণ করা হয়েছে৷");
                            this.$router.push({path:'/product/price/list'});
                        }
                    }
                    else if(key=='units'){
                        this.units = this.kernel[key].data;
                    }
                    else if(key=='products'){
                        this.products = this.kernel[key].data;
                    }
                    else if(key=='price-label'){
                        this.price_labels = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

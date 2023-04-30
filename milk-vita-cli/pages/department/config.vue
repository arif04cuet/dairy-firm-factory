<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-cogs" aria-hidden="true"></i> &nbsp;ডিপার্টমেন্টের কনফিগারেশন</h5>
                <div class="btn-group">
                    <nuxt-link to="/department/all" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফেরেজান 
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <h6 class="m-0"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;{{department.department_name_bn}}</h6>
                <div class="row col-md-6">
                    <div class="col-md-8">
                        <select-picker 
                            placeholder="ম্যানেজার নির্বাচন করুন"
                            :options="users"
                            :reduce="row=>row.id"
                            v-model="manager_id"
                            label="name_bn"
                        />
                    </div>
                    <button class="btn btn-success col-md-4" @click="configStore">
                        <span v-if="is_submit==false"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;আপডেট করুন</span>
                        <span v-else ><i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>&nbsp;সাবমিট হচ্ছে...</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="border-bottom"><i class="fa fa-list-ul"></i>&nbsp;সকল পণ্যের তালিকা</h6>
                    <div class="custom-box">
                        <ul class="product-list">
                            <li v-for="(row, index) in product_list" :key="index" v-if="old_ids.indexOf(row.id) < 0"><label :for="index"><input type="checkbox" v-model="selected_list[index]" :true-value="row.id" false-value="" :id="index">&nbsp;{{row.product_name}}-<span class="text-success">(<small>{{row.category_name}}</small>)</span></label></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="border-bottom"><i class="fa fa-list-ul"></i>&nbsp;নির্বাচিত পণ্যের তালিকা</h6>
                    <div class="custom-box">
                        <ul class="product-list">
                            <li v-for="(row, index) in d_product_list" :key="index"><label :for="'f'+index"><input type="checkbox" :id="'f'+index" v-model="submited_product_ids[index]" :true-value="row.product_id" false-value="">&nbsp;<span v-html="row.product_name"></span></label></li>
                        </ul>
                    </div>
                </div>
            </div>
            <loader :loader="loader" />
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        data:()=>({
            kernel  : {},
            loader  : true,
            is_submit : false,
            product_list   : [],
            department     : {},
            d_product_list : [],
            selected_list  : [],
            submited_product_ids : [],
            old_ids : [],
            users   : [],
            manager_id : '',
        }),
        mounted(){
            this.http('product/list', 'product-list');
            this.http('department/config/'+(this.$route.query.id), 'config');
        },
        methods:{
            refreshIds(niddle){
                var balance = [];
                Object.values(this.d_product_list).forEach(product=>{
                    balance.push(product.product_id);
                });
                this.selected_list = [];
                //
                if(niddle=='submited'){
                    this.submited_product_ids = [];
                    this.submited_product_ids = balance;
                }
                else {
                    this.old_ids = [];
                    this.old_ids = balance;
                }
            },
            configStore(){
                this.is_submit = true;
                var ids = Object.values(this.selected_list).concat(Object.values(this.submited_product_ids));
                this.http('department/config-setup', 'config-setup', {
                    department_id : this.$route.query.id,
                    manager_id    : this.manager_id,
                    product_ids   : ids,
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            d_product_list(){
                this.refreshIds('submited')
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='product-list'){
                        this.product_list = this.kernel[key].data;
                        this.loader = false;
                    }
                    else if(key=='config'){
                        this.department = this.kernel[key].department;
                        this.d_product_list = this.kernel[key].product_list;
                        this.users          = this.kernel[key].users;
                        this.manager_id     = this.kernel[key].manager_id;
                        this.refreshIds();
                    }
                    else if(key=='config-setup'){
                        if(this.kernel[key].errors)
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else {
                            this.d_product_list = this.kernel[key];
                            this.refreshIds();
                            this.$toastr.s("সফলভাবে সাবমিট হয়েছে");
                        }
                        this.is_submit = false;
                    }
                }
            }
        }
    }
</script>


<style scoped>
    .custom-box {
        background: #ffffff75;
        height: 370px;
        overflow: auto;
    }
    ul.product-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    ul.product-list li {
        list-style: none;
        user-select: none;
        padding: 5px;
        padding-left: 7px;
    }
    ul.product-list li:nth-child(2n) {
        background: #dddddd4f;
    }
    ul.product-list li label {
        cursor: pointer;
        margin: 0!important;
        font-size: 14px;
        padding: 0;
        line-height: 0;
    }
</style>

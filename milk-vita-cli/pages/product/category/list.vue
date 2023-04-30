<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল পণ্যের ক্যাটাগরি</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/category/add" class="btn btn-primary" v-if="$ck_action('/product/category/add')">
                        <i class="fa fa-plus"></i>&nbsp;পণ্যের ক্যাটাগরি তৈরি করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select-picker
                                placeholder="ক্যাটাগরি নির্বাচন করুন"
                                v-model="search.parent_id" 
                                :options="all_category"
                                :reduce="row=>row.id"
                                label="category_name"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-2">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">ক্যাটাগরির নাম</th>
                            <th class="text-left">প্যারেন্ট ক্যাটাগরির</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in categories" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td class="text-left">{{ row.category_name }}</td>
                            <td class="text-left">{{ row.parent_category ? (row.parent_category).category_name : 'N/A' }}</td>
                            <td class="text-center">
                                <div class="btn-group custom" v-if="row.is_system!=1">
                                    <nuxt-link :to="'/product/category/edit?id='+row.id" v-if="$ck_action('/product/category/edit')">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    
                                    <!-- // -->
                                    <nuxt-link to="#" v-if="$ck_action('/product/category/destroy')">
                                        <button class="btn btn-danger" @click="destroy(row.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                                <!-- // -->
                                <span v-else class="btn-group custom">
                                    <button class="btn btn-primary disabled">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                    
                                    <!-- // -->
                                    <button class="btn btn-danger disabled">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                        <tr v-if="(categories).length==0">
                            <td colspan="4">কোনো ক্যাটাগরি পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchCategory"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
        },
        data(){
            return {
                kernel      : {},
                all_category: [],
                categories       : [],
                search              : {
                    parent_id:'',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchCategory();
            //
            this.http('product/category/list', 'all_category', {
                where:{parent_id:'0'}
            });
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchCategory();
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, ক্যাটাগরিটি মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('product/category/destroy/'+id, 'destroy');
                    }
                })
            },
            fetchCategory(){
                this.loader = true;
                this.http('product/category/list', 'categories', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='categories'){
                        this.categories = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                    else if(key=='all_category'){
                        this.all_category = this.kernel[key].data;
                        console.log(this.kernel[key].data);
                    }
                    else if(key=='destroy'){
                        if(this.kernel[key].errors){
                            this.$toastr.s(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('সফলভাবে মুছে ফেলা হয়েছে');
                            this.filter();
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সকল শপের তালিকা</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/shop/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;শপ সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.area_id">
                                <option value="">এরিয়া নির্বাচন করুন</option>
                                <option v-for="(row, index) in areas" :key="index" :value="row.id">{{row.area_name_bn}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success text-nowrap">
                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                সার্চ করুন&nbsp;
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>এরিয়া</th>
                            <th>শপের নাম (BN)</th>
                            <th>শপের নাম (EN)</th>
                            <th>মোবাইল</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in shops" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.area_name}}</td>
                            <td>{{row.shop_name_bn}}</td>
                            <td>{{row.shop_name_en}}</td>
                            <td>{{row.shop_mobile}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)" v-if="$ck_action('/shop/edit')">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger" @click="destroy(row.id)" v-if="$ck_action('/shop/destroy')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(shops.length <= 0)">
                            <th colspan="5">কোনো শপ পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllshop"/>
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
                kernel          : {},
                areas          : [],
                shops     : [],
                search          : {
                    area_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllshop();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('area/list', 'areas', {
                select:['id', 'area_name_bn', 'area_name_en']
            });
        },
        methods:{
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, এরিয়া মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('shop/destroy/'+id, 'destroy');
                    }
                })
            },
            filter(){
                this.page_no = 1;
                this.fetchAllshop();
            },
            edit(row){
                this.$router.push({path:'/shop/edit?id='+row.id});
            },
            fetchAllshop(){
                this.loader = true;
                this.http('shop/list', 'all-shop', {
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
                    if(key=='all-shop'){
                        this.shops = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='areas'){
                        this.areas = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        this.fetchAllshop();
                        this.$toastr.s("সফলভাবে মুছে ফেলা হয়েছে");
                    }
                }
            }
        }
    }
</script>

<style>

</style>

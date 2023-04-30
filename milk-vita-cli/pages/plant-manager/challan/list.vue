<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2"><i class="fa fa-fax" aria-hidden="true"></i> চালানের তালিকা</h4>
                <div class="btn-group">
                    <nuxt-link to="/plant-manager/challan/add" class="btn btn-primary" v-if="$ck_action('/plant-manager/challan/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন চালান করুন
                    </nuxt-link>
                </div>
            </div>
        </div>

        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <!-- // -->
                        <div class="col-md-3 form-group">
                            <input class="form-control" v-model="search.voucher_no" placeholder="ভাউচার নাম্বার">
                        </div>
                        <!-- // -->
                        <div class="col-md-4 form-group">
                            <date-picker
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                class="form-control p-0"
                                v-model="search.date['from']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-4 form-group">
                            <date-picker
                                placeholder="শেষ তারিখ নির্বাচন করুন"
                                class="form-control p-0"
                                v-model="search.date['to']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-1 form-group">
                            <button class="btn btn-success text-nowrap"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" v-if="!loader">
                
                <table class="table table-bordered table-hover custom">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>চালান নাম্বার</th>
                            <th>দুগ্ধ পরিমান</th>
                            <th class="text-center"> বর্তমান অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- // -->
                        <tr v-for="(row, index) in challans" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td>{{$en2bn(row.date)}}</td>
                            <td>{{$en2bn(row.voucher_no)}}</td>
                            <td>{{$en2bn(row.amount ? row.amount : 0)}}&nbsp;লিটার</td>
                            <td class="text-capitalize">{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/plant-manager/challan/view?id='+row.id" v-if="$ck_action('/plant-manager/challan/view') && row.is_submit==1">
                                        <button class="btn btn-success mr-1"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </nuxt-link>

                                    <nuxt-link :to="'/plant-manager/challan/add?id='+row.id" v-if="row.is_driver_receive==0 && $ck_action('/plant-manager/challan/add')">
                                        <button class="btn btn-info"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                    </nuxt-link>

                                    <!-- <nuxt-link :to="'/plant-manager/challan/edit?id='+row.id" v-if="row.is_driver_receive==0 && $ck_action('/plant-manager/challan/edit')">
                                        <button class="btn btn-info"><i class="fa fa-pencil-square-o"></i></button>
                                    </nuxt-link> -->
                                </div>
                            </td>
                        </tr>
                        <!-- // -->
                        <tr v-if="(challans.length<=0 && !loader)">
                            <th colspan="8">কোনো তথ্য পাওয়া যায়নি</th>
                        </tr>
                        <!-- // -->
                    </tbody>
                </table>
            </div>

            <Loader :loader="loader" />
            <div class="d-flex justify-content-end">
                <pagination v-model="page" :records="total_row" :per-page="per_page" @paginate="fetchChallanList"/>
            </div>
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
                kernel   : {},
                challans : [],
                search   : {},
                total_row: 0,
                per_page : 10,
                page     : 1,
                loader   : true,
                search   : {
                    date:{
                        from:this.$date()
                    },
                    // is_submit:1
                },
            }
        },
        mounted(){
            this.fetchChallanList();
        },
        methods:{
            destroy(challan_id){
                this.$alert({
                    text: "আপনি কি নিশ্চিত চালানটি ডিলিট করতে চান ?",
                    icon: "question",
                    showCancelButton:  true,
                    cancelButtonText:  'না',
                    confirmButtonText: 'হ্যাঁ'
                })
                .then(result=>{
                    if(result.isConfirmed) {
                        this.http('chilling-plant/challan/delete/'+challan_id, 'delete');
                    }
                });
            },
            fetchChallanList(){
                this.loader = true;
                this.http('chilling-plant/challan/list', 'list', { 
                    where: this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            filter(){
                this.page = 1;
                this.fetchChallanList();
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='list'){
                        this.total_row  = (this.kernel[key].total_row ? this.kernel[key].total_row : 0);
                        this.challans   = (this.kernel[key].data ? this.kernel[key].data : []);
                        this.loader     = false;
                    }
                    else if(key=='delete'){
                        if(this.kernel[key].erros){
                            this.$toastr.w(this.kernel[key].erros);
                        }
                        else {
                            this.fetchChallanList();
                            this.$toastr.s('চালানটি সফলভাবে মুছে ফেলা হয়েছে');
                        }
                    }
                }
            }
        }
    }
</script>


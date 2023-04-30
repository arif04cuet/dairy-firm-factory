<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    ফর্মুলেশন এস্টিমেট
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/reports/formulation-sheet/add" class="btn btn-primary" v-if="$ck_action('/reports/formulation-sheet/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন যোগ করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4">
                            <date-picker
                                placeholder="শুরুর তারিখ নির্বাচন করুন"
                                v-model="search.date['from']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <div class="col-md-4">
                            <date-picker
                                placeholder="শেষের তারিখ নির্বাচন করুন"
                                v-model="search.date['to']"
                                :bind="$local('bind')"
                                :locale="$store.state.local"
                            />
                        </div>
                        <div class="col-md-2 form-group">
                            <button class="btn btn-primary text-nowrap">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>পণ্যের নাম</th>
                            <th>উজার</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in records" :key="index">
                            <td class="text-center">{{$en2bn(index+1)}}</td>
                            <td>{{row.date}}</td>
                            <td>{{row.product_name}}</td>
                            <td>{{row.user_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/reports/formulation-sheet/view?id='+row.id" v-if="$ck_action('/reports/formulation-sheet/view')">
                                        <button title="রেজোলিউশন দেখুন" class="btn btn-info" >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(records.length <= 0)">
                            <th colspan="11">কোনো তথ্য পাওয়া যায়নি</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllResolution"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel     : {},
                records    : [],
                search     : {
                    date : {
                        from:this.$date(),
                        to:'',
                    },
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllResolution();
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchAllResolution();
            },
            fetchAllResolution(){
                this.loader = true;
                this.http('report/formula-estimate/list', 'records', {
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
                    if(key=='records'){
                        this.records    = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                }
            }
        }
    }
</script>

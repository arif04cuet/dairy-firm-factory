<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সংশোধনের জন্য প্রেরিত অবেদনসমূহের তালিকাঃ</h5>
                <div class="btn-group">
                    <nuxt-link to="/association/add" class="btn btn-primary" v-if="$ck_action('/association/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন সমিতি সংযুক্ত করুন
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <select class="form-control" v-model="search.id">
                                <option value="">সমিতির নির্বাচন করুন</option>
                                <option v-for="(row, index) in all_association" :key="index" :value="row.id">{{row.association_name}}</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" class="form-control" v-model="search.association_code" placeholder="সমিতির কোড">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" >সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                <table class="table table-bordered table-hover custom">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>প্রস্তাবিত সমিতির নাম</th>
                            <th>কোড</th>
                            <th>সমিতির কার্যকরী এলাকা</th>
                            <th>দুগ্ধ এলাকার নাম</th>
                            <th>সদস্যগনের সংখ্যা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in paginate_associations" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td>{{row.association_name}}</td>
                            <td>{{row.association_code ? row.association_code : '#'}}</td>
                            <td>{{row.working_area_of_association}}</td>
                            <td>{{row.name_of_dairy_area}}</td>
                            <td>{{row.total_members}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <div class="input-group-append">
                                        <nuxt-link :to="'/association/applied/correction?id='+row.id">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </nuxt-link>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr v-if="(paginate_associations.length<=0 && !loader)">
                            <th colspan="7">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Loader :loader="loader"/>
            <div class="d-flex justify-content-end">
                <pagination v-model="page" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
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
            Pagination
        },
        data(){
            return {
                kernel                : {},
                paginate_associations : [],
                all_association       : [],
                search                : { id : '', association_code : '',},
                user                  : '',
                total_row             : 0,
                per_page              : 10,
                page                  : 1,
                is_quick_info         : false,
                loader                : true,
            }
        },
        mounted(){
            this.user = this.$store.state.auth.user;
            this.fetchData();
            this.http('association/list', 'all_association', {
                select:['id', 'association_name'],
                type: 'correction-list'
            });
        },
        methods:{
            fetchData:function(){
                this.loader = true;
                this.http('association/list', 'paginate_associations', {
                    per_page    : this.per_page,
                    page_no     : this.page,
                    where       : this.search,
                    type        : 'correction-list'
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page, index);
            },
            filter:function(){
                this.fetchData();
            },
            view_details:function(association_id){
                this.$router.push({path:'/association/applied/details?id='+association_id});
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_association'){
                        this.all_association = this.kernel[key].data;
                    }
                    else if(key=='paginate_associations'){
                        this.paginate_associations   = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                        this.loader = false;
                    }
                }
            }
        }
    }
</script>

<style>
    .VuePagination__count  {
        display: none!important;;
    }
    /* .popup-box {
        width: 65%!important;
    } */
</style>

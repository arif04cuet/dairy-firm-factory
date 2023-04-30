<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    রেজোলিউশন তালিকা
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/field-officer/meeting-resolution/new" class="btn btn-primary" v-if="$ck_action('/field-officer/meeting-resolution/new')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন মিটিং যোগ করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.association_id">
                                <option value="">সমিতি নির্বাচন করুন</option>
                                <option v-for="(row, index) in associations" :key="index" :value="row.id">{{row.association_name}}</option>
                            </select>
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
                            <th>সমিতি</th>
                            <th>মিটিং-এর তারিখ</th>
                            <th>মিটিং-এর শিরোনাম</th>
                            <th>বর্তমান অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in resolution_list" :key="index">
                            <td class="text-center">{{$en2bn(index+1)}}</td>
                            <td>{{row.association_name}}</td>
                            <td>{{row.meeting_date}}</td>
                            <td>{{row.meeting_title}}</td>
                            <td>{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/field-officer/meeting-resolution/meeting?id='+row.id" v-if="row.is_done==0 && $ck_action('/field-officer/meeting-resolution/meeting')">
                                        <button title="মিটিং এর জন্য প্রস্তুত" class="btn btn-primary">
                                            <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>

                                    <nuxt-link :to="'/field-officer/meeting-resolution/details?id='+row.id" v-else-if="$ck_action('/field-officer/meeting-resolution/details')">
                                        <button title="রেজোলিউশন দেখুন" class="btn btn-info" >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(resolution_list.length <= 0)">
                            <th colspan="6">Data Not Found</th>
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
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
        },
        data(){
            return {
                kernel              : {},
                associations        : [],
                resolution_list    : [],
                search              : {
                    association_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllResolution();
            //
            this.http('association/list', 'associations', {
                type:'chairman-approve-list'
            });
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchAllResolution();
            },
            fetchAllResolution(){
                this.loader = true;
                this.http('meeting-resolution/list', 'meeting-list', {
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
                    if(key=='meeting-list'){
                        this.resolution_list = this.kernel[key].data;
                        this.total_row       = this.kernel[key].total_row;
                        this.loader          = false;
                    }
                    else if(key=='associations'){
                        this.associations = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

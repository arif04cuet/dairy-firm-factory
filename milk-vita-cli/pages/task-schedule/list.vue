<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সমস্ত সময়সূচী</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/task-schedule/add" v-if="$ck_action('/task-schedule/add')" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;সময়সূচী যোগ করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <date-picker 
                                v-model="search.start_date"
                                placeholder="শুরুর তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-4 form-group">
                            <date-picker 
                                v-model="search.end_date"
                                placeholder="শেষ তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                        <!-- // -->
                        <div class="col-md-4">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info text-nowrap" @click="()=>{this.search.start_date=''; this.search.end_date=''; this.filter()}"><i class="fa fa-history" aria-hidden="true"></i></button>
                                &nbsp;
                                <button class="btn btn-success text-nowrap"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
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
                            <th>শুরুর তারিখ</th>
                            <th>শেষ তারিখ</th>
                            <th>বিষয়</th>
                            <th>বর্ণনা</th>
                            <th>স্টেটাস</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in records" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{$en2bn(row.date)}}</td>
                            <td>{{$en2bn(row.start_date)}}</td>
                            <td>{{$en2bn(row.end_date)}}</td>
                            <td>{{row.subject}}</td>
                            <td>{{row.description}}</td>
                            <td class="text-capitalize">{{row.status}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="$router.push({path:'/task-schedule/view?id='+row.id})" v-if="$ck_action('/task-schedule/view')">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="btn btn-primary" @click="$router.push({path:'/task-schedule/edit?id='+row.id})" v-if="$ck_action('/task-schedule/edit') && row.status=='pending'">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(records.length <= 0)">
                            <th colspan="8">কোনো টাস্ক পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchRecords"/>
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
                kernel    : {},
                areas     : [],
                records     : [],
                search      : {
                    area_id : '',
                    date :{
                        from : '',
                        to   : ''
                    }
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchRecords();
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchRecords();
            },
            fetchRecords(){
                this.loader = true;
                this.http('task-schedule/list', 'record', {
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
                    if(key=='record'){
                        this.records    = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

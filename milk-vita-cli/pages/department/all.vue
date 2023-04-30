<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল ডিপার্টমেন্টের তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/department/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;ডিপার্টমেন্টের সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select class="form-control" v-model="search.processing_plant_id">
                                <option value="">প্রসেসিং প্ল্যান্ট নির্বাচন করুন</option>
                                <option v-for="(row, index) in plants" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                            </select>
                        </div>
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
                            <th>প্রসেসিং প্ল্যান্টের নাম</th>
                            <th>ডিপার্টমেন্টের নাম (BN)</th>
                            <th>ডিপার্টমেন্টের নাম (EN)</th>
                            <th>ম্যানেজারের নাম</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in departments" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td>{{row.processing_plant_name}}</td>
                            <td>{{row.department_name_bn}}</td>
                            <td>{{row.department_name_en}}</td>
                            <td>{{row.manager_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="$router.push({path:'/department/config?id='+row.id})">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                    </button>
                                    <!-- // -->
                                    <button class="btn btn-primary" @click="edit(row)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                    <!-- // -->
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(departments.length <= 0)">
                            <th colspan="5">কোনো ডিপার্টমেন্ট পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllDepartment"/>
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
                kernel          : {},
                plants          : [],
                departments     : [],
                search          : {
                    processing_plant_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllDepartment();
            // FETCH ALL PROCESSING PLANT WITHOUT CONDITION
            this.http('processing-plant/all', 'all-plants', {
                select:['id', 'processing_plant_name']
            });
        },
        methods:{
            filter(){
                this.fetchAllDepartment();
            },
            edit(row){
                this.$router.push({path:'/department/edit?id='+row.id});
            },
            fetchAllDepartment(){
                this.loader = true;
                this.http('department/list', 'all-department', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-department'){
                        this.departments = this.kernel[key].data;
                        this.total_row   = this.kernel[key].total_row;
                        this.loader = false;
                    }
                    else if(key=='all-plants'){
                        this.plants = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    <span>আবেদন সমূহের তালিকা</span>
                </h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" class="form-control" v-model="search.mobile" placeholder="মোবাইল নাম্বার">
                        </div>
                        <Location class="col-md-8" v-model="locations">
                            <div class="row">
                                <div class="col-md-4 form-group" data-division></div>
                                <div class="col-md-4 form-group" data-district></div>
                                <div class="col-md-4 form-group" data-upazila></div>
                            </div>
                        </Location>
                        <div class="col-md-2 text-right">
                            <button class="btn btn-success text-nowrap">
                                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                সার্চ করুন&nbsp;
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- // -->
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>নাম (<small>BN</small>)</th>
                            <th>নাম (<small>EN</small>)</th>
                            <th>মোবাইল</th>
                            <th>ইমেইল</th>
                            <th>ঠিকানা</th>
                            <th>টাইপ</th>
                            <th>বর্তমান অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in applications" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.name_bn}}</td>
                            <td>{{row.name_en}}</td>
                            <td>{{row.mobile}}</td>
                            <td>{{row.email}}</td>
                            <td>
                                <span v-if="row.address_details" v-for="(address, key) in row.address_details" :key="key">{{address.name ? address.name.bn : ''}}, </span>
                            </td>
                            <td class="text-capitalize">{{$local('bn.'+row.type)}}</td>
                            <td>{{$local(row.status)}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link class="btn btn-success" :to="'/application/view?id='+row.id" v-if="$ck_action('/application/view')">
                                        <i class="fa fa-eye"></i>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(applications.length <= 0)">
                            <th colspan="9">কোনো আবেদন পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchApplications"/>
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
                applications    : [],
                search          : {},
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
                locations       : {}
            }
        },
        mounted(){
            this.fetchApplications();
            
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchApplications();
            },
            fetchApplications(){
                this.loader = true;
                this.http('application/list', 'applications', {
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
                    if(key=='applications'){
                        console.log(this.kernel[key].data);
                        this.applications = this.kernel[key].data;
                        this.total_row    = this.kernel[key].total_row;
                        this.loader       = false;
                    }
                }
            },
            locations(){
                this.search.division_id = this.locations.division_id;
                this.search.district_id = this.locations.district_id;
                this.search.upazila     = this.locations.upazila;
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    <span>দুধের স্ট্যান্ডার্ডাইজেশন সিট</span>
                </h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="fetchRecords">
                <div class="row">
                    <div class="col-md-4">
                        <select-picker 
                            placeholder="প্রসেসিং প্লান্ট নির্বাচন করুন"
                            v-model="search.processing_plant_id"
                            :options="processing_plants"
                            :reduce="row=>row.id"
                            label="processing_plant_name"
                        />
                    </div>
                    <!-- // -->
                    <div class="col-md-3">
                        <date-picker 
                            v-model="search.date['from']"
                            v-bind="$local('bind')"
                            :locale="$store.state.local"
                        />
                    </div>
                    <!-- // -->
                    <div class="col-md-3">
                        <date-picker 
                            v-model="search.date['to']"
                            v-bind="$local('bind')"
                            :locale="$store.state.local"
                        />
                    </div>
                    <!-- // -->
                    <div class="col-md-2 text-left">
                        <button class="btn btn-success text-nowrap">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            সার্চ করুন&nbsp;
                        </button>
                    </div>
                </div>
            </form>
            <hr>
            <!-- // -->
            <div v-for="(challan, index) in challans" :key="index">
                <!-- // -->
                <div class="table-response mt-md-3">
                    <caption class="text-nowrap m-0 pt-0">{{ challan.chilling_plant_name }}</caption>
                    <table class="table table-bordered part-1 challan-table bg-light">
                        <tr>
                            <th class="p-1" colspan="3">তরল দুধের পরিমান</th>
                            <th class="p-1" colspan="2">ফ্যাট</th>
                            <th class="p-1" colspan="2">এস এন এফ</th>
                        </tr>
                        
                        <tr>
                            <th class="p-1">পরিমান (লিটার)</th>
                            <th class="p-1">ঘনত্ব</th>
                            <th class="p-1">পরিমান (কেজি)</th>
                            <!-- // -->
                            <th class="p-1">%</th>
                            <th class="p-1">কেজি</th>
                            <!-- // -->
                            <th class="p-1">%</th>
                            <th class="p-1">কেজি</th>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_liter)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_density)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_kg)}}</td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_fat_persentase)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_fat_kg)}}</td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_snf_persentase)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.clpt_snf_kg)}}</td>
                        </tr>
                        <br>
                        <!-- // -->
                        <tr>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_liter)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_density)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_kg)}}</td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_fat_persentase)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_fat_kg)}}</td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_snf_persentase)}}</td>
                            <td rowspan="2" class="custom-challan-row">{{$en2bn(challan.prpt_snf_kg)}}</td>
                        </tr>

                    </table>
                </div>
            </div>

            <div v-if="(challans.length <= 0 ) && loader==false">
                <h4 class="text-dark text-center">স্ট্যান্ডার্ডাইজেশন সিট পাওয়া যায়নি</h4>
                <h6 class="text-dark text-center">{{$en2bn(search.date.from)}} - {{$en2bn(search.date.to)}}</h6>
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
                kernel            : {},
                processing_plants : [],
                search            : {
                    processing_plant_id : '',
                    date : {
                        from : this.$date(),
                        to   : this.$date(),
                    },
                },
                loader      : false,
                challans    : [],
            }
        },
        mounted(){
            this.fetchRecords();
            this.http('processing-plant/all', 'processing-plnat', {
                select:['processing_plant_name', 'id']
            });
        },
        methods:{
            fetchRecords(){
                this.http('report/milk-standardization/list', 'reports', {
                    where:this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='reports'){
                        this.challans = this.kernel[key].data;
                    }
                    else if(key=='processing-plnat'){
                        this.processing_plants = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>

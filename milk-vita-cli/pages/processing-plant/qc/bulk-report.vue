<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;&nbsp;কিউ.সি / ল্যাব</h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <div class="table-responsive">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th>বাল্ক এই.ডি </th>
                            <th>তারিখ</th>
                            <th>কিউ.সি তারিখ</th>
                            <th>গাড়ী</th>
                            <th>চালকের নাম</th>
                            <th>দুধের পরিমান</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{$en2bn(bulk.voucher_no)}}</td>
                            <td>{{$en2bn(bulk.receive_date)}}</td>
                            <td>{{$en2bn(bulk.qc_date)}}</td>
                            <td>{{bulk.vehicle}}</td>
                            <td>{{bulk.driver_name}}</td>
                            <td>{{$en2bn(bulk.grand_total_milk)}} লিটার</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- // -->
            
            <div class="row">
                <div class="col-md-2">ক্যাটাগরি</div>
                <div class="col-md-5">: {{bulk.qc_category_name}}</div>
            </div>
            
            <div class="row">
                <div class="col-md-2">দুধের পরিমান</div>
                <div class="col-md-5">: {{$en2bn(bulk.qc_milk_amount)}} লিটার</div>
            </div>
            
            <div class="row">
                <div class="col-md-2">দুধের পার্থক্য</div>
                <div class="col-md-5">: {{$en2bn((bulk.grand_total_milk - bulk.qc_milk_amount))}} লিটার</div>
            </div>


            <br>

            <div v-if="bulk.challans" v-for="(challan, index) in bulk.challans" :key="index">
                <!-- // -->
                <div class="table-response mt-md-3">
                    <caption class="text-nowrap">{{ challan.chilling_plant_name }}</caption>
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
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_liter" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_density" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_fat_persentase" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_fat_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_snf_persentase" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.clpt_snf_kg" readonly></td>
                        </tr>
                        <br>
                        <!-- // -->
                        <tr>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_liter" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_density" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_persentase" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_persentase" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_kg" readonly></td>
                        </tr>

                    </table>
                </div>
            </div>


            <caption class="mt-0 text-nowrap">কিউ.সি রিপোর্টস </caption>
            <div class="table-responsive">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>টেস্টার নাম</th>
                            <th>আদর্শ মান</th>
                            <th>ফলাফল</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in reports" :key='index'>
                            <td width="50">{{$en2bn(++index)}}</td>
                            <td>{{$en2bn(row.test_name)}}</td>
                            <td>{{$en2bn(row.test_standerd)}}</td>
                            <td>{{row.result}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- // -->
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
                loader          : true,
                bulk            : {},
                tests           : [],
                reports         : [],
                is_processing:false,
            }
        },
        mounted(){
            this.http('processing-plant/bulk/list', 'bulk', {
                where : {id:this.$route.query.id},
                type  : 'qc',
            });
            //
            this.http('processing-plant/bulk/qc-report/list/'+this.$route.query.id, 'report');
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='bulk'){
                        this.loader = false;
                        this.bulk   = this.kernel[key].data[0]
                    }
                    else if(key=='report'){
                        this.reports = this.kernel[key];
                        console.log(this.kernel[key]);
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .custom-row-test {
        background: #eee;
        padding: 17px;
        margin: 4px 0 0 0;
    }
</style>>


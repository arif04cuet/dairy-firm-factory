<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;&nbsp;কিউ.সি / ল্যাব</h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit">
                <!-- // -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover custom mb-2">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>চালান নাম্বার</th>
                                <th>গাড়ী</th>
                                <th>চালকের নাম</th>
                                <th>বর্তমান অবস্থা</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{$en2bn(challan.sand_qc_date)}}</td>
                                <td>{{challan.voucher_no}}</td>
                                <td><span v-if="challan.bulk">{{challan.bulk.vehicle}}</span></td>
                                <td><span v-if="challan.bulk">{{challan.bulk.driver_name}}</span></td>
                                <td>{{challan.is_qc==0?'অপেক্ষমান':'কিউ.সি সম্পন্ন হয়েছে'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- // -->
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-2">নমুনার পরিমান</div>
                        <div class="col-md-5">: {{$en2bn(challan.sample_quantity)}} লিটার</div>
                    </div>
                    <!-- // -->
                    <div class="row">
                        <div class="col-md-2">প্রাপ্ত দুধের পরিমাণ</div>
                        <div class="col-md-5">: {{$en2bn(challan.prpt_liter)}} লিটার</div>
                    </div>
                </div>

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
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_liter" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_density" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_percentage" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_percentage" readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_kg" readonly></td>
                        </tr>

                    </table>
                </div>
                <!-- // -->
                <br>
                <div v-if="reports.length > 0">
                <!-- // -->
                    <caption class="m-0 p-0 text-nowrap">কিউ.সি রিপোর্টস </caption>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover custom mb-2">
                            <thead>
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th class="text-left">টেস্টার নাম</th>
                                    <th>আদর্শ মান</th>
                                    <th>ফলাফল</th>
                                </tr>
                            </thead>
                            <!-- // -->
                            <tbody>
                                <tr v-for="(row, index) in reports" :key='index'>
                                    <td width="50">{{$en2bn(index+1)}}</td>
                                    <td class="text-left" width="40%">{{row.test_name}}</td>
                                    <td width="25%">{{$en2bn(row.standerd_value)}}</td>
                                    <td>{{row.result}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- // -->
                <Loader :loader="loader"/>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        data(){
            return {
                kernel          : {},
                loader          : true,
                challan         : {},
                tests           : [],
                reports         : [],
            }
        },
        mounted(){
            this.http('processing-plant/challan/view/'+this.$route.query.id, 'challan');
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='challan'){
                        this.loader = false;
                        this.challan   = this.kernel[key].challan;
                        this.reports   = this.kernel[key].reports;
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


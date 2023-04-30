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
                        <!-- // -->
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
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_density " required readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" :value="challan.prpt_fat_percentage" required readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_kg" readonly></td>
                            <!--  -->
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" :value="challan.prpt_snf_percentage" required readonly></td>
                            <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_kg" readonly></td>
                        </tr>

                    </table>
                </div>
                <!-- // -->
                <br>
                <!-- // -->
                <caption class="m-0 p-0 text-nowrap">কিউ.সি রিপোর্টস </caption>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover custom mb-2">
                        <thead>
                            <tr>
                                <th>ক্রমিক</th>
                                <th>টেস্টার নাম</th>
                                <th>আদর্শ মান</th>
                                <th>ফলাফল</th>
                                <th width="10">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <!-- // -->
                        <tbody>
                            <tr>
                                <td width="50">{{$en2bn(1)}}</td>
                                <th width="40%"> <big>ঘনত্ব</big> </th>
                                <td width="25%">---</td>
                                <td class="input-group">
                                    <input type="number" step="any" @click="calculation()" @input="calculation()" v-model="challan.prpt_density"  class="form-control text-center" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    ---
                                </td>
                            </tr>

                            <tr>
                                <td width="50">{{$en2bn(2)}}</td>
                                <th width="40%"> <big>ফ্যাট</big> </th>
                                <td width="25%">---</td>
                                <td class="input-group">
                                    <input type="number" step="any" @click="calculation()" @input="calculation()" v-model="challan.prpt_fat_percentage"  class="form-control text-center" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    ---
                                </td>
                            </tr>

                            <!-- <tr>
                                <td width="50">{{$en2bn(3)}}</td>
                                <th width="40%"> <big>এস এন এফ</big> </th>
                                <td width="25%">---</td>
                                <td class="input-group">
                                    <input type="text" class="form-control text-center" :value="challan.prpt_snf_percentage" required readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    ---
                                </td>
                            </tr> -->

                            <!-- // -->
                            <tr v-for="(row, index) in reports" :key='index'>
                                <td width="50">{{$en2bn(index+3)}}</td>
                                <td width="40%">
                                    <select-picker
                                        placeholder="টেস্ট নির্বাচন করুন"
                                        :options="tests"
                                        :reduce="row=>row.id"
                                        label="test_name"
                                        v-model="reports[index].test_id"
                                        @input="testChecked(index)"
                                    />
                                </td>
                                <td width="25%">{{$en2bn(row.standerd_value)}}</td>
                                <td><input type="text" class="form-control" v-model="reports[index].result" required :readonly="row.test_id==''"></td>
                                <td class="text-center">
                                    <div class="btn-group custom">
                                        <button type="button" class="btn btn-danger" @click="rmTest(index)"><i class="fa fa-times"></i></button type="button">
                                        <button type="button" class="btn btn-success" @click="addTest()" v-if="index==(reports.length-1)"><i class="fa fa-plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- // -->
                <div class="card-body bg-light">
                    <h5 class="border-bottom pt-3">পাউডার দুধের তথ্য (<small>যদি থেকে থাকে</small>)</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ফ্যাট(%)</label>
                                <div class="input-group">
                                    <input type="number" v-model="challan.QCPMFP" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ময়েশ্চারাইজার(%)</label>
                                <div class="input-group">
                                    <input type="number" v-model="challan.QCPMMP" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <button class="btn btn-success float-right mt-3">
                    <span v-if="is_submit==false"><i class="fa fa-floppy-o"></i> সাবমিট</span>
                    <span v-else >&nbsp;&nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;</span>
                </button>
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
                is_submit       : false,
                loader          : true,
                challan         : {},
                tests           : [],
                reports         : [],
                empty_test      : {test_id:'', standerd_value:'---', result:''},
                is_processing   : false,
            }
        },
        mounted(){
            this.http('processing-plant/challan/list', 'challan', {
                where : {id:this.$route.query.id},
            });
            this.reports = [Object.assign({},this.empty_test)];

            this.http('test/list', 'test', {
                type : 'qc',
            });
        },
        methods:{
            calculation()
            {
                this.challan.prpt_kg  = Number.parseFloat(this.challan.prpt_liter * this.challan.prpt_density).toFixed(2);
                //
                var item = Object.assign({}, this.challan);
                var clr   = this.$clrDensity(item.prpt_density);
                //
                item.prpt_kg             = Number.parseFloat(item.prpt_liter * item.prpt_density).toFixed(2);
                item.prpt_fat_kg         = Number.parseFloat((item.prpt_kg / 100) * item.prpt_fat_percentage).toFixed(2);
                item.prpt_snf_percentage = Number.parseFloat(((clr / 4) + (item.prpt_fat_percentage/5) + 0.14)).toFixed(2);
                item.prpt_snf_kg         = Number.parseFloat((item.prpt_kg / 100) * item.prpt_snf_percentage).toFixed(2);
                //
                if(this.challan.prpt_kg > 0 && this.challan.prpt_density > 0 && this.challan.prpt_fat_percentage > 0) this.challan = item;
            },
            addTest(){
                (this.reports).push(Object.assign({}, this.empty_test));
            },
            rmTest(index){
                this.$delete(this.reports, index);
                if(this.reports.length==0)
                    this.reports = [Object.assign({},this.empty_test)];
            },
            testChecked(index){
                let report = this.reports[index];
                //
                (this.tests).forEach(test => {
                    if(test.id==report.test_id){
                        this.reports[index].standerd_value =  test.standerd_value;
                    }
                });
            },
            submit(){
                var data = {
                    prpt_density        : this.challan.prpt_density,
                    prpt_kg             : this.challan.prpt_kg,
                    prpt_fat_percentage : this.challan.prpt_fat_percentage,
                    prpt_fat_kg         : this.challan.prpt_fat_kg,
                    prpt_snf_percentage : this.challan.prpt_snf_percentage,
                    prpt_snf_kg         : this.challan.prpt_snf_kg,
                    QCPMFP              : this.challan.QCPMFP,
                    QCPMMP              : this.challan.QCPMMP,
                    reports             : this.reports,
                    challan_id          : this.$route.query.id,
                };
                //
                this.is_submit = true;
                this.http('processing-plant/challan/report-submit', 'submit', data);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='challan'){
                        this.loader  = false;
                        this.challan = this.kernel[key].data[0];
                    }
                    else if(key=='report'){
                        this.reports = this.kernel[key];
                    }
                    else if(key=='test') {
                        this.tests = this.kernel[key].data;
                    }
                    else if(key=='submit'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else this.$router.push({path:'/processing-plant/qc/challan/view?id='+this.kernel[key]});
                    }
                }
            }
        }
    }
</script>

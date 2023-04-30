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
                            <th>তারিখ</th>
                            <th>বাল্ক এই.ডি </th>
                            <th>গাড়ী</th>
                            <th>চালকের নাম</th>
                            <th>দুধের পরিমান</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{$en2bn(bulk.receive_date)}}</td>
                            <td>{{$en2bn(bulk.voucher_no)}}</td>
                            <td>{{bulk.vehicle}}</td>
                            <td>{{bulk.driver_name}}</td>
                            <td>{{$en2bn(bulk.grand_total_milk)}} লিটার</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- // -->
            <form @submit.prevent="submit()">

                <!-- // -->
                <fieldset class="border p-2">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="">দুধের ধরণ</label>
                            <select class="form-control" v-model="qc_cat_id" required>
                                <option value="">দুধের ধরণ নির্বাচন করুন </option>
                                <option v-for="(row, index) in milk_categories" :key="index" :value="row.id">{{row.category_name}}</option>
                            </select>
                        </div>

                        <!-- // -->
                        <!-- <div class="col-md-4 form-group">
                            <label for="">দুধের পরিমান</label>
                            <input type="number" v-model="qc_milk_amount" step="any" class="form-control" min="0" placeholder="দুধের পরিমান লিখুন" required>
                        </div> -->
                        <!-- // -->

                        <div class="col-md-4 form-group">
                            <label for="">দুধের পরিমান</label>
                            <div class="input-group mb-3">
                            <input type="number" v-model="qc_milk_amount" step="any" class="form-control" min="0" placeholder="দুধের পরিমান লিখুন" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">লিটার</span>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="">দুধের পার্থক্য</label>
                            <div class="input-group mb-3">
                            <input type="number" v-model="qc_milk_difference" step="any" class="form-control" min="0" placeholder="দুধের পরিমান লিখুন" aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">লিটার</span>
                            </div>
                            </div>
                        </div>

                    </div>
                </fieldset>

                <br>

                <fieldset class="border p-2" v-if="bulk.challans" v-for="(challan, index) in bulk.challans" :key="index">
                    <legend class="w-auto">{{ challan.chilling_plant_name }}</legend>
                    <!-- // -->
                    <div class="table-response mt-md-3">
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
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_liter" @change="convertToKg(index)" @input="convertToKg(index)" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_density" @change="convertToKg(index)" @input="convertToKg(index)" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_kg" @change="calcFatKg(index), calcSnfKg(index)" @input="calcFatKg(index), calcSnfKg(index)" required readonly></td>
                                <!--  -->
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_persentase" @change="calcFatKg(index)" @input="calcFatKg(index)" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_fat_kg" required readonly></td>
                                <!--  -->
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_persentase" @change="calcSnfKg(index)" @input="calcSnfKg(index)" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="challan.prpt_snf_kg" required readonly></td>
                            </tr>

                        </table>
                    </div>
                </fieldset>


                <br>

                <fieldset class="border p-2">
                    <legend class="w-auto">কিউ.সি</legend>
                    <!-- // -->
                    <div class="row custom-row-test" v-for="(row, index) in reports" :key="index" :class="index==0?' m-0':''">
                        <div class="col-md-1 text-right">{{$en2bn(index+1)}}.</div>
                        <div class="col-md-4 form-group">
                            <label :for="'test-'+(index+1)">পরীক্ষা নির্বাচন করুন</label>
                            <select v-model="reports[index].test_id" :id="'test-'+(index+1)" class="form-control" required>
                                <option value="">টেস্ট নির্বাচন করুন </option>
                                <option v-for="(row, index) in tests" :key="index" :value="row.id">{{row.test_name}}</option>
                            </select>
                        </div>
                        <!-- // -->
                        <div class="col-md-4 form-group">
                            <label for="">পরীক্ষার ফলাফল </label>
                            <input type="text" v-model="reports[index].result" class="form-control" placeholder="পরীক্ষার ফলাফল লিখুন" required>
                        </div>
                        <div class="col-md-2 form-group d-flex align-items-end">
                            <button type="button" class="btn btn-success" v-if="(reports.length-1)==index" @click="increment()"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-danger" v-else @click="decrement(index)"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="text-right mt-1">
                        <div class="btn-group">
                            <button type="button" v-if="is_processing" class="btn btn-success rounded-0">
                                <i class="fa fa-spinner fa-spin fa-fw"></i>&nbsp;অপেক্ষা করুন
                            </button>

                            <button type="submit" v-else class="btn btn-success rounded-0">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সাবমিট করুন&nbsp;
                            </button>
                        </div>
                    </div>
                    
                </fieldset>
            </form>
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
                qc_cat_id       : '',
                qc_milk_amount  : 0,
                reports         : [{
                    test_id : '',
                    result  : '',
                }],
                is_processing:false,
                milk_categories : [],
                qc_milk_difference : 0,
            }
        },
        mounted(){
            this.http('test/list', 'test', {
                type : 'qc',
            });
            //
            this.http('processing-plant/bulk/view/'+this.$route.query.id, 'bulk', {
                type  : 'qc',
            });
            //
            this.http('product/category/list', 'milk_categories', {
                where : {slug:'raw-milk'},
                children:1
            });
        },
        methods:{
            convertToKg(index){
                this.bulk.challans[index].prpt_kg = (this.bulk.challans[index].prpt_liter * this.bulk.challans[index].prpt_density);
            },
            calcFatKg(index){
                this.bulk.challans[index].prpt_fat_kg = Number.parseFloat(((this.bulk.challans[index].prpt_kg/100)*this.bulk.challans[index].prpt_fat_persentase)).toFixed(2);
            },
            calcSnfKg(index){
                this.bulk.challans[index].prpt_snf_kg = Number.parseFloat(((this.bulk.challans[index].prpt_kg/100)*this.bulk.challans[index].prpt_snf_persentase)).toFixed(2);
            },
            submit()
            {
                this.is_processing = true;
                var data = {
                    bulk_id         : this.$route.query.id,
                    reports         : this.reports,
                    qc_cat_id       : this.qc_cat_id,
                    qc_milk_amount  : this.qc_milk_amount,
                    challans        : [],
                };

                if(this.bulk.challans) ((this.bulk.challans)).forEach((challan) => {
                    data.challans.push({
                        id                  :challan.id,
                        prpt_liter          : challan.prpt_liter,
                        prpt_density        : challan.prpt_density,
                        prpt_fat_persentase : challan.prpt_fat_persentase,
                        prpt_snf_persentase : challan.prpt_snf_persentase,
                    });
                });

                console.log();

                if(this.$route.query.id) this.http('processing-plant/bulk/qc-report/store', 'store', data);
                else this.$toastr.w('দুঃখিত, প্রক্রিয়া সম্ভব নয়');
            },
            increment(){
                this.reports.push({
                    test_id : '',
                    result  : '',
                });
            },
            decrement(index){
                this.$delete(this.reports, index);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            qc_milk_amount(){
                this.qc_milk_difference = (this.bulk.grand_total_milk - this.qc_milk_amount);
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='bulk'){
                        this.loader = false;
                        // 
                        console.log(this.kernel[key]);
                        if(this.kernel[key].errors)
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else {
                            this.bulk   = this.kernel[key]
                        }
                    }
                    else if(key=='milk_categories'){
                        var category = this.kernel[key].data[0]
                        if(category){
                            this.milk_categories = category.children;
                        }
                    }
                    else if(key=='test'){
                        this.tests = this.kernel[key].data;
                    }
                    else if(key=='store')
                    {
                        this.is_processing = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else {
                            this.$toastr.s('বাল্ক রিপোর্ট সফল ভাবে সাবমিট হয়েছে');
                            this.$router.push({path:'/processing-plant/qc/bulk-report?id='+this.$route.query.id});
                        }
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


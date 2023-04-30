<template>
    <div class="card">
        <div class="card-body min85vh">
            <div class="form-header mt-4">
                <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                <h2>প্রসেসিং প্লান্ট</h2>
                <h2>প্রসেসিং প্লান্টের নাম</h2>
            </div>
            <!-- // -->
            <hr>
            <!-- // -->
            <div v-if="loader==false">
                <!-- // -->
                <div class="d-flex justify-content-between">
                    <table>
                        <tr>
                            <td>তারিখ</td>
                            <td>: {{$en2bn(challan.date)}}</td>
                        </tr>
                        <tr>
                            <td>তৈরিকারক</td>
                            <td>: {{bulk.user_name}}</td>
                        </tr>
                    </table>
                    <!-- // -->
                    <table>
                        <tr>
                            <td class="text-right">চালকের নাম</td>
                            <td>: {{bulk.driver_name}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">গাড়ী</td>
                            <td>: {{bulk.vehicle}}</td>
                        </tr>
                    </table> 
                </div>

                <!-- // -->
                <div class="table-responsive mt-md-3">
                    <table class="table table-bordered part-1 challan-table bg-light custom">
                        <thead>
                            <tr>
                                <th class="p-1" colspan="4">তরল দুধের পরিমান</th>
                                <th class="p-1" colspan="2">ফ্যাট</th>
                                <th class="p-1" colspan="3">এস এন এফ</th>
                            </tr>
                            <tr>
                                <th class="p-1">#</th>
                                <th class="p-1">পরিমান (লিটার)</th>
                                <th class="p-1">ঘনত্ব</th>
                                <th class="p-1">পরিমান (কেজি)</th>
                                <!-- // -->
                                <th class="p-1">%</th>
                                <th class="p-1">কেজি</th>
                                <!-- // -->
                                <th class="p-1">%</th>
                                <th class="p-1">কেজি</th>
                                <th class="p-1" width="120">SMP (কেজি)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>---</td>
                                <td class="custom-challan-row">{{challan.clpt_liter|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.clpt_density|en2bn}}</td>
                                <td class="custom-challan-row">{{challan.clpt_kg|en2bnF2}}</td>
                                <!--  -->
                                <td class="custom-challan-row">{{challan.clpt_fat_percentage|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.clpt_fat_kg|en2bnF2}}</td>
                                <!--  -->
                                <td class="custom-challan-row">{{challan.clpt_snf_percentage|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.clpt_snf_kg|en2bnF2}}</td>
                                <td>---</td>
                            </tr>
                            <tr v-if="challan.is_qc==1" style="background: #ced4c2;">
                                <td>---</td>
                                <td class="custom-challan-row">{{challan.prpt_liter|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.prpt_density|en2bn}}</td>
                                <td class="custom-challan-row">{{challan.prpt_kg|en2bnF2}}</td>
                                <!--  -->
                                <td class="custom-challan-row">{{challan.prpt_fat_percentage|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.prpt_fat_kg|en2bnF2}}</td>
                                <!--  -->
                                <td class="custom-challan-row">{{challan.prpt_snf_percentage|en2bnF2}}</td>
                                <td class="custom-challan-row">{{challan.prpt_snf_kg|en2bnF2}}</td>
                                <td>---</td>
                            </tr>
                            <tr v-if="stock.FP & challan.is_qc==1" style="border: 2px solid #ff9f9f!important; border-bottom:2px solid #63c863!important;background: #f6dac1">
                                <th></th>
                                <th>{{stock.amount|en2bnF2}}</th>
                                <th></th>
                                <th></th>
                                <th>{{stock.FP|en2bnF2}}</th>
                                <th>{{Math.abs(std.RFK-challan.prpt_fat_kg)|en2bnF2}}</th>
                                <th>{{stock.SNFP|en2bnF2}}</th>
                                <th>{{Math.abs(std.RSNFK-challan.prpt_snf_kg)|en2bnF2}}</th>
                                <th></th>
                            </tr>
                            <tr v-if="stock.FP & challan.is_qc==1" style="border: 2px solid #ff9f9f!important;background: #f6dac1">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{std.RFK|en2bnF2}}</th>
                                <th></th>
                                <th>{{std.RSNFK|en2bnF2}}</th>
                                <th></th>
                            </tr>
                            <tr v-if="challan.is_qc==1">
                                <td>মোট</td>
                                <td class="custom-challan-row">{{std.SML|en2bnF2}}</td>
                                <td class="custom-challan-row">{{std.SCLR|en2bnF2}}</td>
                                <td class="custom-challan-row">{{std.SMK|en2bnF2}}</td>
                                <td width="90" v-if="std.SFP <= 0">
                                    <button @click="(isPopUp=true)" class="btn btn-info p-0 pl-2 pr-2">SMP</button>
                                </td>
                                <td class="custom-challan-row" v-else >{{std.SFP|en2bnF2}}</td>
                                <td class="custom-challan-row">{{std.SFK|en2bnF2}}</td>
                                <td class="custom-challan-row">{{std.SSNFP|en2bnF2}}</td>
                                <td class="custom-challan-row">{{std.SSNFK|en2bnF2}}</td>
                                <td>{{(std.SMP >= 0 ? std.SMP : 0 )|en2bnF2}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="popup" v-if="isPopUp">
                    <div class="popup-body" style="min-height:200px">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fa fa-calculator" aria-hidden="true"></i> ক্যালকুলেটিভ ফ্যাট পার্সেন্টেজে </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="accumulate-fat-percentage">মোট FAT এবং SNF পার্সেন্টেজে (%)</label>
                                    <input type="number" v-model="std.AFP" class="form-control">
                                    <!-- // AFP = Accumulate Fat Percentage -->
                                </div>
                                <div class="form-group">
                                    <label for="accumulate-fat-percentage">স্ট্যান্ডার্ড ফ্যাট পার্সেন্টেজে (%)</label>
                                    <input type="number" v-model="std.SFP" class="form-control">
                                    <!-- // AFP = Standard Fat Percentage -->
                                </div>
                                <div class="form-group">
                                    <label for="accumulate-fat-percentage">রিসিভ ফ্যাট কেজি</label>
                                    <input type="number" v-model="std.RFK" class="form-control">
                                    <!-- // AFP = Standard Fat Percentage -->
                                </div>
                                <div class="form-group">
                                    <label for="accumulate-fat-percentage">রিসিভ SNFK</label>
                                    <input type="number" v-model="std.RSNFK" class="form-control">
                                    <!-- // AFP = Standard Fat Percentage -->
                                </div>
                                <div class="btn-group float-right">
                                    <button type="button" @click="(isPopUp=false)" class="btn btn-danger">বাতিল</button>
                                    <button type="button" @click="setCalculativeFatPercentage()" class="btn btn-success">সাবমিট</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- // -->
                <div class="alert-info" v-if="(challan.is_send_qc==0 && challan.is_driver_receive!=0)">
                    <div class="card-body"> 
                        <form @submit.prevent="SubmitSample">
                            <div class="row form-group">
                                <label for="" class="col-md-4 text-right pt-2 pr-0">প্রাপ্ত দুধের পরিমাণঃ</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="qc_sample['receive_quantity']" required>
                                        <div class="input-group-append bg-default">
                                            <span class="input-group-text">লিটার</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="" class="col-md-4 text-right pt-2 pr-0">নমুনার পরিমাণঃ</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="qc_sample['sample_quantity']" required>
                                        <div class="input-group-append bg-default">
                                            <span class="input-group-text">লিটার</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <span v-if="is_submit"><i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>&nbsp;প্রোসেসিং...</span>
                                        <span v-else ><i class="fa fa-share-square-o" aria-hidden="true"></i>&nbsp;QC-তে পাঠান</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="alert alert-info" v-if="(challan.is_send_qc==1 && challan.is_qc==0)">
                    <h4 class="pt-2"><i class="fa fa-calculator"></i> কিউ. সি তে অপেক্ষায় আছে</h4>
                </div>

                <!-- // -->
                <div class="alert-info p-1" v-if="(challan.is_send_qc==0 && challan.is_qc==1)">
                    <div class="table-responsive mt-md-3">
                        <caption class="text-nowrap m-0 p-0 text-black"><i class="fa fa-sticky-note-o"></i>&nbsp;কিউ.সি তথ্য</caption>
                        <table class="table table-bordered part-1 challan-table">
                            <thead>
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
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_liter}}</td>
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_density}}</td>
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_kg}}</td>
                                    <!--  -->
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_fat_percentage}}</td>
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_fat_kg}}</td>
                                    <!--  -->
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_snf_percentage}}</td>
                                    <td rowspan="2" class="custom-challan-row">{{challan.clpt_snf_kg}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- // -->
                <div v-if="(challan.is_send_qc==1 && challan.is_qc==1)">
                    <!-- // -->
                    <div class="table-responsive mt-3" style="overflow-x:inherit">
                        <caption class="text-nowrap p-0 m-0"><i class="fa fa-cubes" aria-hidden="true"></i> দুধের ধরন সমূহ</caption>
                        <form @submit.prevent="milkCategorizedSubmit">
                            <table class="table table-bordered part-1 challan-table custom">
                                <thead>
                                    <tr>
                                        <th colspan="5">---</th>
                                        <th colspan="2">ফ্যাট</th>
                                        <th colspan="2">এস এন এফ</th>
                                        <th rowspan="2" v-if="category_wise_milk.length == 0">অ্যাকশন</th>
                                    </tr>
                                    <tr>
                                        <th width="10">নং</th>
                                        <th>ক্যাটাগরি</th>
                                        <th>পরিমান</th>
                                        <th>ঘনত্ব</th>
                                        <th>কেজি</th>
                                        <th>%</th>
                                        <th>কেজি</th>
                                        <th>%</th>
                                        <th>কেজি</th>
                                    </tr>
                                </thead>
                                <!-- // -->
                                <tbody v-if="category_wise_milk.length == 0">
                                    <tr v-for="(row, index) in milk_categories" :key="index">
                                        <td>{{index+1}}</td>
                                        <td width="300">
                                            <select-picker
                                                placeholder="ধরণ নির্বাচনে করুন"
                                                v-model="milk_categories[index].category_id"
                                                :options="categories"
                                                :reduce="(row)=>row.id"
                                                label="category_name"
                                            />
                                        </td>
                                        <td><input type="number" step="any" v-model="milk_categories[index].quantity" @input="percentageCalculation(index)" @change="percentageCalculation(index)" class="form-control text-center" placeholder="পরিমান" required /></td>
                                        <td><input type="number" step="any" v-model="milk_categories[index].density" @input="percentageCalculation(index)" @change="percentageCalculation(index)" class="form-control text-center" placeholder="ঘনত্ব" required /></td>
                                        <td><input type="number" step="any" v-model="milk_categories[index].kg" class="form-control text-center" placeholder="কেজি" required readonly /></td>
                                        <td><input type="number" step="any" v-model="milk_categories[index].fat_percentage" @input="percentageCalculation(index)" @change="percentageCalculation(index)" class="form-control text-center" placeholder="ফ্যাট %" required /></td>
                                        <td><input type="text" v-model="milk_categories[index].fat_kg" class="form-control text-center" placeholder="ফ্যাট কেজি" required readonly /></td>
                                        <td><input type="text" v-model="milk_categories[index].snf_percentage" class="form-control text-center" placeholder="এস.এন.এফ %" required readonly /></td>
                                        <td><input type="text" v-model="milk_categories[index].snf_kg" class="form-control text-center" placeholder="এস.এন.এফ কেজি" required readonly /></td>
                                        <td width="10" class="text-center">
                                            <div class="btn-group custom">
                                                <button v-if="milk_categories.length == (index+1)" type="button" to="#" class="btn-sml btn btn-success" @click="addType()"><i class="fa fa-plus"></i></button>
                                                <button v-if="milk_categories.length != 1" type="button" to="#" class="btn-sml btn btn-danger" @click="removeType(index)"><i class="fa fa-times"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- // -->
                                <tbody v-if="category_wise_milk.length != 0">
                                    <tr v-for="(row, index) in category_wise_milk" :key="index">
                                        <td>{{index+1}}</td>
                                        <td width="300">{{row.category_name}}</td>
                                        <td>{{row.quantity|en2bnF2}}</td>
                                        <td>{{row.density|en2bnF2}}</td>
                                        <td>{{row.kg|en2bnF2}}</td>
                                        <td>{{row.fat_percentage|en2bnF2}}</td>
                                        <td>{{row.fat_kg|en2bnF2}}</td>
                                        <td>{{row.snf_percentage|en2bnF2}}</td>
                                        <td>{{row.snf_kg|en2bnF2}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- // -->
                            <div class="text-right mt-2" v-if="category_wise_milk.length == 0">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সাবমিট</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- // -->
                    <div class="table-responsive mt-3" style="overflow-x:inherit">
                        <caption class="text-nowrap p-0 m-0"><i class="fa fa-sitemap" aria-hidden="true"></i> ডিপার্টমেন্টে দুধ হস্তান্তর</caption>
                        <form @submit.prevent="milkDepartmentWiseSubmit">
                            <table class="table table-bordered part-1 challan-table custom">
                                <thead>

                                    <tr>
                                        <th colspan="6">---</th>
                                        <th colspan="2">ফ্যাট</th>
                                        <th colspan="2">এস এন এফ</th>
                                        <th rowspan="2" v-if="department_wise_milk.length == 0">অ্যাকশন</th>
                                    </tr>

                                    <tr>
                                        <th width="10">নং</th>
                                        <th>ডিপার্টমেন্ট</th>
                                        <th>ক্যাটাগরি</th>
                                        <th>পরিমান</th>
                                        <th>ঘনত্ব</th>
                                        <th>কেজি</th>
                                        <th>%</th>
                                        <th>কেজি</th>
                                        <th>%</th>
                                        <th>কেজি</th>
                                    </tr>
                                </thead>
                                <!-- // -->
                                <tbody v-if="department_wise_milk.length==0">
                                    <tr v-for="(row, index) in milk_transfer" :key="index">
                                        <td>{{index+1}}</td>
                                        <td width="150px" class="border-right-0">
                                            <select-picker
                                                placeholder="ডিপার্টমেন্ট"
                                                v-model="milk_transfer[index].department_id"
                                                :options="departments"
                                                :reduce="(row)=>row.id"
                                                label="department_name_bn"
                                                required
                                            />
                                        </td>
                                        <td width="150px" class="border-right-0">
                                            <select-picker
                                                placeholder="ক্যাটাগরি"
                                                v-model="milk_transfer[index].category_id"
                                                :options="categories"
                                                :reduce="(row)=>row.id"
                                                label="category_name"
                                                @input="checkCategoryWiseMilk(index)"
                                            />
                                        </td>
                                        <!-- // -->
                                        <td><input type="number" step="any" v-model="milk_transfer[index].quantity" @input="percentageCalculation(index, 'department')" @change="percentageCalculation(index, 'department')" class="form-control text-center" placeholder="পরিমান" required /></td>
                                        <td><input type="number" step="any" v-model="milk_transfer[index].density" @input="percentageCalculation(index, 'department')" @change="percentageCalculation(index, 'department')" class="form-control text-center" placeholder="ঘনত্ব" required /></td>
                                        <td><input type="number" step="any" v-model="milk_transfer[index].kg" class="form-control text-center" placeholder="কেজি" required readonly /></td>
                                        <td><input type="number" step="any" v-model="milk_transfer[index].fat_percentage" @input="percentageCalculation(index, 'department')" @change="percentageCalculation(index, 'department')" class="form-control text-center" placeholder="ফ্যাট %" required /></td>
                                        <td><input type="text" v-model="milk_transfer[index].fat_kg" class="form-control text-center" placeholder="ফ্যাট কেজি" required readonly /></td>
                                        <td><input type="text" v-model="milk_transfer[index].snf_percentage" class="form-control text-center" placeholder="এস.এন.এফ %" required readonly /></td>
                                        <td><input type="text" v-model="milk_transfer[index].snf_kg" class="form-control text-center" placeholder="এস.এন.এফ কেজি" required readonly /></td>
                                        <!-- // -->
                                        <td width="10" class="text-center">
                                            <div class="btn-group custom">
                                                <button type="button" v-if="milk_transfer.length == (index+1)" to="#" class="btn-sml btn btn-success" @click="addTransfer()"><i class="fa fa-plus"></i></button>
                                                <button type="button" v-if="milk_transfer.length != 1" to="#" class="btn-sml btn btn-danger" @click="removeTransfer(index)"><i class="fa fa-times"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- // -->
                                <tbody v-if="department_wise_milk.length > 0">
                                    <tr v-for="(row, index) in department_wise_milk" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{row.department_name}}</td>
                                        <td>{{row.category_name}}</td>
                                        <!-- // -->
                                        <td>{{row.quantity}}</td>
                                        <td>{{row.density}}</td>
                                        <td>{{row.kg}}</td>
                                        <td>{{row.fat_percentage}}</td>
                                        <td>{{row.fat_kg}}</td>
                                        <td>{{row.snf_percentage}}</td>
                                        <td>{{row.snf_kg}}</td>
                                    </tr>
                                </tbody>
                                <!-- // -->
                            </table>
                            <div v-if="department_wise_milk.length==0 && category_wise_milk.length > 0" class="text-right">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সাবমিট</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- // -->
            <loader :loader="loader" />
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        data(){
            return {
                kernel      : {},
                loader      : true,
                is_submit   : false,
                challan     : {},
                bulk        : {},
                challan_id  : '',
                categories  : [],
                departments : [],
                category_wise_milk   : [],
                department_wise_milk : [],
                milk_categories  : [
                    {
                        quantity : 0,
                        density : 0,
                        kg : 0,
                        fat_percentage : 0,
                        fat_kg : 0,
                        snf_percentage : 0,
                        snf_kg : 0,
                    }
                ],
                milk_transfer : [
                    {
                        quantity : 0,
                        density : 0,
                        kg : 0,
                        fat_percentage : 0,
                        fat_kg : 0,
                        snf_percentage : 0,
                        snf_kg : 0,
                    }
                ],
                qc_sample     : {
                    challan_id : this.$route.query.id,
                },
                std : {
                    SAFP    : 0,
                    PMSNFP  : 0,
                    SFK     : 0,
                    SMK     : 0,
                    SSNFK   : 0,
                    SCLR    : 0,
                    SSNFP   : 0,
                    SML     : 0,
                    SMP     : 0,
                },
                stock:{},
                isPopUp:false,
            }
        },
        mounted(){
            this.challan_id = this.$route.query.id;
            this.http('product/category/list', 'category', {where:{slug:'milk-qc'}, children:true,});
            this.http('department/list', 'department-list');
        },
        methods:{
            checkCategoryWiseMilk(index){
                const category_id = this.milk_transfer[index].category_id;

                var used_quantity = 0;
                Object.values(this.milk_transfer).forEach((row)=>{
                    if(category_id==row.category_id) used_quantity += +row.quantity;
                });

                Object.values(this.category_wise_milk).forEach((row)=>{
                    if(category_id==row.category_id){
                        if((row.quantity - used_quantity) > 0){
                            this.milk_transfer[index] = Object.assign({
                                department_id : this.milk_transfer[index].department_id
                            }, row);
                            this.milk_transfer[index].quantity = (row.quantity - used_quantity)
                        }
                        else this.$toastr.w('পর্যাপ্ত পরিমানে স্টক নেই ');
                    }
                });
            },
            setCalculativeFatPercentage(){
                this.calculateStd();
                this.$axios.post("processing-plant/challan/standerdization", {
                    challan_id :this.challan_id,
                    RSNFK : this.std.RSNFK,
                    AFP   : this.std.AFP,
                    SFP   : this.std.SFP,
                    RFK   : this.std.RFK,
                    SML   : this.std.SML,
                })
                .then(res=>{
                    if(res.data.errors){
                        this.$toastr.w(this.$msgSanitize(res.data.errors));
                    }
                    else {
                        this.isPopUp = false;
                        this.$alert({
                            icon:'success',
                            text: "মোট সলিড মিল্ক প্রয়োজন "+(this.$en2bn(this.std.SMP))+"কেজি",
                            confirmButtonText: `<i class="fa fa-check-square-o" aria-hidden="true"></i>`,
                        });  
                    }
                });
            },
            calculateStd(){
                var std    = Object.assign(this.std);
                //
                std.SAFP   = (std.AFP - std.SFP);
                std.PMSNFP = (100 - (+this.challan.QCPMMP + +this.challan.QCPMFP));
                //
                std.SFK   = this.$getSML(+std.RFK, +std.SFP, +std.SAFP, +std.RSNFK, std.PMSNFP, +this.challan.QCPMFP); // RFK, FP, SAFP, RSNFK, PMP, PMFP
                std.SMK   = this.$getSMK(std.SFK, std.SFP); // SFK, SFP
                std.SSNFK = this.$getSSNFK(std.SMK, std.SAFP); // SMK, SAFP
                std.SCLR  = this.$getSCLR(std.SAFP, std.SFP);
                //
                std.SSNFP = this.$getSNFP(std.SCLR, std.SFP);
                std.SML   = std.SMK / this.$clrDensity(std.SCLR, 'density');
                std.SMP   = (std.SSNFK - std.RSNFK) / (std.PMSNFP/100);
                //
                this.std  = std;
            },
            percentageCalculation(index, niddle)
            {
                if(niddle=='department'){
                    var item = Object.assign({}, this.milk_transfer[index]);
                    this.milk_transfer[index].kg = Number.parseFloat(this.milk_transfer[index].quantity * this.milk_transfer[index].density).toFixed(2);
                }
                else {
                    var item = Object.assign({}, this.milk_categories[index]);
                    this.milk_categories[index].kg = Number.parseFloat(this.milk_categories[index].quantity * this.milk_categories[index].density).toFixed(2);
                }

                var clr = this.$clrDensity(item.density);
                //
                item.kg             = Number.parseFloat(item.quantity*item.density).toFixed(2);
                item.fat_kg         = Number.parseFloat((item.kg/100) * item.fat_percentage).toFixed(2);
                item.snf_percentage = Number.parseFloat(((clr / 4) + (item.fat_percentage/5) + 0.14)).toFixed(2);
                item.snf_kg         = Number.parseFloat((item.kg/100) * item.snf_percentage).toFixed(2);
                //
                var department = this.milk_transfer[index];
                var category   = this.milk_categories[index];
                //
                if(niddle=='department' && department.quantity > 0 && department.density > 0 && department.fat_percentage > 0)
                {
                    this.milk_transfer[index] = item;
                    this.milk_transfer = Object.assign({}, this.milk_transfer);
                }
                else if(niddle!='department' && category.quantity > 0 && category.density > 0 && category.fat_percentage > 0)
                {
                    this.milk_categories[index] = item;
                    this.milk_categories = Object.assign({}, this.milk_categories);
                }
            },
            addType(){
                if(this.milk_categories.length < this.categories.length)
                this.milk_categories.push({
                    quantity : 0,
                    density : 0,
                    kg : 0,
                    fat_percentage : 0,
                    fat_kg : 0,
                    snf_percentage : 0,
                    snf_kg : 0,
                });
            },
            removeType(index){
                this.$delete(this.milk_categories, index);
            },
            addTransfer(){
                if(this.milk_transfer.length < this.departments.length)
                this.milk_transfer.push({
                    quantity : 0,
                    density : 0,
                    kg : 0,
                    fat_percentage : 0,
                    fat_kg : 0,
                    snf_percentage : 0,
                    snf_kg : 0,
                });
            },
            removeTransfer(index){
                this.$delete(this.milk_transfer, index);
            },
            SubmitSample(){
                this.is_submit = true;
                this.http('processing-plant/challan/sample-submit', 'submitsample', this.qc_sample);
            },
            submit(){
                this.$alert({
                    icon:'question',
                    text: 'আপনি চালানটি QC-তে পাঠাতে চাচ্ছেন ?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText:'না'
                }).then((result) => {
                    if (result.isConfirmed) { 
                        this.is_submit = true;
                        this.http('processing-plant/challan/receive/'+this.challan_id, 'challan-receive');
                    }
                });
            },
            milkCategorizedSubmit(){
                this.http('processing-plant/challan/category-wise-milk-submit/'+this.challan_id, 'milk-categorized', {milk_categories:this.milk_categories});
            },
            milkDepartmentWiseSubmit(){
                this.http('processing-plant/challan/department-wise-milk-submit/'+this.challan_id, 'milk-department', {departments:this.milk_transfer});
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='challan'){
                        if((this.kernel[key]))
                        {
                            this.challan = this.kernel[key].challan;
                            this.stock   = this.kernel[key].stock;
                            
                            //
                            this.bulk    = this.kernel[key].challan.bulk;
                            this.category_wise_milk   = this.kernel[key].challan.category_wise_milk;
                            this.department_wise_milk = this.kernel[key].challan.department_wise_milk;
                            //
                            this.std.QCPMMP = this.challan.QCPMMP;
                            this.std.QCPMFP = this.challan.QCPMFP;
                            this.std.AFP    = this.challan.AFP;
                            this.std.SFP    = this.challan.SFP;
                            this.std.SFK    = this.challan.SFK;
                            this.std.RSNFK  = this.challan.RSNFK;
                            
                            this.std.PMSNFP = this.challan.PMSNFP;
                            this.std.ASNFK  = 0;

                            this.stock.amount = +this.challan.SFP <= 0 ? this.stock.amount : this.challan.pre_stock;

                            this.stock.FK   = this.$getSFKWithL(this.stock.amount, this.stock.DENSITY, this.stock.FP);
                            this.stock.SNFK = this.$getSFKWithL(this.stock.amount, this.stock.DENSITY, this.stock.SNFP);

                            this.std.RFK    = +this.challan.RFK <= 0 ? (+this.stock.FK + +this.challan.prpt_fat_kg) : this.challan.RFK;
                            this.std.RSNFK  = +this.challan.RSNFK <= 0 ? (+this.stock.SNFK + +this.challan.prpt_snf_kg) : this.challan.RSNFK;

                            //
                            this.calculateStd();
                        }
                        this.loader = false;
                    }
                    else if(key=='challan-receive'){
                        this.is_submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s(' সফলভাবে QC-এর জন্য পাঠানো হয়েছে');
                            this.http('processing-plant/challan/view', 'challan', {
                                challan_id:this.challan_id
                            });
                        }
                    }
                    else if(key=='category'){
                        if(this.kernel[key].data && this.kernel[key].data[0].children){
                            this.categories = this.kernel[key].data[0].children;
                        }
                    }
                    else if(key=='department-list'){
                        this.departments = this.kernel[key].data;
                    }
                    else if(key=='submitsample')
                    {
                        if(this.kernel[key].errors)
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else{
                            this.http('processing-plant/challan/view', 'challan', {
                                challan_id:this.challan_id
                            });
                            this.$toastr.s("সফলভাবে সাবমিট হয়েছে");
                        }
                    }
                    else if(key=='milk-categorized'){
                        if(this.kernel[key].errors)
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        else {
                            this.category_wise_milk = this.kernel[key];
                            this.$toastr.s("সফলভাবে সাবমিট হয়েছে");
                        }
                    }
                    else if(key=='milk-department') 
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else {
                            this.loader = true;
                            this.http('processing-plant/challan/view', 'challan', {
                                challan_id:this.challan_id
                            });
                        } 
                    }
                }
            },
            challan_id(){
                this.loader = true;
                this.http('processing-plant/challan/view', 'challan', {
                    challan_id:this.challan_id
                });
            }
        }
    }
</script>

<style>
    .custom-btn-group {
        display: grid;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -59%);
    }
    table.part-1 tr td, table.part-1 tr th {
        border: 1px solid #00000024!important;
    }
</style>

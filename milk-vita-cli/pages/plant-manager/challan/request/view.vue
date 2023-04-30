<template>
    <form @submit.prevent="submit">
        <div class="card">
            <!-- // -->
            <div class="card-body min85vh">
                <div v-if="loader==false">
                    <!-- // -->
                    <div class="form-header pt-4">
                        <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                        <h2>দুধের চালান</h2>
                    </div>
                    <!-- // -->
                    <hr>
                    <!-- // -->
                    <div class="row">
                        <div class="col-md-2 text-right pt-2"><strong>সমিতির নামঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{form.association_name}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>তারিখঃ</strong></div>
                        <div class="col-md-4 pt-2">{{$en2bn(form.date)}}</div>
                    </div>
                    <!-- // -->
                    <div class="row">
                        <div class="col-md-2 text-right pt-2"><strong>চালান নাম্বারঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{$en2bn(form.voucher_no)}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>শিফটঃ</strong></div>
                        <div class="col-md-4 pt-2">{{$shift(form.shift)}}</div>
                    </div>
                    <!-- // -->
                    <div class="table-response mt-md-3">
                        <table class="table table-bordered part-1 challan-table">
                            <tr>
                                <th>পরিমান (লিটার)</th>
                                <th>তাপমাত্রা (০সে)</th>
                                <th>ল্যাক্টোমিটার রিডিং</th>
                                <th>ননী (%)</th>
                                <th>এস এন এফ</th>
                                <th colspan="2">ক্যান-সংখ্যা</th>
                            </tr>
                            <tr>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn((form.amount_of_milk > 0 ? form.amount_of_milk : '--'))" @change="canCalculation()" @input="canCalculation()" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn((form.temperature > 0 ? form.temperature : '--'))" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn((form.lectometer_reading > 0 ? form.lectometer_reading : '--'))" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn((form.noni > 0 ? form.noni : '--'))" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn((form.snf > 0 ? form.snf : '--'))" readonly></td>
                                <td class="p-0 text-center"><small>পূর্ণ</small></td>
                                <td class="p-0 text-center"><small>আংশিক</small></td>
                            </tr>
                            <tr>
                                <td><input type="text" min="0" :value="$en2bn(form.full_can)" readonly></td>
                                <td><input type="text" min="0" :value="$en2bn(form.half_can)" readonly></td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="">মন্তব্যঃ</label>
                        <div>{{form.remark}}</div>
                    </div>
                    
                    <div class="form-group col-md-4 d-flex justify-content-center">
                        <div>
                            <img :src="$store.state.host_server + form.manager_signature" height="50" class="mt-5" alt="" v-if="form.manager_signature!=''">
                            <h6 class="border-top text-center">সমিতির ম্যানেজার</h6>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 form-group" v-if="form.status!='pending'">
                            <label for="">গাড়ির ক্রমিক নং</label>
                            <input :type="inputType()" class="form-control" v-model="form.entry_no" placeholder="গাড়ির ক্রমিক নং লিখুন" disabled>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">গাড়ি পৌঁছানোর সময়</label>
                            <input type="text" class="form-control" v-model="form.received_time" placeholder="গাড়ি পৌঁছানোর সময় লিখুন" :readonly="form.status!='pending'">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">টক দুধের নমুনার রং</label>
                            <input type="text" class="form-control" v-model="form.sour_milk_sample_no" placeholder="টক দুধের নমুনার রং লিখুন" :readonly="form.status!='pending'">
                        </div>
                    </div>

                    <div class="table-response mt-md-3" style="margin-top:0!important">
                        <table class="table table-bordered part-1 challan-table">
                            <tr>
                                <th class="text-nowrap" width="120" style="vertical-align: middle;">দুধের ধরণ</th>
                                <th>পরিমান (কেজি)</th>
                                <th>স্পেসিফিক গ্রাভিটি</th>
                                <th>পরিমান (লিটার)</th>
                                <th>ননী (%)</th>
                                <th>এস এন এফ</th>
                                <th colspan="2" style="vertical-align: middle;">ক্যান-সংখ্যা</th>
                            </tr>

                            <!-- // -->
                            <tr v-if="form.status=='pending'">
                                <td rowspan="2" width="200" class="custom-challan-row">
                                    <select name="" id="" v-model="form.milk_cat_id" class="form-control" required>
                                        <option v-for="(row, key) in milk_categories" :key="key" :value="row.id">{{row.category_name}}</option>
                                    </select>
                                </td>
                                <td rowspan="2" class="custom-challan-row"><input type="number"  min="0" step="any" v-model="form.milk_amount_kg_in_plant" @change="milkDifference()" @input="milkDifference()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number"  min="0" step="any" v-model="form.specific_gravity_in_plant" @change="milkDifference()" @input="milkDifference()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" :readonly="true" v-model="form.milk_amount_liter_in_plant" ></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number"  min="0" step="any" v-model="form.noni_in_plant" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number"  min="0" step="any" v-model="form.snf_in_plant" required></td>
                                <td class="p-0 text-center"><small>পূর্ণ</small></td>
                                <td class="p-0 text-center"><small>আংশিক</small></td>
                            </tr>

                            <tr v-if="form.status=='pending'">
                                <td><input type="number" min="0" v-model="form.full_can" readonly></td>
                                <td><input type="number" min="0" v-model="form.half_can" readonly></td>
                            </tr>

                            <tr v-if="form.status=='pending'">
                                <th class="text-right">পার্থক্যঃ</th>
                                <td colspan="2" class="text-left pl-2" style="vertical-align: middle;">{{form.milk_difference}} (লিটার)</td>
                                <th class="text-right" colspan="4">খালি ক্যান ফেরতের সংখ্যাঃ</th>
                                <td class="custom-challan-row"><input type="number"  style="height:41px" v-model="form.total_can_return" min="0" required></td>
                            </tr>
                            <!-- // -->
                            
                            <tr v-if="form.status!='pending'">
                                <td rowspan="2" class="custom-challan-row">
                                    <select name="" id="" v-model="form.milk_cat_id" class="form-control" disabled>
                                        <option v-for="(row, key) in milk_categories" :key="key" :value="row.id">{{row.category_name}}</option>
                                    </select>
                                </td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" readonly :value="$en2bn(form.milk_amount_kg_in_plant > 0 ? form.milk_amount_kg_in_plant : '--')" @change="milkDifference()" @input="milkDifference()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" readonly :value="$en2bn(form.specific_gravity_in_plant > 0 ? form.specific_gravity_in_plant : '--')" @change="milkDifference()" @input="milkDifference()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" readonly :value="$en2bn(form.milk_amount_liter_in_plant > 0 ? form.milk_amount_liter_in_plant : '--')" ></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" readonly :value="$en2bn(form.noni_in_plant > 0 ? form.noni_in_plant : '--')" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" readonly :value="$en2bn(form.snf_in_plant > 0 ? form.snf_in_plant : '--')" required></td>
                                <td class="p-0 text-center"><small>পূর্ণ</small></td>
                                <td class="p-0 text-center"><small>আংশিক</small></td>
                            </tr>

                            <tr v-if="form.status!='pending'">
                                <td><input type="text" :value="$en2bn(form.full_can)" readonly></td>
                                <td><input type="text" :value="$en2bn(form.half_can)" readonly></td>
                            </tr>

                            <tr v-if="form.status!='pending'">
                                <th class="text-right">পার্থক্যঃ</th>
                                <td colspan="2" class="text-left pl-2" style="vertical-align: middle;">{{$en2bn(Number.parseFloat(form.milk_difference).toFixed(2))}} (লিটার)</td>
                                <th class="text-right" colspan="4">খালি ক্যান ফেরতের সংখ্যাঃ</th>
                                <td class="custom-challan-row"><input type="text" style="height:41px" :value="$en2bn(form.total_can_return)"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="row mt-5" v-if="form.status!='pending'">
                        <div class="form-group col-md-4 d-flex justify-content-center mt-5">
                            <div>
                                <img :src="$store.state.host_server + form.chilling_manager_signature" style="height:50px" alt="" v-if="form.chilling_manager_signature!=''">
                                <div v-else style="height:50px"></div>
                                <h6 class="border-top text-center">চিলিং প্লান্টের ম্যানেজার</h6>
                            </div>
                        </div>
                    </div>

                    <div class="text-right" v-if="form.status=='pending'">
                        <div class="btn-group">
                            <button :type="is_submit?'button':'submit'" class="btn btn-success">
                                <span v-if="is_submit">
                                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    <span>লোডিং</span>
                                </span>
                                <span v-else >
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    <span>সাবমিট</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <Loader :loader="loader" />
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel   : {},
                challans : [],
                user     : this.$store.state.auth.user,
                loader   : true,
                is_submit: false,
                editable : '',
                milk_categories: [],
                form     : {
                    shift              : this.$currentShift(),
                    noni               : 0,
                    snf                : 0,
                    full_can           : 0,
                    half_can           : 0,
                    lectometer_reading : 0,
                    amount_of_milk     : 0,
                    temperature        : 0,
                    remark             : '',
                    milk_difference    : 0,
                },
            }
        },
        mounted(){
            this.editable = this.$route.query.id;
        },
        methods:{
            submit(){
                if((this.form.specific_gravity_in_plant > 0) && (this.form.milk_amount_kg_in_plant > 0))
                {
                    this.is_submit = true;
                    this.http('chilling-plant/challan/receive/'+this.editable, 'challan-receive', this.form);
                }
                else {
                    this.$toastr.w("গ্রাভিটি এবং দুধের পরিমান লিখুন!!");
                }
            },
            inputType(){
                return (this.form.status=='pending' ? 'number' : 'text');
            },
            milkDifference(){
                if((this.form.specific_gravity_in_plant > 0) && (this.form.milk_amount_kg_in_plant > 0)){
                    //
                    this.form.milk_amount_liter_in_plant = (this.form.milk_amount_kg_in_plant / this.form.specific_gravity_in_plant);
                    this.form.milk_amount_liter_in_plant = Number.parseFloat(this.form.milk_amount_liter_in_plant).toFixed(4);
                    //
                    this.form.milk_difference = Number.parseFloat((this.form.amount_of_milk - this.form.milk_amount_liter_in_plant)).toFixed(2);
                }
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            editable(){
                this.http('association/milk/challan-list', 'challan', {
                    where:{id:this.editable}
                })
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='challan'){
                        this.http('product/category/list', 'milk-category', {
                            where:{slug:'raw-milk'},
                            children:1
                        });
                        //
                        if((this.kernel[key].data).length > 0){
                            this.form = this.kernel[key].data[0];
                        }
                        this.loader = false;
                    }
                    else if(key=='challan-receive'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('দুধের চালান সফলভাবে গ্রহণ করা হয়েছে');
                            this.http('association/milk/challan-list', 'challan', {
                                where:{id:this.editable}
                            })
                        }
                        this.is_submit = false;
                    }
                    else if(key=='milk-category'){
                        if((this.kernel[key].data).length > 0){
                            this.milk_categories = this.kernel[key].data[0].children;
                            //
                            this.form.milk_cat_id = ((this.milk_categories).length > 0 ? this.milk_categories[((this.milk_categories).length - 1)].id : '');
                            return 1;
                        }
                        this.milk_categories = [];
                    }
                }
            }
        }
    }
</script>



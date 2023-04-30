<template>
    <form @submit.prevent="submit">
        <div class="card">
            <!-- // -->
            <div class="card-body min85vh">
                <div v-if="loader==false && form.voucher_no">
                    <!-- // -->
                    <div class="form-header pt-4">
                        <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                        <h2>দুধের চালান</h2>
                    </div>
                    <!-- // -->
                    <hr>
                    <!-- // -->
                    <div class="d-flex justify-content-between">
                        <table>
                            <tr>
                                <td>ভাউচার নাম্বার</td>
                                <td>: {{form.voucher_no}}</td>
                            </tr>
                            <tr>
                                <td>গাড়ী</td>
                                <td>: {{form.bulk.vehicle}}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <td>তারিখ</td>
                                <td>: {{$en2bn($date())}}</td>
                            </tr>
                            <tr>
                                <td>ড্রাইভার</td>
                                <td>: {{form.bulk.driver_name}}</td>
                            </tr>
                        </table>
                    </div>
                    

                    <div class="table-response mt-md-3">

                        <label for="" class="bg-success pl-2 pr-2 text-white">বর্তমান দুধের স্টক {{$en2bn(stock)}}</label>
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
                            <tr>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_liter" @change="calculation()" @input="calculation()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_density" @change="calculation()" @input="calculation()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_kg" required readonly></td>
                                <!--  -->
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_fat_percentage" @change="calculation()" @input="calculation()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_fat_kg" required readonly></td>
                                <!--  -->
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_snf_percentage" required readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_snf_kg" required readonly></td>
                            </tr>
                        </table>

                    </div>
                    <div class="form-group">
                        <label for="">মন্তব্যঃ</label>
                        <textarea class="form-control" v-model="form.remark" rows="4" placeholder="আপনার মন্তব্য লিখুন"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">
                                <span v-if="is_submit">
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>&nbsp;
                                    লোডিং হচ্ছে...
                                </span>
                                <span v-else >
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                                    সাবমিট
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="loader==false && !form.voucher_no" style="position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);color:rgb(138 138 138);font-size:25px">
                    <div>
                        <span>কোনো চালান পাওয়া যায়নি</span>
                        <span>¯\_(ツ)_/¯</span>
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
                stock    : 0,
                form     : {},
                is_submit:false,
            }
        },
        mounted(){
            this.http('chilling-plant/challan/get-voucher', 'voucher');
        },
        methods:{
            calculation()
            {
                this.form.clpt_kg = Number.parseFloat(this.form.clpt_liter * this.form.clpt_density).toFixed(2);
                var item = Object.assign({}, this.form);
                var clr  = this.$clrDensity(item.clpt_density);
                //
                item.clpt_kg             = Number.parseFloat(item.clpt_liter*item.clpt_density).toFixed(2);
                item.clpt_fat_kg         = Number.parseFloat((item.clpt_kg/100) * item.clpt_fat_percentage).toFixed(2);
                item.clpt_snf_percentage = Number.parseFloat(((clr / 4) * (item.clpt_fat_percentage/5) + 0.14)).toFixed(2);
                item.clpt_snf_kg         = Number.parseFloat((item.clpt_kg/100) * item.clpt_snf_percentage).toFixed(2);
                //
                if(item.clpt_liter > 0 && item.clpt_density > 0 && item.clpt_fat_percentage > 0) this.form = item;
            },
            submit(){
                this.is_submit = true;
                if((this.stock > 0) && (this.form.amount > 0)){
                    this.http('chilling-plant/challan/store/'+this.form.id, 'submit', this.form);
                }
                else {
                    this.$toastr.w('দুঃখিত, অনুগ্রহ করে দুদের পরিমান এবং স্টক অনুসন্ধান করুন');
                }
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='stock'){
                        this.form.amount = (this.kernel[key].amount);
                        this.stock       = (this.kernel[key].amount);
                        this.loader      = false;
                    }
                    else if(key=='submit'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("চালানটি সফল ভাবে সম্পন্ন হয়েছে");
                            this.$router.push({path:'/plant-manager/challan/view?id='+(this.kernel[key].id)});
                        }
                        this.is_submit = false;
                    }
                    else if(key=='voucher'){
                        this.form = this.kernel[key];
                        if(this.form){
                            this.http('chilling-plant/milk-stock', 'stock');
                        }
                    }
                }
            }
        }
    }
</script>



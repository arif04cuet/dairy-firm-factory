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
                        <div class="col-md-4 pt-2" v-if="user">{{user.association_name}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>তারিখঃ</strong></div>
                        <div class="col-md-4 pt-2">{{$en2bn(form.date)}}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right pt-2"><strong>সমিতির কোডঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{user.association_code}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>শিফটঃ</strong></div>
                        <div class="col-md-4 pt-2">
                            <select class="form-control" v-model="form.shift" required>
                                <option v-for="(row, index) in $store.state.shifts" :key="index" :value="row.key">{{ row.value }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-response mt-md-3">
                        <table class="table table-bordered part-1">
                            <tr>
                                <th>পরিমান (লিটার)</th>
                                <th>তাপমাত্রা (০সে)</th>
                                <th>ল্যাক্টোমিটার রিডিং</th>
                                <th>ননী (%)</th>
                                <th>এস এন এফ</th>
                                <th colspan="2">ক্যান-সংখ্যা</th>
                            </tr>
                            <tr>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.amount_of_milk" @change="canCalculation()" @input="canCalculation()" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.temperature" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.lectometer_reading" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.noni" required></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.snf" required></td>
                                <td class="p-0 text-center"><small>পূর্ণ</small></td>
                                <td class="p-0 text-center"><small>আংশিক</small></td>
                            </tr>
                            <tr>
                                <td><input type="number" min="0" v-model="form.full_can" readonly></td>
                                <td><input type="number" min="0" v-model="form.half_can" readonly></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="">মন্তব্যঃ</label>
                        <textarea class="form-control" v-model="form.remark" rows="4" placeholder="আপনার মন্তব্য লিখুন"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">সাবমিট</button>
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
                editable : '',
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
                },
            }
        },
        mounted(){
            this.editable = this.$route.query.id;
        },
        methods:{
            submit(){
                if(this.form.amount_of_milk > 0){
                    this.http('association/milk/challan-update/'+this.editable, 'submit', this.form);
                }
                else {
                    this.$toastr.w('দুঃখিত, অনুগ্রহ করে দুদের পরিমান অনুসন্ধান করুন');
                }
            },
            canCalculation(){
                if(this.form.amount_of_milk > 0){
                    var total_can = (this.form.amount_of_milk / 40).toFixed(2);
                    /*************************************************/
                    this.form.full_can = (total_can.slice(0, total_can.indexOf('.')));
                    this.form.half_can = ((total_can.slice(total_can.indexOf('.'))) > 0 ? 1 : 0);
                }
                else {
                    this.form.full_can = 0;
                    this.form.half_can = 0;
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
                    if(key=='submit'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("চালানটি সফল ভাবে সম্পন্ন হয়েছে");
                            this.$router.push({path:'/association/manager/challan/list'});
                        }
                    }
                    else if(key=='challan'){
                        if((this.kernel[key].data).length > 0){
                            this.form = this.kernel[key].data[0];
                            this.loader = false;
                        }
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .custom-challan-row input{
        height: 51px;
    }
    table.part-1 td {
        padding: 0;
    }
    table.part-1 td input {
        border: none;
        width: 100%;
        box-shadow: none;
        outline: none;
        text-align: center;
        background: #fbfbfb;
    }
    table.part-1 td, table.part-1 th {
        text-align: center;
    }
</style>


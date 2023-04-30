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
                        <div class="col-md-2 text-right pt-2"><strong>ভাউচার নাম্বারঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{$en2bn(form.voucher_no)}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>শিফটঃ</strong></div>
                        <div class="col-md-4 pt-2">{{$shift(form.shift)}}</div>
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
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn(form.amount_of_milk)" @change="canCalculation()" @input="canCalculation()" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn(form.temperature)" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn(form.lectometer_reading)" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn(form.noni)" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="text" min="0" step="any" :value="$en2bn(form.snf)" readonly></td>
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
                            <h6 class="border-top">ম্যানেজারের স্বাক্ষর</h6>
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
                        console.log(this.kernel[key].data);
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


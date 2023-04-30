<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-plus"></i>
                    নতুন যোগ করুন
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/reports/transfer-milk-to-cold-room/list" class="btn btn-primary" >
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td>তারিখঃ &nbsp;</td>
                                <td>
                                    <date-picker
                                        placeholder=" তারিখ নির্বাচন করুন "
                                        v-model="form.date"
                                        :bind="$local('bind')"
                                        :locale="$store.state.local"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td>কোড নং- &nbsp;</td>
                                <td>
                                    <input type="text" v-model="form.code_no" class="form-control text-left p-2">
                                </td>
                            </tr>
                            <tr>
                                <td>তাপমাত্রাঃ &nbsp;</td>
                                <td>
                                    <input type="text" v-model="form.temperature" class="form-control text-left p-2">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- // -->
                <br>
                <!-- // -->
                <div class="table-responsive">
                    <caption class="text-nowrap mb-0 pb-0">পাস্তরিত তরল দুধ</caption>
                    <!-- // -->
                    <table class="table table-bordered cold-room" v-if="form.items.length > 0">
                        <tr v-for="(unit, key) in units" :key="key">
                            {{(form.items[key].type="general") ? '' : ''}}
                            {{(form.items[key].unit=unit.en) ? '' : ''}}
                            <td class="text-nowrap p-1 align-middle">পূর্ণ কলাম সংখ্যাঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[key].full_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">আংশিক কলাম ক্রেটঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[key].partial_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">{{unit.bn}}</td>
                            <td class="p-1"><input type="text" v-model="form.items[key].total_milk" @change="grandTotal" @input="grandTotal"  class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">লিটার</td>
                            <td class="text-nowrap p-1 align-middle">মোট পেকেট সংখ্যাঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[key].total_packet" class="form-control"></td>
                        </tr>
                        <!-- // -->
                        <tr><td colspan="9"></td></tr>
                        <!-- // -->
                        <tr>
                            <td class="text-nowrap p-1 align-middle" rowspan="2">টোনড মিল্কঃ</td>
                            {{(form.items[4].type="toned") ? '' : ''}}
                            {{(form.items[4].unit="1liter") ? '' : ''}}
                            <td class="p-1"><input type="text" v-model="form.items[4].full_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">আংশিক কলাম ক্রেটঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[4].partial_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">১ লিটার</td>
                            <td class="p-1"><input type="text" v-model="form.items[4].total_milk" @change="grandTotal" @input="grandTotal" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">লিটার</td>
                            <td class="text-nowrap p-1 align-middle">মোট পেকেট সংখ্যাঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[4].total_packet" class="form-control"></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            {{(form.items[5].type="toned") ? '' : ''}}
                            {{(form.items[5].unit="500ml") ? '' : ''}}
                            <td class="p-1"><input type="text" v-model="form.items[5].full_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">আংশিক কলাম ক্রেটঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[5].partial_column" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">১/২ লিটার</td>
                            <td class="p-1"><input type="text" v-model="form.items[5].total_milk" @change="grandTotal" @input="grandTotal" class="form-control"></td>
                            <td class="text-nowrap p-1 align-middle">লিটার</td>
                            <td class="text-nowrap p-1 align-middle">মোট পেকেট সংখ্যাঃ</td>
                            <td class="p-1"><input type="text" v-model="form.items[5].total_packet" class="form-control"></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td colspan="3" class="text-right p-1 align-middle">সর্বমোট ক্রেট সংখ্যাঃ</td>
                            <td class="p-1"><input type="text" v-model="form.total_crate" class="form-control"></td>
                            <td colspan="4" class="text-right p-1 align-middle">মোট প্যাকেটঃ</td>
                            <td class="p-1"><input type="text" v-model="form.total_packet" class="form-control"></td>
                        </tr>
                    </table>
                </div>
                <!-- // -->
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td>মোটঃ&nbsp;</td>
                                <td><input type="text" v-model="form.total" class="form-control"></td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                            <tr>
                                <td>ক্রিম ক্যানঃ&nbsp;</td>
                                <td><input type="text" v-model="form.total_cream_can" class="form-control"></td>
                                <td>&nbsp;টি</td>
                            </tr>
                            <tr>
                                <td>সর্বমোট ক্রিমঃ&nbsp;</td>
                                <td><input type="text" v-model="form.total_cream" class="form-control"></td>
                                <td>&nbsp;কেজি</td>
                            </tr>
                            <tr>
                                <td>বাল্ক মিল্কঃ&nbsp;</td>
                                <td><input type="text" v-model="form.bulk_milk" class="form-control"></td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                            <tr>
                                <td>সর্বমোটঃ&nbsp;</td>
                                <td><input type="text" v-model="form.grand_total" class="form-control"></td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                        </table>
                        <!-- // -->
                        <button class="btn btn-success float-right">Submit</button>
                    </div>
                </div>
            </form>
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
                kernel : {},
                loader : false,
                units  : [{en:'1liter', bn:'১ লিটার'}, {en:'500ml', bn:'১/২ লিটার'}, {en:'250ml',bn:'২৫০মিলি'}, {en:'200ml', bn:'২০০মিলি'}],
                form   : {
                    items : []
                },
                is_submit : false,
            }
        },
        mounted(){
            for(var i=0; i<6; i++){
                this.form.items.push({
                    "type"          : "",
                    "unit"          : "",
                    "full_column"   : "",
                    "partial_column": "",
                    "total_milk"    : "",
                    "total_packet"  : "",
                });
            }
        },
        methods:{
            grandTotal()
            {
                this.form.total = 0;
                Object.values(this.form.items).forEach(item=>{
                    this.form.total += +item.total_milk;
                });

                this.form.total = isNaN(this.form.total) ? 0 : this.form.total;
            },
            submit(){
                this.is_submit = true;
                this.http('report/transfer-milk-to-cold-room/store', 'store', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='store'){
                        this.is_submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                            return 1;
                        }
                        this.$router.push({path:'/reports/transfer-milk-to-cold-room/view?id='+this.kernel[key]});
                    }
                }
            }
        }
    }
</script>

<style scoped>
    table.cold-room tr td {
        border-color: #e3e3e3!important;;
    }
</style>
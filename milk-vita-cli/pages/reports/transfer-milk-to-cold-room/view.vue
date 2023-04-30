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
                                <td>{{$en2bn(record.date)}}
                                </td>
                            </tr>
                            <tr>
                                <td>কোড নং- &nbsp;</td>
                                <td>{{record.code_no}}</td>
                            </tr>
                            <tr>
                                <td>তাপমাত্রাঃ &nbsp;</td>
                                <td>{{record.temperature}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- // -->
                <div class="table-responsive">
                    <caption class="text-nowrap mb-0 pb-0">পাস্তরিত তরল দুধ</caption>
                    <!-- // -->
                    <table class="table table-bordered cold-room" v-if="record.items && record.items.length > 0">
                        <tr v-for="(item, key) in record.items" :key="key" v-if="item.type=='general'">
                            <td class="text-nowrap p-1 align-middle">পূর্ণ কলাম সংখ্যাঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].full_column}}</td>
                            <td class="text-nowrap p-1 align-middle">আংশিক কলাম ক্রেটঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].partial_column}}</td>
                            <td class="text-nowrap p-1 align-middle">{{item.unit}}</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].total_milk}}</td>
                            <td class="text-nowrap p-1 align-middle">লিটার</td>
                            <td class="text-nowrap p-1 align-middle text-right">মোট পেকেট সংখ্যাঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].total_packet}}</td>
                        </tr>
                        <!-- // -->
                        <tr><td colspan="9"></td></tr>

                        <tr v-for="(item, key) in record.items" :key="key" v-if="item.type!='general'">
                            <td class="text-nowrap p-1 align-middle" v-if="(key < (record.items.length - 1))" :rowspan="(key < (record.items.length - 1)) ? '2':''">টোনড মিল্কঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].full_column}}</td>
                            <td class="text-nowrap p-1 align-middle">আংশিক কলাম ক্রেটঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].partial_column}}</td>
                            <td class="text-nowrap p-1 align-middle">{{item.unit}}</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].total_milk}}</td>
                            <td class="text-nowrap p-1 align-middle">লিটার</td>
                            <td class="text-nowrap p-1 align-middle text-right">মোট পেকেট সংখ্যাঃ</td>
                            <td class="p-1 text-center" width="150">{{record.items[key].total_packet}}</td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td colspan="3" class="text-right p-1 align-middle">সর্বমোট ক্রেট সংখ্যাঃ</td>
                            <td class="p-1 text-center">{{record.total_crate}}</td>
                            <td colspan="4" class="text-right p-1 align-middle">মোট প্যাকেটঃ</td>
                            <td class="p-1 text-center">{{record.total_packet}}</td>
                        </tr>
                    </table>
                </div>
                <!-- // -->
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <table class="table table-bordered cold-room">
                            <tr>
                                <td>মোটঃ&nbsp;</td>
                                <td class="text-center">{{record.total}}</td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                            <tr>
                                <td>ক্রিম ক্যানঃ&nbsp;</td>
                                <td class="text-center">{{record.total_cream_can}}</td>
                                <td>&nbsp;টি</td>
                            </tr>
                            <tr>
                                <td>সর্বমোট ক্রিমঃ&nbsp;</td>
                                <td class="text-center">{{record.total_cream}}</td>
                                <td>&nbsp;কেজি</td>
                            </tr>
                            <tr>
                                <td>বাল্ক মিল্কঃ&nbsp;</td>
                                <td class="text-center">{{record.bulk_milk}}</td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                            <tr>
                                <td>সর্বমোটঃ&nbsp;</td>
                                <td class="text-center">{{record.grand_total}}</td>
                                <td>&nbsp;লিটার</td>
                            </tr>
                        </table>
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
                form   : {
                    items : []
                },
                record  : {
                    items : []
                }
            }
        },
        mounted(){
            this.getLlist();
        },
        methods:{
            getLlist(){
                this.loading = true;
                this.http('report/transfer-milk-to-cold-room/details/'+this.$route.query.id, 'list', );
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='list'){
                        this.loading = false;
                        this.record  = this.kernel[key];
                    }
                }
            }
        }
    }
</script>

<style scoped>
    table.cold-room tr td {
        border-color: #b2b2b2!important;
        font-size: 15px;
    }
</style>
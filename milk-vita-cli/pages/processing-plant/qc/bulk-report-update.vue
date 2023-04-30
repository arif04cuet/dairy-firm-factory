<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;&nbsp;কিউ.সি / ল্যাব</h5>
                <nuxt-link to="/processing-plant/qc/bulk-list" class="btn btn-primary"> <i class="fa fa-list"></i> তালিকায় ফিরে যান</nuxt-link>
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
                <fieldset class="border p-2">
                    <legend  class="w-auto">কিউ.সি  পরীক্ষা</legend>
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
                    <!-- // -->
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
                reports         : [{
                    test_id : '',
                    result  : '',
                }],
                is_processing:false,
            }
        },
        mounted(){
            this.http('test/list', 'test', {
                type : 'qc',
            });
            //
            this.http('processing-plant/bulk/list', 'bulk', {
                where : {id:this.$route.query.id},
                type  : 'qc',
            });
            this.http('processing-plant/bulk/qc-report/list/'+this.$route.query.id, 'report');
        },
        methods:{
            submit(){
                this.is_processing = true;
                if(this.$route.query.id){
                    this.http('processing-plant/bulk/qc-report/update', 'store', {
                        bulk_id:this.$route.query.id,
                        reports:this.reports
                    });
                }
                else {
                    this.$toastr.w('দুঃখিত, প্রক্রিয়া সম্ভব নয়');
                }
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
            kernel(){
                for(const key in this.kernel){
                    if(key=='bulk'){
                        this.loader = false;
                        this.bulk   = this.kernel[key].data[0]
                    }
                    else if(key=='test'){
                        this.tests = this.kernel[key].data;
                    }
                    else if(key=='report'){
                        this.reports = this.kernel[key];
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


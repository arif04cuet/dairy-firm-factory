<template>
    <div class="card">
        <div class="card-body min85vh">
            <div class="form-header">
                <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                <h2>প্রসেসিং প্লান্ট</h2>
                <h2>প্রসেসিং প্লান্টের নাম</h2>
            </div>
            <!-- // -->
            <hr>
            <!-- // -->
            <div v-if="loader==false">
                <!-- // -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-3">তারিখ</div>
                            <div class="col-md-9">: {{$en2bn(bulk.date)}}</div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">তৈরিকারক</div>
                            <div class="col-md-9">: {{bulk.user_name}}</div>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-3">চালকের নাম</div>
                            <div class="col-md-9">: {{bulk.driver_name}}</div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">গাড়ী</div>
                            <div class="col-md-9">: {{bulk.vehicle}}</div>
                        </div>
                    </div>  
                </div>
                <!-- // -->
                <hr class="m-0">
                <!-- // -->
                <div class="table-responsive">
                    <caption class="text-nowrap m-0 pb-0"><strong>চিলিং প্লান্টের তথ্য</strong></caption>
                    <table class="table table-bordered custom">
                        <thead>
                            <tr class="text-center">
                                <th width="10">ক্রমিক</th>
                                <th>চিলিং প্লান্টের নাম</th>
                                <th>ভাউচার নাম্বার</th>
                                <th>দুধের পরিমান</th>
                                <th>বর্তমান অবস্থা</th>
                                <th width="10">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <!-- // -->
                        <tbody>
                            <tr v-for="(row, index) in bulk.challans" :key="index">
                                <td>{{$en2bn(++index)}}</td>
                                <td>{{row.chilling_plant_name}}</td>
                                <td>{{$en2bn(row.voucher_no)}}</td>
                                <td>{{$en2bn(row.clpt_kg)}}&nbsp;লিটার</td>
                                <td class="text-capitalize">{{(row.status).replaceAll('_', ' ')}}</td>
                                <td class="text-center">
                                    <div class="btn-group custom">
                                        <nuxt-link :to="'/processing-plant/bulk/challan-view?id='+row.id" class="btn btn-success" title="ডিটেলস দেখুন">
                                            <i class="fa fa-eye"></i>
                                        </nuxt-link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- // -->
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
                kernel : {},
                loader : true,
                is_submit:false,
                bulk_id:'',
                bulk:{},
            }
        },
        mounted(){
            this.bulk_id = this.$route.query.id;
        },
        methods:{
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
                        this.http('processing-plant/bulk/receive/'+this.bulk_id, 'bulk-receive');
                    }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='bulk'){
                        if((this.kernel[key].data).length>0){
                            this.bulk   = this.kernel[key].data[0];
                            this.loader = false;
                        }
                    }
                    else if(key=='bulk-receive'){
                        this.is_submit = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s(' সফলভাবে QC-এর জন্য পাঠানো হয়েছে');
                            this.http('processing-plant/bulk/list', 'bulk', {
                                where:{id:this.bulk_id}
                            });
                        }
                    }
                }
            },
            bulk_id(){
                this.http('processing-plant/bulk/list', 'bulk', {
                    where:{id:this.bulk_id}
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
</style>

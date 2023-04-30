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
                        <div class="col-md-2 text-right pt-2"><strong>প্লান্টের নামঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{form.chilling_plant_name}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>তারিখঃ</strong></div>
                        <div class="col-md-4 pt-2">{{$en2bn(form.date)}}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right pt-2"><strong>গাড়ীঃ</strong></div>
                        <div class="col-md-4 pt-2" v-if="user">{{(form.bulk.vehicle)}}</div>
                        <!-- // -->
                        <div class="col-md-2 text-right pt-2"><strong>ড্রাইভারঃ</strong></div>
                        <div class="col-md-4 pt-2">{{form.bulk.driver_name}}</div>
                    </div>

                    <div class="table-response mt-md-3">
                        <table class="table table-bordered part-1 bg-light">
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
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_liter" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_density" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_kg" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_fat_persentase" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_fat_kg" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_snf_persentase" readonly></td>
                                <td rowspan="2" class="custom-challan-row"><input type="number" min="0" step="any" v-model="form.clpt_snf_kg" readonly></td>
                            </tr>
                        </table>
                    </div>
                    <div>মন্তব্যঃ{{form.remark}}</div>
                    
                    <div class="row">
                        <div class="form-group col-md-4 mt-5">
                            <div class="mt-5 text-center">
                                <img :src="$store.state.host_server + form.chilling_plant_manger_signature" height="50" alt="" v-if="form.chilling_plant_manger_signature!=''">
                                <h6 class="border-top text-center">ম্যানেজারের স্বাক্ষর (চিলিং প্লান্ট)</h6>
                            </div>
                        </div>

                        <div class="col-md-4"></div>
                        
                        <div class="form-group col-md-4 mt-5">
                            <div v-if="form.is_driver_receive==1" class="mt-5 text-center">
                                <img :src="$store.state.host_server + form.bulk.driver_signature" height="50" alt="" v-if="form.bulk.driver_signature!=''">
                                <h6 class="border-top text-center">চালকের স্বাক্ষর</h6>
                            </div>

                            <div class="text-right" v-else >
                                <div style="height:50px"></div>
                                <div class="btn-group">
                                    <button class="btn btn-success" @click="submit()" v-if="form.is_submit==1">
                                        <span v-if="is_submit==false"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;নিশ্চিত করুন</span>
                                        <span v-else ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;অপেক্ষা করুন</span>
                                    </button>
                                </div>
                            </div>
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
                stock    : 0,
                edit_id  : '',
                is_submit: false,
                form     : {
                    lectometer_reading : 0,
                    temperature        : 0,
                    noni               : 0,
                    snf                : 0,
                    amount             : 0,
                    remark             : "",
                },
            }
        },
        mounted(){
            this.edit_id = this.$route.query.id;
        },
        methods:{
            submit(){
                this.$alert({
                    icon:'question',
                    text: 'আপনি চালান গ্রহণ করতে ইচ্ছুক?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText:'না'
                }).then((result) => {
                    if (result.isConfirmed) { 
                        this.is_submit = true;
                        this.http('processing-plant/challan/receive/'+this.edit_id, 'receive');
                    }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='readable'){
                        console.log(this.kernel[key].data);
                        this.loader = false;
                        if((this.kernel[key].data).length > 0){
                            this.form = (this.kernel[key].data)[0];
                        }
                    }
                    else if(key=='receive'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.http('chilling-plant/challan/list', 'readable', {
                                where:{id:this.edit_id}
                            });
                            this.$toastr.s('চালানটি গ্রহণ করা হয়েছে');
                        }
                        this.is_submit=false;
                    }
                }
            },
            edit_id(){
                this.http('chilling-plant/challan/list', 'readable', {
                    where:{id:this.edit_id}
                });
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


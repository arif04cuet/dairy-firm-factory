<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0"><img src="/images/info.webp" height="25px" alt=""> পণ্যের ট্রান্সফারের তথ্য </h5>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/product-stock/transfer/list" class="btn btn-primary"  >
                    <!-- v-if="$ck_action('/processing-plant/stock/transfer/add')" -->
                        <img src="/images/requirement-white.webp" height="25px" alt="">
                        <span>তালিকায় ফিরে যান</span>
                    </NuxtLink>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form>
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <table>
                            <tr>
                                <td>তারিখ</td>
                                <td>: {{$en2bn(challan.date)}}</td>
                            </tr>
                            <tr>
                                <td>প্রসেসিং প্লান্ট</td>
                                <td>: {{challan.to_processing_plant_name}}</td>
                            </tr>
                        </table>
                        <!-- // -->
                    </div>

                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <table>
                            <tr>
                                <td>তৈরিকারক</td>
                                <td>: {{$en2bn(challan.sender ? challan.sender.name_bn : '---')}}</td>
                            </tr>
                            <tr>
                                <td>প্রসেসিং প্ল্যান্ট</td>
                                <td>: {{challan.from_processing_plant_name}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>


                <div class="card-body bg-white">
                    <h4><i class="fa fa-table" aria-hidden="true"></i> পণ্যের তথ্য</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered custom">
                            <tr>
                                <th colspan="4" class="text-left">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                    পণ্যের তথ্য
                                </th>
                                <th colspan="9" class="text-left">
                                    <i class="fa fa-database" aria-hidden="true"></i>
                                    পণ্যের কিউ.সি. তথ্য
                                </th>
                            </tr>
                            <tr>
                                <th width="40">ক্রমিক</th>
                                <th>পণ্যের নাম</th>
                                <th>ইউনিট</th>
                                <th>পরিমান</th>
                                <th class="text-nowrap">লিটার</th>
                                <th class="text-nowrap">ঘনত্ব</th>
                                <th class="text-nowrap">কেজি</th>
                                <th class="text-nowrap">ফ্যাট %</th>
                                <th class="text-nowrap">এস.এন.ফ %</th>
                                <th class="text-nowrap">ফ্যাট(কেজি)</th>
                                <th class="text-nowrap">এস.এন.ফ(কেজি)</th>
                                <th>অ্যাকশন</th>
                            </tr>
                            <!-- // -->
                            <tr v-for="(row, index) in challan.items" :key="index">
                                <td>{{$en2bn(index+1)}}</td>
                                <td class="text-nowrap">{{row.product_name}}</td>
                                <td width="130">{{row.unit_name}}</td>
                                <td width="130">{{$en2bn(floar(row.quantity))}}</td>
                                <td width="130">{{$en2bn(floar(row.quantity_litre))}}</td>
                                <td width="130">{{$en2bn(floar(row.density))}}</td>
                                <td width="130">{{$en2bn(floar(row.quantity_kg))}}</td>
                                <td width="130">{{$en2bn(floar(row.fat_persentase))}}</td>
                                <td width="130">{{$en2bn(floar(row.snf_persentase))}}</td>
                                <td width="130">{{$en2bn(floar(row.fat_kg))}}</td>
                                <td width="130">{{$en2bn(floar(row.snf_kg))}}</td>
                                <td width="30">
                                    <div class="btn-group custom">
                                        <button class="btn btn-danger" @click="rmRow(index)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="challan.items && challan.items.length >0">
                                <th colspan="3" rowspan="4" class="text-right">সর্বমোট পরিমানঃ</th>
                                <td class="text-center">{{$en2bn(floar(total_quantity))}}</td>
                                <td colspan="8" class="text-center"></td>
                            </tr>

                            <!-- // -->
                            <tr v-if="challan.items && challan.items.length ==0">
                                <th colspan="13">কোর্ট-এ কোনো পণ্য পাওয়া যায়নি</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- // -->
                <div class="row justify-content-end">
                    <div class="col-md-3" style="display:grid">
                        <img height="35" style="margin:auto" :src="((challan.receiver && challan.receiver.signature_path) ? challan.receiver.signature_path : '/gif/loader-v1.01.gif')" alt="">
                        <small class="text-center text-nowrap border-top">{{challan.receiver ? challan.receiver.name_bn : '---'}} </small>
                    </div>
                </div>
            </form>
            <Loader :loader="is_loader" />
        </div>
    </div>
</template>

<script>
export default {
    layout: "admin",
    data() {
        return {
            kernel         : {},
            form           : {},
            location_data  : '',
            plants         : [],
            challan        : {
                date:this.$date(),
                total_quantity:0,
            },
            user      : this.$auth.user,
            is_loader : true,
        }
    },
    mounted() {
        this.http('stock-transfer/finish-product/details/'+this.$route.query.id, 'record');
    },
    methods: {
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
        floar(number, digit=3){
            return Number.parseFloat(number).toFixed(digit)
        }
    },
    watch: {
        kernel: function () {
            for (const key in this.kernel) {
                if(key == "record") {
                    this.challan   = this.kernel[key];
                    var total_quantity = 0;
                    if(this.kernel[key].items) Object.values(this.kernel[key].items).forEach((item)=>{total_quantity += +item.quantity});
                    this.total_quantity = total_quantity;
                    this.is_loader = false;
                }
                else if(key=='plants' && this.kernel[key].data){
                    this.plants = this.kernel[key].data;
                }
            }
        },
    },
};
</script>


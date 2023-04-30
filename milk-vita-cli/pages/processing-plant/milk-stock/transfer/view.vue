<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0"><i class="fa fa-braille" aria-hidden="true"></i> ভিউ ট্রান্সফার </h5>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/stock/transfer/list" class="btn btn-primary"  >
                    <!-- v-if="$ck_action('/processing-plant/stock/transfer/add')" -->
                        <i class="fa fa-list"></i>
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

                <div class="table-responsive mt-md-3">
                    <table class="table table-bordered custom">
                        <thead>
                            <tr>
                                <th class="p-1" colspan="3">তরল দুধের পরিমান</th>
                                <th class="p-1" colspan="2">ফ্যাট</th>
                                <th class="p-1" colspan="2">এস এন এফ</th>
                                <th rowspan="2" width="100" class="text-nowrap">বর্তমান অবস্থা</th>
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
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{challan.sdr_liter}}</td>
                                <td>{{challan.sdr_density}}</td>
                                <td>{{challan.sdr_kg}}</td>
                                <!--  -->
                                <td>{{challan.sdr_fat_persentase}}</td>
                                <td>{{challan.sdr_fat_kg}}</td>
                                <!--  -->
                                <td>{{challan.sdr_snf_persentase}}</td>
                                <td>{{challan.sdr_snf_kg}}</td>
                                <td>{{challan.status}}</td>
                            </tr>
                        </tbody>
                    </table>
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
                sdr_liter           : 0,
                sdr_density         : 0,
                sdr_kg              : 0,
                sdr_fat_persentase  : 0,
                sdr_fat_kg          : 0,
                sdr_snf_persentase  : 0,
                sdr_snf_kg          : 0,
            },
            user      : this.$auth.user,
            is_loader : true,
        }
    },
    mounted() {
        this.http('stock-transfer/milk-send/details/'+this.$route.query.id, 'record');
    },
    methods: {
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
    },
    watch: {
        kernel: function () {
            for (const key in this.kernel) {
                if(key == "record") {
                    this.challan = this.kernel[key];
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


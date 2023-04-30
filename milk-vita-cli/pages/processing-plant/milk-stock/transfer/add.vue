<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0"><i class="fa fa-list" aria-hidden="true"></i> নতুন ট্রান্সফার </h4>
                <div class="btn-group">
                    <NuxtLink to="/processing-plant/stock/transfer/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>
                        <span>তালিকায় ফিরে যান</span>
                    </NuxtLink>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()">
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <div class="form-group">
                            <date-picker
                                :locale="$store.state.local"
                                v-model="challan.date"
                            />
                        </div>
                        <div class="form-group mb-0">
                            <select-picker
                                v-model="challan.to_processing_plant_id"
                                placeholder="প্রসেসিং প্ল্যান্ট নির্বাচন করুন"
                                :options="plants"
                                label="processing_plant_name"
                                :reduce="row=>row.id"
                            />
                        </div>
                    </div>

                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <table>
                            <tr>
                                <td>তৈরিকারক</td>
                                <td>: {{user ? user.name_bn : 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>প্রসেসিং প্ল্যান্ট</td>
                                <td>: {{user ? user.entity_real_name : 'N/A'}}</td>
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
                                <td><input type="number" step="any" v-model="challan.sdr_liter" class="form-control text-center"></td>
                                <td><input type="number" step="any" v-model="challan.sdr_density" class="form-control text-center"></td>
                                <td><input type="number" step="any" v-model="challan.sdr_kg" class="form-control text-center"></td>
                                <!--  -->
                                <td><input type="number" step="any" v-model="challan.sdr_fat_persentase" class="form-control text-center"></td>
                                <td><input type="number" step="any" v-model="challan.sdr_fat_kg" class="form-control text-center"></td>
                                <!--  -->
                                <td><input type="number" step="any" v-model="challan.sdr_snf_persentase" class="form-control text-center"></td>
                                <td><input type="number" step="any" v-model="challan.sdr_snf_kg" class="form-control text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <div class="btn-group">
                        <button :type="is_submit==true?'button':'submit'" class="btn btn-success" style="min-width:127px">
                            <span v-if="is_submit"><i class="fa fa-spinner fa-spin"></i>&nbsp;লোডিং...</span>
                            <span v-else ><i class="fa fa-floppy-o"></i>&nbsp;সাবমিট করুন</span>
                        </button>
                    </div>
                </div>
            </form>
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
                date       : this.$date(),
                sdr_liter           : 0,
                sdr_density         : 0,
                sdr_kg              : 0,
                sdr_fat_persentase  : 0,
                sdr_fat_kg          : 0,
                sdr_snf_persentase  : 0,
                sdr_snf_kg          : 0,
            },
            user : this.$auth.user,
            is_submit : false,
        }
    },
    mounted() {
        this.http('processing-plant/all', 'plants');
    },
    methods: {
        submit: function () {
            this.is_submit = true;
            this.http("stock-transfer/milk-send/store", "submit", this.challan);
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
    },
    watch: {
        kernel: function () {
            for (const key in this.kernel) {
                if(key == "submit") {
                    if(this.kernel[key].errors)
                        this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                    else {
                        this.$toastr.s("সফলভাবে সাবমিট হয়েছে");
                        this.$router.push({path:'/processing-plant/stock/transfer/view?id='+this.kernel[key]});
                    }
                    this.is_submit = false;
                }
                else if(key=='plants' && this.kernel[key].data)
                {
                    var $sanitize = [];
                    (this.kernel[key].data).forEach(row => {
                        if(row.id!=this.user.processing_plant_id)
                            $sanitize.push(row);
                    });
                    this.plants = $sanitize;
                }
            }
        },
    },
};
</script>


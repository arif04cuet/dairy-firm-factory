<template>
    <div class="card">
        <div class="card-header">
            <h3 class="m-0">
            <i class="fa fa-user-plus" aria-hidden="true"></i> নতুন প্রসেসিং প্লান্ট
            </h3>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()">
                <!-- // -->
                <div class="row form-group">
                    <label for="" class="col-md-3 text-md-right">প্রসেসিং প্লান্টের নাম</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="প্রসেসিং প্লান্টের নাম লিখুন" v-model="form.processing_plant_name" required>
                    </div>
                </div>
                <!-- // -->
                <Location v-model="location_data">
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-md-right">বিভাগ</label>
                        <div class="col-md-6" data-division></div>
                    </div>
                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-md-right">জেলা</label>
                        <div class="col-md-6" data-district data-required="true"></div>
                    </div>
                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-md-right">উপজেলা</label>
                        <div class="col-md-6" data-upazila data-required="true"></div>
                    </div>
                    <!-- // -->
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-md-right">ইউনিয়ন</label>
                        <div class="col-md-6" data-union data-required="true"></div>
                    </div>
                </Location>
                
                <!-- // -->
                <div class="row form-group">
                    <label for="" class="col-md-3 text-md-right">পুরো ঠিকানা</label>
                    <div class="col-md-6">
                        <textarea
                            type="text"
                            class="form-control"
                            placeholder="প্রক্রিয়াকরণ কারখানার ঠিকানা লিখুন"
                            v-model="form.full_address"
                            rows="3"
                            required
                        ></textarea>
                    </div>
                </div>
                <!-- // -->
                <div class="row form-group">
                    <div class="col-md-9 text-right">
                        <div class="btn-group">

                            <button type="button" v-if="is_submit" class="btn btn-success float-right">
                                <i class="fa fa-spinner fa-spin fa-fw"></i>
                                <span>অপেক্ষা করুন</span>
                            </button>

                            <button type="submit" v-else class="btn btn-success float-right">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                <span>সংরক্ষণ করুন</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- // -->
            </form>
        </div>
    </div>
</template>

<script>
import Location from '@/components/system/Location.vue';
export default {
    components:{Location},
    layout: "admin",
    name: "processingPlant",
    data() {
        return {
            kernel      : {},
            divisions   : [],
            districts   : [],
            thanas      : [],
            entities    : [],
            form        : {
                processing_plant_name: "",
                full_address         : "",
                division_id     : "",
                district_id     : "",
                upazila_id      : "",
                union_id        : "",
                longitude       : "",
                latitude        : "",
            },
            location_data:{},
            is_submit : false,
        }
    },
    mounted() {
        this.http("location/divisions", "divisions");
    },
    methods: {
        submit: function () {
            this.is_submit = true;
            this.http("processing-plant/add", "store", this.form);
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
        checkLocation: function (type, id) {
            var url =  "location/" + (type == "division" ? "districts" : type == "district" ? "thanas" : "");
            //
            this.$axios.post(url, { where: { [type + "_id"]: id } }).then((res) => {
                if (type == "division") {
                    this.districts = res.data;
                } 
                else if (type == "district") {
                    this.thanas = res.data;
                }
            });
        },
    },
    watch: {
        location_data:function(){
            this.form.division_id = this.location_data.division_id; 
            this.form.district_id = this.location_data.district_id; 
            this.form.upazila_id  = this.location_data.upazila_id; 
            this.form.union_id    = this.location_data.union_id; 
        },
        kernel: function () {
            for (const key in this.kernel) {
                if (key == "divisions") {
                    this.divisions = this.kernel[key];
                }
                else if(key=='store'){
                    this.is_submit = false;
                    if(this.kernel[key].errors){
                        this.$toastr.w(this.kernel[key].errors);
                    }
                    else{
                        this.$toastr.s("প্রসেসিং প্লান্ট সফলভাবে তৈরী হয়েছে");
                        this.$router.push({ path: "/processing-plant/all" });
                    }
                }
            }
        },
    },
};
</script>


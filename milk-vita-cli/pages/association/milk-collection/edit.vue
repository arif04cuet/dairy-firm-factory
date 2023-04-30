<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="m-0"><i class="fa fa-user-plus" aria-hidden="true"></i> সমিতির দুধ সংগ্রহ হালনাগাদ</h3>
            <h5 class="p-0 pt-1"><span v-if="user">{{user.association_name}}</span></h5>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()" v-if="loader==false">
                <div class="p-3 border">
                <!-- // -->
                <div class="row" v-if="!loader">
                    <div class="col-md-3 form-group">
                        <label for="member_id"><small><strong>খামারি</strong></small></label>
                        <input type="text" :value="form.member_name" class="form-control" readonly>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="member_code"><small><strong>খামারির কোড</strong></small></label>
                        <input class="form-control" placeholder="খামারির কোড" v-model="form.member_code" readonly />
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="shift"><small><strong>শিফট</strong></small></label>
                        <select class="form-control" v-model="form.shift" required>
                            <option v-for="(row, index) in $store.state.shifts" :key="index" :value="row.key">{{ row.value }}</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="amount_of_milk"><small><strong>দুধের পরিমাণ (লিটার)</strong></small></label>
                        <input type="number" step="any" placeholder="0.00" class="form-control" v-model="form.amount_of_milk" required />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="temperature"><small><strong>দুধের তাপমাত্রা (সেলসিয়াস)</strong></small></label>
                        <input type="number" step="any" placeholder="0.00" class="form-control" v-model="form.temperature" />
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="test_id">পরীক্ষার ধরন</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="result">পরীক্ষার ফলাফল</label>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <div class="row pt-2" v-for="(testResult, index) in form.test_results" :key="index">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" v-model="form.test_results[index].test_id" required>
                                    <option value="">পরীক্ষার ধরন নির্বাচন করুন</option>
                                    <option v-for="(row, index) in examinations" :key="index" :value="row.id">{{ row.test_name }}</option></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" placeholder="পরীক্ষার ফলাফল" v-model="form.test_results[index].result" />
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button v-if="index!=0" type="button" class="btn btn-danger" @click="removeTestResult(index)"><i class="fa fa-times"></i></button>
                                    <button v-else type="button" class="btn btn-success" @click="addMoreTest()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //   -->
                <hr />
                <!-- // -->
                <div class="text-right">
                    <div class="btn-group">
                        <nuxt-link to="/association/milk-collection/all" class="btn btn-info mr-1">তালিকায় ফিরে যান</nuxt-link>
                        <button type="submit" class="btn btn-success">
                            <span v-if="is_submit==true"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;অপেক্ষা করুন</span>
                            <span v-else >সংরক্ষণ করুন</span>
                        </button>
                    </div>
                </div>
                <!-- // -->
                </div>
            </form>
            <Loader :loader="loader" />
        </div>
    </div>
</template>

<script>
export default {
    layout: "admin",
    name: "milkCollection",
    data() {
        return {
            kernel          : {},
            members         : [],
            association     : [],
            examinations    : [],
            user            : this.$store.state.auth.user,
            form: {
                member_id       : "",
                shift           : "",
                amount_of_milk  : "",
                temperature     : "",
            },
            loader    : true,
            is_submit : false,
        };
    },
    mounted() {
        this.http("test/list", "test-list");
        this.edit();
    },
    methods: {
        submit: function () {
            this.is_submit = true;
            this.$axios
            .post("association/milk-collection/update/" + this.$route.query.id, this.form)
            .then((res) => {
                if(res.data=1){
                    this.is_submit = false;
                    this.$toastr.s("দুধ সংগ্রহের এন্ট্রি সফলভাবে হালনাগাদ হয়েছে");
                    this.$router.push({ path: "/association/milk-collection/all" });
                }
            });
        },
        edit: function () {
            this.$axios
            .post("association/milk-collection/get-single-entry", {
                where: {id: this.$route.query.id },
            })
            .then((res) => {
                this.form   = res.data[0];
                this.loader = false;
                if((this.form.test_results).length <= 0){
                    this.form.test_results = [{
                        test_id: "",
                        result: ""
                    }];
                }
            });
        },
        addMoreTest: function (){
            this.form.test_results.push({
                test_id  : "",
                result   : ""
            })
        },
        removeTestResult: function (index) {
            this.$delete(this.form.test_results, index);
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
    },
    watch: {
        kernel:function () {
            for (const key in this.kernel) {
                if(key == "members") {
                    this.members = this.kernel[key].data;
                }
                else if(key == "test-list") {
                    this.examinations = this.kernel[key].data;
                }
            }
        },
    },
};
</script>

<style scoped></style>

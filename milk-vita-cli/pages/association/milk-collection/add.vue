<template>
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h3 class="m-0">
        <i class="fa fa-user-plus" aria-hidden="true"></i> সমিতির দুধ সংগ্রহ
      </h3>
      <h5 class="p-0 pt-1"><span v-if="user">{{user.association_name}}</span></h5>
    </div>

    <div class="card-body min75vh">
        <form @submit.prevent="submit()">
            <!-- // -->
            <div class="p-3 mb-3 border" v-for="(row, index) in form.memberMilkCollections" :key="index">
                <div class="row">
                    <!-- // -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="member_id"><small><strong>খামারি</strong></small></label>
                            <select class="form-control" v-model="form.memberMilkCollections[index].member_id" @change="cnMember(form.memberMilkCollections[index].member_id, index)" required>
                                <option value="">খামারি নির্বাচন করুন</option>
                                <option v-for="(row, index) in members" :key="index" :value="row.id">{{ row.member_name }}</option>
                            </select>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="member_code"><small><strong>খামারির কোড</strong></small></label>
                            <input class="form-control" placeholder="খামারির কোড" :value="form.memberMilkCollections[index].member_code" readonly />
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="shift"><small><strong>শিফট</strong></small></label>
                            <select v-if="members" class="form-control" v-model="form.memberMilkCollections[index].shift" required>
                                <option v-for="(row, index) in $store.state.shifts" :key="index" :value="row.key">{{ row.value }}</option>
                            </select>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="amount_of_milk"><small><strong>দুধের পরিমাণ (লি.)</strong></small></label>
                            <input type="number" step="any" placeholder="0.000" class="form-control" v-model="form.memberMilkCollections[index].amount_of_milk" required />
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="temperature"><small><strong>দুধের তাপমাত্রা (সে.)</strong></small></label>
                            <input type="number" step="any" placeholder="0.00" class="form-control" v-model="form.memberMilkCollections[index].temperature" />
                        </div>
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-0 border-bottom">
                        <label for="test_id">পরীক্ষার ধরন</label>
                        </div>
                    </div>
                    <!-- // -->
                    <div class="col-md-3">
                        <div class="form-group mb-0 border-bottom">
                        <label for="result">পরীক্ষার ফলাফল</label>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <div class="row pt-2" v-for="(row2, index2) in row.testResult" :key="index2">
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <!-- <label for="test_id">পরীক্ষার ধরন</label> -->
                            <select class="form-control" v-model="row.testResult[index2].test_id">
                                <option value="">পরীক্ষার ধরন নির্বাচন করুন</option>
                                <option v-for="(row, index) in examinations" :key="index" :value="row.id">{{ row.test_name }}</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input class="form-control" placeholder="পরীক্ষার ফলাফল" v-model="row.testResult[index2].result" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button v-if="index2!=0" type="button" class="btn btn-danger" @click="removeTestResult(index, index2)"><i class="fa fa-times"></i></button>
                                <button v-else type="button" class="btn btn-success" @click="addMoreTest(index)"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-1" v-if="index!=0">
                        <div class="form-group">
                        <button type="button" class="btn btn-danger" @click="removeMilkCollectionInfo(index)"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <hr class="mt-0">
                <!-- // -->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="btn-group">
                            <input type="submit" class="btn btn-success" value="সংরক্ষণ করুন" />
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive" v-if="loader!=true">
            <table class="table table-bordered custom">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">ক্রমিক</th>
                        <th class="text-left">তারিখ</th>
                        <th class="text-left">সদস্যের নাম</th>
                        <th class="text-left">শিফট</th>
                        <th class="text-left">দুধের পরিমাণ (লিটার)</th>
                        <th class="text-left">দুধের তাপমাত্রা (সেলসিয়াস)</th>
                        <th width="10%" class="text-center">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in collected_list" :key="index">
                        <td class="text-center">{{ $en2bn(++index) }}</td>
                        <td class="text-left">{{ row.date}}</td>
                        <td class="text-left">{{ row.member? row.member.member_name: "" }}</td>
                        <td class="text-left">{{ $shift(row.shift) }}</td>
                        <td class="text-left">{{ row.amount_of_milk }}</td>
                        <td class="text-left">{{ row.temperature }}</td>
                        <!-- // -->
                        <td class="text-center">
                            <div class="btn-group custom">
                                <button class="btn btn-success" @click="viewDetails(row.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <NuxtLink 
                                    :to="'/association/milk-collection/edit?id=' + row.id" 
                                    class="btn btn-info" 
                                    v-if="$ck_action('/association/milk-collection/edit')"
                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </NuxtLink>
                            </div>
                        </td>
                    </tr>
                    <!-- // -->
                    <tr v-if="collected_list.length == 0">
                        <td colspan="7">কোন তথ্য পাওয়া যায়নি</td>
                    </tr>
                </tbody>
            </table>
            <!-- // -->
            <div class="d-flex mt-2 justify-content-end">
                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="getCollection"/>
            </div>
        </div>
        <!-- // -->
        <div class="popup" v-if="collection_id!=false">
            <div class="popup-box">
                <view-details
                    v-model="collection_id"
                ></view-details>
            </div>
        </div>
    </div>
    <Loader :loader="loader" />
  </div>
</template>

<script>
import Pagination from "vue-pagination-2";
import view from "@/components/association/MilkCollectionView.vue";
export default {
  layout: "admin",
  name: "milkCollection",
  components: { Pagination, 'view-details':view},
    data() {
        return {
            kernel        : {},
            members       : [],
            association   : {},
            examinations  : [],
            user          : this.$store.state.auth.user,
            form          : {
                memberMilkCollections : [],
            },
            collected_list  : [],
            per_page        : 10,
            page_no         : 1,
            total_row       : 0,
            loader          : true,
            collection_id   : false,
        }
    },
    mounted() {
        this.formRefresh();
        this.getMembers();
        this.getCollection();
        this.http("test/list", "test-list");
    },
    methods: {
        cnMember(member_id, index){
            this.form.memberMilkCollections[index].member_code = '';
            (this.members).forEach(row=>{
                if(member_id==row.id){
                    this.form.memberMilkCollections[index].member_code=row.member_code
                }
            });
        },
        viewDetails(collected_id){
            this.collection_id = collected_id;
        },
        getCollection(){
            this.loader = true; 
            var date = new Date(), 
            where = {
                date  : this.$date(),
                // shift : this.$currentShift(),
            };
            //
            this.$axios.post("association/milk-collection/all", {
                per_page    : this.per_page,
                page_no     : this.page_no,
                where       : where,
            })
            .then((res) => {
                this.collected_list = res.data.data;
                this.total_row      = res.data.total_row;
                this.loader         = false;
            })
            .catch((err) => console.log(err));
        },
        formRefresh(){
            this.form.memberMilkCollections = [{
                association_id      : this.$store.state.auth.user.association_id,
                amount_of_milk      : "",
                temperature         : "",
                member_code         : "",
                member_id           : "",
                shift               : this.$currentShift(),
                testResult: [{
                    test_id: "",
                    result: ""
                }]
            }];
        },
        submit: function () {
            this.$axios.post("association/milk-collection/add", this.form)
            .then((res) => {
                console.log(res);
                if(res.data.errors){
                    this.$toastr.w(res.data.errors);
                    return 0;
                }
                
                this.$toastr.s("দুধ সংগ্রহের এন্ট্রি সফলভাবে তৈরী হয়েছে");
                this.formRefresh();
                this.getCollection();
                // this.$router.push({ path: "/association/milk-collection/all" });
            });
        },
        getMembers() {
            this.http("association/all-member", "members", {
                where: {
                    association_id: this.user.association_id
                },
            });
        },
        removeMilkCollectionInfo: function (index) {
            this.$delete(this.form.memberMilkCollections, index);
        },
        addMoreTest: function (index){
            this.form.memberMilkCollections[index].testResult.push({
                test_id: "",
                result: ""
            })
        },
        removeTestResult: function (index, index2) {
            this.$delete(this.form.memberMilkCollections[index].testResult, index2);
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
                if(key == "members"){
                    this.members = this.kernel[key].data;
                }
                else if (key == "test-list"){
                    this.examinations = this.kernel[key].data;
                }
            }
        },
    },
};
</script>

<style scoped>

</style>

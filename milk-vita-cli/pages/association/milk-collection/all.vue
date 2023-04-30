<template>
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h4 class="m-0">
            <i class="fa fa-user-plus" aria-hidden="true"></i> সমিতির দুধ সংগ্রহ
            তালিকা
        </h4>
        <div class="btn-group">
            <NuxtLink
                to="/association/milk-collection/add"
                class="btn btn-primary"
                v-if="$ck_action('/association/milk-collection/add')"
            >
                <i class="fa fa-plus"></i>
                <span>নতুন দুধ সংগ্রহের এন্ট্রি </span>
            </NuxtLink>
        </div>
      </div>
    </div>
    <div class="card-body min75vh">
        <form @submit.prevent="filter">
            <div class="row">
                <!-- // -->
                <div class="col-md-3 form-group">
                    <input type="date" class="form-control" v-model="search.date">
                </div>
                <!-- // -->
                <div class="col-md-3 form-group">
                    <select class="form-control" v-model="search.shift">
                        <option value="">শিফট নির্বাচন করুন</option>
                        <option v-for="(row, index) in $store.state.shifts" :key="index" :value="row.key">{{ row.value }}</option>
                    </select>
                </div>
                <!-- // -->
                <div class="col-md-3 form-group">
                    <select class="form-control" v-model="search.member_id">
                        <option value="">সদস্য নির্বাচন করুন</option>
                        <option v-for="(row, index) in members" :key="index" :value="row.id">{{ row.member_name }}</option>
                    </select>
                </div>
                <!-- // -->
                <div class="col-md-2"><button class="btn btn-success">সার্চ করুন</button></div>
            </div>
        </form>
        <div class="table-responsive" v-if="!loader">
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
                    <tr v-for="(memberMilkCollection, index) in memberMilkCollections" :key="index">
                        <td class="text-center">{{ $en2bn(++index) }}</td>
                        <td class="text-left">{{ memberMilkCollection.date}}</td>
                        <td class="text-left">{{ memberMilkCollection.member? memberMilkCollection.member.member_name: "" }}</td>
                        <td class="text-left">{{ $shift(memberMilkCollection.shift) }}</td>
                        <td class="text-left">{{ memberMilkCollection.amount_of_milk }}</td>
                        <td class="text-left">{{ memberMilkCollection.temperature }}</td>
                        <!-- // -->
                        <td class="text-center">
                            <div class="btn-group custom">
                                <button class="btn btn-success mr-1" v-if="$ck_action('/association/milk-collection/view')" @click="milkTestInfo(memberMilkCollection.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <NuxtLink 
                                    :to="'/association/milk-collection/edit?id=' + memberMilkCollection.id" 
                                    class="btn btn-info" 
                                    v-if="$ck_action('/association/milk-collection/edit')"
                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </NuxtLink>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="memberMilkCollections.length == 0">
                        <td colspan="7">কোন তথ্য পাওয়া যায়নি</td>
                    </tr>
                </tbody>
            </table>
            <!-- ------------------ PAGINATION ------------------ -->
            <div class="d-flex justify-content-end">
                <pagination
                    v-model="page_no"
                    :records="total_row"
                    :per-page="per_page"
                    @paginate="fetchAllMemberMilkCollection"
                />
            </div>
        </div>
      <Loader :loader="loader" />


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
        kernel: {},
        memberMilkCollections: [],
        associations    : [],
        members         : [],
        testResults     : [],
        search: {
            member_id : "",
            shift     : '',
            date      : this.$date(),
        },
        current_hours   : (new Date()).getHours(),
        per_page        : 10,
        page_no         : 1,
        total_row       : 0,
        loader          : true,
        collection_id   : false,
    };
  },
  mounted()
  {
    this.search.shift = this.current_hours > 12 ? 'evening' : 'morning';
    //
    this.fetchAllMemberMilkCollection();
    //
    this.getMembers();
  },
  methods: {
    filter() {
        this.page_no=1;
        this.fetchAllMemberMilkCollection();
    },
    fetchAllMemberMilkCollection() {
        this.loader = true;
        this.$axios.post("association/milk-collection/all", {
            per_page: this.per_page,
            page_no: this.page_no,
            where: this.search,
        })
        .then((res) => {
            this.memberMilkCollections = res.data.data;
            this.total_row = res.data.total_row;
            this.loader = false;
        })
        .catch((err) => console.log(err));
    },
    milkTestInfo: function(milkCollectionId){
      this.collection_id = milkCollectionId;
    },
    close:function(){
        this.collection_id = false;
    },
    getMembers() {
      this.http("association/all-member", "members", {
        where: {
          association_id: this.search.association_id
            ? this.search.association_id
            : 0,
        },
      });
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
        if (key == "members") {
          this.members = this.kernel[key].data;
        } 
        else if (key == "all_association") {
          this.associations = this.kernel[key].data;
        }
      }
    },
  },
};
</script>

<style scoped>
th,
td {
  vertical-align: middle;
}
.img-wrapper {
  width: 100%;
  overflow: hidden;
  box-sizing: border-box;
  padding: 7px;
  border: 1px solid #ddd;
}
.img-wrapper img {
  width: 100%;
}
.choose {
  width: 100%;
  height: 30px;
  background: #ddd;
  overflow: hidden;
  position: relative;
  cursor: pointer;
}
.choose input[type="file"],
.choose span {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 999;
  opacity: 0;
  cursor: pointer;
}
.choose span {
  z-index: 998;
  opacity: 1;
  border: 1px solid #ddd;
  font-size: 14px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}
</style>

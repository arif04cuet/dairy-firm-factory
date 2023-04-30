<template>
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h4 class="m-0">
          <i class="fa fa-user-plus" aria-hidden="true"></i> যানবাহনের তালিকা
        </h4>
        <div class="btn-group">
          <NuxtLink
            to="/vehicle/add"
            class="btn btn-primary"
            v-if="$ck_action('/vehicle/add')"
          >
            <i class="fa fa-plus"></i>
            <span>নতুন যানবাহন যুক্ত করুন </span>
          </NuxtLink>
        </div>
      </div>
    </div>
    <div class="card-body min75vh">
      <div>
        <form @submit.prevent="filter">
          <div class="row">
            <div class="col-md-4 form-group">
              <select class="form-control" v-model="search.processing_plant_id">
                <option value="">প্রসেসিং প্লান্ট নির্বাচন করুন</option>
                <option
                  v-for="(row, index) in processingPlants"
                  :key="index"
                  :value="row.id"
                >
                  {{ row.processing_plant_name }}
                </option>
              </select>
            </div>
            <div class="col-md-3 form-group">
              <select class="form-control" v-model="search.vehicle_category_id">
                <option value="">বাহনের ধরণ নির্বাচন করুন</option>
                <option
                  v-for="(row, index) in categories"
                  :key="index"
                  :value="row.id"
                >
                  {{ row.vehicle_category_name }}
                </option>
              </select>
            </div>
            <div class="col-md-2">
              <button class="btn btn-success">সার্চ করুন</button>
            </div>
          </div>
        </form>
      </div>
      <div class="table-responsive" v-if="!loader">
        <table class="table table-bordered custom">
          <thead>
            <tr>
              <th width="50" class="text-center">ক্রমিক</th>
              <th class="text-left">মডেল</th>
              <th class="text-left">ভ্যাট নম্বর</th>
              <th class="text-left">বাহনের ধরণ</th>
              <th class="text-left">প্রসেসিং প্লান্টের নাম</th>
              <th width="10%" class="text-center">কার্যক্রম</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(vehicle, index) in vehicles" :key="index">
              <td class="text-center">{{ $en2bn(mkindex(++index)) }}</td>
              <td class="text-left">
                {{ vehicle.model_no }}
              </td>
              <td class="text-left">
                {{ vehicle.vat_no }}
              </td>
              <td class="text-left">
                {{
                  vehicle.category ? vehicle.category.vehicle_category_name : ""
                }}
              </td>
              <td class="text-left">
                {{ vehicle.processing_plant.processing_plant_name }}
              </td>
              <td class="text-center">
                <div class="btn-group custom">
                  <NuxtLink
                    :to="'/vehicle/edit?id=' + vehicle.id"
                    class="btn btn-info"
                    v-if="$ck_action('/vehicle/edit')"
                  >
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                  </NuxtLink>
                  <button
                    class="btn btn-danger ml-2"
                    v-if="$ck_action('/vehicle/delete')"
                  >
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="vehicles.length == 0">
              <td colspan="6">কোন তথ্য পাওয়া যায়নি</td>
            </tr>
          </tbody>
        </table>
        <!-- ------------------ PAGINATION ------------------ -->
        <div class="d-flex justify-content-end">
          <pagination
            v-model="page_no"
            :records="total_row"
            :per-page="per_page"
            @paginate="fetchAllvehicles"
          />
        </div>
      </div>
      <Loader :loader="loader" />
    </div>
  </div>
</template>

<script>
import Pagination from "vue-pagination-2";
export default {
  layout: "admin",
  name: "vehicle",
  components: {
    Pagination,
  },
  data() {
    return {
      kernel: {},
      vehicles: [],
      categories: [],
      processingPlants: [],
      search: {
        processing_plant_id: "",
        vehicle_category_id: "",
      },
      per_page: 10,
      page_no: 1,
      total_row: 0,
      loader: true,
    };
  },
  mounted() {
    this.fetchAllvehicles();
    this.http("vehicle/category", "all_category");

    this.getProcessingPlant();
  },
  methods: {
    filter() {
      this.fetchAllvehicles();
    },
    fetchAllvehicles() {
      this.loader = true;
      this.$axios
        .post("vehicle/list", {
          per_page: this.per_page,
          page_no: this.page_no,
          where: this.search,
        })
        .then((res) => {
          this.vehicles = res.data.data;
          this.total_row = res.data.total_row;
          this.loader = false;
        })
        .catch((err) => console.log(err));
    },
    mkindex: function (index) {
      return this.$paginatedIndex(this.per_page, this.page_no, index);
    },
    getProcessingPlant() {
      this.http("processing-plant/all", "all_processing_plant", {
        where: {
          parent_id: 0,
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
        if (key == "all_processing_plant") {
          this.processingPlants = this.kernel[key].data;
        } else if (key == "all_category") {
          this.categories = this.kernel[key];
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

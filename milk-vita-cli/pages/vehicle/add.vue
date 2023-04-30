<template>
  <div class="card">
    <div class="card-header">
      <h3 class="m-0">
        <i class="fa fa-user-plus" aria-hidden="true"></i> নতুন যানবাহন
      </h3>
    </div>
    <div class="card-body min75vh">
      <form @submit.prevent="submit()">
        <div class="row">
          <div class="col-md-12">
            <div class="row form-group">
              <div class="col-md-4">
                <select
                  class="form-control"
                  v-model="form.processing_plant_id"
                  required
                >
                  <option value="0">প্রসেসিং প্লান্ট নির্বাচন করুন</option>
                  <option
                    v-for="(row, index) in processingPlants"
                    :key="index"
                    :value="row.id"
                  >
                    {{ row.processing_plant_name }}
                  </option>
                </select>
              </div>
              <div class="col-md-4">
                <select
                  class="form-control"
                  v-model="form.vehicle_category_id"
                  required
                >
                  <option value="0">যানবাহনের ধরণ নির্বাচন করুন</option>
                  <option
                    v-for="(row, index) in categories"
                    :key="index"
                    :value="row.id"
                  >
                    {{ row.vehicle_category_name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label for="model_no" class="col-md-3 text-left pt-2"
                >যানবাহনের মডেল</label
              >
              <div class="col-md-9">
                <input
                  type="text"
                  class="form-control"
                  placeholder="যানবাহনের মডেল লিখুন"
                  v-model="form.model_no"
                />
              </div>
            </div>
            <div class="row form-group">
              <label for="vat_no" class="col-md-3 text-left pt-2"
                >যানবাহনের ভ্যাট নম্বর</label
              >
              <div class="col-md-9">
                <input
                  type="text"
                  class="form-control"
                  placeholder="ভ্যাট নম্বর লিখুন"
                  v-model="form.vat_no"
                />
              </div>
            </div>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-md-12">
            <input
              type="submit"
              class="btn btn-success float-right"
              value="সংরক্ষণ করুন"
            />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  layout: "admin",
  name: "vehicle",
  data() {
    return {
      kernel: {},
      categories: [],
      processingPlants: [],
      form: {
        processing_plant_id: 0,
        vehicle_category_id: 0,
        model_no: "",
        vat_no: "",
      },
    };
  },
  mounted() {
    this.http("vehicle/category", "all_category");

    this.getProcessingPlant();
  },
  methods: {
    submit: function () {
      this.$axios.post("vehicle/add", this.form).then((res) => {
        this.$toastr.s("যানবাহনের নাম সফলভাবে তৈরী হয়েছে");
        this.$router.push({ path: "/vehicle/all" });
      });
    },
    getProcessingPlant() {
      this.http("processing-plant/all", "all_processing_plant");
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
          console.log(this.processingPlants);
        } 
        else if (key == "all_category") {
          this.categories = this.kernel[key];
        }
      }
    },
  },
};
</script>


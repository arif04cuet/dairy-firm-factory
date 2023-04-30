<template>
  <div class="card">
    <div class="card-header">
      <h3 class="m-0">
        <i class="fa fa-user-plus" aria-hidden="true"></i> নতুন পরীক্ষার ফলাফল
      </h3>
    </div>
    <div class="card-body min75vh">
      <form @submit.prevent="submit()">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="entity_id">এনটিটি টাইপ</label>
                  <select class="form-control" v-model="form.entity_id" required>
                    <option value="0">এনটিটি টাইপ নির্বাচন করুন</option>
                    <option v-for="(row, index) in entities" :key="index" :value="row.id">
                      {{ row.entity_name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="testable_id">এনটিটি</label>
                  <select class="form-control" v-model="form.testable_id" required>
                    <option value="0">এনটিটি নির্বাচন করুন</option>
                    <option v-for="(row, index) in testables" :key="index" :value="row.id">
                      {{ row.entity_name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="test_id">পরীক্ষার নাম</label>
                  <select class="form-control" v-model="form.test_id" required>
                    <option value="0">পরীক্ষার নাম নির্বাচন করুন</option>
                    <option v-for="(row, index) in tests" :key="index" :value="row.id">
                      {{ row.test_name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="result">পরীক্ষার ফলাফল</label>
                  <input type="text" class="form-control" placeholder="পরীক্ষার ফলাফল লিখুন" v-model="form.result" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-md-12">
            <input type="submit" class="btn btn-success float-right" value="সংরক্ষণ করুন" />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  layout: "admin",
  name: "TestResult",
  data() {
    return {
      kernel: {},
      entities: [],
      testables: [],
      tests: [],
      form: {
        entity_id: 0,
        testable_id: 0,
        tested_by: 0,
        test_id: 0,
        testable_type:'',
        result:'',
      },
    };
  },
  mounted() {
    this.http("processing-plant/all", "processing-plant");
    this.http("test/test-list", "tests");
    this.getEntities();
  },
  methods: {
    submit: function () {
      this.$axios.post("test/result/add", this.form).then((res) => {
        this.$toastr.s("পরীক্ষার ফলাফল সফলভাবে তৈরী হয়েছে");
        this.$router.push({ path: "/test/result/all" });
      });
    },
    getEntities() {
      this.http("entity/all", "entities", {
        where: {
          system_id: this.form.system_id ? this.form.system_id : 0,
          parent_id: "0",
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
        if (key == "entities") {
          this.entities = this.kernel[key].data;
        } else if (key == "processing-plant") {
          this.testables = this.kernel[key];
        } else if (key == "tests") {
          this.tests = this.kernel[key].data;
        }
      }
    },
  },
};
</script>

<style scoped></style>

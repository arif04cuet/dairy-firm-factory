<template>
  <div class="card">
    <div class="card-header">
      <h3 class="m-0">
        <i class="fa fa-user-plus" aria-hidden="true"></i> দুধের ধরণ হালনাগাদ
      </h3>
    </div>
    <div class="card-body min75vh">
      <form @submit.prevent="submit()">
        <div class="row">
          <div class="col-md-11">
            <div class="row form-group">
              <label for="" class="col-md-3 text-right pt-2">দুধের ধরণ</label>
              <div class="col-md-8">
                <input
                  type="text"
                  class="form-control"
                  placeholder="দুধের ধরণের নাম লিখুন"
                  v-model="form.milk_category_name"
                />
              </div>
            </div>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-md-11">
            <input
              type="submit"
              class="btn btn-success float-right"
              value="হালনাগাদ করুন"
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
  name: "milkCategory",
  data() {
    return {
      form: {
        milk_category_name: "",
      },
    };
  },
  mounted() {
    this.edit();
  },
  methods: {
    submit: function () {
      this.$axios
        .post("milk-category/update/this.$route.query.id", this.form)
        .then((res) => {
          this.$toastr.s("ক্যাটাগরি সফলভাবে হালনাগাদ করা হয়েছে");
          this.$router.push({ path: "/milk-category/all" });
        });
    },
    edit: function () {
      this.$axios
        .post("milk-category/all", {
          where: { id: this.$route.query.id },
        })
        .then((res) => {
          this.form = res.data[0];
        });
    },
    // update(id) {
    //   this.$axios
    //     .post("milk-category/update", this.form)
    //     .then((res) => {
    //       if (res.data.errors) {
    //         this.$toastr.e(res.data.errors);
    //       } else {
    //         this.$toastr.s("ক্যাটাগরি সফলভাবে তৈরী হয়েছে");
    //         this.$router.push({ path: "/milk-category/all" });
    //       }
    //     })
    //     .catch((err) => console.log(err));
    // },
  },
};
</script>

<style scoped></style>

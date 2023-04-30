<template>
  <div class="card">
    <div class="card-header">
      <h3 class="m-0">
        <i class="fa fa-user-plus" aria-hidden="true"></i> নতুন দুধের ধরণ
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
                  name="form.milk_category_name"
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
              value="Save"
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
  mounted() {},
  methods: {
    submit: function () {
      this.$axios.post("milk-category/add", this.form).then((res) => {
        this.$toastr.s("দুধের ধরণ সফলভাবে তৈরী হয়েছে");
        this.$router.push({ path: "/milk-category/all" });
      });
    },
  },
};
</script>

<style scoped></style>

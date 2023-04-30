<template>
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h4 class="m-0">
          <i class="fa fa-user-plus" aria-hidden="true"></i> দুধের ধরণের তালিকা
        </h4>
        <div class="btn-group">
          <NuxtLink
            to="/milk-category/add"
            class="btn btn-primary"
            v-if="$ck_action('/milk-category/add')"
          >
            <i class="fa fa-plus"></i>
            <span>নতুন দুধের ধরণ যুক্ত করুন </span>
          </NuxtLink>
        </div>
      </div>
    </div>
    <div class="card-body min75vh">
      <div class="table-responsive" v-if="!loader">
        <table class="table table-bordered custom">
          <thead>
            <tr>
              <th width="10%" class="text-center">ক্রমিক সংখ্যা</th>
              <th class="text-left">দুধের ধরণ</th>
              <th width="10%" class="text-center">কার্যক্রম</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(category, index) in categories" :key="index">
              <td class="text-center">{{ $en2bn(++index) }}</td>
              <td class="text-left">{{ category.milk_category_name }}</td>
              <td class="text-center">
                <div class="btn-group custom">
                  <NuxtLink
                    :to="'/milk-category/edit?id=' + category.id"
                    class="btn btn-info"
                    v-if="$ck_action('/milk-category/edit')"
                  >
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                  </NuxtLink>
                  <button
                    class="btn btn-danger ml-2"
                    v-if="$ck_action('/milk-category/delete')"
                  >
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="categories.length == 0">
              <td colspan="3">কোন তথ্য পাওয়া যায়নি</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Loader :loader="loader" />
    </div>
  </div>
</template>

<script>
export default {
  layout: "admin",
  name: "milkCategory",
  data() {
    return {
      categories: [],
      loader: true,
    };
  },
  mounted() {
    this.fetchAllCategories();
  },
  methods: {
    fetchAllCategories() {
      this.loader = true;
      this.$axios
        .post("milk-category/all")
        .then((res) => {
          this.categories = res.data;
          this.loader = false;
        })
        .catch((err) => console.log(err));
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

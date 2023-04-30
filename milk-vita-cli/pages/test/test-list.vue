<template>
<div class="card">
    <div class="card-header">
        <h3 class="m-0">পরীক্ষার তালিকা</h3>
    </div>
        <div class="card-body min75vh">
            <form @submit.prevent="form.id ? update(form.id) : save()">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="test_name" class="mt-1">পরীক্ষার নাম</label>
                      <input type="text" class="form-control" placeholder="পরীক্ষার নাম লিখুন" v-model="form.test_name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="standerd_value" class="mt-1">স্ট্যান্ডার্ড মান</label>
                      <input type="text" class="form-control" placeholder="স্ট্যান্ডার্ড মান লিখুন" v-model="form.standerd_value">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-success">
                        <span v-if="form.id">হালনাগাদ করুন</span>
                        <span v-else >সংরক্ষণ করুন</span>
                    </button>
                  </div>
                </div>
            </form>
            <hr>

            <div>
              <form @submit.prevent="filter" class="form-inline justify-content-end mt-5 mb-2">
                  <input type="text" class="form-control" v-model="search.test_name">
                  <button class="btn btn-success">সার্চ করুন</button>
              </form>
            </div>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered custom">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">পরীক্ষার নাম</th>
                            <th class="text-left">স্ট্যান্ডার্ড মান</th>
                            <th width="10%" class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(test, index) in tests" :key="index">
                            <td class="text-center">{{ $en2bn(mkindex(++index)) }}</td>
                            <td class="text-left">{{ test.test_name }}</td>
                            <td class="text-left">{{ test.standerd_value }}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                  <button class="btn btn-info" v-if="$ck_action('/test/test-list/edit')" @click="edit(test)">Edit</button>
                                  <button class="btn btn-danger ml-2" v-if="$ck_action('/test/test-list/delete')">
                                      <i class="fa fa-trash" aria-hidden="true"></i>
                                  </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="tests.length == 0">
                            <td colspan="4">কোন তথ্য পাওয়া যায়নি</td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                  <pagination
                    v-model="page_no"
                    :records="total_row"
                    :per-page="per_page"
                    @paginate="fetchAllTest"
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
    layout:'admin',
    name:'ProductTest',
    components: {
      Pagination,
    },
    data(){
      return {
        form:{
            test_name:'',
            standerd_value:'',
            id:''
        },
        tests:[],
        search: {
          test_name: "",
        },
        per_page: 10,
        page_no: 1,
        total_row: 0,
        loader: true,
      };
    },
    mounted(){
      this.fetchAllTest();
    },
    methods:{
        filter() {
          this.fetchAllTest();
        },
        fetchAllTest(){
          this.loader = true;
          this.$axios.post('test/list', {
            per_page: this.per_page,
            page_no: this.page_no,
            where: this.search,
          })
          .then(res=>{
              this.tests = res.data.data;
              this.total_row = res.data.total_row;
              this.loader = false;
          })
          .catch(err=>console.log(err));
        },
        mkindex: function (index) {
          return this.$paginatedIndex(this.per_page, this.page_no, index);
        },
        save:function(){
            this.$axios.post('test/test-list/add', this.form)
            .then((res) => {
              this.$toastr.s("পরীক্ষার নাম সফলভাবে তৈরী হয়েছে");
              this.fetchAllTest();
            })
            .catch(err=>console.log(err));
        },
        edit:function(test){
            this.form = {
                test_name : test.test_name,
                standerd_value : test.standerd_value,
                id : test.id,
            };
        },
        update(id){
            this.$axios.post('test/test-list/update/' + this.form.id, this.form)
            .then(res=>{
                if(res.data.errors){
                  console.log(res.data.errors);
                }
                else {
                    this.$toastr.s("পরীক্ষার নাম সফলভাবে হালনাগাদ হয়েছে");
                    this.fetchAllTest();
                    this.form = {
                        test_name:'',
                        standerd_value :'',
                        id:'',
                    };
                }

            })
            .catch(err=>console.log(err));
        }
    }
}
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
</style>

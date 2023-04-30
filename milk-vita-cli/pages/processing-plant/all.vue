<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0"> <i class="fa fa-user-plus" aria-hidden="true"></i> প্রসেসিং প্লান্টের তালিকা </h4>
                <!-- <div class="btn-group">
                    <NuxtLink to="/processing-plant/add" class="btn btn-primary" v-if="$ck_action('/processing-plant/add')" >
                        <i class="fa fa-plus"></i>
                        <span>নতুন প্রসেসিং প্লান্ট যুক্ত করুন </span>
                    </NuxtLink>
                </div> -->
            </div>
        </div>
        <!-- // -->

    <div class="card-body min75vh">
        <form @submit.prevent="filter">
            <div class="row">
                <Location v-model="location_data" class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label>বিভাগ</label>
                        <div data-division></div>
                    </div>

                    <div class="form-group col-md-3">
                        <label>জেলা</label>
                        <div data-district data-required="true"></div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="">প্রসেসিং প্ল্যান্ট</label>
                        <select class="form-control" v-model="search.id">
                            <option value="">প্রসেসিং প্ল্যান্ট নির্বাচন করুন</option>
                            <option v-for="(row, index) in all_processing_plant" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 form-group">
                        <label for="">&nbsp;</label>
                        <div class="btn-group form-control p-0 bg-default">
                            <button class="btn btn-success">সার্চ করুন</button>
                            <button class="btn btn-info ml-1" type="button" @click="syncOffices()"><i class="fa fa-refresh" :class="(is_sysnc_runing==true?'fa-spin':'')" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </Location>
            </div>
        </form>
        <!-- // -->
      <div class="table-responsive" v-if="!loader">
        <table class="table table-bordered custom">
          <thead>
            <tr>
              <th width="50" class="text-center">ক্রমিক</th>
              <th class="text-left">প্রসেসিং প্লান্টের নাম</th>
              <th class="text-left">ঠিকানা</th>
              <th class="text-left">পুরো ঠিকানা</th>
              <th width="10%" class="text-center">কার্যক্রম</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(row, index) in processingPlants"
              :key="index"
            >
              <td class="text-center" width="40">{{$en2bn(++index)}}</td>
              <td class="text-left">
                {{ row.processing_plant_name }}
              </td>
              <td class="text-left">
                <span v-if="row.location_details" v-for="(area, key) in row.location_details" :key="key">{{area.name ? area.name.bn : ''}}, </span>
              </td>
              <td class="text-left">
                {{ row.full_address }}
              </td>
              <td class="text-center">
                <div class="btn-group custom">
                    <NuxtLink :to="'/processing-plant/edit?id=' + row.id">
                        <button class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                    </NuxtLink>
                
                    <NuxtLink :to="'/processing-plant/edit?id=' + row.id">
                        <button class="btn btn-danger ml-2" v-if="$ck_action('/processing-plant/delete')" disabled > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                    </NuxtLink>
                </div>
              </td>
            </tr>
            <tr v-if="processingPlants.length == 0">
              <td colspan="5">কোন তথ্য পাওয়া যায়নি</td>
            </tr>
          </tbody>
        </table>
        <!-- ------------------ PAGINATION ------------------ -->
        <div class="d-flex justify-content-end">
          <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllProcessingPlants" />
        </div>
      </div>
      <Loader :loader="loader" />
    </div>
  </div>
</template>

<script>
import Pagination from "vue-pagination-2";
import Location from '@/components/system/Location.vue';
export default {
    layout  : "admin",
    name    : "processingPlant",
    components: {Pagination, Location},
    data() {
        return {
            kernel: {},
            processingPlants     : [],
            all_processing_plant : [],
            search: {id:''},
            per_page: 10,
            page_no: 1,
            total_row: 0,
            loader: true,
            is_sysnc_runing : false,
            location_data   : {},
        };
    },
    mounted() {
        // FETCH ALL CHILLING PLANT WITHOUT CONDITION
        this.http('processing-plant/all', 'all-processing-plant', {
            select:['id', 'processing_plant_name']
        });
        this.fetchAllProcessingPlants();
    },
    methods: {
        syncOffices(){
          this.is_sysnc_runing = true;
          this.http('office/synchronize', 'office-sync');
        },
        filter() {
            this.page_no = 1;
            this.fetchAllProcessingPlants();
        },
        fetchAllProcessingPlants() {
            this.loader = true;
            this.$axios
            .post("processing-plant/all", {
                per_page : this.per_page,
                page_no  : this.page_no,
                where    : this.search,
            })
            .then((res) => {
                this.processingPlants = res.data.data;
                this.total_row        = res.data.total_row;
                this.loader           = false;
            })
            .catch((err) => console.log(err));
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
        checkLocation: function (type, id) {
            var url = "location/" + (type == "division" ? "districts" : type == "district" ? "thanas" : "");
            //
            this.$axios.post(url, { where: { [type + "_id"]: id } }).then((res) => {
                if (type == "division") {
                    this.districts = res.data;
                } 
                else if (type == "district") {
                    this.thanas = res.data;
                }
            });
        },
    },
    watch: {
        location_data(){
            this.search.id = '';
            this.search.division_id = this.location_data.division_id;
            this.search.district_id = this.location_data.district_id;
            //
            this.http('processing-plant/all', 'all-processing-plant', {
                select:['id', 'processing_plant_name'],
                where : this.search
            });
        },
        kernel: function () {
            for (const key in this.kernel) {
                if(key=='office-sync'){
                  this.$toastr.s('সকল অফিস সিঙ্ক্রোনাইজ করা হয়েছে');
                  this.is_sysnc_runing = false;
                  this.filter();
                }
                else if(key=='all-processing-plant'){
                    this.all_processing_plant = this.kernel[key].data;
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

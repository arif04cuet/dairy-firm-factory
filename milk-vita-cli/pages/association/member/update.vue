<template>
<div class="card">
    <div class="card-header">
      <h4 class="m-0">প্রোফাইল আপডেট</h4>
    </div>
    <div class="card-body min75vh">
      <div class="row">
			  <div class="col-md-12">
            <ul class="nav nav-tabs" id="citizenTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="personal-info-tab" data-toggle="tab" href="#tab_personal_info" type="button" role="tab" aria-controls="home" aria-selected="true">
                      <i class="fa fa-info-circle"></i>&nbsp;&nbsp;ব্যাক্তিগত তথ্য
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="communication-info-tab" data-toggle="tab" href="#tab_communication_information" type="button" role="tab" aria-controls="communication" aria-selected="false">
                      <i class="fa fa-map-marker"></i>&nbsp;&nbsp;যোগাযোগের তথ্য
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="educational-info-tab" data-toggle="tab" href="#tab_educational_info" type="button" role="tab" aria-controls="education" aria-selected="false">
                      <i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;শিক্ষাগত যোগ্যতা
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="workplace-info-tab" data-toggle="tab" href="#tab_workplace_information" type="button" role="tab" aria-controls="workplace" aria-selected="false">
                      <i class="fa fa-briefcase"></i>&nbsp;&nbsp;কর্মস্থলের তথ্য
                  </button>
              </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
              <!-- // -->
              <div class="tab-pane fade show active" id="tab_personal_info" role="tabpanel" aria-labelledby="tab_personal_info-tab">
                <div id="personal-info">
                  <form @submit.prevent="submit()">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="member_name" class="text-strong">নাম (বাংলায়) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="নাম লিখুন" v-model="form.member_name" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="member_name_en" class="text-strong">নাম (ইংরেজিতে) </label>
                          <input type="text" class="form-control" placeholder="নাম লিখুন" v-model="form.member_name_en" />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="father_name_bn" class="text-strong">পিতার নাম (বাংলায়) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="পিতার নাম লিখুন" v-model="form.father_name_bn" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="father_name_en" class="text-strong">পিতার নাম (ইংরেজিতে) </label>
                          <input type="text" class="form-control" placeholder="পিতার নাম লিখুন" v-model="form.father_name_en" />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="mother_name_bn" class="text-strong">মায়ের নাম (বাংলায়) </label>
                          <input type="text" class="form-control" placeholder="মায়ের নাম লিখুন" v-model="form.mother_name_bn" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="mother_name_en" class="text-strong">মায়ের নাম (ইংরেজিতে) </label>
                          <input type="text" class="form-control" placeholder="মায়ের নাম লিখুন" v-model="form.mother_name_en" />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="spouse_name_bn" class="text-strong">স্বামী/স্ত্রীর নাম (বাংলায়) </label>
                          <input type="text" class="form-control" placeholder="স্বামী/স্ত্রীর নাম লিখুন" v-model="form.spouse_name_bn" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="spouse_name_en" class="text-strong">স্বামী/স্ত্রীর নাম (ইংরেজিতে) </label>
                          <input type="text" class="form-control" placeholder="স্বামী/স্ত্রীর নাম লিখুন" v-model="form.spouse_name_en" />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nid" class="text-strong">জাতীয় পরিচয়পত্র নম্বর (ইংরেজি) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর " v-model="form.nid" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="date_of_birth" class="text-strong">জন্ম তারিখ <span class="text-danger">*</span></label>
                          <date-picker
                            placeholder="YYYY-MM-DD"
                            format="yyyy-MM-dd"
                            v-model="form.date_of_birth"
                            class="form-control"
                            :locale="$store.state.local"
                            required
                          />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="religion" class="text-strong">ধর্ম <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="ধর্ম" v-model="form.religion" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="gender" class="text-strong">লিঙ্গ <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" :value="(form.gender_details ? form.gender_details.display_value : '---')" readonly />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <input type="submit" class="btn btn-success float-right" value="সংরক্ষণ করুন" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- // -->
              <div class="tab-pane fade" id="tab_communication_information" role="tabpanel" aria-labelledby="tab_communication_information">
                <div id="communication-info">
                  <form @submit.prevent="submit()">
                    <div class="row">


                      <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-strong">বিভাগ</label>
                              <select class="form-control" v-model="form.division_id" @change="checkLocation('division', form.division_id)" required>
                                  <option value="0">বিভাগ নির্বাচন করুন </option>
                                  <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-strong">জেলা</label>
                              <select class="form-control" v-model="form.district_id" @change="checkLocation('district', form.district_id)" required>
                                  <option value="0">জেলা নির্বাচন করুন </option>
                                  <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-strong">থানা</label>
                              <select class="form-control" v-model="form.thana_id" data-live-search="true" required>
                                  <option value="0">থানা নির্বাচন করুন </option>
                                  <option v-for="(thana, index) in thanas" :key="index" :value="thana.id">{{thana.bn_name}}</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-strong">গ্রামের নাম</label>
                              <input type="text" v-model="form.village" class="form-control" placeholder="গ্রামের নাম লিখুন">
                          </div>
                      </div>
                    </div>


                    <div class="col-md-12">
                        <Location class="row" v-if="form.geolocation" v-model="form.geolocation">
                            <!-- // -->
                            <div class="col-md-6 form-group">
                                <label>বিভাগ <span class="text-danger">*</span></label>
                                <div data-division ref="required_division"></div>
                            </div>
                            <!-- // -->
                            <div class="col-md-6 form-group">
                                <label>জেলা <span class="text-danger">*</span></label>
                                <div data-district ref="required_district"></div>
                            </div>
                            <!-- // -->
                            <div class="col-md-6 form-group">
                                <label>উপজেলা <span class="text-danger">*</span></label>
                                <div data-upazila ref="required_upazila"></div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>গ্রাম <span class="text-danger">*</span></label>
                                <input type="text" v-model="form.village" class="form-control required" placeholder="গ্রাম">
                            </div>
                        </Location>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="pre_address" class="text-strong">বর্তমান ঠিকানা</label>
                              <textarea class="form-control" v-model="form.pre_address" rows="3" placeholder="বর্তমান ঠিকানা লিখুন"></textarea>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="per_address" class="text-strong">স্থায়ী ঠিকানা</label>
                              <textarea class="form-control" v-model="form.per_address" rows="3" placeholder="স্থায়ী ঠিকানা লিখুন"></textarea>
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="mobile" class="text-strong">মোবাইল নম্বর <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" placeholder="মোবাইল নম্বর লিখুন" v-model="form.mobile" required />
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="email" class="text-strong">ইমেইল</label>
                              <input type="text" class="form-control" placeholder="ইমেইল লিখুন" v-model="form.email" />
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <input type="submit" class="btn btn-success float-right" value="সংরক্ষণ করুন" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- // -->
              <div class="tab-pane fade" id="tab_educational_info" role="tabpanel" aria-labelledby="tab_educational_info-tab">
                <div id="educational-info">
                  <form @submit.prevent="submit()">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="educational_qualification" class="text-strong">শিক্ষাগত যোগ্যতা </label>
                          <textarea class="form-control" rows="3" placeholder="শিক্ষাগত যোগ্যতা লিখুন" v-model="form.educational_qualification"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <input type="submit" class="btn btn-success float-right" value="সংরক্ষণ করুন" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- // -->
              <div class="tab-pane fade" id="tab_workplace_information" role="tabpanel" aria-labelledby="tab_workplace_information">
                <div id="workplace-info">
                  <form @submit.prevent="submit()">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="occupation" class="text-strong">পেশা/পদবি <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="পেশা/পদবি লিখুন" v-model="form.occupation" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="membership_date" class="text-strong">সদস্যপদ লাভের তারিখ</label>
                          <date-picker
                            placeholder="YYYY-MM-DD"
                            format="yyyy-MM-dd"
                            v-model="form.membership_date"
                            class="form-control"
                            required
                          />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="bkash_account_number" class="text-strong">বিকাশ/ব্যাংক একাউন্ট<span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="বিকাশ/ব্যাংক একাউন্ট লিখুন" v-model="form.bkash_account_number" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="bank_address" class="text-strong">ব্যাংকের নাম </label>
                          <input type="text" class="form-control" placeholder="ব্যাংকের নাম লিখুন" v-model="form.bank_address" />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="share_kromic_no" class="text-strong">শেয়ারের ক্রোমিক নম্বর</label>
                          <input type="number" min="0" step="1" class="form-control" v-model="form.share_kromic_no" readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="number_of_share" class="text-strong">শেয়ার সংখ্যা</label>
                          <input type="number" min="0" step="100" class="form-control" v-model="form.number_of_share" readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="total_share_price" class="text-strong">মোট শেয়ারের মূল্য</label>
                          <input type="number" min="0" class="form-control" v-model="form.total_share_price" readonly />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="share_price_received_date" class="text-strong">শেয়ার মূল্য প্রাপ্তির তারিখ</label>
                          <date-picker
                            placeholder="YYYY-MM-DD"
                            format="yyyy-MM-dd"
                            v-model="form.share_price_received_date"
                            class="form-control"
                            readonly
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="share_price_received_amount" class="text-strong">শেয়ারের মূল্য আদায়</label>
                          <input type="number" min="0" step="100" class="form-control" v-model="form.share_price_received_amount" readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="share_price_return_amount" class="text-strong">শেয়ারের মূল্য ফেরত</label>
                          <input type="number" min="0" step="100" class="form-control" v-model="form.share_price_return_amount" readonly />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <input type="submit" class="btn btn-success float-right" value="সংরক্ষণ করুন" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- // -->
            </div>
        </div>
      </div>
    </div>
</div>
</template>

<script>
    import Location from '@/components/system/Location.vue';
    export default {
        components:{Location},
        layout:'admin',
        name:'profile-edit',
        data(){
            return {
                kernel : {},
                associations: [],
                divisions   : [],
                districts   : [],
                thanas      : [],
                form: {
                  member_name: "",
                  member_name_en: "",
                  father_name_bn: "",
                  father_name_en: "",
                  mother_name_bn: "",
                  mother_name_en: "",
                  spouse_name_bn: "",
                  spouse_name_en: "",
                  date_of_birth: new Date(),
                  religion: "",
                  gender: "",
                  nid: "",
                  about_me: "",
                  division_id: 0,
                  district_id: 0,
                  thana_id: 0,
                  pre_address: "",
                  per_address: "",
                  email: "",
                  mobile: "",
                  occupation: "",
                  membership_date:new Date(),
                  educational_qualification: "",
                  bkash_account_number:"",
                  bank_address:"",
                  share_kromic_no:"",
                  number_of_share:"",
                  total_share_price:"",
                  share_price_received_date:new Date(),
                  share_price_received_amount:"",
                  share_price_return_amount:"",
                },
            }
        },
        mounted() {
          // this.http("association/all", "all_association", {
          //   select: ["id", "association_name"],
          // });

          document.querySelector('BODY').style.overflow = 'auto';
          this.http("location/divisions", "divisions", this.form.division_id ? this.form.division_id : "");
          this.edit();
        },
        methods:{
          submit: function () {
            this.$axios.post("association/update-profile/" + this.$route.query.id, this.form)
            .then((res) => {
              console.log(res.data);
              if(res.data.errors){
                this.$toastr.w(this.$msgSanitize(res.data.errors));
              }
              else 
                this.$toastr.s("সদস্য প্রোফাইল সফলভাবে হালনাগাদ হয়েছে");
              // this.$router.push({ path: "/association/member-profile/view?id="+ this.$route.query.id });
            });
          },
          edit: function () {
            this.$axios
              .post("association/all-member", {
                where: { id: this.$route.query.id },
              })
              .then((res) => {
                this.form = res.data.data[0];
                
                this.form.geolocation = {
                    division_id : this.form.division_id,
                    district_id : this.form.district_id,
                    upazila_id : this.form.upazila_id,
                };
                //this.onChangeAssociation();
              });
          },
          http(url, type, data=null){
              this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
          },
          checkLocation: function (type, id) {
            var url = "location/" + (type == "division" ? "districts" : type == "district" ? "thanas" : "");
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
          kernel: function () {
            for (const key in this.kernel) {
              if (key == "divisions") {
                console.log(this.kernel[key].data);
                this.divisions = this.kernel[key];
              }
              else if (key == "all_association") {
                this.associations = this.kernel[key].data;
              }
            }
          },
        },
    }
</script>

<style scoped>

</style>

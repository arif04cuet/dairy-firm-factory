<template>
<div class="card">
    <div class="card-header">
      <div class="row">
        <h4 class="col-md-9 m-0 mt-2">
          সমিতির সদস্য: {{ member.member_name }}
        </h4>
        <div class="col-md-3 text-right">
            <NuxtLink to="/association/member/list" class="btn btn-info">তালিকায় ফিরে যান</NuxtLink>
        </div>
      </div>
    </div>
    <div class="card-body min75vh">
      <div class="row">
        <div class="col-md-12">
          <div class="profile-head">
            <!-- <h5>নাম:  {{ member.member_name }}</h5> -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="passbook-tab" data-toggle="tab" href="#passbook-info" role="tab" aria-controls="passbook" aria-selected="true">পাস-বুক</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#personal-info" role="tab" aria-controls="home" aria-selected="false">ব্যাক্তিগত তথ্য</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#communication-info" role="tab" aria-controls="profile" aria-selected="false">যোগাযোগের তথ্য</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#educational-info" role="tab" aria-controls="profile" aria-selected="false">শিক্ষাগত যোগ্যতা</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#workplace-info" role="tab" aria-controls="profile" aria-selected="false">কর্মস্থলের তথ্য</a>
                </li>

                <li class="nav-item">
                    <nuxt-link :to="'/association/member/update?id='+$route.query.id"  class="nav-link" data-toggle="tab" href="#" role="tab" aria-controls="profile" aria-selected="false">তথ্য আপডেট করুন</nuxt-link>
                </li>
            </ul>
          </div>
        </div>
        <!-- <div class="col-md-2">
            <NuxtLink :to="'/association/member-profile/edit?id='+member_id">Edit Profile</NuxtLink>
        </div> -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tab-content profile-tab my-3 px-3" id="myTabContent">
            <!-- // -->
            <div class="tab-pane fade show active" id="passbook-info" role="tabpanel" aria-labelledby="passbook-info-tab">
              <div class="table-responsive">
                <pass-book :member_id="this.$route.query.id" />
              </div>
            </div>
            <!-- // -->
            <div class="tab-pane fade" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
              <div class="table-responsive">
                <table class="table ">
                  <tbody>
                    <tr>
                      <td class="text-left"><b class="w127">সদস্যদের নাম (বাংলায়)</b>: {{ member.member_name }}</td>
                      <td class="text-left"><b class="w143">সদস্যদের নাম (ইংরেজিতে)</b>: {{ member.member_name_en }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">পিতার নাম (বাংলায়)</b>: {{ member.father_name_bn }}</td>
                      <td class="text-left"><b class="w143">পিতার নাম (ইংরেজিতে)</b>: {{ member.father_name_en }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">মায়ের নাম (বাংলায়)</b>: {{ member.mother_name_bn }}</td>
                      <td class="text-left"><b class="w143">মায়ের নাম (ইংরেজিতে)</b>: {{ member.mother_name_en }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">পিতার/স্বামীর নাম (বাংলায়)</b>: {{ member.spouse_name_bn }}</td>
                      <td class="text-left"><b class="w143">পিতার/স্বামীর নাম (ইংরেজিতে)</b>: {{ member.spouse_name_en }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">জাতীয় পরিচয়পত্র নম্বর</b>: {{ member.nid }}</td>
                      <td class="text-left"><b class="w143">জন্ম তারিখ</b>: {{ member.date_of_birth }}</td>
                    </tr>
                    <tr>  
                      <td class="text-left"><b class="w127">ধর্ম</b>: {{ member.religion }}</td>
                      <td class="text-left"><b class="w143">লিঙ্গ</b>: {{ member.gender_details ? member.gender_details.display_value : '---' }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">সাপ্তাহিক দুগ্ধ উৎপাদনের ক্ষমতা</b>: {{$en2bn(4300)}} লিটার</td>
                      <td class="text-left"><b class="w143">গবাদি পশুর সংখ্যা</b>: {{$en2bn(15)}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- // -->
            <div class="tab-pane fade" id="communication-info" role="tabpanel" aria-labelledby="communication-info-tab">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td class="text-left"><b class="w80">বিভাগ</b>: {{ member.division?member.division.bn_name:"" }}</td>
                      <td class="text-left"><b class="w65">জেলা</b>: {{ member.district?member.district.bn_name:"" }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w80">থানা</b>: {{ member.thana?member.thana.bn_name:"" }}</td>
                      <td class="text-left"><b class="w65">গ্রামের নাম</b>: {{ member.village }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w80">বর্তমান ঠিকানা</b>: {{ member.pre_address }}</td>
                      <td class="text-left"><b class="w65">স্থায়ী ঠিকানা</b>: {{ member.per_address }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w80">মোবাইল নম্বর</b>: {{ member.mobile }}</td>
                      <td class="text-left"><b class="w65">ইমেইল</b>: {{ member.email }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- // -->
            <div class="tab-pane fade" id="educational-info" role="tabpanel" aria-labelledby="educational-info-tab">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td class="text-left"><b class="w90">শিক্ষাগত যোগ্যতা</b>: {{ member.educational_qualification }}</td>
                      <td class="text-left"><b class="w65">পেশা/পদবি</b>: {{ member.occupation }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- // -->
            <div class="tab-pane fade" id="workplace-info" role="tabpanel" aria-labelledby="workplace-info-tab">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td class="text-left"><b class="w127">সদস্যপদ লাভের তারিখ</b>: {{ member.membership_date }}</td>
                      <td class="text-left"><b class="w135">বিকাশ/ব্যাংক একাউন্ট</b>: {{ member.bkash_account_number }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">শেয়ারের ক্রোমিক নম্বর</b>: {{ member.share_kromic_no }}</td>
                      <td class="text-left"><b class="w135">শেয়ার সংখ্যা</b>: {{ member.number_of_share }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">মোট শেয়ারের মূল্য</b>: {{ member.total_share_price }}</td>
                      <td class="text-left"><b class="w135">শেয়ার মূল্য প্রাপ্তির তারিখ</b>: {{ member.share_price_received_date }}</td>
                    </tr>
                    <tr>
                      <td class="text-left"><b class="w127">শেয়ারের মূল্য আদায়</b>: {{ member.share_price_received_amount }}</td>
                      <td class="text-left"><b class="w135">শেয়ারের মূল্য ফেরত</b>: {{ member.share_price_return_amount }}</td>
                    </tr>
                  </tbody>
                </table>
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
    import PassBook from '@/components/association/member/Passbook.vue';
    export default {
        layout:'admin',
        name:'profile-view',
        components:{'pass-book':PassBook},
        data(){
            return {
              member: [],
              loader: true,
              member_id:'',
            }
        },
        mounted(){
            this.member_id = this.$route.query.id;
            this.fetchMemberInfo();
        },
        methods:{
          fetchMemberInfo() {
            this.loader = true;
            this.$axios
              .post("association/all-member", {
                where: { id: this.$route.query.id },
              })
              .then((res) => {
                this.member = res.data.data[0];
                this.loader = false;
                console.log(res.data);
              });
          }
        }
    }
</script>

<style scoped>
  .nav-link {
    color:black!important;
  }
  .nav-link.active {
    color: #007bff!important;
  }
  table tr td b {
    display: block;
    float: left;
  }
  table tr td b.w143 {
    min-width: 143px;
  }
  table tr td b.w127 {
    min-width: 127px;
  }
  table tr td b.w135 {
    min-width: 135px;
  }
  table tr td b.w80 {
    min-width: 80px;
  }
  table tr td b.w90 {
    min-width: 90px;
  }
  table tr td b.w65 {
    min-width: 65px;
  }
  table tr td {
    font-size: 14px;
  }
</style>

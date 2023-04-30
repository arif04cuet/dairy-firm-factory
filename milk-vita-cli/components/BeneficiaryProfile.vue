<template>
    <div class="container main-page-wrapper">
        <div class="card w100 mt-2" >
            <div class="card-header">
                <h4 class="mt-2">সমিতির সদস্য : {{ user.name_bn }}</h4>
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
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="tab-content profile-tab my-3 px-3" id="myTabContent">
                        <!-- // -->
                        <div class="tab-pane fade show active" id="passbook-info" role="tabpanel" aria-labelledby="passbook-info-tab">
                            <pass-book v-if="member.id" :member_id="member.id" />
                        </div>
                        <!-- // -->
                        <div class="tab-pane fade" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                <tr>
                                <td class="text-left"><b>সদস্যদের নাম (বাংলায়):</b> {{ member.member_name }}</td>
                                <td class="text-left"><b>সদস্যদের নাম (ইংরেজিতে):</b> {{ member.member_name_en }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>পিতার নাম (বাংলায়):</b> {{ member.father_name_bn }}</td>
                                <td class="text-left"><b>পিতার নাম (ইংরেজিতে): </b> {{ member.father_name_en }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>মায়ের নাম (বাংলায়): </b> {{ member.mother_name_bn }}</td>
                                <td class="text-left"><b>মায়ের নাম (ইংরেজিতে): </b> {{ member.mother_name_en }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>স্বামী/স্ত্রীর নাম (বাংলায়): </b> {{ member.spouse_name_bn }}</td>
                                <td class="text-left"><b>স্বামী/স্ত্রীর নাম (ইংরেজিতে): </b> {{ member.spouse_name_en }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>জাতীয় পরিচয়পত্র নম্বর: </b> {{ member.nid }}</td>
                                <td class="text-left"><b>জন্ম তারিখ: </b> {{ member.date_of_birth }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>ধর্ম: </b> {{ member.religion }}</td>
                                <td class="text-left"><b>লিঙ্গ: </b> {{ member.gender }}</td>
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
                                <td class="text-left"><b>বিভাগ: </b> {{ member.division?member.division.bn_name:"" }}</td>
                                <td class="text-left"><b>জেলা: </b> {{ member.district?member.district.bn_name:"" }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>থানা: </b> {{ member.thana?member.thana.bn_name:"" }}</td>
                                <td class="text-left"><b>গ্রামের নাম: </b> {{ member.village }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>বর্তমান ঠিকানা: </b> {{ member.pre_address }}</td>
                                <td class="text-left"><b>স্থায়ী ঠিকানা: </b> {{ member.per_address }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>মোবাইল নম্বর: </b> {{ member.mobile }}</td>
                                <td class="text-left"><b>ইমেইল: </b> {{ member.email }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="educational-info" role="tabpanel" aria-labelledby="educational-info-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                <tr>
                                <td class="text-left"><b>শিক্ষাগত যোগ্যতা: </b> {{ member.educational_qualification }}</td>
                                <td class="text-left"><b>পেশা/পদবি: </b> {{ member.occupation }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="workplace-info" role="tabpanel" aria-labelledby="workplace-info-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                <tr>
                                <td class="text-left"><b>সদস্যপদ লাভের তারিখ: </b> {{ member.membership_date }}</td>
                                <td class="text-left"><b>বিকাশ/ব্যাংক একাউন্ট: </b> {{ member.bkash_account_number }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>শেয়ারের ক্রোমিক নম্বর: </b> {{ member.share_kromic_no }}</td>
                                <td class="text-left"><b>শেয়ার সংখ্যা: </b> {{ member.number_of_share }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>মোট শেয়ারের মূল্য: </b> {{ member.total_share_price }}</td>
                                <td class="text-left"><b>শেয়ার মূল্য প্রাপ্তির তারিখ: </b> {{ member.share_price_received_date }}</td>
                                </tr>
                                <tr>
                                <td class="text-left"><b>শেয়ারের মূল্য আদায়: </b> {{ member.share_price_received_amount }}</td>
                                <td class="text-left"><b>শেয়ারের মূল্য ফেরত: </b> {{ member.share_price_return_amount }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PassBook from '@/components/association/member/Passbook.vue';

export default {
    name:'BeneficiaryPanel',
    components:{'pass-book':PassBook},
    data(){
        return {
            user:this.$store.state.auth.user,
            member: [],
            loader: true,
            member_id:this.$store.state.auth.user.asso_member_id,
        }
    },
    mounted(){
        this.$axios
        .post("association/all-member", {
            where: { id: this.$store.state.auth.user.asso_member_id },
        })
        .then((res) => {
            this.member = res.data.data[0];
            this.loader = false;
        });
    }
}
</script>

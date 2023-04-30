<template>
    <div class="card">
        <div class="card-body">
            <div class="form-header">
                <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                <h2>প্রধান কার্যালয়</h2>
                <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
                <h5>মিটিং রিসোলিউশন</h5>
            </div>

            <hr>

            <h6 class="pb-2 mb-3 text-strong">প্রস্তাবিত প্রাথমিক দুগ্ধ উৎপাদনকারী সমিতি সংগঠন সংক্রান্ত তথ্য স্বারক </h6>

            <div class="row form-group">
                <div class="col-md-4 form-group">
                    <label class="text-strong">১. প্রস্তাবিত সমিতির নাম</label>
                    <input type="text" class="form-control" v-model="form.association_name" readonly>
                </div>

                <div class="col-md-4 form-group">
                    <label class="text-strong">২. দুগ্ধ এলাকার নাম</label>
                    <input type="text" class="form-control" v-model="form.name_of_dairy_area" readonly>
                </div>

                <div class="col-md-4 form-group">
                    <label class="text-strong"> ৩. সমিতির কার্যকরী এলাকা</label>
                    <input type="text" class="form-control" v-model="form.working_area_of_association" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-5 text-strong pr-0 mt-2"> ৪. প্রস্তাবিত সমিতির কোড:</div>
                        <div class="col-md-2 pl-0">
                            <input type="text" class="form-control" :value="$en2bn(form.association_code)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-5 text-strong pr-0 mt-2"> ৫. সাংগঠনিক সভায় উপস্থিত সদস্য সংখ্যা:</div>
                        <div class="col-md-2 pl-0">
                            <input type="text" class="form-control" :value="$en2bn(form.total_present_member)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group mb-0">
                        <div class="col-md-5 text-strong pr-0 mt-2">৬. দুগ্ধ এলাকার ঠিকানা </div>
                        <div class="col-md-5 pl-0">
                            : {{$locationSanitize(form.milk_area_location_details)}}|
                            <label class="text-strong">গ্রাম : {{form.milk_area_village}}</label>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-strong">বিভাগ</label>
                                <select class="form-control" v-model="form.milk_area_division_id" @change="checkLocation('division', form.milk_area_division_id)" disabled>
                                    <option value="">বিভাগ নির্বাচন করুন </option>
                                    <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-strong">জেলা</label>
                                <select class="form-control" v-model="form.milk_area_district_id" @change="checkLocation('district', form.milk_area_district_id)" disabled>
                                    <option value="">জেলা নির্বাচন করুন </option>
                                    <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-strong">থানা</label>
                                <select class="form-control" v-model="form.milk_area_thana_id" data-live-search="true" disabled>
                                    <option value="">থানা নির্বাচন করুন </option>
                                    <option v-for="(thana, index) in thanas" :key="index" :value="thana.id">{{thana.bn_name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-strong">গ্রাম</label>
                                <input type="text" class="form-control" placeholder="গ্রামের নাম লিখুন" v-model="form.milk_area_village" readonly>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-5 text-strong pr-0 mt-2">৭. সমিতির ঠিকানা </div>
                        <div class="col-md-5 pl-0">
                            : {{$locationSanitize(form.association_location_details)}}|
                            <label class="text-strong">গ্রাম : {{form.association_village}}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-4 text-strong pr-0 mt-2">৮. কার্যকরী কমিটির সদস্যগণের সংখ্যাঃ </div>
                <div class="col-md-2 pl-0">
                    <input type="text" class="form-control" :value="$en2bn(form.total_members)" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-8 text-strong pr-0 mt-1"><label for=""> ৯. প্রস্তাবিত সমিতির কার্যকরী এলাকা হইতে পার্শ্ববর্তি সমিতির কার্যকরী এলাকার দূরত্ব :</label></div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" :value="$en2bn(form.distance_of_working_area_to_adjoining_area)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-8 text-strong"><label for=""> ১০. প্রস্তাবিত সমিতির দুগ্ধ সংগ্রহ কেন্দ্র হইতে কারখানার দূরত্ব :</label></div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" :value="$en2bn(form.distance_of_factory_to_association_center)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="border-bottom text-strong"> ১১. রাস্তার ধরন  <span><i class="fa fa-spinner fa-spin" v-if="is_loading_types"></i></span>  </label>
                    <ol>
                        <li v-for="(item, index) in form.road_types" :key="index">
                            <div class="row form-group">
                                <div class="col-md-5 custom-label">
                                    <label for="name">
                                        <span>&nbsp;</span>
                                        <input type="text" class="form-control" :value="$en2bn(item.distance)" readonly>
                                    </label>
                                </div>

                                <div class="col-md-4">
                                    <input type="text" class="form-control" :value="item.road_type_name" readonly>
                                </div>

                                <div class="col-md-3 custom-label">
                                    {{item.unit}}
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <p>প্রত্যয়ন করা যাইতেছে যে, প্রস্তাবিত <span class="text-success">&nbsp;{{form.association_name}}&nbsp;</span> সমিতির নিয়ম মোতাবেক সংগ্রহ করা হইতেছে। অত্র সমিতির কার্যকরী এলাকা নিবিড় ও সলংগ্ন। সাংগঠনিক সভায় উপস্তি সমিতির সদস্য পদ গ্রহনে আগ্রহী ব্যক্তিগনের বয়স ১৮ বৎসরের নিচে নহে  প্রত্যেকে গাভী পালন করেন </p>

            <hr>
            <form @submit.prevent="submit()">
                <div class="row mb-4">
                    <div class="col-md-3 text-strong pr-0 mt-2 mb-4"> ১২. দুগ্ধ সংরক্ষণের স্থানঃ </div>
                    <div class="col-md-6 pl-0">
                        <input type="text" v-model="dairy_storage_area" class="form-control" >
                    </div>

                    <div class="col-md-12">
                        <label class="text-strong"> ১৩. কমিটির সদস্যদের তথ্য </label>
                        <hr class="mt-0">
                        <ol>
                            <li v-for="(row, index) in committee_members" :key="index">
                                <div class="row form-group">

                                    <div class="col-md-5 custom-label">
                                        <label for="name">
                                            <select id="" class="form-control" v-model="committee_members[index].member_id">
                                                <option value="">মেম্বার নির্বাচন করুন</option>
                                                <option v-if="form.members" v-for="(row, index) in form.members" :key="index" :value="row.id">{{row.member_name}}</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <select id="" class="form-control" v-model="committee_members[index].designation_id">
                                            <option value="">সদস্যের পদবী নির্বাচন করুন</option>
                                            <option v-if="designations" v-for="(row, index) in designations" :key="index" :value="row.id">{{row.designation_name}}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 pl-0">
                                        <button type="button" class="btn btn-success" @click="addNewMember()" v-if="index==0"><i class="fa fa-plus"></i></button>
                                        <button type="button" class="btn btn-danger" @click="removeMember(index)" v-else ><i class="fa fa-times"></i></button>
                                    </div>

                                </div>
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="text-strong"> ১৪. সমিতির ম্যানেজারের তথ্য </label>
                        <hr class="mt-0">
                        <div class="row pl-4">
                            <div class="col-md-6 form-group">
                                <label class="text-strong">১. ম্যানেজারের নামঃ</label>
                                <input type="text" class="form-control" v-model="manager_info.name_bn" required>
                            </div> 
                            
                            <div class="col-md-6 form-group">
                                <label class="text-strong">২. ম্যানেজারের মোবাইল নাম্বারঃ</label>
                                <input type="text" class="form-control" v-model="manager_info.mobile" required>
                            </div> 
                            
                            <div class="col-md-6 form-group">
                                <label class="text-strong">৩. ইমেইল এড্রেসঃ</label>
                                <input type="email" class="form-control" v-model="manager_info.email" required>
                            </div> 
                            
                            <div class="col-md-6 form-group">
                                <label class="text-strong">৪. জাতীয় পরিচয়পত্র নম্বরঃ</label>
                                <input type="text" class="form-control" v-model="manager_info.nid_no" required>
                            </div> 
                            
                            <div class="col-md-12 form-group">
                                <label class="text-strong">৫. ম্যানেজারের ঠিকানাঃ</label>
                                <textarea class="form-control" rows="3" v-model="manager_info.address" placeholder="ম্যানেজারের ঠিকানা লিখুন" required></textarea>
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="text-strong"> ১৫. দুগ্ধ কমিশন একাউন্ট </label>
                        <hr class="mt-0">
                        <div class="row pl-4">
                            <div class="col-md-6 form-group">
                                <label class="text-strong">ব্যাংকের নাম</label>
                                <input type="text" class="form-control" v-model="bank_info.commission_account.bank_name" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-strong">শাখার নাম</label>
                                <input type="text" class="form-control" v-model="bank_info.commission_account.branch_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="text-strong"> ১৬. দুগ্ধ বিল একাউন্ট </label>
                        <hr class="mt-0">
                        <div class="row pl-4">
                            <div class="col-md-6 form-group">
                                <label class="text-strong">ব্যাংকের নাম</label>
                                <input type="text" class="form-control" v-model="bank_info.bill_account.bank_name" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-strong">শাখার নাম</label>
                                <input type="text" class="form-control" v-model="bank_info.bill_account.branch_name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success float-right">Submit</button>
            </form>

        </div>
        <div class="card-footer">&nbsp;</div>
    </div>
</template>

<script>
    export default {
        name:'ApplicationDetals',
        layout:'admin',
        props:['relation'],
        data(){
            return {
                kernel              : {},
                divisions           : [],
                districts           : [],
                thanas              : [],
                somity_districts    : [],
                somity_thanas       : [],
                road_types          : [],
                is_loading_types    : false,
                is_submit           : false,
                form                : {},
                designations        : [],
                dairy_storage_area  : '',
                committee_members   : [{
                    designation_id:'',
                    member_id:''
                }],
                manager_info: {},
                bank_info:{
                    commission_account:{},
                    bill_account:{},
                }
            }
        },
        mounted(){
            this.fetchAssociation();
            //
            this.http('road-type/all', 'road_types');
            // GET ALL DIVISIONS
            this.http('location/divisions', 'divisions');
            // GET ALL DIVISIONS
            this.http('designation/list', 'designations');
        },
        methods:{
            submit(){
                this.http('association/resolution-submit/'+this.$route.query.id, 'resolution-submit', {
                    committee_members       : this.committee_members,
                    manager_infos           : this.manager_info,
                    bank_infos              : this.bank_info,
                    dairy_storage_area      : this.dairy_storage_area,
                    type                    : (this.form.control_flow.is_forward_for_correction==1 ? 're-submit' : 'submit')
                });
            },
            addNewMember(){
                if((this.committee_members).length <= (this.form.members).length)
                (this.committee_members).push({
                    designation_id:'',
                    member_id:''
                });
            },
            removeMember(index){
                this.$delete(this.committee_members, index);
            },
            fetchAssociation(){
                this.http('association/list', 'association', {
                    where:{ id:this.$route.query.id }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            checkLocation:function(type, id, is_somity=false){
                var url = 'location/'+(type=='division' ? 'districts' : (type=='district' ? 'thanas' : ''));
                this.$axios.post(url, {where:{[type+'_id']:id}})
                .then(res=>{
                    if(is_somity==true){
                        if(type=='division'){
                            this.somity_districts = res.data;
                        }
                        else if(type=='district'){
                            this.somity_thanas = res.data;
                        }
                    }
                    else {
                        if(type=='division'){
                            this.districts = res.data;
                        }
                        else if(type=='district'){
                            this.thanas = res.data;
                        }
                    }
                });
            }
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='designations'){
                        this.designations = (this.kernel[key].data);
                    }
                    else if(key=='resolution-submit'){
                        console.log(this.kernel[key]);
                        if(this.kernel[key].errors){
                            this.$alert({
                                text:this.kernel[key].errors,
                                icon:'info'
                            });
                        }
                        else {
                            this.$toastr.s("আবেদনটি সফলভাবে প্রেরণ করা হয়েছে");
                            this.$router.push({
                                path:'/association/application/resolution-list'
                            });
                        }
                    }
                    else if(key=='road_types'){
                        this.road_types       = this.kernel[key];
                        this.road_type_limit  = (this.kernel[key]).length-1;
                        this.is_loading_types = false;
                    }
                    else if(key=='association'){
                        if(this.kernel[key].data[0]){
                            this.form = this.kernel[key].data[0];
                            console.log(this.form);
                            this.checkLocation('division', this.form.association_division_id, true);
                            this.checkLocation('district', this.form.association_district_id, true);
                            //
                            this.checkLocation('division', this.form.milk_area_division_id)
                            this.checkLocation('district', this.form.milk_area_district_id)
                        }
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .custom-btn-group {
        display: grid;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -59%);
    }
</style>

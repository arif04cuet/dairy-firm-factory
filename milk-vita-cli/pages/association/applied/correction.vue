<template>
    <div class="card">
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="form-header">
                    <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                    <h2>প্রধান কার্যালয়</h2>
                    <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
                </div>

                <hr class="mb-2">

                <div class="alert-warning mb-2 p-2">
                    {{form.control_flow ? form.control_flow.remark : ''}}
                </div>

                <h6 class="pb-2 mb-3 text-strong">প্রস্তাবিত প্রাথমিক দুগ্ধ উৎপাদনকারী সমিতি সংগঠন সংক্রান্ত তথ্য স্বারক </h6>

                <div class="row form-group">
                    <div class="col-md-4 form-group">
                        <label class="text-strong">১. দুগ্ধ এলাকার নাম</label>
                        <input type="text" class="form-control" v-model="form.name_of_dairy_area" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="text-strong"> ২. প্রস্তাবিত সমিতির নাম</label>
                        <input type="text" class="form-control" v-model="form.association_name" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="text-strong"> ৩. সমিতির কার্যকরী এলাকা</label>
                        <input type="text" class="form-control" v-model="form.working_area_of_association" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-5 text-strong pr-0 mt-2"> ৪. প্রস্তাবিত সমিতির কোড:</div>
                            <div class="col-md-2 pl-0">
                                <input type="number" class="form-control" v-model="form.association_code" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-5 text-strong pr-0 mt-2"> ৪. সাংগঠনিক সভায় উপস্থিত সদস্য সংখ্যা:</div>
                            <div class="col-md-2 pl-0">
                                <input type="number" class="form-control" v-model="form.total_present_member" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="border-bottom mb-3"><strong> ৫. দুগ্ধ এলাকার ঠিকানা</strong></label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-strong">বিভাগ</label>
                                    <select class="form-control" v-model="form.milk_area_division_id" @change="checkLocation('division', form.milk_area_division_id)" required>
                                        <option value="">বিভাগ নির্বাচন করুন </option>
                                        <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-strong">জেলা</label>
                                    <select class="form-control" v-model="form.milk_area_district_id" @change="checkLocation('district', form.milk_area_district_id)" required>
                                        <option value="">জেলা নির্বাচন করুন </option>
                                        <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-strong">থানা</label>
                                    <select class="form-control" v-model="form.milk_area_thana_id" data-live-search="true" required>
                                        <option value="">থানা নির্বাচন করুন </option>
                                        <option v-for="(thana, index) in thanas" :key="index" :value="thana.id">{{thana.bn_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-strong">গ্রাম</label>
                                    <input type="text" class="form-control" placeholder="গ্রামের নাম লিখুন" v-model="form.milk_area_village" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-5 text-strong pr-0 mt-2">  ৬. কার্যকরী কমিটির সদস্যগণের সংখ্যা</div>
                    <div class="col-md-2 pl-0">
                        <input type="number" class="form-control" :value="form.total_members" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label class="border-bottom mb-2"><strong> ৭. সমিতির ঠিকানা</strong></label>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="text-strong">বিভাগ</label>
                                <select class="form-control" v-model="form.association_division_id" @change="checkLocation('division', form.association_division_id, true)" required>
                                    <option value="">জেলা নির্বাচন করুন </option>
                                    <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="text-strong">জেলা</label>
                                <select class="form-control" v-model="form.association_district_id" @change="checkLocation('district', form.association_district_id, true)" required>
                                    <option value="">উপজেলা নির্বাচন করুন </option>
                                    <option v-for="(district, index) in somity_districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="text-strong">থানা</label>
                                <select class="form-control" v-model="form.association_thana_id" required>
                                    <option value="">ডাকঘর নির্বাচন করুন </option>
                                    <option v-for="(thana, index) in somity_thanas" :key="index" :value="thana.id">{{thana.bn_name}}</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="text-strong">গ্রাম</label>
                                <input type="text" class="form-control" placeholder="গ্রামের নাম লিখুন " v-model="form.association_village" required>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-8 text-strong pr-0 mt-1"><label for=""> ৮. প্রস্তাবিত সমিতির কার্যকরী এলাকা হইতে পার্শ্ববর্তি সমিতির কার্যকরী এলাকার দূরত্ব :</label></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" v-model="form.distance_of_working_area_to_adjoining_area" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-8 text-strong"><label for=""> ৯. প্রস্তাবিত সমিতির দুগ্ধ সংগ্রহ কেন্দ্র হইতে কারখানার দূরত্ব :</label></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" v-model="form.distance_of_factory_to_association_center" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="border-bottom text-strong"> ১০. রাস্তার ধরন  <span><i class="fa fa-spinner fa-spin" v-if="is_loading_types"></i></span>  </label>
                        <ol>
                            <li v-for="(item, index) in form.road_type" :key="index">
                                <div class="row form-group">
                                    <div class="col-md-5 custom-label">
                                        <label for="name">
                                            <span>&nbsp;</span>
                                            <select class="form-control" v-model="form.road_type[index].road_type_id" @change="checkType(index)"  required>
                                                <option value="">রাস্তার ধরন নির্বাচন করুন</option>
                                                <option v-for="(type, index) in road_types" :key="index" :value="type.id">{{type.road_type_name}}</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number" class="form-control" v-model="form.road_type[index].distance" required>
                                    </div>

                                    <div class="col-md-1 custom-label">
                                        <span class="text-nowrap">{{item.unit}}</span>
                                    </div>

                                    <div class="col-md-1" v-if="index!=0">
                                        <button type="button" class="btn btn-danger" @click="removeRoadType(index)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </li>
                        </ol>
                        <div class="btn-group">
                            <!-- <button type="button" class="btn btn-danger" v-else @click="removeRoadType(index)"><i class="fa fa-trash" aria-hidden="true"></i></button> -->
                            <button type="button" class="btn btn-light border-success" @click="addRoadType"><i class="fa fa-plus" aria-hidden="true"></i>  আরও যুক্ত করুন</button>
                        </div>
                    </div>
                </div>

                <p>প্রত্যয়ন করা যাইতেছে যে, প্রস্তাবিত <span><input type="text" class="form-control" style="width:200px;display:inherit;outline:none;box-shadow:none" v-model="form.name_of_dairy_area" readonly></span> সমিতির নিয়ম মোতাবেক সংগ্রহ করা হইতেছে। অত্র সমিতির কার্যকরী এলাকা নিবিড় ও সলংগ্ন। সাংগঠনিক সভায় উপস্তি সমিতির সদস্য পদ গ্রহনে আগ্রহী ব্যক্তিগনের বয়স ১৮ বৎসরের নিচে নহে  প্রত্যেকে গাভী পালন করেন </p>

                <div class="form-group float-right">
                    <button class="btn btn-primary">
                        <i v-if="!is_submit" class="fa fa-floppy-o"></i> 
                        <i v-else class="fa fa-spinner fa-spin"></i>
                        <span>&nbsp;পুনরায় আবেদন করুন</span>
                    </button>
                </div>
                
            </form>
        </div>
        <div class="card-footer">&nbsp;</div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
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
                members             : [],
                form                : {},
                designation_list    : [],
                association_id      : '',
            }
        },
        mounted(){
            this.association_id = this.$route.query.id;
            this.http('association/list', 'association', {
                where:{
                    id:this.association_id
                }
            });
            
            this.http('association/all-member', 'members', {
                where:{
                    association_id:this.association_id
                }
            });
            // GET ALL ROAD TYPIES
            this.geolocation();
            //
            this.http('road-type/all', 'road_types');
            // GET ALL DIVISIONS
            this.http('location/divisions', 'divisions');
            this.http('designation/list', 'designation-list');
        },
        methods:{
            addRoadType:function(){
                if((this.form.road_type).length <= this.road_type_limit){
                    this.form.road_type.push({id:'', distance:'', unit:'কিঃ মিঃ', default:0});  
                    this.refreshForm();
                }
            },
            addCommiteeMember(){
                this.form.commitee_members.push({id:'', designation_id:'', member_id:''});
                this.refreshForm();
            },
            removeRoadType:function(index){
                this.$delete(this.form.road_type, index);
                this.refreshForm();
            },
            removeCommiteeMemberType:function(index){
                this.$delete(this.form.commitee_members, index);
                this.refreshForm();
            },
            submit:function(){
                this.is_submit = true;
                this.form.re_application = 1;
                this.http('association/application/'+this.association_id, 'send_application', this.form);
            },
            geolocation:function(){
                var option = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition((pos)=>{
                    var crd = pos.coords;
                    this.form.latitude  = crd.latitude;
                    this.form.longitude = crd.longitude;
                },
                (err)=>console.warn(`ERROR(${err.code}): ${err.message}`), option);
            },
            checkType:function(index){
                var count = 0;
                (this.form.road_type).forEach(type=>{
                    if(type.id==this.form.road_type[index].id){
                        count ++;
                        if(count==2)
                            this.form.road_type[index].id='';
                    }
                });
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
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            refreshForm(){
                var form = this.form; this.form = {}; this.form = form;
            },
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='road_types'){
                        this.road_types       = this.kernel[key];
                        this.road_type_limit  = (this.kernel[key]).length-1;
                        this.is_loading_types = false;
                    }
                    else if(key=='send_application'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                            this.is_submit = false;
                        }
                        else {
                            this.is_submit = false;
                            this.$toastr.s('আপনার আবেদনটি সংরক্ষন করা হয়েছে');
                            this.$router.push({path:'/association/application/list'});
                        }

                    }
                    else if(key=='members'){
                        this.members = this.kernel[key].data;
                    }
                    else if(key=='designation-list'){
                        this.designation_list = this.kernel[key].data;
                    }
                    else if(key=='association'){
                        if(this.kernel[key].data[0]){
                            this.form               = this.kernel[key].data[0];
                            this.form.road_type     = this.form.road_types;

                            // this.form.commitee_members         = [{designation_id:'', member_id:''}];

                            this.checkLocation('division', this.form.milk_area_division_id)
                            this.checkLocation('district', this.form.milk_area_district_id)
                            this.checkLocation('division', this.form.association_division_id, true)
                            this.checkLocation('district', this.form.association_district_id, true)
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

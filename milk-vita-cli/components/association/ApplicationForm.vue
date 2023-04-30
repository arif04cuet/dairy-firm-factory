<template>
    <div class="card">
        <div class="card-body p-5">
            <form @submit.prevent="submit">
                <div class="form-header">
                    <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                    <h2>প্রধান কার্যালয়</h2>
                    <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
                </div>

                <hr>

                <h6 class="pb-2 mb-3 text-strong">প্রস্তাবিত প্রাথমিক সমবায় সমিতি সংগঠন সংক্রান্ত তথ্য স্বারক </h6>

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
                            <div class="col-md-5 text-strong pr-0 mt-2"> {{$en2bn(4)}}. প্রস্তাবিত সমিতির কোডঃ</div>
                            <div class="col-md-2 pl-0">
                                <input type="number" class="form-control" v-model="form.association_code" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-5 text-strong pr-0 mt-2"> {{$en2bn(5)}}. সাংগঠনিক সভায় উপস্থিত সদস্য সংখ্যাঃ</div>
                            <div class="col-md-2 pl-0">
                                <input type="number" class="form-control" v-model="form.total_present_member" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-md-5 text-strong pr-0 mt-2">  ৬. কার্যকরী কমিটির সদস্যগণের সংখ্যাঃ</div>
                            <div class="col-md-2 pl-0">
                                <input type="number" class="form-control" :value="form.total_commitee_member" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <fieldset>
                            <legend>{{$en2bn(7)}}. দুগ্ধ এলাকার ঠিকানা</legend>

                            <location v-model="milk_area_location" class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">বিভাগ</label>
                                        <div data-division></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">জেলা</label>
                                        <div data-district></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">উপজেলা</label>
                                        <div data-upazila></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">ইউনিয়ন</label>
                                        <div data-union></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">গ্রাম</label>
                                        <input type="text" class="form-control" placeholder="গ্রামের নাম লিখুন" v-model="form.milk_area_village" required>
                                    </div>
                                </div>
                            </location>
                        </fieldset>
                        <!-- // -->
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <fieldset>
                            <legend>{{$en2bn(8)}}. সমিতির ঠিকানা</legend>
                            <location v-model="association_location" class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">বিভাগ</label>
                                        <div data-division></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">জেলা</label>
                                        <div data-district></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">উপজেলা</label>
                                        <div data-upazila></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-strong">ইউনিয়ন</label>
                                        <div data-union></div>
                                    </div>
                                </div>
                                <!-- // -->
                                <div class="col-md-3 form-group">
                                    <label class="text-strong">গ্রাম</label>
                                    <input type="text" class="form-control" placeholder="গ্রামের নাম লিখুন " v-model="form.association_village" required>
                                </div>
                            </location>
                        </fieldset>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-6 text-strong pr-0 mt-1"><label for=""> {{$en2bn(9)}}. প্রস্তাবিত সমিতির কার্যকরী এলাকা হইতে পার্শ্ববর্তি সমিতির কার্যকরী এলাকার দূরত্বঃ</label></div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" v-model="form.distance_of_working_area_to_adjoining_area" required aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">কিঃ মিঃ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-6 text-strong"><label for=""> {{$en2bn(10)}}. প্রস্তাবিত সমিতির দুগ্ধ সংগ্রহ কেন্দ্র হইতে কারখানার দূরত্বঃ</label></div>
                            <div class="col-md-4">

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" v-model="form.distance_of_factory_to_association_center" required aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">কিঃ মিঃ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="border-bottom text-strong"> {{$en2bn(11)}}. রাস্তার ধরন  <span><i class="fa fa-spinner fa-spin" v-if="is_loading_types"></i></span>  </label>
                        <ol>
                            <li v-for="(item, index) in form.road_type" :key="index">
                                <div class="row form-group">
                                    <div class="col-md-5 custom-label">
                                        <label for="name">
                                            <span>&nbsp;</span>
                                            <select class="form-control" v-model="form.road_type[index].road_type_id" @change="checkType(index)" required>
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

                                    <div class="col-md-1">
                                        <button v-if="index==0" type="button" class="btn btn-success" @click="addRoadType"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        <button v-else type="button" class="btn btn-danger" @click="removeRoadType(index)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- // -->
                <div v-if="form.control_flow && form.control_flow.chilling_plant_manager_id">
                    <h6 class="pb-2 mb-3 mt-5 text-strong border-bottom">১১. কমিটির তথ্য </h6>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <ol>
                                <li v-for="(item, index) in form.committee_members" :key="index">
                                    <div class="row form-group">
                                        <div class="col-md-5 custom-label">
                                            <label for="name">
                                                <span>&nbsp;</span>
                                                <select class="form-control" v-model="form.committee_members[index].designation_id" required>
                                                    <option value="">উপাধি নির্বাচন করুন</option>
                                                    <option v-for="(row, index) in designation_list" :key="index" :value="row.id">{{row.designation_name}}</option>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-md-5">
                                            <select class="form-control" v-model="form.committee_members[index].member_id" required>
                                                <option value="">সদস্য নির্বাচন করুন</option>
                                                <option v-for="(row, index) in members" :key="index" :value="row.id">{{row.member_name}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1" v-if="index!=0">
                                            <button type="button" class="btn btn-danger" @click="removeCommiteeMemberType(index)"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light border-success" @click="addCommiteeMember()"><i class="fa fa-plus" aria-hidden="true"></i>  আরও যুক্ত করুন</button>
                            </div>
                        </div>
                    </div>
                </div>

                <p>প্রত্যয়ন করা যাইতেছে যে, প্রস্তাবিত <span class="text-success">&nbsp;{{form.association_name}}&nbsp;</span> সমিতির নিয়ম মোতাবেক সংগ্রহ করা হইতেছে। অত্র সমিতির কার্যকরী এলাকা নিবিড় ও সংলগ্ন। সাংগঠনিক সভায় উপস্থিত সমিতির সদস্য পদ গ্রহনে আগ্রহী ব্যক্তিগনের বয়স ১৮ বৎসরের নিচে নহে  প্রত্যেকে গাভী পালন করেন </p>

                <div class="form-group float-right">
                    <button class="btn btn-primary">
                        <i v-if="!is_submit" class="fa fa-floppy-o"></i> 
                        <i v-else class="fa fa-spinner fa-spin"></i>
                        <span>&nbsp;আবেদন করুন</span>
                    </button>
                </div>
                
            </form>
        </div>
            <loader :loader="is_loading" style="position:fixed"/>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        props:['association_id'],
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
                milk_area_location  : {},
                association_location: {},
                is_loading          : true,
            }
        },
        mounted(){
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
            // 
            this.http('designation/list', 'designation-list', {});
        },
        methods:{
            addRoadType:function(){
                if((this.form.road_type).length <= this.road_type_limit){
                    this.form.road_type.push({road_type_id:'', distance:'', unit:'কিঃ মিঃ', default:0});  
                    this.refreshForm();
                }
            },
            addCommiteeMember(){
                this.form.committee_members.push({designation_id:'', designation_id:'', member_id:''});
                this.refreshForm();
            },
            removeRoadType:function(index){
                this.$delete(this.form.road_type, index);
                this.refreshForm();
            },
            removeCommiteeMemberType:function(index){
                this.$delete(this.form.committee_members, index);
                this.refreshForm();
            },
            submit:function(){
                this.is_submit = true;
                this.form.for_validation = 1;
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
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            refreshForm(){
                var form = this.form; this.form = {}; this.form = form;
            },
        },
        watch:{
            milk_area_location(){
                this.form.milk_area_division_id = this.milk_area_location.division_id
                this.form.milk_area_district_id = this.milk_area_location.district_id
                this.form.milk_area_upazila_id  = this.milk_area_location.upazila_id
                this.form.milk_area_union_id    = this.milk_area_location.union_id
            },
            association_location(){
                this.form.association_division_id = this.association_location.division_id
                this.form.association_district_id = this.association_location.district_id
                this.form.association_upazila_id  = this.association_location.upazila_id
                this.form.association_union_id    = this.association_location.union_id
            },
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='road_types'){
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
                            this.form.road_type     = [{road_type_id:'', unit:'কিঃ মিঃ', distance:'', default:1}];
                            this.form.committee_members         = [{designation_id:'', member_id:''}];
                            this.form.association_division_id   = '';
                            this.form.association_district_id   = '';
                            this.form.association_thana_id      = '';
                            this.form.milk_area_division_id     = '';
                            this.form.milk_area_district_id     = '';
                            this.form.milk_area_thana_id        = '';
                        }
                        this.is_loading = false;
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

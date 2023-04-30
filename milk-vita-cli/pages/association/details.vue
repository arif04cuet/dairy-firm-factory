<template>
    <div class="card">
        <div class="card-header">
            <h3 class="m-0">সমিতির তথ্য </h3>
        </div>
        <div class="card-body min80vh">
            <div v-if="!loader && association_id > 0">
                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(1)}}. দুগ্ধ এলাকার নাম</div>
                    <div class="col-md-6">: {{data.name_of_dairy_area}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(2)}}. সমিতির কার্যকরী এলাকা</div>
                    <div class="col-md-6">: {{data.working_area_of_association}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(3)}}. প্রস্তাবিত সমিতির কোড</div>
                    <div class="col-md-6">: {{$en2bn(data.association_code)}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(4)}}. সাংগঠনিক সভায় উপস্থিত সদস্য সংখ্যা</div>
                    <div class="col-md-6">: {{$en2bn(data.total_present_member)}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(5)}}. কার্যকরী কমিটির সদস্যগণের সংখ্যা</div>
                    <div class="col-md-6">: {{$en2bn(data.total_members)}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">{{$en2bn(6)}}. দুগ্ধ সংরক্ষণের স্থান</div>
                    <div class="col-md-6">: {{data.dairy_storage_area}}</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8 pr-0">{{$en2bn(7)}}. প্রস্তাবিত সমিতির দুগ্ধ সংগ্রহ কেন্দ্র হইতে কারখানার দূরত্ব</div>
                    <div class="col-md-3 pl-0">: {{$en2bn(data.distance_of_factory_to_association_center)}} কি.মি.</div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8 pr-0">{{$en2bn(8)}}. প্রস্তাবিত সমিতির কার্যকরী এলাকা হইতে পার্শ্ববর্তি সমিতির কার্যকরী এলাকার দূরত্ব</div>
                    <div class="col-md-3 pl-0">: {{$en2bn(data.distance_of_working_area_to_adjoining_area)}} কি.মি.</div>
                </div>

                <div class="row mb-4" v-if="data.road_types">
                    <div class="col-md-12">
                        <label class="text-strong">{{$en2bn(9)}}. রাস্তার ধরন </label>
                        <div class="row pl-5">
                            <label class="col-md-3 text-strong text-nowrap" v-for="(row, index) in data.road_types" :key="index">{{$en2bn(index+1)}}. {{row.road_type_name}} = {{$en2bn(row.distance)}} {{row.unit}}</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-4" v-if="data.manager">
                    <div class="col-md-12">
                        <label class="text-strong">{{$en2bn(10)}}. সমিতির ম্যানেজারের তথ্য </label>
                        <div class="row pl-5">
                            <label class="col-md-3 text-strong text-nowrap">১. ম্যানেজারের নাম</label><span class="col-md-9 text-strong">: {{data.manager.name_bn}}</span>
                            
                            <label class="col-md-3 text-strong text-nowrap">২. ম্যানেজারের মোবাইল নাম্বার</label><span class="col-md-9 text-strong">: {{data.manager.mobile}}</span>

                            <label class="col-md-3 text-strong text-nowrap">৩. ইমেইল এড্রেস</label><span class="col-md-9 text-strong">: {{data.manager.email}}</span>

                            <label class="col-md-3 text-strong text-nowrap">৪. জাতীয় পরিচয়পত্র নম্বর</label><span class="col-md-9 text-strong">: {{data.manager.nid_no}}</span>
                            
                            <label class="col-md-3 text-strong text-nowrap">৫. ম্যানেজারের ঠিকানা</label> <span class="col-md-9 text-strong">: {{data.manager.address}}</span>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="data.bank_infos">
                    <div class="col-md-12 pb-2" v-for="(row, index) in data.bank_infos" :key="index">
                        <div style="position:relative">
                            <label class="text-strong"> {{$en2bn((index+11))}}. {{row.type=='commission_account' ? 'দুগ্ধ কমিশন একাউন্ট' : 'দুগ্ধ বিল একাউন্ট'}}</label>
                            <!-- // -->
                            <button v-if="index==0" @click="((row.account_no=='' || row.account_no==null) ? openPopup(true) : '')" class="customer-info-btn" style="position: absolute;right:0"> 
                                <div v-if="(row.account_no=='' || row.account_no==null)">
                                    <i class="fa fa-university" aria-hidden="true"></i>&nbsp;
                                    <span>ব্যাংকের তথ্য হালনাগাদ করুন</span>
                                </div>

                                <div v-else >
                                    <i class="fa fa-check" aria-hidden="true"></i>&nbsp;
                                    <span>সমিতির তথ্য হালনাগাদ করা হয়েছে</span>
                                </div>
                            </button>
                        </div>
                        <hr class="mt-0">
                        <div class="pl-4" style="display:grid">
                            <div class="text-strong text-nowrap"><label style="width:100px">১. ব্যাংকের নাম</label> <span> : {{row.bank_name}}</span></div>
                            <div class="text-strong text-nowrap"><label style="width:100px">২. শাখার নাম</label> <span>  : {{row.branch_name}}</span></div>
                            <div class="text-strong text-nowrap" v-if="(row.account_no!='' && row.account_no!=null)"><label style="width:100px">{{$en2bn(3)}}. হোল্ডার নাম</label> <span>  : {{row.holder_name}}</span></div>
                            <div class="text-strong text-nowrap" v-if="(row.account_no!='' && row.account_no!=null)"><label style="width:100px">{{$en2bn(4)}}. একাউন্ট নাম্বার</label> <span>  : {{row.account_no}}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <h5 v-else-if="!loader" class="text-danger">দুঃখিত, আপনি কোনো সমিতির ম্যানেজার নন</h5>

            <Loader :loader="loader" />

            <!-- // BANK INFO UPDATE PART // -->
            <div class="popup" v-if="is_popup">
                <div class="popup-box">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="p-0 pt-1 m-0"><i class="fa fa-university" aria-hidden="true"></i>&nbsp;ব্যাংকের তথ্য</h4>
                            <button class="btn btn-warning" @click="openPopup(false)"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="card-body min85vh">
                            <form @submit.prevent="submit()">

                                <div class="row" v-if="data.bank_infos">
                                    <div class="col-md-12 pb-2" v-for="(row, index) in data.bank_infos" :key="index">
                                        <label class="text-strong"> {{$en2bn((index+1))}}. {{row.type=='commission_account' ? 'দুগ্ধ কমিশন একাউন্ট' : 'দুগ্ধ বিল একাউন্ট'}}</label>
                                        
                                        <hr class="mt-0">

                                        <div class="pl-5">
                                            <div class="row form-group">
                                                <div class="col-md-2">১. ব্যাংকের নাম</div><div class="col-md-4 border-right">: {{row.bank_name}}</div>
                                                <div class="col-md-1 pr-0 text-nowrap">২. শাখার নাম</div><div class="col-md-4 pr-0">&nbsp;:&nbsp;{{row.branch_name}}</div>
                                            </div>

                                            <div class="row form-group">
                                                <!-- // -->
                                                <div class="col-md-2 pt-2">{{$en2bn(3)}}. একাউন্ট নাম্বার</div><div class="col-md-4 border-right"> <input type="text" class="form-control" v-model="acc_details[row.type].account_no" placeholder="একাউন্ট নাম্বার" required></div>
                                                <!-- // -->
                                                <div class="col-md-1 pr-0 pt-1 text-nowrap">{{$en2bn(4)}}. হোল্ডার নাম</div><div class="col-md-4 d-flex">&nbsp;<span class="mt-1">:</span>&nbsp;<input type="text" class="form-control" v-model="acc_details[row.type].holder_name" placeholder="হোল্ডার নাম" required></div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-2">{{$en2bn(5)}}. সিগনেটোরি</div>
                                                <div class="col-md-9">
                                                    <div class="form-control" style="height:100px;overflow:auto">
                                                        <div class="row m-0">
                                                            <div class="col-md-6" v-if="data.commitee_members && (data.commitee_members).length > 0" v-for="(member, inner_index) in data.commitee_members" :key="inner_index">
                                                                <label :for="'member'+(inner_index+'d'+index)" class="d-flex align-items-center">
                                                                <input type="checkbox" :id="'member'+(inner_index+'d'+index)" :true-value="member.id" v-model="acc_details[row.type].signatories[inner_index]">&nbsp;{{member.member_name}}({{member.designation}})</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-11">
                                        <button class="btn btn-success float-right" style="width:225px">
                                            <span v-if="is_submit"><i class="fa fa-spinner fa-spin"></i>&nbsp;অনুগ্রহপূর্বক অপেক্ষা করুন</span>
                                            <span v-else ><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সেইভ করুন</span>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // END BANK INFO UPDATE PART // -->

        </div>
    </div>
</template>

<script>
    export default {
        name:'add',
        layout:'admin',
        head(){
            return {title:'সমিতি নিবন্ধন'}
        },
        data(){
            return {
                kernel  : {},
                url     : process.env.API_SERVER,
                data    : {
                    manager     : {},
                    bank_infos  : {}, 
                },
                association_id : 0,
                is_popup       : false,
                is_submit      : false,
                loader         : true,
                acc_details    : {
                    commission_account : {
                        signatories : [],
                        account_no:'',
                        holder_name:'',
                    },
                    bill_account       : {
                        signatories : [],
                        account_no:'',
                        holder_name:'',
                    },
                }
            }
        },
        mounted(){
            this.association_id = this.$store.state.auth.user.association_id;
            this.getAssociation();
        },
        methods:{
            submit(){
                this.http('association/update-bank-info/'+(this.data.id), 'update-bank', {
                    bank_infos:this.acc_details
                });
                this.is_submit = true;
            },
            getAssociation(){
                this.http(this.url+'association/list', 'association', {
                    where:{
                        'id':this.$store.state.auth.user.association_id
                    }
                });
            },
            openPopup(niddle){
                this.is_popup  = niddle;
                this.is_submit = false;
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='association'){
                        this.data = this.kernel[key].data[0];
                        this.loader = false;
                    }
                    else if(key=='update-bank'){
                        this.is_submit = false;
                        if(this.kernel[key].erros){
                            this.$toastr.w(this.kernel[key].erros);
                        }
                        else {
                            this.$toastr.s("ব্যাংকের তথ্য সফলভাবে আপডেট করা হয়েছে");
                            this.is_popup  = false;
                            this.loader    = true;
                            this.getAssociation();
                        }
                    }
                }
            },
        }
    }
</script>

<style scoped>
    .popup-box {
        width: 75%;
        border-radius: 4px;
    }
    .popup-inner-div {
        width: 100%;
        max-height: 90vh;
        display: block;
        overflow: auto;
    }
    .customer-info-btn {
        padding: 14px 35px;
        border: 1px solid #ddd;
        font-size: 15px;
        min-width: 243px;
        background: #ffe2e2;
        border-radius: 2px;
        transition: all 0.5s linear;
        color: #382929dd;
    }

    .customer-info-btn:hover {
        background: #e5cdcd;
        color: #4c4949;
    }
</style>

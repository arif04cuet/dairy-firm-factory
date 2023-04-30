<template>
    <div class="card border-0 shadow-0">
        <div class="card-header">
            <h4 class="m-0">সদস্যদ আপডেট করুন</h4>
        </div>

        <div class="card-body">
            <form @submit.prevent="update">
                <!-- // -->
                <fieldset class="fieldset">
                    <legend class="m-0"><span class="mr-1 ml-1"> ----- </span></legend>
                    <div class="row form-group member_rows" style="position:relative">
                        <!-- // -->
                        <div class="col-md-6 border-right">
                            <!-- // -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label> নাম <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" v-model="form.member_name" class="form-control required" style="border-radius: 3px;" placeholder="সদস্যের নাম">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>পিতার/স্বামীর নাম <span class="text-danger">*</span></label>
                                    <input type="text" v-model="form.spouse_name_en" class="form-control required" placeholder="সদস্যের পিতার/স্বামীর নাম ">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>লিঙ্গ <span class="text-danger">*</span></label>
                                    <div class="form-control border-0 p-0 m-0" ref="required_gender">
                                        <Gender
                                            v-if="form.gender"
                                            v-model="form.gender"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-3 p-0 form-group">
                                    <label>বয়স <span class="text-danger">*</span></label>
                                    <input type="number" min="0" v-model="form.age" class="form-control required">
                                </div>

                                <div class="col-md-5 form-group">
                                    <label>মোবাইল <span class="text-danger">*</span></label>
                                    <input type="text" v-model="form.mobile" class="form-control required" placeholder="মোবাইল">
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


                            </div>
                            <!-- // -->
                        </div>
                        <!-- // -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3 form-group" title="উৎপাদিত দুধের পরিমান (প্রতিদিন)"> 
                                    <!-- (প্রতিদিন) -->
                                    <label><small>উৎপাদিত দুধের পরিমান</small></label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="0" v-model="form.amount_of_milk_produced" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">লিটার</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="">গাভী</label>
                                    <input type="number" min="0" v-model="form.total_gavi" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>বকনা</label>
                                    <input type="number" min="0" v-model="form.total_bokna" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>বকন বাছুর</label>
                                    <input type="number" min="0" v-model="form.total_bokon_bachor" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>এঁড়ে বাছুর</label>
                                    <input type="number" min="0" v-model="form.total_bokna" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>ষাঁড়</label>
                                    <input type="number" min="0" v-model="form.total_shar" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>বলদ</label>
                                    <input type="number" min="0" v-model="form.total_bolod" class="form-control">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>মহিষ</label>
                                    <input type="number" min="0" v-model="form.total_mohish" class="form-control">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>কোথায় বিক্রয় হয়</label>
                                    <textarea style="min-height:125px" v-model="form.where_sales_are" class="form-control" placeholder="কোথায় বিক্রয় হয়" cols="30" rows="4"></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>মন্তব্য</label>
                                    <textarea style="min-height:125px" v-model="form.remark" class="form-control" placeholder="মন্তব্য" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
                <!-- // -->
                <div class="pt-2">
                    <button class="btn btn-success float-right ml-1">
                        <span v-if="loader.submit==false"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;আপডেট করুন</span>
                        <span v-else ><i class="fa fa-spinner fa-spin"></i>&nbsp;আপডেট হচ্ছে</span>
                    </button>
                    <button type="button" class="btn btn-danger float-right" @click="cancel"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;বাতিল করুন</button>
                </div>
            </form>
            <Loader :loader="loader.page" />
        </div>
    </div>
</template>

<script>
    import Gender from '@/components/system/Gender.vue';
    import Location from '@/components/system/Location.vue';
    export default {
        components:{Location, Gender},
        props:['member_id'],
        model:{
            prop:'member_id',
            event:'change',
        },
        data(){
            return {
                loader: {
                    submit:false,
                    page:true
                },
                form:{}
            }
        },
        mounted(){
            this.$axios.post('association/all-member', {
                where:{id:this.member_id}
            })
            .then(res=>{
                if(res.data.data && res.data.data[0]){
                    this.form = res.data.data[0];
                    this.form.gender = this.form.gender_id;
                    this.form.geolocation = {
                        division_id : this.form.division_id,
                        district_id : this.form.district_id,
                        upazila_id : this.form.upazila_id,
                    };
                    //
                    setTimeout(() => {
                        this.loader.page = false;
                    }, 5000);
                }
            });
        },
        methods:{
            update(){
                this.loader.submit = true;
                this.$axios.post('association/update-member/'+this.member_id, this.form)
                .then(res=>{
                    if(res.data.errors){
                        this.$toastr.w(res.data.errors);
                    }
                    else {
                        this.$toastr.s('মেম্বার সফল ভাবে আপডেট হয়েছে');
                    }
                    //
                    this.loader.submit = false;
                });
            },
            cancel(){
                this.$emit('change', '');
            }
        }
    }
</script>


<style scoped>
    .popup-box {
        width: 100%!important;
        border-radius: 4px;
    }
    .popup-inner-div {
        width: 100%;
        max-height: 90vh;
        display: block;
        overflow: auto;
    }
</style>

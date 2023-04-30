<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;মিটিং রেজোলিউশন সংযুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/field-officer/meeting-resolution/all" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="submit()">

                    <div class="form-group row">
                        <label class="col-md-4 text-md-right mt-2" for="">সমিতি নির্বাচন করুনঃ</label>
                        <div class="col-md-5">
                            <select class="form-control" v-model="form.association_id">
                                <option value="">সমিতি নির্বাচন করুন</option>
                                <option v-for="(row, index) in associations" :key="index" :value="row.id">{{row.association_name}} ({{row.association_code}})</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 text-md-right mt-2" for="">মিটিং এর তারিকঃ</label>
                        <div class="col-md-5">
                            <!-- <date-picker
                                ref="date"
                                class="form-control" 
                                v-model="form.meeting_date" 
                                placeholder="মিটিং এর তারিক" 
                                format="yyyy/MM/dd"
                                required
                            ></date-picker> -->
                            <input type="date" class="form-control" v-model="form.meeting_date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 text-md-right mt-2" for="">মিটিং শিরোনামঃ</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" v-model="form.meeting_title" placeholder="মিটিং শিরোনাম" required>
                        </div>
                    </div>

                    <div class="col-md-9 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                সেইভ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel        : {},
                associations  : [],
                form : {
                    association_id  :'',
                    meeting_date    : (new Date().getTime()),
                    meeting_title   :'',
                },
            }
        },
        mounted(){
            this.http('association/list', 'associations', {
                type:'chairman-approve-list'
            });
        },
        methods:{
            submit(){
                this.http('meeting-resolution/new', 'add-new', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='associations'){
                        this.associations = this.kernel[key].data;
                    }
                    else if(key=='add-new'){
                        if(this.kernel[key].errors){
                            this.$toastr.s(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s("মিটিং রেসোলিউশন সফলভাবে তৈরী হয়েছে");
                            this.$router.push({path:'/field-officer/meeting-resolution/all'});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;মিটিং রেজোলিউশন - <span v-if="resolution">{{resolution.association_name}}</span></h5>
                <div class="btn-group">
                    <nuxt-link to="/field-officer/meeting-resolution/all" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div class="form-group">
                <label for="">মিটিং তারিখঃ</label>
                <input type="text" v-model="resolution.meeting_date" class="form-control" placeholder="মিটিং তারিখ" readonly>
            </div>

            <!-- // -->
            <div class="form-group">
                <label for="">মিটিং শিরোনামঃ</label>
                <input type="text" v-model="resolution.meeting_title" class="form-control" placeholder="মিটিং শিরোনাম লিখুন" readonly>
            </div>

            <!-- // -->
            <div class="form-group">
                <label for="">মিটিং রেজুলেশনঃ</label>
                <textarea v-model="resolution.meeting_resolution" class="form-control" cols="30" rows="6" placeholder="মিটিং রেজুলেশন লিখুন" readonly></textarea>
            </div>

            <div v-if="resolution.manager && resolution.type=='manager-change'">
                <hr>
                <!-- // -->
                <div class="form-group">
                    <label for="">ম্যানেজারের নামঃ</label>
                    <input v-model="resolution.manager.name_bn" class="form-control" placeholder="ম্যানেজারের নাম লিখুন" readonly>
                </div>

                <!-- // -->
                <div class="form-group">
                    <label for="">ম্যানেজারের মোবাইল নাম্বারঃ</label>
                    <input v-model="resolution.manager.mobile" class="form-control" placeholder="ম্যানেজারের মোবাইল নাম্বার লিখুন" readonly>
                </div>

                <!-- // -->
                <div class="form-group">
                    <label for="">ইমেইল এড্রেসঃ</label>
                    <input v-model="resolution.manager.email" class="form-control" placeholder="ইমেইল এড্রেস লিখুন" readonly>
                </div>

                <!-- // -->
                <div class="form-group">
                    <label for="">জাতীয় পরিচয়পত্র নম্বরঃ</label>
                    <input v-model="resolution.manager.nid_no" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর লিখুন" readonly>
                </div>

                <!-- // -->
                <div class="form-group">
                    <label for="">ম্যানেজারের ঠিকানাঃ</label>
                    <textarea v-model="resolution.manager.address" class="form-control" cols="30" rows="6" placeholder="ম্যানেজারের ঠিকানা লিখুন" readonly></textarea>
                </div>
            </div>

            <div v-if="resolution.type=='committee-change'">
                <hr>
                <!-- // -->
                <div class="form-group" v-if="resolution.commitee_members" v-for="(row, index) in resolution.commitee_members" :key="index">
                    <label for="">{{row.designation}}:</label>
                    <select class="form-control" v-model="resolution.commitee_members[index].member_id" disabled>
                        <option value="">সদস্য নির্বাচন করুন</option>
                        <option v-for="(member, index2) in members" :key="index2" :value="member.id">{{member.member_name}}</option>
                    </select>
                </div>
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
                resolution:{
                    commitee_members:[]
                },
                kernel : {},
                members:[],
            }
        },
        mounted(){
            this.http('meeting-resolution/list', 'resolution', {
                type:'chairman-approve-list',
                where:{id:this.$route.query.id}
            });
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='resolution'){
                        this.resolution = this.kernel[key].data[0];
                        //
                        if(this.resolution.type=='committee-change'){
                            //
                            this.$axios.post('association/all-member', {
                                where:{
                                    association_id:this.resolution.association_id
                                }
                            })
                            .then(res=>{this.members = (res.data).data;});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>

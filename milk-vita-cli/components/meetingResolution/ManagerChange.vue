<template>
    <form action="" @submit.prevent="submit" class="pt-3">
        <!-- // -->
        <div class="form-group">
            <label for="">মিটিং তারিখঃ</label>
            <input type="text" v-model="form.meeting_date" class="form-control" placeholder="মিটিং তারিখ" readonly>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">মিটিং শিরোনামঃ</label>
            <input type="text" v-model="form.meeting_title" class="form-control" placeholder="মিটিং শিরোনাম লিখুন" readonly>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">মিটিং রেজুলেশনঃ</label>
            <textarea v-model="form.meeting_resolution" class="form-control" cols="30" rows="6" placeholder="মিটিং রেজুলেশন লিখুন" required></textarea>
        </div>

        <hr>

        <!-- // -->
        <div class="form-group">
            <label for="">ম্যানেজারের নামঃ</label>
            <input v-model="form.manager_name" class="form-control" placeholder="ম্যানেজারের নাম লিখুন" required>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">ম্যানেজারের মোবাইল নাম্বারঃ</label>
            <input v-model="form.manager_mobile" class="form-control" placeholder="ম্যানেজারের মোবাইল নাম্বার লিখুন" required>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">ইমেইল এড্রেসঃ</label>
            <input v-model="form.manager_email" class="form-control" placeholder="ইমেইল এড্রেস লিখুন" required>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">জাতীয় পরিচয়পত্র নম্বরঃ</label>
            <input v-model="form.manager_nid_no" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর লিখুন" required>
        </div>

        <!-- // -->
        <div class="form-group">
            <label for="">ম্যানেজারের ঠিকানাঃ</label>
            <textarea v-model="form.manager_address" class="form-control" cols="30" rows="6" placeholder="ম্যানেজারের ঠিকানা লিখুন" required></textarea>
        </div>

        <!-- // -->
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success"> 
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                <span>সাবমিট করুন</span>
            </button>
        </div>
        <!-- // -->
    </form>
</template>

<script>
export default {
    data(){
        return {
            resolution_id:'',
            form : {}
        }
    },
    mounted(){
        this.resolution_id = this.$route.query.id;
    },
    methods:{
        submit(){
            this.form.type = 'manager-change';
            this.$axios.post('meeting-resolution/resolution-submit/'+this.resolution_id, this.form)
            .then(res=>{
                if(res.data.errors){
                    this.$toastr.w(res.data.errors);
                }
                else {
                    this.$toastr.s("রেজোলিউশন ফর্ম সফলভাবে সাবমিট দেওয়া হয়েছে");
                    this.$router.push({path:'/field-officer/meeting-resolution/all'});
                }
            });
        }
    },
    watch:{
        resolution_id(){
            this.$axios.post('meeting-resolution/list',{where:{id:this.resolution_id}})
            .then(res=>{
                if((res.data.data).length>0){
                    this.form = res.data.data[0];
                }
            });
        }
    }
}
</script>

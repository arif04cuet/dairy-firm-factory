<template>
    <form action="" @submit.prevent="submit" class="pt-3">
        <!-- // -->
        <div class="form-group">
            <label for="">মিটিং তারিখঃ</label>
            <input type="text" v-model="form.meeting_date" class="form-control" placeholder="মিটিং তারিখ" readonly>
        </div>
        <!-- // -->
        <div class="form-group">
            <label for="" >মিটিং শিরোনামঃ</label>
            <input type="text" v-model="form.meeting_title" class="form-control" placeholder="মিটিং শিরোনাম লিখুন" readonly>
        </div>
        <!-- // -->
        <div class="form-group">
            <label for="">মিটিং রেজুলেশনঃ</label>
            <textarea v-model="form.meeting_resolution" class="form-control" cols="30" rows="6" placeholder="মিটিং রেজুলেশন লিখুন"></textarea>
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
            this.form.type = 'general';
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

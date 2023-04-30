<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 bg-white">
                <h2 class="text-center pt-5">কার্য্য তালিকা</h2>
                <FullCalendar
                    v-if="is_ready"
                    :events="events"
                />
            </div>
        </div>
    </div>
</template>

<script>
import FullCalendar from '~/components/FullCalendar.vue';

export default {
    components:{FullCalendar},
    data:()=>({
        is_ready : false,
        events   : [],
    }),
    mounted(){
        this.$axios.post('dashboard', {})
        .then(res=>{
            this.events = (res.data.meetings ? res.data.meetings : []);
            this.events.map((row)=>{ 
                if(row.type=='schedule') row.path = "/task-schedule/view?id="+row.id
                else row.path = "/field-officer/meeting-resolution/meeting?id="+row.id
            });
            this.is_ready = true;
        });
    }
}
</script>

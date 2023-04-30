<template>
    <association-details
        relation="field_officer_app_view"
    ></association-details>
</template>

<script>
import details from '@/components/association/ApplicationDetails.vue';
export default {
    layout:'admin',
    components:{
        'association-details':details
    },
    data(){
        return {}
    },
    mounted(){
        
    }
}
</script>

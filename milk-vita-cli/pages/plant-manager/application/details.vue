<template>
    <association-details
        relation="chilling-plant-manager"
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

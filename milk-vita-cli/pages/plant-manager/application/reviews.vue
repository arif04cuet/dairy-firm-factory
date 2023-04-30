<template>
    <div class="card">
    	<div class="card-body min75vh">
	        <asso-list
                type="application-review-list"
            ></asso-list>
    	</div>
    </div>
</template>

<script>
    import Pagination from 'vue-pagination-2';
    import list from '@/components/association/AssociationList.vue';
    //
    export default {
        layout :'admin',
        name   :'all',
        components : {
            Pagination,
            'asso-list':list
        },
        data(){
            return {
                
            }
        },
        mounted(){
           
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    
                }
            }
        }
    }
</script>

<style>
    .VuePagination__count  {
        display: none!important;;
    }
</style>

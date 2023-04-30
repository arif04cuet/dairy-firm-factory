<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">আবেদনকৃত সমিতির তালিকাঃ</h5>
            </div>
        </div>

        <div class="card-body min75vh">
            <association-list
                type="chilling-manager-application-list"
            ></association-list>
        </div>
    </div>
</template>
<script>
    import list from '@/components/association/AssociationList.vue';
    export default {
        layout:'admin',
        name:'all',
        components : {
            'association-list':list
        },
        data(){
            return {
                kernel : {},
            }
        },
        mounted(){
            this.user = this.$store.state.auth.user;
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_association'){
                        //
                    }
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

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">প্রস্তাবিত প্রাথমিক দুগ্ধ উৎপাদনকারী সমিতির তালিকাঃ</h5>
                <div class="btn-group">
                    <nuxt-link to="/association/add" class="btn btn-primary" v-if="$ck_action('/association/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন সমিতি সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min65vh">
            <association-list
                type="verified-resolution-list"
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
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="m-0">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                <span>সমিতির নিবন্ধন</span>
            </h3>
        </div>

        <div class="card-body min65vh position-relative">
            <div class="custom-btn-group">
                <nuxt-link to="/association/application/form" class="btn btn-primary mt-2 text-left" v-if="$ck_action('/association/application/form')"><i class="fa fa-file-text-o" aria-hidden="true"></i> নতুন সমিতির জন্য আবেদন করুন</nuxt-link>
                <nuxt-link to="/association/application/list" class="btn btn-success mt-2 text-left" v-if="$ck_action('/association/application/list')"><i class="fa fa-list" aria-hidden="true"></i> আবেদনকৃত সমিতির তালিকা</nuxt-link>
                <nuxt-link to="/association/application/resolution-list" class="btn btn-success mt-2 text-left" v-if="$ck_action('/association/application/list')"><i class="fa fa-list" aria-hidden="true"></i> আবেদনকৃত সমিতির মিটিং রেজুলেশন</nuxt-link>
                <nuxt-link to="/association/applied/correction-list" class="btn btn-info mt-2 text-left" ><i class="fa fa-list" aria-hidden="true"></i> সংশোধনের জন্য প্রেরিত অবেদনসমূহ</nuxt-link>
                <nuxt-link to="/association/application/reject-list" class="btn btn-danger mt-2 text-left" ><i class="fa fa-list" aria-hidden="true"></i> বাতিলকৃত সমিতির অবেদনসমূহ</nuxt-link>
                <div class="alert alert-warning" v-if="!$ck_action('/association/application/form') && !$ck_action('/association/application/list')"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> আপনাকে কোনো একশনের অনুমতি দেয়া হয়নি</div>
            </div>
        </div>

        <!-- <div class="card-footer">&nbsp;</div> -->
    </div>
</template>

<script>
    export default {
        layout:'admin',
        name:'Index',
        data(){
            return {}
        },
        mounted(){
            console.log(this.$store.state.auth.user);
        }
    }
</script>

<style scoped>
    .custom-btn-group {
        display: grid;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -59%);
    }
</style>

<template>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="m-0"><i class="fa fa-user-plus" aria-hidden="true"></i> ব্যবহারকারীর বিবরণ দেখুন </h3>
        <div class="btn-group">
            <nuxt-link to="/user/access/all" class="btn btn-primary">
                <i class="fa fa-list"></i>
                তালিকায় ফিরে যান
            </nuxt-link>
        </div>
    </div>

    <view-details :view_id="$route.query.id"></view-details>
    <!-- // -->
    <div class="card-footer">&nbsp;</div>
</div>
</template>

<script>
import Details from '@/components/user/mk_access/Details';

    export default {
        layout:'admin',
        name:'AddAccess',
        components:{ 'view-details' : Details},
        data(){
            return {}
        },
        mounted(){},
        methods:{},
        watch:{}
    }
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
    .img-wrapper {
        width: 100%;
        overflow: hidden;
        box-sizing: border-box;
        padding: 7px;
        border:1px solid #ddd;
    }
    .img-wrapper img{
        width: 100%;
    }
    .choose {
        width: 100%;
        height: 30px;
        background: #ddd;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .choose input[type='file'], .choose span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        opacity: 0;
        cursor: pointer;
    }
    .choose span {
        z-index: 998;
        opacity: 1;
        border: 1px solid #ddd;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
</style>

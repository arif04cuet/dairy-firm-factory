<template>
    <div class="page-loader" v-if="loader" >
        <div>
            <i class="fa fa-spinner fa-spin fa-fw"></i>
            <span>Loading...</span>
        </div>
    </div>
</template>

<script>
    export default {
        props:['loader'],
        name: 'Loader',
    }
</script>

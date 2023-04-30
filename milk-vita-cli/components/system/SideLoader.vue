<template>
    <div class="loader" v-if="loading">
        <h1 class="brand">
            <img src="~/assets/images/milk-vita.png" alt="" height="100px">
            <!-- <span>Milk</span>
            <span>Vita</span> -->
        </h1>
        <div class="loading-bar"></div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: true
        }),
        methods: {
            start() {
                this.loading = true
            },
            finish() {
                this.loading = false
            }
        }
    }
</script>

<style scoped>
    div.loader {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: fixed;
        width: 100%;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 9999;
        background: rgb(255 255 255);
        box-sizing: border-box;
        user-select: none;
    }
    h1.brand {
        font-size: 40px;
    }
    h1.brand span:nth-child(1) {
        background-color: transparent;
        color: #0074b4;
    }
    h1.brand span:nth-child(2) {
        background-color: #0074b4;
        color: #f3f2ef;
        padding: 0px 6px;
        margin-left: -6px;
        border-radius: 2px;
    }
    div.loading-bar {
        width: 100px;
        height: 2px;
        background-color: #eceadf;
        border-radius: 10px;
        margin-top: 11px;
        overflow: hidden;
        position: relative;
    }
    div.loading-bar::after {
        content: '';
        width: 50px;
        height: 2px;
        position: absolute;
        background-color: #0074b4;
        transform: translateX(-20px);
        animation: loop 2s ease infinite;
    }
    @keyframes loop {
        0%,100% {
            transform: translateX(-28px);
        }
        50% {
            transform: translateX(78px)
        }
    }
</style>
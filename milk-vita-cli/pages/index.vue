<template>
    <div style="width:100%;min-height:60vh;display:flex;justify-content:center;align-items:center;">
        <div class="card text-center w100" style="padding:70px;background:#fff">
            <img src="~/assets/images/milk-vita.png" style="height:100px; width:fit-content; margin:auto;object-fit:contain;" alt="" />
            <h2 class="mt-5">ডিজিটাল দুগ্ধ সংগ্রহ ও বিতরণ ব্যবস্থাপনা সিস্টেম</h2>
            <h5 class="mt-3">বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড</h5>
            <nuxt-link to="/application/distributor">পরিবেশক আবেদন </nuxt-link>
            <nuxt-link to="/application/shop">শপের জন্য আবেদন </nuxt-link>
        </div>
    </div>
</template>

<script>
    export default {
        layout:'default',
    }
</script>

<template>
    <Application 
        type="distributor"
    />
</template>

<script>
    import Application from "@/components/fontend/application";
    export default {
        layout:'default',
        components:{Application},
        head:()=>({
			script: [
				{src: "http://127.0.0.1:8000/components/services/rdcd-application-control.js"},
			],
        }),
    }
</script>

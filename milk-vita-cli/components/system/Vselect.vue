<template>
    <select-picker />
</template>

<script>


import Vselect from 'vue-select';

export default {
    components:{'select-picker':Vselect},
    mounted(){
        console.log(Vselect);
    }
}
</script>

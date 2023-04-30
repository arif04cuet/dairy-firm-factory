<template>
    <select-picker
        :placeholder="is_loading ? 'লোডিং হচ্ছে...': 'লিঙ্গ নির্বাচন করুন'"
        :options="genders"
        label="display_value"
        v-model="gender_"
    />
</template>

<script>
    export default {
        props:['gender'],
        model:{
            prop  : 'gender',
            event : 'change'
        },
        data:()=>({
            genders  : [],
            gender_  : '',
            is_loading : true,
        }),
        mounted(){
            this.$axios.post('master-data/gender')
            .then(response=>{
                this.genders = response.data;
                //
                if(1+this.gender > 0) 
                    Object.values(this.genders).forEach(row=>{
                        if(this.gender==row.id)
                            this.gender_ = row;
                    });
                else 
                    this.gender_ = this.gender;
                this.is_loading = false;
            });
        },
        watch:{
            gender_(){
                this.$emit('change', this.gender_);
            }
        }

    }
</script>

<template>
    <div>
        <div class="details-wrapper">
            <div class="d-flex justify-content-between">
                <h5>প্রস্তাবিত সমিতির নামঃ {{association.association_name}}</h5>
                <button class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;প্রিন্ট করুন</button>
            </div>

            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table info">
                        <tr>
                            <td width="30%">২. প্রস্তাবিত সমিতির নামঃ</td>
                            <td>{{association.association_name}}</td>
                        </tr>

                        <tr>
                            <td>১. দুগ্ধ এলাকার নামঃ </td>
                            <td>{{association.name_of_dairy_area}} </td>
                        </tr>

                        <tr>
                            <td>৩. সমিতির কার্যকরী এলাকাঃ </td>
                            <td>{{association.working_area_of_association}}</td>
                        </tr>

                        <tr>
                            <td>৪. মোট সদস্য সংখ্যঃ</td>
                            <td>{{$en2bn(association.total_members)}} জন</td>
                        </tr>
                    </table>
                </div>


                <div class="status table-responsive">
                    <caption class="text-nowrap mb-0 pb-0">
                        <strong>সমিতির লগসম্মূহ</strong>
                    </caption>

                    <table class="table info">
                        <tr v-for="(row, index) in status" :key="index">
                            <td width="30%">
                                <span class="float-left">{{$en2bn(index+1)}}.&nbsp;</span>
                                <div style="display:grid">
                                    <span>{{row.status}}</span>
                                    <small class="ml-1">({{$en2bn(row.date)}})</small>
                                </div>
                            </td>
                            <td>{{row.remark}}</td>
                        </tr>
                    </table>
                </div>


                <div class="qck-btn-custom">
                    <button class="btn btn-light ml-2" @click="close">বাতিল করুন</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props:['association_id'],
    data(){
        return {
            association:{},
            status:[],
        }
    },
    model:{
        prop:'association_id',
        event:'change'
    },
    mounted(){
        this.$axios.post('association/list', {
            where:{
                id:this.association_id
            }
        })
        .then(res=>{
            this.association = res.data.data[0];
        });


        this.$axios.post('association/log/'+this.association_id)
        .then(res=>{
            this.status = res.data;
        });


    },
    methods:{
        close(){
            this.$emit('change', '');
        },
    }
}
</script>

<style scoped>
    .details-wrapper {
        padding: 30px;
    }
    .table.info tr td {
        padding: 4px 7px;
        font-size: 13px;
        vertical-align: middle;
    }
    .table.info tr td:first-child{
        background: #0f75bc;
        color: #fff
    }
    .table.info tr td:last-child{
        background: #ddd;
    }
    .table.info tr td {
        border: 1px solid #b1b1b1;
    }
    .qck-btn-custom {
        position: absolute;
        right: 15px;
        bottom: 15px;
    }
    .custom button {
        padding: 1px 8px!important;
        font-size: 11px!important;
        line-height: 21px;
    }
    .popup-inner-div {
        width: 100%;
        max-height: 90vh;
        display: block;
        overflow: auto;
    }
</style>

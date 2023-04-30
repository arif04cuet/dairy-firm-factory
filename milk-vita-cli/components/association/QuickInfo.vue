<template>
    <div>
        <edit-member
            v-if="member_id"
            v-model="member_id"
        >
        </edit-member>

        <div v-if="is_open">
           <add-member
                class="popup-inner-div"
                style="width:100%!important"
                :association_id = "association_id"
                v-model="is_open"
            ></add-member>
        </div>

        <div class="details-wrapper" v-if="!is_open && !member_id" >
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
                            <td>{{$en2bn(total_row)}} জন</td>
                        </tr>
                    </table>
                </div>

                <h6 class="mt-2 mb-2">৫. সকল সদস্যদের তালিকাঃ</h6>

                <div class="table-responsive mb-0">
                    <table class="table custom mb-2">
                        <thead>
                            <tr>
                                <th width="40">ক্রমিক</th>
                                <th class="text-center">সদস্যের নাম</th>
                                <th class="text-center">বয়স</th>
                                <th class="text-center">পিতার নাম</th>
                                <th class="text-center">গ্রাম</th>
                                <th class="text-center">গাভী</th>
                                <th class="text-center">বকনা</th>
                                <th class="text-center">বকন বাছুর</th>
                                <th class="text-center">এঁড়ে বাছুর</th>
                                <th class="text-center">ষাঁড়</th>
                                <th class="text-center">বলদ</th>
                                <th class="text-center">মহিষ</th>
                                <th class="text-center">গবাদি পশুর সংখ্যা</th>
                                <th class="text-center">অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(row, index) in members" :key="index">
                                <td>{{$en2bn(mkindex(index+1))}}</td>

                                <td class="text-center">{{row.member_name}}</td>
                                <td class="text-center">{{row.age}}</td>
                                <td class="text-center">{{row.father_name_bn}}</td>
                                <td class="text-center">{{row.village}}</td>
                                <td class="text-center">{{row.total_gavi}}</td>
                                <td class="text-center">{{row.total_bokna}}</td>
                                <td class="text-center">{{row.total_bokon_bachor}}</td>
                                <td class="text-center">{{row.total_are_bachor}}</td>
                                <td class="text-center">{{row.total_shar}}</td>
                                <td class="text-center">{{row.total_bolod}}</td>
                                <td class="text-center">{{row.total_mohish}}</td>

                                <td>{{row.total_cattle}}</td>
                                <td class="text-center">
                                    <div class="btn-group custom">
                                        <button @click="memberRedirect('/association/member/profile?id='+row.id)"  class="btn btn-success">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <button class="btn btn-primary" @click="editMember(row.id)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="(members).length <= 0">
                                <th colspan="14" class="text-center">কোনো সদস্য পাওয়া যায়নি</th>
                            </tr>
                        </tbody>
                    </table>
                    <pagination class="float-right mb-3" v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
                </div>

                <div class="qck-btn-custom">
                    <button class="btn btn-light text-success" @click="member_add" v-if="$ck_action('/association/add-member')">নতুন সদস্য যোগ করুন</button>
                    <button class="btn btn-danger ml-2" @click="close">বাতিল করুন</button>
                </div>
            </div>
        </div>
        <Loader :loader="loader" />
    </div>
</template>

<script>
    import EditMember from '@/components/association/EditMember.vue';
    import AddMember from '@/components/association/AddMember.vue';

    export default {
        name    : 'QuickInfo',
        model   : {
            prop  : 'association_id',
            event : 'change'
        },
        components : {
            'edit-member':EditMember,
            'add-member' :AddMember
        },
        props     :['association_id'],
        data(){
            return {
                is_open     : false,
                member_id   : false,
                loader      : true,
                kernel      : [],
                association : {},
                members     : [],
                total_row   : 0,
                per_page    : 8,
                page_no     : 1,
            }
        },
        mounted(){
            // FETCH AN ASSOCIATION INFO
            this.http('association/list', 'association', {
                where:{
                    id:this.association_id
                },
                select:[
                    'association_name',
                    'association_code',
                    'working_area_of_association',
                    'name_of_dairy_area'
                ]
            });

            // GET LIST OF MEMBERS OF THIS ASSOCIATION
            this.fetchData();
        },
        methods:{
            memberRedirect(path){
                this.$router.push({path:path});
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            member_add(){
                this.is_open = true;
            },
            editMember(member_id){
                this.member_id = member_id;
            },
            fetchData(){
                this.http('association/all-member', 'all_member', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : {
                        association_id:this.association_id
                    },
                });
            },
            close:function(){
                this.$emit('change', '');
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            member_id:function(){
                if(this.member_id==''){
                    this.fetchData();
                }
            },
            is_open:function(){
                if(this.member_id==''){
                    this.fetchData();
                }
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='association'){
                        this.association = this.kernel[key].data[0];
                    }
                    else if(key=='all_member'){
                        this.members    = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                        this.loader     = false;
                    }
                }
            }
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

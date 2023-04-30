<template>
<div class="card">
    <div class="card-header">
        <h3 class="m-0">যানবাহনের ধরণ</h3>
    </div>
        <div class="card-body min75vh">
            <form @submit.prevent="form.id ? update(form.id) : save()">
                <div class="row">
                    <div class="col-md-3 text-right">
                        <label for="" class="mt-1">যানবাহনের ধরণের নাম</label>
                    </div>
                    <div class="col-md-5">
                        <input vehicle_category="text" class="form-control" placeholder="যানবাহনের ধরণের নাম লিখুন" v-model="form.vehicle_category_name">
                    </div>
                    <div class="col-md-3">
                        <button vehicle_category="submit" class="btn btn-success">
                            <span v-if="form.id">হালনাগাদ করুন</span>
                            <span v-else >সংরক্ষণ করুন</span>
                        </button>
                    </div>
                </div>
            </form>
            <hr>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered custom">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">যানবাহনের ধরণের নাম</th>
                            <th width="10%" class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(vehicle_category, index) in vehicle_categories" :key="index">
                            <td class="text-center">{{++index}}</td>
                            <td class="text-left">{{vehicle_category.vehicle_category_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="edit(vehicle_category)">Edit</button>                                    
                                    <button
                                        class="btn btn-danger ml-2"
                                        v-if="$ck_action('/vehicle/category/delete')"
                                    >
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>                                    
                                </div>
                            </td>
                        </tr>
                        <tr v-if="vehicle_categories.length == 0">
                            <td colspan="3">কোন তথ্য পাওয়া যায়নি</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Loader :loader="loader" />
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        name:'VehicleCategory',
        data(){
            return {
                form:{
                    vehicle_category_name:'',
                    id:''
                },
                vehicle_categories:[],
                loader: true,
            }
        },
        mounted(){
            this.loader = true;
            this.$axios.post('vehicle/category')
            .then(res=>{
                this.vehicle_categories = res.data;
                this.loader = false;
            })
            .catch(err=>console.log(err));
        },
        methods:{
            save:function(){
                this.$axios.post('vehicle/category/add', this.form)
                .then(res=>{
                    this.vehicle_categories = res.data;
                    this.$router.push({path:'/vehicle/category'});
                })
                .catch(err=>console.log(err));
            },
            edit:function(vehicle_category){
                this.form = {
                    vehicle_category_name : vehicle_category.vehicle_category_name,
                    id : vehicle_category.id,
                };
            },
            update(id){
                this.$axios.post('vehicle/category/update/' + this.form.id, this.form)
                .then(res=>{
                    if(res.data.errors){
                        alert(res.data.errors[0]);
                    }
                    else {
                        this.vehicle_categories = res.data;
                        this.form = {
                            vehicle_category_name:'',
                            id:'',
                        };
                    }
                    
                })
                .catch(err=>console.log(err));
            }
        }
    }
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
</style>

<template>
<div class="card">
    <div class="card-header">
        <h3 class="m-0"> রাস্তার ধরন </h3>
    </div>
        <div class="card-body min75vh">
            <form @submit.prevent="form.type_id ? update(form.type_id) : save()">
                <div class="row">
                    <div class="col-md-2 text-right">
                        <label for="" class="mt-1">Road Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Enter Road Type Name" v-model="form.road_type_name">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">
                            <span v-if="form.type_id">Update</span>
                            <span v-else >Save</span>
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">SL</th>
                            <th class="text-left">Role</th>
                            <th width="70" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <!-- // -->
                    <tbody>
                        <tr v-for="(road, index) in road_types" :key="index" v-if="road.id!=form.type_id">
                            <td class="text-center">{{++index}}</td>
                            <td class="text-left">{{road.road_type_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-info" @click="edit(road)">Edit</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Loader />
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        name:'AdminRole',
        data(){
            return {
                form:{
                    road_type_name:'',
                    type_id:''
                },
                road_types:[]
            }
        },
        mounted(){
            this.$axios.post('road-type/all')
            .then(res=>{
                this.road_types = res.data;
                this.$store.commit('pageLoader', false);
            })
            .catch(err=>console.log(err));
        },
        methods:{
            save:function(){
                this.$axios.post('road-type/add', this.form)
                .then(res=>{
                    this.road_types = res.data;
                    this.form.road_type_name = '';
                })
                .catch(err=>console.log(err));
            },
            edit:function(road_type){
                this.form = {
                    road_type_name : road_type.road_type_name,
                    type_id : road_type.id,
                };
            },
            update(type_id){
                this.$axios.post('road-type/update', this.form)
                .then(res=>{
                    if(res.data.errors){
                        alert(res.data.errors[0]);
                    }
                    else {
                        this.road_types = res.data;
                        this.form = {
                            road_type_name:'',
                            type_id:'',
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

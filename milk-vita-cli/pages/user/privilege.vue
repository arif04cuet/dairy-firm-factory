<template>
    <div class="card">
        <div class="card-header">
            <h4 class="mt-1 m-0">
                <span><i class="fa fa-shield" aria-hidden="true"></i></span>&nbsp;
                পারমিশন
            </h4>
        </div>
        <div class="card-body min75vh">
            <div class="row">
                
                <div class="col-md-3 form-group">
                    <select id="" class="form-control" v-model="entity_id" required>
                        <option value="0">এনটিটি নির্বাচন করুন </option>
                        <option v-for="(row, index) in parent_entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                    </select>
                </div>
                
                <div class="col-md-4 form-group" v-if="(child_entities).length">
                    <select id="" class="form-control" v-model="child_entity_id" required>
                        <option value="0">চাইল্ড এনটিটি নির্বাচন করুন </option>
                        <option v-for="(row, index) in child_entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <select class="form-control" v-model="role_id" @change="fetchPrivilege">
                        <option value="">রোল নির্বাচন করুন</option>
                        
                        <option v-for="(role, index) in roles" :key="index" :value="role.id" >{{role.role_name}}</option>
                        <!-- <option v-for="(role, index) in roles" :key="index" :value="role.id"  :disabled="(entity_id==0 && (role.role_name ? role.role_name : '').toLocaleLowerCase() == 'superadmin')"  >{{role.role_name}}</option> -->
                    </select>
                </div>

                <div class="col-md-2">
                   <button class="btn btn-success text-nowrap" @click="update">আপডেট করুন</button>
                </div>

            </div>

            <hr class="mt-0">

            <div id="accordion" v-if="menus">
                <div class="card" v-for="(menu, index) in menus" :key="index">
                    <div class="card-header" :id="'#collapse'+index">
                        <h5 class="mb-0">
                            <input type="checkbox" class="float-left" style="margin-top:13px"  :id="index" @click="AssignMenuToggle(menu.id, 'menu')" :checked="permited_menu.indexOf(menu.id) > -1">
                            <button class="btn btn-link custom-collapse-button" data-toggle="collapse" :data-target="'#collapse'+index" :aria-expanded="(index==0 ? true : false)" :aria-controls="'collapse'+index">
                            {{menu.name_bn}}
                            <i class="fa fa-angle-down" v-if="(menu.action_menu).length > 0"></i>
                            </button>
                        </h5>
                    </div>

                    <div v-if="(menu.action_menu).length > 0" :id="'collapse'+index" class="collapse" :class="(index==0 ? 'show':'')" :aria-labelledby="'heading'+index" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                                <li v-for="(action_menu, index2) in menu.action_menu" :key="index2" :title="action_menu.url">
                                    <label :for="index+'of'+index2">
                                        <input type="checkbox" :id="index+'of'+index2" @click="AssignMenuToggle(action_menu.id, 'action')" :checked="permited_a_menu.indexOf(action_menu.id) > -1">
                                        <span>{{action_menu.name_bn}}</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <loader :loader="loader" />
        </div>
    </div>
</template>
<script>
import Loader from '~/components/Loader.vue';
    export default {
  components: { Loader },
        layout:'admin',
        name:'Privilege',
        data(){
            return {
                kernel      : {},
                menus       : [],
                roles       : [],

                parent_entities  : [],
                child_entities   : [],
                entity_id        : '0',
                child_entity_id  : '0',

                permited_menu   : [],
                permited_a_menu : [],
                role_id         : '',
                loader          : true,
            }
        },
        mounted(){
            this.parentEntity();
            this.getRole();
            // this.menus = this.$store.state.auth.user.privilege;
            this.http('menu/list', 'all-menu', {});
        },
        methods:{
            parentEntity(){
                this.http('entity/all', 'all_parent_entities', {
                    where:{
                        parent_id : '0',
                    }
                });
            },
            childrenEntity(){
                this.http('entity/all', 'all_child_entities', {
                    where:{
                        parent_id : (this.entity_id != '0' ? this.entity_id : '-1'),
                    }
                });
            },
            fetchPrivilege(){
                this.clearPrivilege();
                if(this.role_id){
                    this.http('privilege/get', 'getPrivilege', {where:{role_id:this.role_id}});
                }
            },
            update(){
                if(this.role_id){
                    this.http('privilege/update', 'update', {
                        role_id      : this.role_id,
                        menus        : this.permited_menu,
                        action_menus : this.permited_a_menu
                    });
                }
                else {
                    this.$toastr.w("রোল নির্বাচন করে চেষ্টা করুন");
                }
            },
            AssignMenuToggle(id, type){
                if(type=='menu'){
                    var available_index = (this.permited_menu).indexOf(id);
                    if(available_index > -1){
                        this.$delete(this.permited_menu, available_index);

                        (this.menus).forEach(menu=>{
                            if(menu.id==id){
                               (menu.action_menu).forEach(action_menu=>{
                                    available_index = (this.permited_a_menu).indexOf(action_menu.id);
                                    if(available_index > -1){
                                        this.$delete(this.permited_a_menu, available_index);
                                    }
                               }) 
                            }
                        });
                    }
                    else { 
                        (this.permited_menu).push(id); 
                        (this.menus).forEach(menu=>{
                            if(menu.id==id){
                               (menu.action_menu).forEach(action_menu=>{
                                    var available_index = (this.permited_a_menu).indexOf(action_menu.id);
                                    if(available_index > -1){
                                        this.$delete(this.permited_a_menu, available_index);
                                    }
                                    (this.permited_a_menu).push(action_menu.id);
                               }) 
                            }
                        });
                    }
                }
                else {
                    var available_index = (this.permited_a_menu).indexOf(id);
                    if(available_index > -1){
                        this.$delete(this.permited_a_menu, available_index);
                    }
                    else { (this.permited_a_menu).push(id); }
                }
            },
            clearPrivilege(){
                this.permited_menu   = [];
                this.permited_a_menu = [];
            },
            getRole(){
                this.role_id = '';
                this.clearPrivilege();
                this.http('role/all', 'get_roles', {
                        where:{
                            entity_id  : (this.child_entity_id == '0' ? this.entity_id : this.child_entity_id),
                            
                        }
                    }
                );
            },
            http(url, type, data=[]){
                this.$axios.post(url, data)
                .then(res=>{ this.kernel = Object.assign({}, {[type] : res.data});});
            }
        },
        watch:{
            entity_id:function(){
                this.child_entities  = [],
                this.child_entity_id = '0';
                this.roles           = [],
                this.role_id         = '0';
            // --------------------------- //
                this.getRole();
                this.childrenEntity();
            },
            child_entity_id:function(){
                this.getRole();
            },
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='update'){
                        this.$toastr.s('পারমিশন সফলভাবে সংরক্ষণ করা হয়েছে৷');
                    }
                    else if(key=='all-menu'){
                        this.menus = this.kernel[key].data;
                        this.loader = false;
                    }
                    else if(key=='get_roles'){
                        this.roles = this.kernel[key].data;
                    }
                    else if(key=='getPrivilege')
                    {
                        console.log(this.kernel['getPrivilege']);
                        this.permited_menu   = this.kernel[key].menus ? this.kernel[key].menus : [];
                        this.permited_a_menu = this.kernel[key].action_menus ? this.kernel[key].action_menus : [];
                    }
                    else if(key=='all_parent_entities'){
                        this.parent_entities = this.kernel[key].data;
                    }
                    else if(key=='all_child_entities'){
                        this.child_entities = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    ul {
        list-style: none;
        margin: none;
        padding: 0;
    }
    ul li {
        user-select: none;
        padding: 4px;
        padding-left: 20px;
        border-left: 1px solid #ddd;
    }
    ul li label {
        margin: 0;
        position: relative;
    }
    ul li > label:before {
        content: '';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: -20px;
        width: 17px;
        border: 1px solid #ddd;
    }
    .custom-collapse-button {
        outline: none;
        box-shadow: none;
        text-align: left; 
        display: flex; 
        justify-content: space-between; 
        width:95%;

    } 
</style>

<template>
    <div ref="slot">
        <slot></slot>
        <!-- // -->
        <div style="display:none!important" >
            <!-- // -->
            <select ref="location_head" v-model="type_id_own" @change="$emit('locations', {'type_id':type_id_own})" class="form-control">
                <option value="defs">লোকেশন টাইপ নির্বাচন করুন</option>
                <option v-for="(row, index) in parents" :key="index" :value="(index)" >{{row}}</option>
            </select>

            <!-- // -->
            <div ref="node_division">
                <select-picker
                    :options="divisions"
                    v-model="division_id"
                    :reduce="row=>row.id"
                    label="name"
                    @input="onChangeDivision(division_id)"
                />
            </div>

            <!-- // -->
            <div ref="node_district">
                <select-picker
                    :options="districts"
                    v-model="district_id"
                    :reduce="row=>row.id"
                    label="name"
                    @input="onChangeDistrict(district_id)"
                />
            </div>

            <!-- // -->
            <div ref="node_upazila">
                <select-picker
                    :options="upazilas"
                    v-model="upazila_id"
                    :reduce="row=>row.id"
                    label="name"
                    @input="onChangeUpazila(upazila_id)"
                />
            </div>

            <!-- // -->
            <div ref="node_union">
                <select-picker
                    :options="unions"
                    v-model="union_id"
                    :reduce="row=>row.id"
                    label="name"
                    @input="onChangeUnion(union_id)"
                />
            </div>


            <!-- 
                <select ref="node_division" v-model="division_id" class="form-control" @change="onChangeDivision(division_id)">
                    <option value="defs">বিভাগ নির্বাচন করুন</option>
                    <option v-for="(row, index) in divisions" :key="index" :value="(row.id)" >{{row.name.bn}}</option>
                </select> 
            -->
            
            <!-- 
            <select ref="node_district" v-model="district_id" class="form-control" @change="onChangeDistrict(district_id)">
                <option value="defs">জেলা নির্বাচন করুন</option>
                <option v-for="(row, index) in districts" :key="index" :value="(row.id)" >{{row.name.bn}}</option>
            </select> 
            -->
            
            <!-- <select ref="node_upazila" v-model="upazila_id" class="form-control" @change="onChangeUpazila(upazila_id)">
                <option value="defs">উপজেলা নির্বাচন করুন</option>
                <option v-for="(row, index) in upazilas" :key="index" :value="(row.id)" >{{row.name.bn}}</option>
            </select> -->
            
            <!-- <select ref="node_union" v-model="union_id" class="form-control" @change="onChangeUnion(union_id)">
                <option value="defs">ইউনিয়ন নির্বাচন করুন</option>
                <option v-for="(row, index) in unions" :key="index" :value="(row.id)" >{{row.name.bn}}</option>
            </select> -->
        </div>
    </div>
</template>

<script>
    export default {
        name:"",
        props:['location_data'],
        model:{
            prop:'location_data',
            event:'locations'
        },
        data(){
            return {
                kernel   : [],
                parents  : [],
                children : [],
                // 
                divisions : [],
                districts : [],
                upazilas  : [],
                unions    : [],
                // 
                type_id_own : '',
                division_id : 'defs',
                district_id : 'defs',
                upazila_id  : 'defs',
                union_id    : 'defs',
                data        : {},
            }
        },
        mounted(){
            //
            this.divisions = [{id:"defs", name:"লোডিং হচ্ছে..."}];
            this.districts = [{id:"defs", name:"জেলা নির্বাচন করুন"}];
            this.upazilas  = [{id:"defs", name:"উপজেলা নির্বাচন করুন"}];
            this.unions    = [{id:"defs", name:"ইউনিয়ন নির্বাচন করুন"}];
            //
            var contents           = this.$refs.slot, 
                location_head_node = this.$refs.location_head,
                slot_location_head = contents.querySelector('[data-location_types]'),
                //
                node_division      = this.$refs.node_division,
                slot_division      = contents.querySelector('[data-division]'),
                //
                node_district      = this.$refs.node_district,
                slot_district      = contents.querySelector('[data-district]'),
                //
                node_upazila       = this.$refs.node_upazila,
                slot_upazila       = contents.querySelector('[data-upazila]'),
                //
                node_union         = this.$refs.node_union,
                slot_union         = contents.querySelector('[data-union]');
            //
            if(slot_location_head){
                slot_location_head.prepend(location_head_node);
                this.http('location', 'locations');
            };
            //
            if(slot_division){
                slot_division.prepend(node_division);
                this.http('location', 'divisions', {
                    type_id:1
                });
            }
            //
            if(slot_district)
                slot_district.prepend(node_district);
            if(slot_upazila)
                slot_upazila.prepend(node_upazila);
            if(slot_union)
                slot_union.prepend(node_union);
            //
            if(this.location_data){
                var group_id = Object.assign({}, this.location_data);
                //
                if(group_id.division_id){
                    this.division_id = group_id.division_id;
                    this.getDistrict();
                }
                //
                if(group_id.district_id){
                    this.district_id = group_id.district_id;
                    this.getUpazila();
                }
                //
                if(group_id.upazila_id){
                    this.upazila_id = group_id.upazila_id;
                    this.getUnion();
                }
                //
                if(group_id.union_id){
                    this.union_id = group_id.union_id;
                }
            }
        },
        methods:{
            onChangeDivision(division_id)
            {
                if(division_id){
                    this.district_id = 'defs';
                    this.districts   = [{id:"defs", name:"জেলা নির্বাচন করুন"}];
                    //
                    this.upazila_id  = 'defs';
                    this.upazilas    = [{id:"defs", name:"উপজেলা নির্বাচন করুন"}];
                    //
                    this.union_id    = 'defs';
                    this.unions      = [{id:"defs", name:"ইউনিয়ন নির্বাচন করুন"}];
                    //
                    this.getDistrict();
                    this.setLocationsId();
                }
            },
            onChangeDistrict(district_id)
            {
                if(district_id){
                    //
                    this.upazila_id = 'defs';
                    this.upazilas   = [{id:"defs", name:"উপজেলা নির্বাচন করুন"}];
                    //
                    this.union_id = 'defs';
                    this.unions   = [{id:"defs", name:"ইউনিয়ন নির্বাচন করুন"}];
                    //
                    this.getUpazila();
                    this.setLocationsId();
                }
            },
            onChangeUpazila(upazila_id)
            {
                if(upazila_id){
                    //
                    this.union_id  = 'defs';
                    this.unions    = [{id:"defs", name:"ইউনিয়ন নির্বাচন করুন"}];
                    //
                    this.getUnion();
                    this.setLocationsId();
                }
            },
            onChangeUnion(union_id){
                this.setLocationsId();
            },
            getDistrict(){
                if(this.division_id!='defs'){
                    this.districts = [{id:"defs", name:"লোডিং হচ্ছে..."}];
                    this.http('location', 'districts', {
                        type_child_id:this.division_id
                    });
                }
                else 
                    this.districts = [{id:"defs", name:"কোনো জেলা পাওয়া যায়নি"}];
            },
            getUpazila(){
                if(this.district_id!='defs'){
                    this.upazilas = [{id:"defs", name:"লোডিং হচ্ছে..."}];
                    this.http('location', 'upazilas', {
                        type_child_id:this.district_id
                    });
                }
                else 
                    this.upazilas = [{id:"defs", name:"কোনো উপজেলা পাওয়া যায়নি"}];
            },
            getUnion(){
                if(this.upazila_id!='defs'){
                    this.unions = [{id:"defs", name:"লোডিং হচ্ছে..."}];
                    this.http('location', 'unions', {
                        type_child_id:this.upazila_id
                    });
                }
                else 
                    this.unions = [{id:"defs", name:"কোনো ইউনিয়ন পাওয়া যায়নি"}];
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            setLocationsId(){
                 this.$emit('locations', {
                    division_id : (this.division_id!='defs' ? this.division_id : ''),
                    district_id : (this.district_id!='defs' ? this.district_id : ''),
                    upazila_id  : (this.upazila_id!='defs' ? this.upazila_id : ''),
                    union_id    : (this.union_id!='defs' ? this.union_id : ''),
                });
            }
        },
        watch:{
            division_id(){
                if(this.division_id==null) this.division_id = 'defs'
                // else this.onChangeDivision(this.division_id);
            },
            district_id(){
                if(this.district_id==null) this.district_id = 'defs';
                // else this.onChangeDistrict(this.district_id)
            },
            upazila_id(){
                if(this.upazila_id==null) this.upazila_id = 'defs';
                // else this.onChangeUpazila(this.upazila_id)
            },
            union_id(){
                if(this.union_id==null) this.union_id = 'defs';
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='locations'){
                        this.parents = this.kernel[key];
                    }
                    else if(key=='divisions'){
                        if(this.kernel[key].message){
                            this.divisions = [{id:'defs', name:{bn:'কোনো বিভাগ পাওয়া যায়নি'}}];
                        }
                        else {
                            (this.kernel[key]).unshift({id:'defs', name:{bn:'বিভাগ নির্বাচন করুন'}});
                            this.divisions = (this.kernel[key]).map(row=>{row.name = row.name.bn; return row});
                        }
                    }
                    else if(key=='districts'){
                        if(this.kernel[key].message){
                            this.districts = [{id:'defs', name:'কোনো জেলা পাওয়া যায়নি'}];
                        }
                        else {
                            (this.kernel[key]).unshift({id:'defs', name:{bn:'জেলা নির্বাচন করুন'}});
                            this.districts = (this.kernel[key]).map(row=>{row.name = row.name.bn; return row});
                        }
                    }
                    else if(key=='upazilas'){
                        if(this.kernel[key].message){
                            this.districts = [{id:'defs', name:'কোনো উপজেলা পাওয়া যায়নি'}];
                        }
                        else {
                            (this.kernel[key]).unshift({id:'defs', name:{bn:'উপজেলা নির্বাচন করুন'}});
                            this.upazilas = (this.kernel[key]).map(row=>{row.name = row.name.bn; return row})
                        }
                    }
                    else if(key=='unions'){
                        if(this.kernel[key].message){
                            this.districts = [{id:'defs', name:'কোনো ইউনিয়ন পাওয়া যায়নি'}];
                        }
                        else {
                            (this.kernel[key]).unshift({id:'defs', name:{bn:'ইউনিয়ন নির্বাচন করুন'}});
                            this.unions = (this.kernel[key]).map(row=>{row.name = row.name.bn; return row})
                        }
                    }
                }
            },
        }
    }
</script>

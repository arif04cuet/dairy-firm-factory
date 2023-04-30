<template>
    <div ref="slot">
        <slot></slot>
        <!-- // -->
        <div style="display:none!important">
            <div ref="category" id="parent_category">
                <select-picker 
                    @input="onChangeCategory('selector')"
                    v-model="par_cat_id"
                    placeholder="ক্যাটাগরি নির্বাচন করুন"
                    :options="parents"
                    :reduce="row=>((slug && (slug!='' || slug!=0)) ? row.slug : row.id)"
                    label="category_name"
                />
            </div>
            <!-- // -->
            <div ref="sub_category" id="parent_category">
                <select-picker 
                    @input="onChangeSubCategory()"
                    v-model="sub_cat_id"
                    :placeholder="(is_submit ? 'সাব-ক্যাটাগরি লোড হচ্ছে...' : 'সাব-ক্যাটাগরি নির্বাচন করুন')"
                    :options="children"
                    :reduce="row=>((slug && (slug!='' || slug!=0)) ? row.slug : row.id)"
                    label="category_name"
                />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:"",
        props:['category_id', 'slug'],
        model:{
            prop:'category_id',
            event:'category'
        },
        data(){
            return {
                kernel   : [],
                parents  : [],
                children : [],
                par_cat_id : '',
                sub_cat_id : '',
                is_submit  : false,
            }
        },
        mounted(){
            //
            var contents            = this.$refs.slot, 
                category_node       = this.$refs.category,
                sub_category_node   = this.$refs.sub_category,
                slot_category       = contents.querySelector('[data-category]'),
                slot_sub_category   = contents.querySelector('[data-sub_category]'),
                slot_sub_par        = contents.querySelector('[data-sub_category_parent_element]');
            //
            if(slot_category) slot_category.append(category_node);
            if(slot_category) slot_category.append(category_node);
            if(slot_sub_category) slot_sub_category.append(sub_category_node);
            if(slot_sub_par) slot_sub_par.style.display = 'none';
            /*
             ----------------------------
              GET PARANT CATEGORIES
             -------------------------
            */
            this.checkPropsCat();
            //
            this.http('product/category/list', 'parents', {
                where:{parent_id:'0'}
            });
        },
        methods:{
            checkPropsCat(){
                if(this.category_id > 0){
                    this.http('product/category/list', 'check-props-cat', {
                        where:{id:this.category_id}
                    });
                }
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            emit(){
                this.$emit('category', (this.sub_cat_id != '' ? this.sub_cat_id : this.par_cat_id));
            },
            onChangeCategory(niddle=''){
                this.children   = [];
                //
                if(niddle=='selector') this.sub_cat_id = '';
                this.emit();
                //
                var contents  = this.$refs.slot, 
                slot_sub_par  = contents.querySelector('[data-sub_category_parent_element]');
                if(slot_sub_par) slot_sub_par.style.display = 'none';
                //
                if(this.par_cat_id){
                    this.is_submit = true;
                    this.http('product/category/list', 'children', {
                        where:{parent_id:this.par_cat_id}
                    });
                }
            },
            onChangeSubCategory(){
                this.emit();
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='parents'){
                        this.parents = this.kernel[key].data;
                    }
                    else if(key=='check-props-cat' && (this.kernel[key].data).length > 0){
                        if(this.kernel[key].data[0].parent_id==0)
                            this.par_cat_id = this.category_id;
                        else {
                            this.par_cat_id = this.kernel[key].data[0].parent_id;
                            this.sub_cat_id = this.category_id;
                            this.onChangeCategory();
                        }
                    }
                    else if(key=='children'){
                        this.children = this.kernel[key].data;
                        
                        /*
                         -----------------------------
                          SUB CATEGORIES OPARATIONS
                         -----------------------------
                        */
                        setTimeout(()=>{
                            var contents  = this.$refs.slot, 
                            category_node = this.$refs.sub_category,
                            sub_category  = contents.querySelector('[data-sub_category]'),
                            slot_sub_par  = contents.querySelector('[data-sub_category_parent_element]');
                            //
                            if(sub_category) sub_category.innerHTML = '';
                            //
                            if(sub_category && category_node){sub_category.append(category_node);} 
                            if((this.children.length > 0) && slot_sub_par) slot_sub_par.style.display = '';
                            this.is_submit = false;
                        }, 1);
                    }
                }
            },
            // category_id(){
            //     this.checkPropsCat();
            // }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2"><i class="fa fa-hashtag" aria-hidden="true"></i>&nbsp;নতুন মেনু তৈরী করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/dev/menu/list" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()">

                <div class="row form-group">
                    <label for="menu_name_bn" class="col-md-4 text-md-right mt-2">পেরেন্ট মেনু</label>
                    <div class="col-md-6">
                        <select-picker 
                            placeholder="পেরেন্ট মেনু নির্বাচন করুন"
                            :options="menus"
                            v-model="form.parent_id"
                            :reduce="row=>row.id"
                            label="name_bn"
                        />
                    </div>
                </div>

                <div class="row form-group">
                    <label for="menu_name_bn" class="col-md-4 text-md-right mt-2">মেনুর নাম লিখুন (বংলায়)</label>
                    <div class="col-md-6">
                        <input type="text" v-model="form.name_bn" id="menu_name_bn" class="form-control" placeholder="মেনুর নাম লিখুন (বংলায়)" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="menu_name_en" class="col-md-4 text-md-right mt-2">মেনুর নাম লিখুন (ইংলিশে)</label>
                    <div class="col-md-6">
                        <input type="text" v-model="form.name_en" id="menu_name_en" class="form-control" placeholder="মেনুর নাম লিখুন (ইংলিশে)" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="path" class="col-md-4 text-md-right mt-2">মেনুর ইউ.আর.এল </label>
                    <div class="col-md-6">
                        <input type="text" v-model="form.url" id="url" class="form-control" placeholder="মেনুর ইউ.আর.এল" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="icon" class="col-md-4 text-md-right mt-2">আইকন নির্বাচন করুন</label>
                    <div class="col-md-6">
                        <input type="file" @change="onChangIcon" id="icon" ref="icon" class="form-control p-1" placeholder="fa fa-pencil" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <img ref="icon" style="height:70px; width: 70px; object-fit:cover;float:right" />
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success float-right">সেইভ করুন</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        components : {},
        data(){
            return {
                kernel : {},
                menus  : [],
                form   : {
                    parent_id : ""
                },
            }
        },
        mounted(){
            this.http('menu/list', 'menus', {
                where : {
                    parent_id:'0'
                }
            });
        },
        methods:{
            onChangIcon(event)
            {
                this.$refs.icon.src = '';
                this.form.icon      = '';

                //
                var file = event.target.files[0];
                if(file){
                    const reader = new FileReader();
                    reader.addEventListener('load', (event) => {
                        this.form.icon  = event.target.result;
                        this.$refs.icon.src = event.target.result;
                    });
                    reader.readAsDataURL(file);
                }
            },
            submit(){
                this.http('menu/store', 'store', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='menus'){
                        this.menus = this.kernel[key].data;
                    }
                    else if(key=='store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('মেনুটি সফলভাবে সংরক্ষণ করা হয়েছে');
                            this.$router.push({path:'/dev/menu/list'});
                        }
                    }
                }
            }
        }
    }
</script>

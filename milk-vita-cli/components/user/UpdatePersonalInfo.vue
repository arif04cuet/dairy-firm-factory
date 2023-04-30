<template>
<form action="" @submit.prevent="submit">
    <div class="card-log p-4">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="">নাম *</label>
                <input type="text" v-model="form.name_bn" class="form-control" placeholder="আপনার নাম লিখুন" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="">নাম ( ইংরেজী )</label>
                <input type="text" v-model="form.name_en" class="form-control" placeholder="আপনার নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">মোবাইল *</label>
                <input type="text" v-model="form.mobile" class="form-control" placeholder="আপনার মোবাইল নাম্বার লিখুন" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="">ই-মেইল</label>
                <input type="email" v-model="form.email" class="form-control" placeholder="আপনার ই-মেইল এড্রেস লিখুন">
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-6 form-group">
                <label for="">পিতার নাম</label>
                <input type="text" v-model="form.fathers_name_bn" class="form-control" placeholder="আপনার পিতার নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">পিতার নাম (ইংরেজি)</label>
                <input type="text" v-model="form.fathers_name_en" class="form-control" placeholder="আপনার পিতার নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">মাতার নাম</label>
                <input type="text" v-model="form.mothers_name_bn" class="form-control" placeholder="আপনার মাতার নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">মাতার নাম (ইংরেজি)</label>
                <input type="text" v-model="form.mothers_name_en" class="form-control" placeholder="আপনার মাতার নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">স্বামী/স্ত্রীর নাম</label>
                <input type="text" v-model="form.husband_or_wife_name_bn" class="form-control" placeholder="স্বামী/স্ত্রীর নাম লিখুন">
            </div>

            <div class="col-md-6 form-group">
                <label for="">স্বামী/স্ত্রীর নাম(ইংরেজি)</label>
                <input type="text" v-model="form.husband_or_wife_name_en" class="form-control" placeholder="স্বামী/স্ত্রীর নাম লিখুন">
            </div>

            <div class="col-md-4 form-group">
                <label for="">জন্ম তারিখ *</label>
                <input type="text" v-model="form.date_of_birth" class="form-control" readonly>
            </div>

            <div class="col-md-2 form-group">
                <label for="">ধর্ম </label>
                <input type="text" v-model="form.religion" class="form-control" readonly>
            </div>

            <div class="col-md-2 form-group">
                <label for="">লিঙ্গ </label>
                <input type="text" v-model="form.sex" class="form-control" readonly>
            </div>

            <div class="col-md-4 form-group">
                <label for="">জাতীয় পরিচয়পত্র নম্বর (ইংরেজি) </label>
                <input type="text" v-model="form.nid_no" class="form-control" readonly>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <label class="signature-file form-control">
                    <span>Choose your Signature Picture</span>
                    <input type="file" ref="signature_file" @change="onChangeFile">
                </label>
            </div>
            <div class="col-md-6">
                <img :src="host_path+form.signature_path" alt="" ref="signature_pic" height="40">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;
                    পরিবর্তন করুন
                </button>
            </div>
        </div>
    </div>
</form>
</template>

<script>
    export default {
        data(){
            return {
                form:{
                    name_bn:'',
                },
                host_path:'',
            }
        },
        mounted(){
            this.form = Object.assign({}, this.$store.state.auth.user);
            this.host_path = this.$store.state.host_server;
        },
        methods:{
            submit(){
                this.$axios.post('user/update/'+this.form.id, this.form)
                .then(res=>{
                    if(res.data.errors){
                        this.$alert({
                            icon:'error',
                            text:res.data.errors,
                            confirmButtonText: 'বাতিল',
                        });
                    }
                    else {
                        this.$toastr.s('সফলভাবে আপনার প্রোফাইল আপডেট করা হয়েছে');
                        this.$auth.$storage.setUniversal('user', res.data, true);
                    }
                })
                .catch(err=>console(err));
            },
            onChangeFile(event){
                var file = event.target.files[0];
                if(file){
                    const reader = new FileReader();
                    reader.addEventListener('load', (event) => {
                        this.$refs.signature_pic.src = event.target.result;
                        this.form.signature = event.target.result;
                    });
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>

<style scoped>
    .signature-file {
        position: relative;
    }
    .signature-file span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #e9ecef;
        z-index: 1;
        text-align: center;
    }
    .signature-file input[type=file] {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
        opacity: 0;
        cursor: pointer;
    }
</style>

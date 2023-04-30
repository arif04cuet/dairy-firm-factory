<template>
<form action="" @submit.prevent="submit">
    <div class="card-log p-4">
        <div class="row form-group">
            <label for="" class="col-md-3 text-right pt-1">পুরানো পাসওয়ার্ড</label>
            <div class="col-md-8">
                <input type="password" v-model="form.old_password" class="form-control" placeholder="আপনার পুরানো পাসওয়ার্ড লিখুন" required>
            </div>
        </div>

        <div class="row form-group">
            <label for="" class="col-md-3 text-right pt-1">নতুন পাসওয়ার্ড</label>
            <div class="col-md-8">
                <input type="password" v-model="form.password" class="form-control" placeholder="আপনার নতুন পাসওয়ার্ড লিখুন" required>
            </div>
        </div>

        <div class="row form-group">
            <label for="" class="col-md-3 text-right pt-1">নতুন পাসওয়ার্ড</label>
            <div class="col-md-8">
                <input type="password" v-model="form.password_confirmation" class="form-control" placeholder="আবার পাসওয়ার্ড লিখন" required>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-11 text-right">
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
                    old_password:'',
                    password:'',
                    password_confirmation:''
                },
            }
        },
        methods:{
            submit(){
                if(this.form.password === this.form.password_confirmation){
                    this.$axios.post('user/forgot-password', this.form)
                    .then(res=>{
                        if(res.data.errors){
                            this.$alert({
                                icon:'error',
                                text:res.data.errors,
                                confirmButtonText: 'বাতিল',
                            });
                        }
                        else {
                            this.$toastr.s('সফলভাবে আপনার পাসওয়ার্ড পরিবর্তন হয়েছে');
                            this.form = {
                                old_password:'',
                                password:'',
                                password_confirmation:''
                            }
                        }
                    })
                    .catch(err=>console.log(err));
                }
                else {
                    this.$alert({
                        icon:'info',
                        text:'আপনার দিয়া নতুন পাসওয়ার্ড গুলো মিলেনি!',
                        confirmButtonText: 'বাতিল',
                    });
                }
            }
        }
    }
</script>

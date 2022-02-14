<template>
<div :style="opacity">
    <AdminHeader>
<div class="container-fluid mt-2 p-0">
    <div class="row">
      <div class="col-md-12 mb-1">
        <section v-if="alert!=''">
      <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
      </section>
       </div>
</div>
    <section v-if="isToken">
<div class="row d-flex justify-content-center p-0">
    <div class="col-md-12 ps-0 m-2 mt-2">
    <h5 class="text-primary mb-2 ps-2"> Item Category </h5>
                  <form @submit.prevent="formCheck">
                      <input type="hidden" class="d-none" v-model="token" required readonly>
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"></legend>
            <div class="row">
            <div class="col-md-4">
                <div class="m-1">
                <div class="input-group">
                    <span class="input-group-text">Name</span>
                    <input type="text" v-model="category_name" class="form-control" placeholder="Name your category" required>
                </div>
                </div>
            </div>

         <div class="col-md-6">
                <div class="m-1">
                <div class="input-group">
                    <span class="input-group-text">Description</span>
                    <input type="text" v-model="description" class="form-control" placeholder="Description (Optional)">
                </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="m-1">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" title="Preview" role="group" aria-label="First group">
                <button type="submit" class="btn btn-outline-primary" :disabled="isDisabled">{{submit}}</button>
                </div>
                </div>
                </div>
            </div>
                </div>
                </fieldset>
            </form>
        
    </div>
</div>

</section>
<section v-else>
<div class="row mt-5">
  <div class="col-md-6 m-auto">
    <div class="card">
  <div class="card-header text-dark">
    Authentication
  </div>
  <div class="card-body">
    <p :class="'card-text '+ validationClass">{{validationMsg}}</p>
    <a @click="$router.go(0)" :class="'btn btn-primary float-end '+tryAgain">Try again</a>
  </div>
</div>
  </div>
</div>
</section>
</div>
  </AdminHeader>
</div>

</template>
<style>

</style>
<script>
import axios from 'axios'
export default {
    data (){
        return{
        formSuccess: 0,
        auth_check: false,
        usersession: '',
        token: '',
        isToken: false,
        tryAgain: 'd-none',
        validationClass: 'text-primary',
        validationMsg: 'Please wait while validating and redirecting to the requested page...',
        alert: '',
        alertmodal: '',
        error: '',
        info: [],
        checked: true,
        category_name: '',
        description: '',
        loader: false,
        selectDefault:"Select",
        classname: 'alert-danger',
        submit: 'Create',
        submittxt:'Create',
        isDisabled: false,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        form_error: '',
        errormodal: '',
        record:false,
        norecord: '',
        toggle:'',
        }
        },

    created(){
    this.tokenize()
    this.usersession = this.$session.get('usersession')
    }, 

    methods:{
   tokenize: function(){
        this.$Progress.start()
    axios.get(process.env.VUE_APP_API+'/auth/token/tokenize/',{
    params:{
      'token': Math.random(9, 9999)
    }
  }).then(response => {
      if(response.data.status==response.data.statusmsg){
      this.token=response.data.key
      this.isToken=true
      this.tryAgain='d-none'
      axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.key;
      this.$Progress.finish()
      }else{
      this.$Progress.finish()
      this.isToken=false
      this.tryAgain=''
      this.validationClass = response.data.classname
      this.validationMsg=localStorage.getItem('error')
      } 
    
  }).catch(()=>{
      this.$Progress.fail()
      this.validationClass='text-danger p-2'
      this.validationMsg='Network error! refresh and try again or report this error on our contact page.'
      this.isToken=false
      this.tryAgain=''
  })
  },

    formCheck: function(e){
        this.error_btn="";
        this.alert="";
        this.$confirm("You are about to submit this form, click Ok to continue or Cancel to go back").then(() => {
        this.submit="Please wait.."
        this.addNew()
        });
    e.preventDefault();
    },
    addNew: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        this.submit='Please wait..'
        const form = new FormData();
        form.append('category_name', this.category_name)
        form.append('category_description', this.description)
        form.append('userid',  this.usersession['email_one'])
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/form/items/addcategory', form)
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        }else{
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable

        }
    }).catch(()=>{
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.submit=this.submittxt
        this.$Progress.fail()
        this.isDisabled = false
        this.opacity = this.opacity_disable

    })  
    },

   


    },


    }
</script>
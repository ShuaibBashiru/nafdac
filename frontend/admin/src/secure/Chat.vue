<template>
<div :style="opacity">
<AdminHeader>
<div class="container-fluid p-0">
<div class="row">
      <div class="col-md-12 mb-1">
        <section v-if="alert!=''">
      <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
      </section>
       </div>
</div>
<div class="row p-0">
    <div class="col-md-12 mb-3">
        <h4 class="">Welcome, <span class="">{{usersession['surname']}}
             {{usersession['firstname']}}!</span></h4>
    </div>

    <div class="col-md-12">
<div class="">
<div class="card bg-light mb-3" style="">
  <div class="card-header">Hi, how can we help you? <span class="float-end">ID: {{chatSessionID}}</span></div>
  <div class="card-body">
      <div class="row">
          <div class="col-md-6">
              <div class="dp ms-2"></div>
          </div>
             <div class="col-md-6 d-flex justify-content-end">
              <div class="ms-2"><img src="@/assets/icons/logo.png" class="img-fluid" alt="" width="80"></div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 p-2 mb-0 m-2 rounded">
              <section v-for="(d, index) in currentChat" :key="index">
                <section v-if="d['attendant_id']==0">
                    <div class="col-md-7 mt-3 border ms-2 p-2 alert-secondary border-0 rounded float-start">
                    {{d['message_text']}} <i class="bi-check float-end"></i>
                     </div>
                </section>
                <section v-else>
                    <div class="col-md-7 border mt-3 me-4 p-2 alert-info border-0 float-end rounded">
                    {{d['response_text']}}
                     </div>
                </section>
              </section>
               
          </div>

      </div>

  </div>
  <div class="card-footer">
      
      <form  @submit.prevent="formCheck" role="form" class="">
          <input type="hidden" v-model="token" required>
<div class="row">
         <div class="col-md-12">
              <span class="float-end" v-if="currentChat.length==1"> <small>One of our suppport officers will connect to your chat</small>   </span>
              <div class="input-group">
              <textarea class="form-control" id="" v-model="chatMessage" required></textarea>
          </div>
     </div>
     <div class="col-md-12">
            <button type="submit" name="login" class="btn btn-primary float-end border-0 mt-2" :disabled="isDisabled">{{button}}</button>
     </div>
</div>
      </form>
      </div>

</div>
</div>
    </div>

</div>
</div>
</AdminHeader>
</div>
</template>

<style scoped>

</style>

<script>
import axios from 'axios'
export default {
    data (){
        return{
        auth_check: false,
        usersession: '',
        userdata:'',
        applicationMsg: 'Please wait while checking your application status',
        applicationStatus:null,
        token: '',
        isToken: false,
        tryAgain: 'd-none',
        validationClass: 'text-primary',
        validationMsg: 'Please wait while validating and redirecting to the requested page...',
        alert: '',
        alertmodal: '',
        error: '',
        info: [],
        loader: false,
        loadermodal: false,
        classname: '',
        classnamemodal: null,
        submit: 'Submit',
        submittxt:'Submit',
        isDisabled: false,
        btntxt: 'Send',
        button: 'Send',
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        errormodal: null,
        record:false,
        norecord: '',
        chatMessage: '',
        chatSessionID: '',
        currentChat: '',
    }
    },

   created(){
        this.setStorage()
        this.checkSession()
        this.tokenize()
        this.initiateChatSession()
        this.preview()
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

            
        setStorage: function(){
        localStorage.setItem('error', this.networkerror)
        },
        initiateChatSession: function(){
                this.chatSessionID = this.$session.get('chatSessionID')
        },
       checkSession: function(){
        if (this.$session.exists()) {
            this.usersession = this.$session.get('usersession')
            }else{
                return false
                }
        },



        formCheck: function(e){
            this.addNew()
    e.preventDefault();
    },
    addNew: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        this.submit='Sending...'
        const form = new FormData();
        form.append('chatMessage', this.chatMessage)
        form.append('userid', this.usersession['email_one'])
        form.append('chatSessionID', this.chatSessionID)
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/form/chat/newchat', form)
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        // this.classname=response.data.classname
        // this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        this.preview()
        this.chatMessage=''
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

 preview: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        axios.get(process.env.VUE_APP_API+'/api/chats/currentchat/',{
              params:{
                userid: this.usersession['email_one'],
                chatSessionID: this.chatSessionID
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.currentChat = response.data.result
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }else{
            this.alert = response.data.msg
            this.classname = response.data.classname
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }
        
        }).catch(()=>{
            this.classname='alert-danger p-2'
            this.alert=localStorage.getItem('error')
            this.$Progress.fail()
            this.isDisabled = true
            this.opacity = this.opacity_disable
        })
    },

    },


    }
</script>
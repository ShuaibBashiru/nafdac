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
  <div class="card-header">Hi, Admin</div>
  <div class="card-body">
       <p>Use the left side menu to navigate this Administrator panel</p>
       <p>To create an account for sub-users: Use the admin menu provided at the left side</p>
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
        countPending: '',
        countClosed: '',
    }
    },

   created(){
        this.setStorage()
        this.checkSession()
        this.initiateChatSession()
        },
        methods:{
            
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

 preview: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        axios.get(process.env.VUE_APP_API+'/api/chats/counts/',{
              params:{
                userid: this.usersession['email_one'],
                chatSessionID: this.chatSessionID
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.countPending = response.data.countPending
            this.countClosed = response.data.countClosed
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